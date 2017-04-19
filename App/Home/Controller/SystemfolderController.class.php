<?php

/**
 *      文档目录控制器
 *      [ZLSYS] (C)2008-2099  
 *      This is NOT a freeware, use is subject to license terms
 *      http://www.zhelininternet.com
 *      tel:13811836808
 *      qq:185530523
 */
 
namespace Home\Controller;
use Think\Controller;

class SystemfolderController extends CommonController {
	//protected $config = array('app_type' => 'asst');
	
	public function _initialize() {
		parent::_initialize();
		$this->dbname = 'SystemFolder';//CONTROLLER_NAME
	}
	
	//过滤查询字段
	function _filter(&$map) {
		if (IS_POST) {
			if (isset($_REQUEST['keys']) && $_REQUEST['keys'] != '') {
				//$map['name'] = array('like', "%" . $_POST['keys'] . "%");
				$map['name'] = array('like','%'.trim($_REQUEST['keys']).'%');
			}
		}
	}

	protected function _index($pid=0,$level=0,$folder='',$folder_list=''){
		$cate=M('SystemFolder');
		$array=array();
		if ($folder != '') {
			$tmp=$cate->where(array('pid'=>$pid,'folder'=>$folder,'is_del'=>0))->order("sort")->select();
		} else {
			$tmp=$cate->where(array('pid'=>$pid,'is_del'=>0))->order("sort")->select();
		}
		if(is_array($tmp)){
			//echo $folder_list.' ';
			if ($folder_list!='') {
				foreach($tmp as $v){
					if (strpos($folder_list,$v['id']) !== false) {
						//echo $v['id'].' ';
						$v['level']=$level;
						$array[count($array)]=$v;
						$sub= $this->_index($v['id'],$level+1,$folder,$folder_list);
						if(is_array($sub))$array=array_merge($array,$sub);
					}
				}
			} else {
				foreach($tmp as $v){
					$v['level']=$level;
					$array[count($array)]=$v;
					$sub= $this->_index($v['id'],$level+1,$folder,$folder_list);
					if(is_array($sub))$array=array_merge($array,$sub);
				}
			}
		}
		return $array;
	}

	public function index() {
		if (method_exists($this, '_filter')) {
			$this -> _filter($map);
		}
		$folder = $_GET["folder"];
		
		if(!in_array(getuserid(),C('ADMINISTRATOR'))){
			$folder_list=D("system_folder")->get_authed_folder(getuserid(),$folder);
			$list=$this->_index(0,0,$folder,implode(',',$folder_list));
		} else {
			$list=$this->_index(0,0,$folder);
		}
		
		//dump($folder);
		//dump($folder_list);
		//dump($list);
		
		$this->assign('list',$list);
		$this->assign('folder',$folder);
		$this->display(); 
	}

	/**
	 * 文件夹管理控制器
	 */
	public function document() {
		if (method_exists($this, '_filter')) {
			$this -> _filter($map);
		}
		//$folder = $_GET["folder"];
		$folder = 'DocumentFolder';
		
		if(!in_array(getuserid(),C('ADMINISTRATOR'))){
			$folder_list=D("system_folder")->get_authed_folder(getuserid(),$folder);
			$list=$this->_index(0,0,$folder,implode(',',$folder_list));
		} else {
			$list=$this->_index(0,0,$folder);
		}
		
		//dump($folder);
		//dump($folder_list);
		//dump($list);
		
		$this->assign('list',$list);
		$this->assign('folder',$folder);
		$this->display(); 
	}

