<?php  
class Thumb
{
	public function make(string $img,string $to,int $width,int $height,int $type=3)
	{
		$image = $this->resource($img);
		$info = $this->size($width,$height,imagesx($image),imagesy($image),$type);#imagesX/Y获取图片的宽高
		$res = imagecreatetruecolor($info[0],$info[1]);#创建画布
		imagecopyresampled($res,$image,0,0,0,0,$info[0],$info[1],$info[2],$info[3]); #生成图片
		#参数:画布,图片,画布起始位置,图片起始位置,画布的宽高,图片的宽高
		// header('Content-type:image/jpeg');
		// imagejpeg($res); #显示图片
		$result = $this->saveActive($img)($res,$to); #保存图片
		return $result;
	}
	// 保存图片
	protected function saveActive($img)
	{
		$info = getimagesize($img); #获取图片的信息的数组
		$functions = [1=>'imagegif',2=>'imagejpeg',3=>'imagepng'];
		return $functions[$info[2]];
	}
	// 图片处理
	protected function size(int $rw,int $rh,int $iw, int $ih,int $type)
	{
		switch ($type){
			#保持宽度,高度自动(瀑布流1)
			case 1:
				$rh = $rw/$iw*$ih;
				break;
			#保持高度,宽度自动(瀑布流2)
			case 2:
				$rw = $rh/$ih*$iw;
				break;
			#画布不动,图片铺满
			case 3:
				break;
			#画布不动,图片在横向或竖向占满
			default:
				$iw/$rw > $ih/$rh?$iw = $ih/$rh*$rw:$ih = $iw/$rw*$rh;
		}
		return [$rw,$rh,$iw,$ih];
	}
	// 引入图片资源
	protected function resource(string $img)
	{
		$this->check($img); #检错
		$info = getimagesize($img); #获取图片的信息的数组
		$functions = [1=>'imagecreatefromgif',2=>'imagecreatefromjpeg',3=>'imagecreatefrompng'];
		$call = $functions[$info[2]];
		return $call($img);#返回图像标识符，代表了从给定的文件名取得的图像
	}
	// 异常检测
	protected function check(string $img)
	{
		#如果不是文件或者不是图片
		if(!is_file($img) || getimagesize($img)===false){
			// 如果return false,调用此方法的方法还需要继续判断是否是false
			// 所以直接抛出错误异常
			throw new Exception("file dont exists or it's not image");
			
		}
	}
}
$img = new Thumb;
try{
	$img->make('123.png','456thumb.png',200,800,1);
}catch(Exception $e){
	echo $e->getMessage();
} #异常处理
?>