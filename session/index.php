<?php
session_save_path('spath');
session_name('xz'); //设置session_name,默认为PHPSESSID
session_id('79889');
echo session_name().'<br>';
session_start();
echo session_id();//session_id要在启动后才能输出
$_SESSION['abc'] = '123456';
// $_SESSION['xyz'] = '654321';
// print_r($_SESSION);
?>