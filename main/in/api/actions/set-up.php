<?php
include $_SERVER['DOCUMENT_ROOT']."/main/in/api/actions/add_admin.php";
if(isset($_POST['tester'])){
    include $_SERVER['DOCUMENT_ROOT']."/main/in/api/actions/start_data.php";
}
    $sql = "DELETE FROM `users` WHERE `mail` = 'test@test.test';";
    $data = mysqli_connect($server,$user,$pass,$base) or die ('connection error');
    $res = $data->query($sql) or die ('base error');
    include $_SERVER['DOCUMENT_ROOT'].'/main/in/cookie/kill.php';
    $data->close();
?>