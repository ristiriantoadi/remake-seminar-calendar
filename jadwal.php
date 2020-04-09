<?php 
    session_start();
    if(isset($_SESSION['nim'])){
        echo $_SESSION['nim'];
    }else{
        exit();
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

        document.addEventListener('DOMContentLoaded', function() {
          var calendarEl = document.getElementById('calendar');
  
          var calendar = new FullCalendar.Calendar(calendarEl, {
            plugins: ['dayGrid']
            // defaultView:'dayGridWeek'
          });
  
          calendar.render();
        });
  
      </script><script></script>

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
                    <input type="checkbox">
                    <label>Hanya tunjukkan seminar saya</label>
                </span>
                <span class="filter-item">
                    <input type="checkbox">
                    <label>Hanya tunjukkan seminar yang akan saya hadiri</label>
                </span>
                <span class="filter-item">
                    <input type="checkbox">
                    <label>Hanya tunjukkan seminar yang belum saya lihat</label>
                </span>
            </div>
            <div id="calendar"></div>
        </div>
        <div style="clear:both"></div>
    </div>
</body>
</html>