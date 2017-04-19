<?php

/**
 *      文档控制器
 *      [ZLSYS] (C)2008-2099  
 *      This is NOT a freeware, use is subject to license terms
 *      http://www.zhelininternet.com
 *      tel:13811836808
 *      qq:185530523
 */
 
namespace Home\Controller;
use Think\Controller;

class DocumentController extends CommonController {	
	//protected $config = array('app_type' => 'folder', 'action_auth' => array('mark' => 'admin'));
	
	public function _initialize() {
		parent::_initialize();
		$this->dbname = CONTROLLER_NAME;
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

	protected function _index($pid=0,$level=0,$folder='',$folder_list){
		$cate=M('SystemFolder');
		$array=array();
		if ($folder != '') {
			$tmp=$cate->where(array('pid'=>$pid,'folder'=>$folder,'is_del'=>0))->order("sort")->select();
		} else {
			$tmp=$cate->where(array('pid'=>$pid,'is_del'=>0))->order("sort")->select();
		}
		if(is_array($tmp)){
			//echo $folder_list.' ';
			foreach($tmp as $v){
				if (strpos($folder_list,$v['id']) !== false) {
					//echo $v['id'].' ';
					$v['level']=$level;
					$array[count($array)]=$v;
					$sub= $this->_index($v['id'],$level+1,$folder,$folder_list);
					if(is_array($sub))$array=array_merge($array,$sub);
				}
			}
		}
		return $array;
	}

	public function index(){
		//$map = $this -> _search();
		if (method_exists($this, '_filter')) {
			$this -> _filter($map);
		}
		$folder_list=D("SystemFolder")->get_authed_folder(getuserid());
		//dump($folder_list);
		if (IS_POST) {
			if (!empty($_REQUEST['folder'])) {
				if (in_array($_REQUEST['folder'],$folder_list)){
					$map['folder'] = array('eq', $_POST['folder']);
				}
			} else {
				$map['folder']=array("in",$folder_list);
			}
		} else {
			$map['folder']=array("in",$folder_list);
		}
		$map['is_del'] = array('eq', '0');
		$model = D("DocumentView");
		if (!empty($model)) {
			$this -> _list($model, $map);
		}
		//$model1 = M("SystemFolder");
		//$map1['id']=array("in",$folder_list);
		//$folder_name_list = $model1->where($map1)->field("id,name")->order('sort')->select();
		$folder_name='DocumentFolder';
		$folder_list_select=$this->_index($pid=0,$level=0,$folder_name,implode(',',$folder_list));
		$this -> assign("system_folder_list", $folder_list_select);
		$this -> display();
	}

	public function manage(){
		//$map = $this -> _search();
		if (method_exists($this, '_filter')) {
			$this -> _filter($map);
		}
		$folder_list=D("SystemFolder")->get_authed_folder(getuserid());
		//dump($folder_list);
		//exit();
		if (IS_POST) {
			if (!empty($_REQUEST['folder'])) {
				if (in_array($_REQUEST['folder'],$folder_list)){
					$map['folder'] = array('eq', $_POST['folder']);
				}
			} else {
				$map['folder']=array("in",$folder_list);
			}
		} else {
			$map['folder']=array("in",$folder_list);
		}
		$model = D("DocumentView");
		if (!empty($model)) {
			$this -> _list($model, $map);
		}
		$folder_name='DocumentFolder';
		$folder_list_select=$this->_index($pid=0,$level=0,$folder_name,implode(',',$folder_list));
		//dump($folder_list_select);
		$this -> assign("system_folder_list", $folder_list_select);
		$this -> display();
	}
	
	public function _befor_add(){
		$folder_list=D("SystemFolder")->get_authed_folder(getuserid());
		$folder_name='DocumentFolder';
		$folder_list_select=$this->_index($pid=0,$level=0,$folder_name,implode(',',$folder_list));
		$this -> assign("system_folder_list", $folder_list_select);
		$attid=time();
		$this->assign('attid',$attid);
	}

	public function _befor_edit(){
		$model = D($this->dbname);
		$info = $model->find(I('get.id'));
		$attid=$info['attid'];
		$this->assign('attid',$attid);

		$folder_list=D("SystemFolder")->get_authed_folder(getuserid());
		$folder_name='DocumentFolder';
		$folder_list_select=$this->_index($pid=0,$level=0,$folder_name,implode(',',$folder_list));
		$this -> assign("system_folder_list", $folder_list_select);
	}

	public function edit() {
		$model = D($this->dbname);
		if(IS_POST){
			$data=I('post.');
			if (false === $data = $model->create()) {
				$this->mtReturn(300,'失败，请检查值是否已经存在','document/manage',true);  
			}
			if (method_exists($this, '_befor_update')) {
				$data = $this->_befor_update($data);
			}
			if($model->save($data)){
				if (method_exists($this, '_after_edit')) {
					$id = $data['id'];
					$this->_after_edit($id);
				}
			}
			$id = $data['id'];
			$this->mtReturn(200,"编辑成功",'document/manage',true,1);
		}
		if (method_exists($this, '_befor_edit')) {
			$this->_befor_edit();
		}
		$id = $_REQUEST [$model->getPk()];
		$vo = $model->getById($id);
		$this->assign('id',$id);
		$this->assign('Rs', $vo);
		$this->display();
	}
	
	
	
	
	
	public function folder(){
		$widget['date'] = true;		
		$this -> assign("widget", $widget);
		$this -> assign('auth', $this -> config['auth']);
		
		$model = D("Document");
		$map = $this -> _search();
		if (method_exists($this, '_filter')) {
			$this -> _filter($map);
		}

		$folder_id = $_REQUEST['fid'];
		$map['folder'] = $folder_id;
		if (!empty($_REQUEST['tag'])) {
			$map['_string'] = "locate('{$_REQUEST['tag']}',Document.tag_name)";
		}
		if (!empty($model)) {
			$this -> _list($model, $map);
		}

		$where = array();
		$where['id'] = array('eq', $folder_id);

		$folder_name = M("SystemFolder") -> where($where) -> getField("name");
		$this -> assign("folder_name", $folder_name);
		$this -> assign("folder", $folder_id);

		$this -> _assign_folder_list();
		$this -> display();
		return;
	}

	public function read() {
		$id = $_REQUEST['id'];		
		$model = M("Document");
		$folder_id = $model -> where("id=$id") -> getField('folder');
		$this -> assign("auth", D("SystemFolder") -> get_folder_auth($folder_id));
		$this->_edit();
	}

	public function mark(){
		$action = $_REQUEST['action'];
		$id = $_REQUEST['id'];
		if (!empty($id)) {
			switch ($action){
				case 'del' :
					$where['id'] = array('in', $id);
					$folder = M("Document") -> distinct(true) -> where($where) -> field("folder") -> select();
					if (count($folder) == 1) {
						$auth = D("SystemFolder") -> get_folder_auth($folder[0]["folder"]);
						if ($auth['admin'] == true) {
							$field = 'is_del';
							$result = $this -> _set_field($id, $field, 1);
							if ($result) {
								$this -> ajaxReturn('', "删除成功", 1);
							} else {
								$this -> ajaxReturn('', "删除失败", 0);
							}
						}
					} else {
						$this -> ajaxReturn('', "删除失败", 0);
					}
					break;

				case 'move_folder' :
					$target_folder = $_REQUEST['val'];
					$where['id'] = array('in', $id);
					$folder = M("Document") -> distinct(true) -> where($where) -> field("folder") -> select();
					if (count($folder) == 1) {
						$auth = D("SystemFolder") -> get_folder_auth($folder[0]["folder"]);
						if ($auth['admin'] == true) {
							$field = 'folder';
							$this -> _set_field($id, $field, $target_folder);
						}
						$this -> ajaxReturn('', "操作成功", 1);
					} else {
						$this -> ajaxReturn('', "操作成功", 1);
					}
					break;
				default :
					break;
			}
		}
	}

	function tag_manage() {
		$this -> _tag_manage("标签管理");
	}

	function upload() {
		$this -> _upload();
	}

	function down() {
		$this -> _down();
	}
}
