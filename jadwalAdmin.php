<?php 
    session_start();
    if(!isset($_SESSION['admin'])){
        // echo $_SESSION['nim'];
        exit();
    }else{
        echo "yes";
        // exit();
        require 'connect.php';
        
        $sql = "SELECT * FROM seminar INNER JOIN mahasiswa WHERE seminar.nim LIKE mahasiswa.nim";
        $result = $conn->query($sql);
        $rows=array();
        // $nim = $_SESSION['nim'];
        while($row=$result->fetch_assoc()){
            // $id_seminar=$row['id_seminar'];
            // $query = "SELECT * FROM peserta WHERE id_seminar=$id_seminar AND nim LIKE '$nim'";
            //     $res = $conn->query($query);
            //     if($res->num_rows>0){
            //         $row['status']=1;
            //     }else{
            //         $row['status']=2;
            //     }
            // }
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="fullcalendar/packages/core/main.css">
    <link rel="stylesheet" type="text/css" href="fullcalendar/packages/daygrid/main.css">
    <link rel="stylesheet" type="text/css" href="style.css">

    <script src='fullcalendar/packages/core/main.js'></script>
    <script src='fullcalendar/packages/daygrid/main.js'></script>

    <script>
        // console.log("hello world");
        function openModal(info){
            
            document.getElementById("head").innerHTML=`[Seminar TA 1] ${info.event.extendedProps.nama} 
            (${info.event.extendedProps.nim})`;
            document.getElementById("judul").innerHTML=`${info.event.extendedProps.judul}`;
            document.getElementById("ruangan").innerHTML=`${info.event.extendedProps.ruangan}`;
            document.getElementById("tanggal").innerHTML=`${info.event.extendedProps.tanggal}`;
            document.getElementById("dosen-pembimbing-1").innerHTML=`${info.event.extendedProps.dosenPembimbing1}`;
            document.getElementById("dosen-pembimbing-2").innerHTML=`${info.event.extendedProps.dosenPembimbing2}`;
            document.getElementById("dosen-penguji-1").innerHTML=`${info.event.extendedProps.dosenPenguji1}`;
            document.getElementById("dosen-penguji-2").innerHTML=`${info.event.extendedProps.dosenPenguji2}`;
            document.getElementById("dosen-penguji-3").innerHTML=`${info.event.extendedProps.dosenPenguji3}`;

            document.getElementById("overlay").classList.toggle('active-popup');
        }

        function closeModal(){
            console.log("halo");
            document.getElementById("overlay").classList.toggle('active-popup');
        }

        var seminars = <?php echo $seminars ?>;
        var calendar={};

        var mapSeminar=x=>{
            const container={};
            container.id=x.id_seminar;
            container.title=`[Seminar TA 1] ${x.nama} 
            (${x.nim})`;
            container.start=x.tanggal;
            container.nama=x.nama;
            container.idSeminar=x.id_seminar;
            container.nim=x.nim;
            container.judul=x.judul;
            container.ruangan=x.ruangan;
            container.tanggal=x.tanggal;
            container.dosenPembimbing1=x.dosenPembimbing1;
            container.dosenPembimbing2=x.dosenPembimbing2;
            container.dosenPenguji1=x.dosenPenguji1;
            container.dosenPenguji2=x.dosenPenguji2;
            container.dosenPenguji3=x.dosenPenguji3;
            // container.status=x.status;
                    
            // if(x.status == 0){
            //     container.backgroundColor="green";
            // }else if(x.status== 1){
            //     container.backgroundColor="orange";
            // }
            return container;
        }

        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar');           
            calendar = new FullCalendar.Calendar(calendarEl, {
                plugins: ['dayGrid'],
                events: seminars.map(mapSeminar),
                eventClick: (info)=>{
                    // console.log("clicked");
                    openModal(info);
                    // document.getElementById("overlay").classList.toggle('active-popup');
                    // document.getElementById("overlay").innerHTML=info.event.extendedProps.nama;
                }
            });  
            calendar.render();
        });
  
      </script>
</head>
<body>
    <div id="overlay" class="nonactive-popup">
        <div class="message">
            <div class="header">
                <h2 id="head">[Seminar TA 1] Ristirianto Adi (F1D016078)</h2>
                <i class="fa fa-times" onclick="closeModal()"></i>
                <!-- <div style="clear:both"></div> -->
            </div>
            <div class="content">
                <div class="info-row">
                    <label>Judul</label><span id="judul">Deteksi Api pada Video dengan Gaussian Mixture Model 
                        untuk Deteksi Gerakan dan Segmentasi Warna Api dalam Ruang Warna YCbCr</span>
                </div>
                <div class="info-row">
                    <label>Ruangan</label><span id="ruangan">A3-01</span>
                </div>
                <div class="info-row">
                    <label>Tanggal</label><span id="tanggal">27-05-2020</span>
                </div>
                <div class="info-row">
                    <div style="width:50%;display:inline-block">
                       <label>Pembimbing</label>
                       <ol>
                           <li id="dosen-pembimbing-1">Dosen 1</li>
                           <li id="dosen-pembimbing-2">Dosen 2</li>
                       </ol>
                    </div>
                    <div style="width:50%;display:inline-block">
                       <label>Penguji</label>
                       <ol>
                           <li id="dosen-penguji-1">Dosen 3</li>
                           <li id="dosen-penguji-2">Dosen 4</li>
                           <li id="dosen-penguji-3">Dosen 5</li>
                       </ol>
                    </div>
                </div>
                <!-- <div class="info-row">
                    <label>Dosen Pembimbing 2</label><span>Dosen 2</span>
                </div>
                <div class="info-row">
                    <label>Dosen Penguji 1</label><span>Dosen 3</span>
                </div>
                <div class="info-row">
                    <label>Dosen Penguji 2</label><span>Dosen 4</span>
                </div>
                <div class="info-row">
                    <label>Dosen Penguji 3</label><span>Dosen 4</span>
                </div> -->
            </div>
            <!-- <div class="content">Content</div> -->
        </div>
    </div>
    <?php 
        include 'headerAdmin.php';
    ?>
    <div class="container">
        <?php include 'sidebarAdmin.php'; ?>
        <div class="main float-left col-10">
            <h1 class="page-header">Jadwal Seminar</h1>           
            <div id="calendar"></div>
        </div>
        <div style="clear:both"></div>
    </div>
    <footer style="text-align:center">Sistem Informasi Seminar | Ristirianto Adi</footer>
</body>
</html>