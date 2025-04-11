<?php
global $user, $umail;
?>
<header>
    <h2 id='name'>Interns<br>Managment<br>System</h2>
    <h2 id='inform'>MAIN MENU</h2>
    <div id="user_prof">
    <p id='user_' data-mail='<?php echo $umail?>'><?php echo $user; ?></p>
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;    
    <button id='out'><i class="fa fa-sign-out"></i></button>
    </div>
</header>