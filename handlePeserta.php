<?php 
    if(isset($_GET['id-seminar'])){
        if(isset($_GET['nim'])){
            $idSeminar=$_GET['id-seminar'];
            $nim=$_GET['nim'];

            // echo gettype($idSeminar).'<br>';
            // echo gettype($nim).'<br>';
            // exit();
            
            require 'connect.php';

            $sql = "INSERT INTO peserta (id_seminar,nim)
                    VALUES ($idSeminar,'$nim')";
            if ($conn->query($sql) === TRUE) {
                // echo "New record created successfully";

                $sql = "SELECT * FROM seminar INNER JOIN mahasiswa WHERE seminar.nim LIKE mahasiswa.nim";
                $result = $conn->query($sql);
                $rows=array();
                // $nim = $_SESSION['nim'];
                while($row=$result->fetch_assoc()){
                    // echo $row['tanggal'];
                    // exit();
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
                echo $seminars;
                exit();

            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }

            $conn->close();
        }
    }
?>