	//添加信息
	public function add(){
		if(IS_POST){
			$model = D('SystemFolder');
			//$data=I('post.');
			$data['pid']=$_POST['pid'];
			$data['folder']=$_POST['folder'];
			$data['name']=$_POST['name'];
			$data['sort']=$_POST['sort'];
			$data['is_del']=$_POST['is_del'];
			$data['remark']=$_POST['remark'];
			$list1 = $model -> add($data);
			if($list1){
				$this->mtReturn(200,L('_OPERATION_SUCCESS_'),'systemfolder/'.$_REQUEST['navTabId'],true,1);
			}
			else
			{
				$this->mtReturn(300,L('_OPERATION_FAIL_'),'systemfolder/'.$_REQUEST['navTabId'],false,1);
			}
		}
				
		$folder = $_GET["folder"];
		$list=$this->_index($pid=0,$level=0,$folder);
		$this->assign('list',$list);
		$this->assign('folder',$folder);
		$navTabId = $_REQUEST['navTabId'];
		$this->assign('navTabId',$navTabId);
		$this->display();
	}

	//修改信息
	public function edit() {
		if(IS_POST){
			$model = D("SystemFolder");
			//$data=I('post.');
			$data['id']=$_POST['id'];
			$data['pid']=$_POST['pid'];
			$data['folder']=$_POST['folder'];
			$data['name']=$_POST['name'];
			$data['sort']=$_POST['sort'];
			$data['is_del']=$_POST['is_del'];
			$data['remark']=$_POST['remark'];
			$list1 = $model -> save($data);
			if($list1){
				$this->mtReturn(200,L('_OPERATION_SUCCESS_'),'systemfolder/'.$_REQUEST['navTabId'],true,1);
			}
			else
			{
				$this->mtReturn(300,L('_OPERATION_FAIL_'),'systemfolder/'.$_REQUEST['navTabId'],false,1);
			}
			
		}

		//$this -> assign("user_id",getuserid());
		$model = D("SystemFolder");
		$id = $_REQUEST['id'];
		$folder = $_REQUEST['folder'];
		$vo = $model -> getById($id);
		$this -> assign('vo', $vo);
		$list=$this->_index($pid=0,$level=0,$folder);
		$this->assign('list',$list);
		$this->assign('folder',$folder);
		$navTabId = $_REQUEST['navTabId'];
		$this->assign('navTabId',$navTabId);
		$this -> display();
	}


	
	protected function _insert() {
		$model = D("SystemFolder");
		if (false === $model -> create()) {
			$this -> error($model -> getError());
		}
		//保存当前数据对象
		$model -> folder = MODULE_NAME;
		$list = $model -> add();
		if ($list !== false) {//保存成功.
			$this -> assign('jumpUrl', get_return_url());
			$this -> success('新增成功!');
		} else {
			//失败提示
			$this -> error('新增失败!');
		}
	}

	protected function _update() {
		$model = D("SystemFolder");
		if (false === $model -> create()) {
			$this -> error($model -> getError());
		}
		// 更新数据
		$list = $model -> save();
		if (false !== $list) {
			//成功提示
			$this -> assign('jumpUrl', get_return_url());
			$this -> success('编辑成功!');
		} else {
			//错误提示
			$this -> error('编辑失败!');
		}
	}

	function read() {
		$model = M("SystemFolder");
		$id = $_REQUEST["id"];
		$data = $model -> getById($id);
		if ($data !== false) {// 读取成功
			$this -> ajaxReturn($data, "", 1);
		}
	}

	function del() {
		$id = $_REQUEST["id"];
		$model = M("SystemFolder");		
		$data = $model -> getById($id);
		$fid=$data['id'];
		$folder=$data['folder'];
		$count=M(str_replace("Folder","",$folder))->where("folder=$fid")->count();
					
		if ($count>0) {// 读取成功
			$this -> ajaxReturn("", "只能删除空文件夹",1);
		}else{
			$result=$model->where("id=$id")->delete();
			if($result){
				$this -> ajaxReturn("", "删除文件夹成功",1);
			}
		}
	}

	function winpop() {
		$node = M("SystemFolder");
		$menu = array();
		$where['folder'] = MODULE_NAME;
		$menu = $node -> where($where) -> field('id,pid,name') -> order('sort asc') -> select();
		$tree = list_to_tree($menu);
		$this -> assign('menu', popup_tree_menu($tree));
		$this -> display("SystemFolder:winpop");
	}

}
