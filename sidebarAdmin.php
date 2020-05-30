<div class="sidebar float-left col-2">
            <ul class=" nav nav-sidebar">

                <?php 
                    if(strcmp($_SERVER['REQUEST_URI'],'/seminarcalendar/proposalAdmin.php') == 0){
                ?>
                    <li>
                        <a href=" <?php echo 'jadwalAdmin.php' ?>">Jadwal Seminar</a>
                    </li>
                    <li class="active">
                        <a href="<?php echo 'proposalAdmin.php' ?>" id="pengajuan">Proposal Seminar</a>
                    </li>
                <?php
                    } else if(strcmp($_SERVER['REQUEST_URI'],'/seminarcalendar/jadwalAdmin.php') == 0){
                ?>
                    <li class="active">
                        <a href=" <?php echo 'jadwalAdmin.php' ?>">Jadwal Seminar</a>
                    </li>
                    <li>
                        <a href="<?php echo 'proposalAdmin.php' ?>" id="pengajuan">Proposal Seminar</a>
                    </li>
                <?php
                    }
                ?>
            </ul>
        </div>