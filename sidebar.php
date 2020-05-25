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