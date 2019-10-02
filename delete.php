<?php

ob_start();
session_start();
require_once 'dbconnect.php';
if(isset($_GET['delete'])){
    $id=$_GET['delete'];
    $conn->query("delete from article where id=$id") or die($conn>error());
    header("Location: display.php");
}
?>