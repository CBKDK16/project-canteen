<?php

include 'config.php';

$delete = mysqli_query($conn,"DELETE FROM compare_tbl");

session_start();
session_unset();
session_destroy();

header('location:login.php');

?>