<?php 
    session_start();
    if(!isset($_SESSION['nim'])){
        exit();
    }else{

        //cek apakah proposal sudah diajukan
        require 'connect.php';
        $nim = $_SESSION['nim'];
        $sql = "SELECT * FROM seminar WHERE nim LIKE '$nim'";
        $result = $conn->query($sql);
        if($result->num_rows>0){
            $row=$result->fetch_assoc();
            $statusProposal = $row['status'];
        }else{
           $statusProposal="kosong"; 
        }

        if(isset($_POST['submit-pengajuan'])){
            //  echo 'yes';
            
    
            $judul = $_POST['judul'];
            $dosenPembimbing1 = $_POST['dosen-pembimbing-1'];
            $dosenPembimbing2 = $_POST['dosen-pembimbing-2'];
            // $nim = $_SESSION['nim'];
            
            $suratPuasPKL = $_FILES['surat-puas-pkl'];
            $proposal = $_FILES['proposal'];
            $suratPengajuan = $_FILES['surat-pengajuan'];
            $lembarPengesahan = $_FILES['lembar-pengesahan'];

            
            //handle files
            if($suratPuasPKL['error'] === 0){
                $name = $suratPuasPKL['name'];
                $fileDestination = "proposal-seminar/$nim-surat-puas-pkl.pdf";
                move_uploaded_file($suratPuasPKL['tmp_name'],$fileDestination);
                
                if($proposal['error'] === 0){
                    $fileDestination = "proposal-seminar/$nim-proposal.pdf";
                    move_uploaded_file($proposal['tmp_name'],$fileDestination);

                    if($suratPengajuan['error'] === 0){
                        $fileDestination = "proposal-seminar/$nim-surat-pengajuan.pdf";
                        move_uploaded_file($suratPengajuan['tmp_name'],$fileDestination);

                        if($lembarPengesahan['error'] === 0){
                            $fileDestination = "proposal-seminar/$nim-lembar-pengesahan.pdf";
                            move_uploaded_file($lembarPengesahan['tmp_name'],$fileDestination);
                            
                            $sql = "INSERT INTO seminar (judul,nim,dosenPembimbing1,dosenPembimbing2,status) VALUES ('$judul','$nim','$dosenPembimbing1','$dosenPembimbing2','tunggu')";
                            $result = $conn->query($sql);

                            if ($result === TRUE) {
                                echo "New record created successfully";
                                $conn->close();
                                header("Location: daftar.php");
                            } else {
                                echo "Error: " . $sql . "<br>" . $conn->error;
                                $conn->close();
                                exit();
                            }
                            
                        }else{
                            echo "There was error uploading file";}
                        
                    }else{
                        echo "There was error uploading file";}
                    
                }else{
                    echo "There was error uploading file";}

            }else{
                echo "There was error uploading file";}

            // //format handling
            // $fileExt = explode('.',$file['name']);
            // $fileActualExt = strtolower(end($fileExt));
            // $allowed = array('pdf');
            // if(in_array($fileActualExt,$allowed)){
            //     if($file['error'] === 0){
            //         $fileDestination = "proposal-seminar/"."$nim/".$file['name'];
            //         move_uploaded_file($file['tmp_name'],$fileDestination);
            //         header("Location: ".$_SERVER['PHP_SELF']."?success");
            //     }else{
            //         echo "There was error uploading file";
            // }
            // }else{
            //     echo "You can't upload file of this type";
            // }

            // echo $judul.'<br>';
            // echo $dosenPembimbing1.'<br>';
            // echo $dosenPembimbing2.'<br>';
    
            // $sql = "INSERT INTO seminar (judul,nim,dosenPembimbing1,dosenPembimbing2) VALUES ('$judul','$nim','$dosenPembimbing1','$dosenPembimbing2')";
            // // $sql = "SELECT * FROM mahasiswa";
            // // $result = $conn->query($sql);

            // if ($conn->query($sql) === TRUE) {
            //     echo "New record created successfully";
            // } else {
            //     echo "Error: " . $sql . "<br>" . $conn->error;
            // }

            // $conn->close();
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
        <?php include 'sidebar.php'; ?>
        <div class="main float-left col-10">
            <h1 class="page-header">Pengajuan Seminar</h1>

            <?php 
                if(strcmp($statusProposal,'tunggu') == 0){
            ?>
                    <div class="wait alert">Proposal Anda sedang dikonfirmasi oleh Admin. Harap menunggu.</div>
            <?php
                }else if(strcmp($statusProposal,'terima') == 0){
            ?>
                    <div class="terima alert">Seminar Anda telah dijadwalkan. Silakan cek di Jadwal Seminar.</div>
            <?php
                }else{
            ?>
                    <div class="form-container">
                        <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) ?>" 
                            enctype="multipart/form-data">
                            <div class="data-proposal">
                                <h3>Data Proposal</h3>
                                <div class="input-container">
                                    <label class="form-label" for="judul">Judul:</label>
                                    <input required class="form" type="text" name="judul" placeholder="Judul Proposal">
                                </div>
                                <div class="input-container">
                                    <label class="form-label" for="dosen-pembimbing-1">Dosen Pembimbing 1:</label>
                                    <select required name="dosen-pembimbing-1" class="form">
                                        <option>Dosen 1</option>
                                        <option>Dosen 2</option>
                                        <option>Dosen 3</option>
                                    </select>
                                </div>
                                <div class="input-container">
                                    <label class="form-label" for="dosen-pembimbing-2">Dosen Pembimbing 2:</label>
                                    <select required name="dosen-pembimbing-2" class="form">
                                        <option>Dosen 1</option>
                                        <option>Dosen 2</option>
                                        <option>Dosen 3</option>
                                    </select>
                                </div>
                            </div>
                            <div class="berkas-seminar">
                                <h3>Berkas Syarat Seminar</h3>
                                <div class="input-container">
                                    <label class="form-label" for="surat-puas-pkl">Surat Puas PKL</label>
                                    <input required type="file" class="form" name="surat-puas-pkl">
                                </div>
                                <div class="input-container">
                                    <label class="form-label" for="proposal">Proposal</label>
                                    <input required type="file" class="form" name="proposal">
                                </div>
                                <div class="input-container">
                                    <label class="form-label" for="surat-pengajuan">Surat Pengajuan Seminar TA</label>
                                    <input required type="file" class="form" name="surat-pengajuan">
                                </div>
                                <div class="input-container">
                                    <label class="form-label" for="lembar-pengesahan">Lembar Pengesahan</label>
                                    <input required type="file" class="form" name="lembar-pengesahan">
                                </div>
                                <div class="input-container">
                                    <input type="submit" class="form-submit" name="submit-pengajuan" value="Ajukan Seminar">
                                    <div style="clear: both;"></div>
                                </div>
                            </div>
                        </form>
                    </div>
            <?php
                }
            ?>
            <!-- <div id="calendar"></div> -->
        </div>
        <div style="clear:both"></div>
    </div>
</body>
</html>