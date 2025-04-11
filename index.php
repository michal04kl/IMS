<?php
if(isset($_COOKIE['in'])){
$idu = NULL;
$user = NULL;
$lvl = NULL;
$umail = NULL;
include "./main/in/dbset/idu_loader.php";
idu_loader();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script type='text/javascript' src='./main/framework/jquery-3.6.1.min.js'></script>
    <link rel='stylesheet' href='./main/main.css'>
    <?php 
    if(isset($_COOKIE['in']) && $_COOKIE['in']==$idu){
    ?>
    <title>IMS</title>
    <link rel="stylesheet" href="./main/in/api/api_settings/api.css">
    <link rel="stylesheet" href="./main/framework/font_awesome/css/all.min.css">
    <script type='text/javascript' src='./main/framework/jquery_md5.js'></script>
    <script type='text/javascript' src='./main/in/api/api_settings/api.js'></script>
    <script type='text/javascript' src='./main/in/cookie/reaper.js'></script>
</head>
<body>
    <?php
    include "./main/in.php";
    }else{
        if(isset($_COOKIE['in'])){
            setcookie("in", "", time()-3600, "/");
        }
    ?>
    <title>Login</title>
    <script type='text/javascript' src='./main/login/l.js'></script>
    <script type='text/javascript' src='./main/framework/jquery_md5.js'></script>
    <link rel='stylesheet' href='./main/login/l.css'>
    </head>
    <body>
    <?php
    include "./main/login.html";
    };
    ?>
</body>
</html>