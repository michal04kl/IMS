<?php
if(isset($_COOKIE['in'])){
    setcookie("in", "", time()-3600, "/");
}
?>