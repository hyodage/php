<?php
//SessionHandlerInterface是一个 接口，用于定义用于创建自定义会话处理程序的原型。为了使用其 OOP调用将自定义会话处理程序传递给session_set_save_handler（），该类必须实现此接口。
/*
SessionHandlerInterface {
abstract public close ( void ) : bool
abstract public destroy ( string $session_id ) : bool
abstract public gc ( int $maxlifetime ) : int
abstract public open ( string $save_path , string $session_name ) : bool
abstract public read ( string $session_id ) : string
abstract public write ( string $session_id , string $session_data ) : bool
}
//开关读写卸垃
*/
class FileHandle implements SessionHandlerInterface
{
	protected $path;
	protected $maxlifetime;
	public function __construct($path='session',$maxlifetime=1400){
		$this->path = $this->mkDir($path);
		$this->maxlifetime = $maxlifetime;
	}
	public function close(){
		return true;
	}
	public function destroy($id){
		if(is_file($this->path.'/'.$id)){
			@unlink($this->path.'/'.$id);
		}
		return true;
	}
	public function gc($maxlifetime){
		// 遍历该文件夹下的所有文件
		foreach (glob($this->path.'/*') as $file) {
			if (filemtime($file)+$this->maxlifetime<time()) {
				//如果文件修改时间+最大限度时间<当前时间;就删除该文件。
				@unlink($file);
			}
		}
		return true;
	}
	protected function mkDir($path){
		is_dir($path) or mkdir($path,0755,true);
		// 反正真正的绝对路径
		return realpath($path);
	}
	public function open($save_path,$name){
		return true;
	}
	public function read($id){
		return (string)@file_get_contents($this->path.'/'.$id);
	}
	public function write($id,$data){
		return (bool)@file_put_contents($this->path.'/'.$id, $data);
	}
}
?>