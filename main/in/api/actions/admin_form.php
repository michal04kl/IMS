<?php
echo "<form id='admin_form'>
    <div>
    <label for='user_email'>Email:</label>
    <input type='email' id='user_email' name='email' required pattern='^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$'>
    </div>

    <div>
    <label for='user_login'>Login:</label>
    <input type='text' id='user_login' name='login' required pattern='^[a-zA-Z0-9]{4,}$' title='Login must be at least 4 characters (letters and numbers only)'>
    </div>

    <div>
    <label for='user_passwd'>Password:</label>
    <input type='password' id='user_passwd' name='passwd' required pattern='^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$' title='Recruters password must be minimum eight characters, at least one letter and one number'>&nbsp;
    </div>
    
    <button type='submit'>ADD RECRUTER ACCOUNT</button>
</form>";
?>