<?php
    session_start();
    if(isset($_POST['login_submit'])){
        echo "yes";
        require 'connect.php';

        $nim = $_POST['nim'];
        $password = $_POST['password'];
        
        echo $_POST['nim']."<br>";
        echo $_POST['password']."<br>";

        $sql = "SELECT * FROM mahasiswa WHERE nim like '$nim' AND password like '$password'";
        // $sql = "SELECT * FROM mahasiswa";
        $result = $conn->query($sql);
        if($result->num_rows>0){

            $row=$result->fetch_assoc();

            $_SESSION['nama']=$row['nama']; 
            $_SESSION['nim']=$nim;
            
            header("Location: jadwal.php");
            exit();
        }else{
            echo "no result";
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
    <div class="navbar">
        <div class="container-header">
            <div class="navbar-header">
                <a class="navbar-brand">Sistem Informasi Seminar</a>
            </div>
        </div>
    </div>
    <div class="limiter">
        <div class="container-login">
            <div class="wrap-login">
                <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) ?>" class="login-form">
                    <span class="login-title">Login</span>
                    <div class="wrap-input">
                        <input class="input" type="text" name="nim" placeholder="NIM">
                    </div>
                    <div class="wrap-input">
                        <input class="input" type="text" name="password" placeholder="Password">
                    </div>
                    <div class="flex-sb-m">
                        <!-- <div class="contact">
                            <input id="ckb1" class="input-checkbox" type="checkbox" name="remember-me">
                            <label class="label-checkbox">Remember me</label>
                        </div> -->
                        <div>
                            <a class="txt1">Lupa password?</a>
                        </div>
                    </div>
                    <div class="container-login">
                        <input type="submit" value="Login" name="login_submit" class="login">
                    </div>
                </form>
            </div>
        </div>
    </div>    
</body>
</html>