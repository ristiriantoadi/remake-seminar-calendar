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
        while($row=$result->fetch_assoc()){
            // echo "id: ".$row['id_seminar'].", judul: ".$row['judul']."<br>";
            $rows[] = $row;
        }
        $rows = json_encode($rows);
        echo $rows;
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
        var  nim = "<?php echo $_SESSION['nim'] ?>";
        // var row = <?php echo $rows ?>;
        // console.log(row);
        var allSeminar= <?php echo $rows ?>;       
        var seminarSaya= allSeminar.filter(x=>{if(x.nim==nim) return x});
        var seminarHadir=[];
        var seminarBelumLihat=[];
        var calendar={};
        document.addEventListener('DOMContentLoaded', function() {
          var calendarEl = document.getElementById('calendar');
  
          calendar = new FullCalendar.Calendar(calendarEl, {
            plugins: ['dayGrid'],
            events: allSeminar.map(x =>{
                    const container = {};
                    container.id=x.id_seminar;
                    container.title=x.judul;
                    container.start=x.tanggal;
                    if(x.nim == nim){
                        container.backgroundColor="green";
                    }
                    return container;
            })
            // defaultView:'dayGridWeek'
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
                    <span class="name">Ristirianto Adi(F1D016078)</span>
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
    <script>
        console.log(seminarSaya);
        console.log(calendar);
        // calendar.removeEvents();
        // calendar.getEvents().forEach(event=>event.remove());
        // calendar.getEvents().forEach(event => event.remove());    
        // var newEvents = seminarSaya.map(x=>{
        //     const container = {};
        //     container.id=x.id_seminar;
        //     container.title=x.judul;
        //     container.start=x.tanggal;
        //     if(x.nim == nim){
        //         container.backgroundColor="green";
        //     }
        //     return container;
        // }); 
        //     // add your new events
        // newEvents.forEach(event => calendar.addEvent(event));
        // calendar.render();
        var state = 0; //0 = semua seminar, 1 = seminar saya, 2 = seminar yang sy hadiri, 3 = seminar belum sy lihat

        var checkboxSeminarSaya = document.getElementById("seminar-saya");
        var checkboxSeminarHadir = document.getElementById("seminar-hadir");
        var checkboxSeminarBelumLihat = document.getElementById("seminar-belum-lihat");


        function updateState(){
            if(checkboxSeminarSaya.checked){
                state=1;
            }else if(checkboxSeminarHadir.checked){
                state=2;
            }else if(checkboxSeminarBelumLihat.checked){
                state=3;
            }else{
                state=0;
            }
            

            //update checkbox UI
            if(state == 0){//semua seminar
                // calendar.getEvents().forEach(event=>event.remove());

                //update checkbox UI 
                checkboxSeminarSaya.checked=false;
                checkboxSeminarHadir.checked = false;
                checkboxSeminarBelumLihat.checked = false;

                checkboxSeminarSaya.disabled=false;
                checkboxSeminarHadir.disabled = false;
                checkboxSeminarBelumLihat.disabled = false;

                //update calendar
                calendar.getEvents().forEach(event=>event.remove());
                var newEvents = allSeminar.map(x=>{
                    const container = {};
                    container.id=x.id_seminar;
                    container.title=x.judul;
                    container.start=x.tanggal;
                    if(x.nim == nim){
                        container.backgroundColor="green";
                    }
                    return container;
                }); 
                newEvents.forEach(event=>calendar.addEvent(event));

            }else if(state == 1){//seminar saya
                checkboxSeminarHadir.checked = false;
                checkboxSeminarHadir.disabled = true;

                checkboxSeminarBelumLihat.checked = false;
                checkboxSeminarBelumLihat.disabled=true;

                //update calendar
                calendar.getEvents().forEach(event=>event.remove());
                var newEvents = seminarSaya.map(x=>{
                    const container = {};
                    container.id=x.id_seminar;
                    container.title=x.judul;
                    container.start=x.tanggal;
                    container.backgroundColor="green";
                    
                    return container;
                }); 
                newEvents.forEach(event=>calendar.addEvent(event));

            }else if(state==2){//seminar hadir
                checkboxSeminarSaya.checked=false;
                checkboxSeminarSaya.disabled=true;
                
                checkboxSeminarBelumLihat.checked=false;
                checkboxSeminarBelumLihat.disabled=true;

                // //update calendar
                // calendar.getEvents().forEach(event=>event.remove());
                // var newEvents = seminarHadir.map(x=>{
                //     const container = {};
                //     container.id=x.id_seminar;
                //     container.title=x.judul;
                //     container.start=x.tanggal;
                //     if(x.nim == nim){
                //         container.backgroundColor="green";
                //     }
                //     return container;
                // }); 
                // newEvents.forEach(event=>calendar.addEvent(event));

            }else if(state==3){//seminar belum lihat
                checkboxSeminarHadir.checked = false;
                checkboxSeminarHadir.disabled = true;

                checkboxSeminarSaya.checked=false;
                checkboxSeminarSaya.disabled=true;
            }

            calendar.render();
        }
        checkboxSeminarSaya.addEventListener('click',updateState);
        checkboxSeminarHadir.addEventListener('click',updateState);
        checkboxSeminarBelumLihat.addEventListener('click',updateState);

    </script>
</body>
</html>