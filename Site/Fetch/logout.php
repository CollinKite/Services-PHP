<?php
    session_start();
    session_destroy();
    header("Location: /content.php?title=Login&categoryid=8");
    exit();
?>