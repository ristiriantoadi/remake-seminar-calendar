<?php 
    session_start();
    if(!isset($_SESSION['nim'])){
        // echo $_SESSION['nim'];
        exit();
    }else{
        require 'connect.php';
        
        $sql = "SELECT * FROM seminar";
        $result = $conn->query($sql);
        $rows=array();
        $nim = $_SESSION['nim'];
        while($row=$result->fetch_assoc()){
            
            //0 = seminar saya, 1 = seminar yg sudah sy lihat, 2 = seminar yg belum sy lihat
            if($row['nim'] == $nim){
                $row['status'] = 0; 
            }else{
                $id_seminar=$row['id_seminar'];
                $query = "SELECT * FROM peserta WHERE id_seminar=$id_seminar AND nim LIKE '$nim'";
                $res = $conn->query($query);
                if($res->num_rows>0){
                    $row['status']=1;
                }else{
                    $row['status']=2;
                }
            }
            $rows[] = $row;
        }
        $seminars = json_encode($rows);
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" type="text/css" href="fullcalendar/packages/core/main.css">
    <link rel="stylesheet" type="text/css" href="fullcalendar/packages/daygrid/main.css">
    <link rel="stylesheet" type="text/css" href="style.css">

    <script src='fullcalendar/packages/core/main.js'></script>
    <script src='fullcalendar/packages/daygrid/main.js'></script>

    <script>
        var seminars = <?php echo $seminars ?>;
        var calendar={};

        var mapSeminar=x=>{
            const container={};
            container.id=x.id_seminar;
            container.title=x.judul;
            container.start=x.tanggal;
                    
            if(x.status == 0){
                container.backgroundColor="green";
            }else if(x.status== 1){
                container.backgroundColor="orange";
            }
            return container;
        }

        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar');           
            calendar = new FullCalendar.Calendar(calendarEl, {
                plugins: ['dayGrid'],
                events: seminars.map(mapSeminar)
            });  
            calendar.render();
        });
  
      </script>
</head>
<body>
    <div class="navbar">
        <div class="container-header">
            <div class="navbar-header dashboard">
                <div>
                    <a class="navbar-brand">Sistem Informasi Seminar</a>
                </div>
                <div>
                    <span>Ristirianto Adi(F1D016078)</span>
                    <span class="navbar-menu">Logout</span>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="sidebar float-left col-2">
            <ul class=" nav nav-sidebar">
                <li class="active">
                    <a>Jadwal Seminar</a>
                </li>
                <li>
                    <a>Pengajuan Seminar</a>
                </li>
            </ul>
        </div>
        <div class="main float-left col-10">
            <h1 class="page-header">Jadwal Seminar</h1>
            <div class="filter-container">
                <span class="filter">Filter: </span>
                <span class="filter-item">
                    <input type="checkbox" id="seminar-saya">
                    <label>Hanya tunjukkan seminar saya</label>
                </span>
                <span class="filter-item">
                    <input type="checkbox" id="seminar-hadir">
                    <label>Hanya tunjukkan seminar yang akan saya hadiri</label>
                </span>
                <span class="filter-item">
                    <input type="checkbox" id="seminar-belum-lihat">
                    <label>Hanya tunjukkan seminar yang belum saya lihat</label>
                </span>
            </div>
            <div id="calendar"></div>
        </div>
        <div style="clear:both"></div>
    </div>
    <footer style="text-align:center">Sistem Informasi Seminar | Ristirianto Adi</footer>
    <script>
        var seminarSaya = document.getElementById('seminar-saya');
        var seminarHadir = document.getElementById('seminar-hadir');
        var seminarBelumLihat = document.getElementById('seminar-belum-lihat');

        var state=0;//0 = semua, 1 = seminar saya, 2 = hadir, 3 = belum lihat

        function updateSeminar(state){
            calendar.getEvents().forEach(event=>event.remove()); 
            var newEvents={}; 
            if(state==0){
                newEvents = seminars.map(mapSeminar);
            }else if(state==1){
                newEvents= seminars.filter(x=>{if(x.status==0) return x}).map(mapSeminar);
            }else if(state==2){
                newEvents= seminars.filter(x=>{if(x.status==1) return x}).map(mapSeminar);
            }else{
                newEvents= seminars.filter(x=>{if(x.status==2) return x}).map(mapSeminar);
            }
            newEvents.forEach(event=>calendar.addEvent(event));
            calendar.render();
        }

        function updateKalender(){
            if(seminarSaya.checked){
                state=1;
            }else if(seminarHadir.checked){
                state=2;
            }else if(seminarBelumLihat.checked){
                state=3;
            }else{
                state=0;
            }

            //update the UI
            if(state==1){
                seminarHadir.disabled=true;
                seminarBelumLihat.disabled=true;
                seminarSaya.disabled=false;

                updateSeminar(state);

            }else if(state==2){
                seminarSaya.disabled=true;
                seminarBelumLihat.disabled=true;
                seminarHadir.disabled=false;

                updateSeminar(state);

            }else if(state==3){
                seminarSaya.disabled=true;
                seminarHadir.disabled=true;
                seminarBelumLihat.disabled=false;

                updateSeminar(state);
            }else{
                seminarSaya.disabled=false;
                seminarHadir.disabled=false;
                seminarBelumLihat.disabled=false;

                updateSeminar(state);
            }
        }

        seminarSaya.addEventListener('click',updateKalender);
        seminarHadir.addEventListener('click',updateKalender);
        seminarBelumLihat.addEventListener('click',updateKalender);

    </script>
</body>
</html>