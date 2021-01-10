<?php
session_start();
print_r($_SESSION);
$_SESSION['opq'] = '1433223';
// session_destroy();
?>