<?php
global $lvl, $umail;
?>
<section id="panel">
<ul>
<?php
if($lvl == 2 && $umail != 'test@test.test'){
?>  
    <li id="interns">Interns</li>

    <li id="admins">Recruters</li>
<?php
}else if($umail != 'test@test.test'){
?>
    <li id="anwser">send anwser</li>
<?php
}
?>
</ul>
</section>