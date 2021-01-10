<?php 
class Upload
{
	//扩展：可以添加用户的id作为前缀
	protected $dir; //存放目录,使用$this->dir即可
	public function make($maxsize,$allowExt,$type=0):array
	{
		$files = $this->format();
		$this->checkfiles($files,$maxsize,$allowExt,$type);
		$this->makeDir();
		$saveFiles = []; //保存成功上传的文件
		foreach ($files as $file) {
			// 通过pathinfo获取扩展名
			$Ename = pathinfo($file['name'])['extension'];
			$to = $this->dir.time().mt_rand(1,9999).'.'.$Ename;//存放路径
			if(@move_uploaded_file($file['tmp_name'], $to)){
				$saveFiles[]=[
					'path'=>$to,
					'name'=>$file['name'],
					'size'=>$file['size']
				];
			}
		}
		return $saveFiles;
	}
	// 创建文件目录
	private function makeDir():bool
	{
		$path = 'uploads/'.date('y/m/d');
		$this->dir = $path;
		return is_dir($path) or mkdir($path,0755,true);
	}
	// 对不同结构的数据统一数据格式
	private function format():array
	{
		$files = [];
		foreach ($_FILES as $filed) {
			if(is_array($filed['name'])){
				foreach ($filed['name'] as $id => $file) {
					$files[]=[
						'name'=>$filed['name'][$id],
						'type'=>$filed['type'][$id],
						'error'=>$filed['error'][$id],
						'tmp_name'=>$filed['tmp_name'][$id],
						'size'=>$filed['size'][$id]
					];
				}
			}else{
				$files[]=$filed;
			}
		}
		return $files;
	}
	//检查上传的文件的数组内是否有合法文件
	/*
	$fileArr处理后的文件数组;$maxsize文件最大限制;$allowExt允许上传类型;$type文件类型(如果是图片,应传1)
	*/
	private function checkfiles($fileArr,$maxsize,$allowExt,$type)
	{
		foreach ($fileArr as $file) {
			if($file['error']===0){
				$Ename = pathinfo($file['name'])['extension'];
				if($file['size']>$maxsize){
					exit(json_encode(['code'=>1,'msg'=>$file['name'].'上传文件过大']));
				}
				if(!in_array($Ename,$allowExt)){
					exit(json_encode(['code'=>1,'msg'=>$file['name'].'非法文件类型']));
				}
				if(!is_uploaded_file($file['tmp_name'])){
					exit(json_encode(['code'=>1,'msg'=>$file['name'].'上传方式有误,请使用post方式']));
				}
				if($type==1){
					// 判断是否为真实图片
					if(!getimagesize($file['tmp_name'])){
						// getimagesize真实就返回数组,否则就返回false
						exit(json_encode(['code'=>1,'msg'=>'不是真正的图片类型']));
					}
				}
			}else{
				switch ($file['error']) {
					case 1:
					case 2:
						exit(json_encode(['code'=>1,'msg'=>$file['name'].'超过上传文件的最大值']));
						break;
					case 3:
					case 4:
						exit(json_encode(['code'=>1,'msg'=>$file['name'].'文件未完成上传']));
						break;
					case 6:
					case 7:
						exit(json_encode(['code'=>1,'msg'=>$file['name'].'上传失败']));
						break;
					default:
						break;
				}
			}
		}
	}
}
?>