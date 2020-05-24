<?php 
    session_start();
    if(!isset($_SESSION['nim'])){
        exit();
    }else{
        if(isset($_POST['submit-pengajuan'])){
            // echo 'yes';
            require 'connect.php';
    
            $judul = $_POST['judul'];
            $dosenPembimbing1 = $_POST['dosen-pembimbing-1'];
            $dosenPembimbing2 = $_POST['dosen-pembimbing-2'];
            $nim = $_SESSION['nim'];
            
            // echo $judul.'<br>';
            // echo $dosenPembimbing1.'<br>';
            // echo $dosenPembimbing2.'<br>';
    
            $sql = "INSERT INTO seminar (judul,nim,dosenPembimbing1,dosenPembimbing2) VALUES ('$judul','$nim','$dosenPembimbing1','$dosenPembimbing2')";
            // $sql = "SELECT * FROM mahasiswa";
            // $result = $conn->query($sql);

            if ($conn->query($sql) === TRUE) {
                echo "New record created successfully";
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }

            $conn->close();
        }
    }

    
?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
    <?php 
        include 'header.php';
    ?>
    <div class="container">
        <div class="sidebar float-left col-2">
            <ul class=" nav nav-sidebar">

                <?php 
                    if(strcmp($_SERVER['REQUEST_URI'],'/seminarcalendar/daftar.php') == 0){
                ?>
                    <li>
                        <a href=" <?php echo 'jadwal.php' ?>">Jadwal Seminar</a>
                    </li>
                    <li class="active">
                        <a href="<?php echo 'daftar.php' ?>" id="pengajuan">Pengajuan Seminar</a>
                    </li>
                <?php
                    } else if(strcmp($_SERVER['REQUEST_URI'],'/seminarcalendar/jadwal.php') == 0){
                ?>
                    <li class="active">
                        <a href=" <?php echo 'jadwal.php' ?>">Jadwal Seminar</a>
                    </li>
                    <li>
                        <a href="<?php echo 'daftar.php' ?>" id="pengajuan">Pengajuan Seminar</a>
                    </li>
                <?php
                    }
                ?>
            </ul>
        </div>
        <div class="main float-left col-10">
            <h1 class="page-header">Pengajuan Seminar</h1>
            <div class="form-container">
                <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) ?>">
                    <div class="data-proposal">
                        <h3>Data Proposal</h3>
                        <div class="input-container">
                            <label class="form-label">Judul:</label>
                            <input class="form" type="text" name="judul" placeholder="Judul Proposal">
                        </div>
                        <div class="input-container">
                            <label class="form-label">Dosen Pembimbing 1:</label>
                            <select name="dosen-pembimbing-1" class="form">
                                <option>Dosen 1</option>
                                <option>Dosen 2</option>
                                <option>Dosen 3</option>
                            </select>
                        </div>
                        <div class="input-container">
                            <label class="form-label">Dosen Pembimbing 2:</label>
                            <select name="dosen-pembimbing-2" class="form">
                                <option>Dosen 1</option>
                                <option>Dosen 2</option>
                                <option>Dosen 3</option>
                            </select>
                        </div>
                    </div>
                    <div class="berkas-seminar">
                        <h3>Berkas Syarat Seminar</h3>
                        <div class="input-container">
                            <label class="form-label">Surat Puas PKL</label>
                            <input type="file" class="form" name="surat-puas-pkl">
                        </div>
                        <div class="input-container">
                            <label class="form-label">Proposal</label>
                            <input type="file" class="form" name="proposal">
                        </div>
                        <div class="input-container">
                            <label class="form-label">Surat Pengajuan Seminar TA</label>
                            <input type="file" class="form" name="surat-pengajuan">
                        </div>
                        <div class="input-container">
                            <label class="form-label">Lembar Pengesahan</label>
                            <input type="file" class="form" name="lembar-pengesahan">
                        </div>
                        <div class="input-container">
                            <input type="submit" class="form-submit" name="submit-pengajuan" value="Ajukan Seminar">
                            <div style="clear: both;"></div>
                        </div>
                    </div>
                </form>
            </div>
            <div id="calendar"></div>
        </div>
        <div style="clear:both"></div>
    </div>
</body>
</html>