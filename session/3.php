<?php
include('FileHandle.php');
// session_set_save_handler — 设置用户级会话存储功能
// 详细：https://www.php.net/manual/en/function.session-set-save-handler.php
$sssh = new FileHandle('xz',1500);
session_set_save_handler($sssh);
session_name('xz'); //设置session_name,默认为PHPSESSID
session_id('79889');
session_start();
$_SESSION['name']='xz123.com';
?>