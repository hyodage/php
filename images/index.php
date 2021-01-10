<?php  
header('Content-type:image/jpeg');
$rw = 300;$rh=400; #这是定义的画布资源的宽高
$res = imagecreatetruecolor($rw,$rh); #创建画布
$image = imagecreatefromjpeg('../img/ll.jpg'); #引入图片
$iw = imagesx($image);
$ih = imagesy($image); #获取图片的宽高
if($iw/$rw > $ih/$rh){
	$iw = $ih/$rh*$rw;
}else{
	$ih = $iw/$rw*$rh;
}
imagecopyresampled($res,$image,0,0,0,0,$rw,$rh,$iw,$ih); #生成图片
#参数:画布,图片,画布起始位置,图片起始位置,画布的宽高,图片的宽高
imagejpeg($res);
?>