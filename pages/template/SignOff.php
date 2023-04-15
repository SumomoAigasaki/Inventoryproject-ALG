<?php

session_start();
// session_name("sesionUser");
session_destroy();

header("Location: ../login.php");
?>