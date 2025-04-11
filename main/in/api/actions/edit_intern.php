<?php
include $_SERVER['DOCUMENT_ROOT'].'/main/in/dbset/dbset.php';
$data = mysqli_connect($server,$user,$pass,$base) or die ('connection error');

$name = $_POST['name'];
$surn = $_POST['surname'];
$mail = $_POST['email'];
$deadline = $_POST['deadline'];
$id = $_POST['ID'];

$sql = "SELECT * FROM interns WHERE ID = '".$id."'";
$res = $data->query($sql) or die ('base error');
while($line = $res->fetch_assoc()){
    $old = $line['mail'];
}

if($deadline==""){
    $sql = "UPDATE `interns` SET `mail` = '".$mail."', `name` = '".$name."', `surn` = '".$surn."', `deadline` = NULL WHERE `interns`.`mail` = '".$old."';"; 
}else{
    $sql = "UPDATE `interns` SET `mail` = '".$mail."', `name` = '".$name."', `surn` = '".$surn."', `deadline` = '".$deadline."' WHERE `interns`.`mail` = '".$old."';"; 
}

$res = $data->query($sql) or die ('base error');

$sql = "UPDATE `users` SET `mail`= '".$mail."' WHERE `mail`='".$old."';";

$res = $data->query($sql) or die ('base error');

$data->close();

echo "done";
?>