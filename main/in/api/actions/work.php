<?php
include $_SERVER['DOCUMENT_ROOT'].'/main/in/dbset/dbset.php';
$data = mysqli_connect($server,$user,$pass,$base) or die ('connection error');
$sql = "UPDATE `interns` SET `quest` = '".$_POST['github-url']."' WHERE `interns`.`mail` = '".$_POST['mail']."'";
$res = $data->query($sql) or die ('base error');
$sql = "DELETE FROM `users` WHERE `mail` = '".$_POST['mail']."';";
$res = $data->query($sql) or die ('base error');
include $_SERVER['DOCUMENT_ROOT'].'/main/in/cookie/kill.php';
$data->close();
?>