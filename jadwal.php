<?php 
    session_start();
    if(!isset($_SESSION['nim'])){
        // echo $_SESSION['nim'];
        exit();
    }else{
        require 'connect.php';
        
        $sql = "SELECT * FROM seminar INNER JOIN mahasiswa WHERE seminar.nim LIKE mahasiswa.nim";
        $result = $conn->query($sql);
        $rows=array();
        $nim = $_SESSION['nim'];
        while($row=$result->fetch_assoc()){
            // echo $row['tanggal'];
            // exit();
            //0 = seminar saya, 1 = seminar yg sudah sy lihat, 2 = seminar yg belum sy lihat
            if($row['nim'] == $nim){
                $statusProposal = $row['statusProposal'];
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="fullcalendar/packages/core/main.css">
    <link rel="stylesheet" type="text/css" href="fullcalendar/packages/daygrid/main.css">
    <link rel="stylesheet" type="text/css" href="style.css">

    <script src='fullcalendar/packages/core/main.js'></script>
    <script src='fullcalendar/packages/daygrid/main.js'></script>
    
    <script>
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

            var displayButton = "none";
            var displayText="none";
            console.log(info.event.extendedProps.status);
            if(info.event.extendedProps.status === 2){
                displayButton="inline-block";
            }else if(info.event.extendedProps.status === 1){
                displayText="inline-block";
            }

            // console.log(display);

            document.getElementById("button-hadir").style.display=displayButton;
            document.getElementById("text-hadir").style.display=displayText;
            document.getElementById("button-hadir").addEventListener("click", ()=>{
                handlePeserta(info);
            }); 

            document.getElementById("overlay").classList.toggle('active-popup');
        }

        function closeModal(){
            console.log("halo");
            document.getElementById("overlay").classList.toggle('active-popup');
        }

        function handlePeserta(info){
            var nim = "<?php echo $_SESSION['nim'] ?>";
            // console.log(nim);
            var url=`http://localhost/seminarcalendar/handlePeserta.php?id-seminar=${info.event.extendedProps.idSeminar}&nim=${nim}`;
            // var url =`${info.event.extendedProps.judul}`;
            console.log(url);
            fetch(url)
            .then((response)=>{
                if(response.status !== 200){
                    console.log('Looks like there was a problem. Status Code: ' +
                        response.status);
                    return;
                }
                // console.log("Info before: "+info.event.extendedProps.status);
                // info.event.extendedProps.status="something";
                // console.log("Info: "+info.event.extendedProps.status);
                // closeModal();
                // openModal(info);

                response.json().then((data)=>{
                    console.log(data);

                    //update kalendar
                    calendar.getEvents().forEach(event=>event.remove());  
                    var newEvents = data.map(mapSeminar);
                    newEvents.forEach(event=>calendar.addEvent(event));
                    calendar.render();
                    closeModal();
                })
            })
        }
    </script>

    <script>
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
            container.status=x.status;
                    
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
                <div>
                    <input type="submit" id="button-hadir" class="form-submit" name="submit-pengajuan" value="Saya bersedia hadir">
                    <h4 id="text-hadir" style="color:green">Anda telah terdaftar sebagai peserta</h4>
                    <div style="clear: both;"></div>
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
        include 'header.php';
    ?>
    <div class="container">
        <?php include 'sidebar.php'; ?>
        <div class="main float-left col-10">
            <h1 class="page-header">Jadwal Seminar</h1>
            <?php 
                if(strcmp($statusProposal,'tunggu') == 0){
            ?>
                    <div class="wait alert">Proposal Anda sedang dikonfirmasi oleh Admin. Harap menunggu.</div>
            <?php
                }else if(strcmp($statusProposal,'terima') == 0){
            ?>
                    <div class="terima alert">Seminar Anda telah dijadwalkan. Silakan cek di Jadwal Seminar.</div>
            <?php
                }
            ?>
            
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

        function updateKalender(){

            //update state
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
            calendar.getEvents().forEach(event=>event.remove()); 
            var newEvents={}; 

            if(state==1){
                seminarHadir.disabled=true;
                seminarBelumLihat.disabled=true;
                seminarSaya.disabled=false;

                newEvents= seminars.filter(x=>{if(x.status==0) return x}).map(mapSeminar);
            }else if(state==2){
                seminarSaya.disabled=true;
                seminarBelumLihat.disabled=true;
                seminarHadir.disabled=false;

                newEvents= seminars.filter(x=>{if(x.status==1) return x}).map(mapSeminar);
            }else if(state==3){
                seminarSaya.disabled=true;
                seminarHadir.disabled=true;
                seminarBelumLihat.disabled=false;

                newEvents= seminars.filter(x=>{if(x.status==2) return x}).map(mapSeminar);
            }else{
                seminarSaya.disabled=false;
                seminarHadir.disabled=false;
                seminarBelumLihat.disabled=false;

                newEvents = seminars.map(mapSeminar);                
            }

            newEvents.forEach(event=>calendar.addEvent(event));
            calendar.render();
        }

        seminarSaya.addEventListener('click',updateKalender);
        seminarHadir.addEventListener('click',updateKalender);
        seminarBelumLihat.addEventListener('click',updateKalender);

    </script>
</body>
</html>