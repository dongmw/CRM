<?php
namespace Home\Controller;
use Think\Controller;

Class SystemclearController extends CommonController{
  
	public function _initialize() {
		parent::_initialize();
	}
	
    public function index(){
		$this -> display();
    }
    //清除缓存
    public function clear(){
		is_dir(DATA_PATH . '_fields/') && delDirAndFile(DATA_PATH . '_fields/');
		$msg="操作有误";
		//$t=$_POST['type'];
		$t=$_GET['type'];
		if($t == "all") {
			$msg="所有缓存清除完毕";
			is_dir(RUNTIME_PATH) && delDirAndFile(RUNTIME_PATH);
			is_dir(CACHE_PATH) && delDirAndFile(CACHE_PATH);
			is_dir(DATA_PATH) && delDirAndFile(DATA_PATH);
			is_dir(TEMP_PATH) && delDirAndFile(TEMP_PATH);
			is_dir(LOG_PATH) && delDirAndFile(LOG_PATH);
		} else if($t == "runtime") {
			$msg="Runtime缓存清除完毕";
			is_dir(RUNTIME_PATH) && delDirAndFile(RUNTIME_PATH.'/common~runtime.php');
		} else if($t == "cache") {
			$msg="Cache缓存清除完毕";
			is_dir(CACHE_PATH) && delDirAndFile(CACHE_PATH);
		} else if($t == "date") {
			$msg="Data缓存清除完毕";
			is_dir(DATA_PATH) && delDirAndFile(DATA_PATH);
		} else if($t == "temp") {
			$msg="Temp缓存清除完毕";
			is_dir(TEMP_PATH) && delDirAndFile(TEMP_PATH);
		} else if($t == "log") {
			$msg="Logs缓存清除完毕";
			is_dir(LOG_PATH) && delDirAndFile(LOG_PATH);
		}
		@unlink(RUNTIME_FILE);
		$this->mtReturn(200,$msg,$_REQUEST['navTabId'],false);
    }

	protected function mtReturn($status,$info,$navTabId="",$closeCurrent=true) {
	   
	    $result = array();
        $result['statusCode'] = $status; 
        $result['message'] = $info;
		$result['tabid'] = '';
        $result['forward'] = '';
		$result['forwardConfirm']='';
        $result['closeCurrent'] =$closeCurrent;
       
        if (empty($type))
            $type = C('DEFAULT_AJAX_RETURN');
        if (strtoupper($type) == 'JSON') {
            // 返回JSON数据格式到客户端 包含状态信息
            header("Content-Type:text/html; charset=utf-8");
            exit(json_encode($result));
        } else {
            // TODO 增加其它格式
        }
	}
  
  
  
  
}