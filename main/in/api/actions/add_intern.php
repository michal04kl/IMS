<?php
include $_SERVER['DOCUMENT_ROOT'].'/main/in/dbset/dbset.php';
$name=$_POST["name"];
$surn=$_POST["surname"];
$mail=$_POST["email"];
$deadline=$_POST["deadline"];

$sql = "SELECT * FROM `interns`;";
$data = mysqli_connect($server,$user,$pass,$base) or die ('connection error');
$res = $data->query($sql) or die ('base error');
$found = 0;
while($line = $res->fetch_assoc()){
if($line['mail']==$mail){
    $found = 1;
    echo "failed - email in use for ".$line['name']." ".$line['surn'];
}
}

if($found==0){
if($deadline == "NULL"){
    $sql = "INSERT INTO `interns` (`ID`, `mail`, `name`, `surn`, `quest`, `deadline`, `status`) VALUES (NULL, '$mail', '$name', '$surn', NULL, NULL, 'waiting')";
}else{
    $sql = "INSERT INTO `interns` (`ID`, `mail`, `name`, `surn`, `quest`, `deadline`, `status`) VALUES (NULL, '$mail', '$name', '$surn', NULL, '$deadline', 'waiting')";
}
$res = $data->query($sql) or die ('base error');
$login = strtolower(substr($name,0,1).$surn);
$pass = "";
$limit = min(4, strlen($mail));
for($i = 0; $i < $limit; $i++){
    $c = $mail[$i];
    $c = ord($c)*rand(1,100);
    $pass.=$c;
}
$hash = sha1(md5($pass));
$sql = "INSERT INTO `users` (`ID`, `mail`, `login`, `passwd`, `rand`, `level`) VALUES (NULL, '$mail', '$login', '$hash', NULL, '1')";
$res = $data->query($sql) or die ('base error');
$data->close();
echo "WARNING!\nsend e-mail to $mail, with:\nlogin: $login\npassword: $pass";
}
?>