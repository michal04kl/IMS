<?php
include $_SERVER['DOCUMENT_ROOT'].'/main/in/dbset/dbset.php';
$data = mysqli_connect($server,$user,$pass,$base) or die ('connection error');
$mail = $_POST['email'];
$login = $_POST['login'];
$paswd = sha1($_POST['passwd']);

$sql = "SELECT * FROM `users`";
$res = $data->query($sql) or die ('base error');
$found = 0;
while($line = $res->fetch_assoc()){
    if($line['mail']==$mail){
        $found = 1;
        break;
    }
}
if($found == 0){
$sql = "INSERT INTO `users` (`ID`, `mail`, `login`, `passwd`, `rand`, `level`) VALUES (NULL, '$mail', '$login', '$paswd', NULL, '2')";
$res = $data->query($sql) or die ('base error');
$data->close();
echo "Recruter added";
}else{
    echo "e-mail in use!";
}
?>