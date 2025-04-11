<?php
function idu_loader(){
    global $idu, $user, $lvl, $umail;
    include $_SERVER['DOCUMENT_ROOT']."/main/in/dbset/dbset.php";
    $data = mysqli_connect($server,$user,$pass,$base) or die ('connection error');
    $sql = "SELECT * FROM users";
    $res = $data->query($sql) or die ('base error');
    while($line = $res->fetch_assoc()){
        $rand =  $line['rand'];
        if($rand!=0 || $rand!=NULL){
        $user = $line['login'];
        $lvl = $line['level'];
        $umail = $line['mail'];
        $idu_t = str_split($line['login']);
            foreach($idu_t as $c){
                $c = ord($c)*$line['ID'];
                $idu .= $c;
            }
        $idu = (int)$idu;
        $idu = $idu%$rand;
        if($_COOKIE['in']==$idu){
            break;
        }
    }
    }
    $data->close();
}
?>