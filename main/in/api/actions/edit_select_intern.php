<?php
include $_SERVER['DOCUMENT_ROOT'].'/main/in/dbset/dbset.php';
$data = mysqli_connect($server,$user,$pass,$base) or die ('connection error');
$ids = $_POST['ids'];
foreach($ids as $id){
$sql = "SELECT * FROM `interns` WHERE `ID` = '$id';";
$res = $data->query($sql) or die ('base error');
while($line = $res->fetch_assoc()){
    echo "<form class = 'edit_i'>
    <label for='email'>Email:</label><input value='".$line['mail']."' type='email' id='ia_email' name='email' required pattern='^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\\.[a-zA-Z]{2,}$'><br>
    <label for='name'>Name:</label><input value='".$line['name']."' type='text' id='ia_name' name='name' required pattern='^[A-ZĄĆĘŁŃÓŚŹŻ][a-ząćęłńóśźż]+$' title='The first letter is uppercase, the rest are lowercase'><br>
    <label for='surname'>Surname:</label><input value='".$line['surn']."' type='text' id='ia_surname' name='surname' required pattern='^[A-ZĄĆĘŁŃÓŚŹŻ][a-ząćęłńóśźż]+(?:[-\\s][A-ZĄĆĘŁŃÓŚŹŻ][a-ząćęłńóśźż]+)*$' title='Name in capital letters, may contain a hyphen or space'>
    <br><label for='deadline'>Deadline (optional):</label><input type='text' id='ia_deadline' name='deadline' pattern='^(NULL|\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2}|)$' title='Format: YYYY-MM-DD HH:MM:SS, e.g. 2025-04-10 15:30:00' value='".$line['deadline']."'>
    <br><button type='submit'>EDIT</button>
    <input type='text' name='ID' value='".$line['ID']."' style='display:none;'>
    </form><br><br>";
}
}
$data->close();
?>