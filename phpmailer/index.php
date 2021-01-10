<?php
/*
开通qq邮箱的域名邮箱
pop3/smtp:vdahgged
登录邮箱->设置->账户->开启pop3和IMAP服务
*/
header("Content-Type:text/html;charset=utf-8");
require_once("./functions.php");
$email = '12345678@qq.com';
$title = '送你一张可爱的猫猫图片';
$content = '<div style="width:100px;margin:100px auto;"><a href="http://xpv.net.cn"><img src="https://ss3.bdstatic.com/70cFv8Sh_Q1YnxGkpoWK1HF6hhy/it/u=4275956321,546087914&fm=26&gp=0.jpg" style="width:100px;"/></a></div>';
$date = date('Y-m-d H:i:s D');
$flag = sendMail($email,$title,$content);
if($flag){
    echo $date."向".$email.'成功发送邮件!';
}else{
    echo "发送邮件失败！";
}
?>