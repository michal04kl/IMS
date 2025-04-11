<?php
$log_spr = $_POST["login"];
$pass_spr = SHA1($_POST["passwd"]);
if($log_spr == NULL || $pass_spr == NULL){
    echo "missing something";
}else{
    include $_SERVER['DOCUMENT_ROOT'].'/main/in/dbset/dbset.php';
    $data = mysqli_connect($server,$user,$pass,$base) or die ('connection error');
    $sql = "SELECT * FROM users WHERE login = '$log_spr' AND passwd = '$pass_spr' LIMIT 1";
    $res = $data->query($sql) or die ('base error');
    $found = 0;
    while($line = $res->fetch_assoc()){
        $idu = 0;
        if($log_spr == $line['login'] && $pass_spr == $line['passwd']){
            $found = 1;
            echo "in";
            $idu_t = str_split($line['login']);
            foreach($idu_t as $c){
                $c = ord($c)*$line['ID'];
                $idu .= $c;
            }
            $rand=rand(10000,99999);
            $idu = (int)$idu;
            $idu = $idu%$rand;
            $sql = "UPDATE users set rand = $rand WHERE ID =".$line['ID'];
            $res = $data->query($sql) or die ('base error');
            setcookie("in", "$idu", time()+10800, "/");
           break; 
        }
    }
    if($found == 0){
        echo "invalid login or password";
    }
    $data->close();
}
?>