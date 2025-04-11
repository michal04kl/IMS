<?php
$umail = $_POST['mail']; 
echo "<table>";
include $_SERVER['DOCUMENT_ROOT']."/main/in/dbset/dbset.php";
$data = mysqli_connect($server,$user,$pass,$base) or die ('connection error');
$sql = "SELECT * FROM `users`";
$res = $data->query($sql) or die ('base error');
echo "<tr>
    <th>check</th>
    <th>ID</th>
    <th>mail</th>
    <th>login</th>
    </tr>";
while($line = $res->fetch_assoc()){
    if($umail == $line['mail']){
        echo "<tr><td>you</td>";
    }else if($line['level']==1){
        echo "<tr><td>[deletion from intern panel]</td>";
    }else{
        echo "<tr><td><input type='checkbox' id='".$line['ID']."' class = 'admin_box'></td>";
    }
    echo "<td>".$line['ID']."</td>";
    echo "<td><a href='mailto:".$line['mail']."'>".$line['mail']."</a></td>";
    echo "<td>".$line['login']."</td>";
    echo "</tr>";
}
$data->close();
echo "</table>"
?>