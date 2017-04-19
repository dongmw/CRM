<?php
/**
 * 流程管理
 */

namespace Home\Controller;
use Think\Controller;

class FlowtypeController extends CommonController {

	//protected $config=array('app_type'=>'master');
	public function _initialize() {
		parent::_initialize();
		$this->dbname = 'FlowType';
	}

	//过滤查询字段
	function _search_filter(&$map) {
		if (!empty($_POST['keyword'])){
			$map['name'] = array('like', "%" . $_POST['keyword'] . "%");
		}
	}

	//添加信息
	public function add(){
		if(IS_POST){
			$model = D($this->dbname);
			//$data=I('post.');
			$data['tag']=I('post.tag');
			$data['doc_no_format']=I('post.doc_no_format');
			$data['name']=I('post.name');
			$data['short']=I('post.short');
			$data['content']=I('post.content');
			$data['is_lock']=I('post.is_lock');
			//$data['confirm']=I('post.confirm');
			//$data['confirm_name']=I('post.confirm_name');
			//$data['consult']=I('post.consult');
			//$data['consult_name']=I('post.consult_name');
			//$data['refer']=I('post.refer');
			//$data['refer_name']=I('post.refer_name');
			$data['create_time']=time();
			$data['request_duty']=I('post.request_duty');
			$data['report_duty']=I('post.report_duty');
			if (method_exists($this, '_befor_insert')) {
				$data = $this->_befor_insert($data);
			}
			$list1 = $model -> add($data);
			if($list1){
				$this->mtReturn(200,L('_OPERATION_SUCCESS_'),'flowtype/index',true,1);//$_REQUEST['navTabId']
			}else{
				$this->mtReturn(300,L('_OPERATION_FAIL_'),'flowtype/index',false,1);
			}
			
		}
				
		$widget['editor']=true;
		$this->assign("widget",$widget);
		
		$this -> assign("user_id",getuserid());
		$this ->_assign_tag_list();
		$this ->_assign_duty_list();				
		$this->display();
	}
	
	//修改信息
	public function edit() {
		if(IS_POST){
			$model = D($this->dbname);
			//$data=I('post.');
			$data['id']=I('post.id');
			$data['tag']=I('post.tag');
			$data['doc_no_format']=I('post.doc_no_format');
			$data['name']=I('post.name');
			$data['short']=I('post.short');
			$data['content']=I('post.content');
			$data['update_time']=time();
			$data['request_duty']=I('post.request_duty');
			$data['report_duty']=I('post.report_duty');
			$data['sort']=I('post.sort');
			$data['is_del']=I('post.is_del');
			$data['is_lock']=I('post.is_lock');
			$data['is_edit']=I('post.is_edit');
			$list1 = $model -> save($data);
			if($list1){
				$this->mtReturn(200,L('_OPERATION_SUCCESS_'),'flowtype/index',true,1);
			}
			else
			{
				$this->mtReturn(300,L('_OPERATION_FAIL_'),'flowtype/index',false,1);
			}
			
		}

		$widget['editor']=true;
		$this->assign("widget",$widget);			
		$this -> assign("user_id",getuserid());
		$model = D($this->dbname);
		$id = $_REQUEST['id'];
		$vo = $model -> getById($id);
		$this -> assign('vo', $vo);
		$this->_assign_tag_list();
		$this->_assign_duty_list();
		$this -> display();
	}
	
	public function index(){
		$model = D($this->dbname);
/*		$map = $this -> _search();
		if (method_exists($this, '_search_filter')) {
			$this -> _search_filter($map);
		}
*/
		$list = $model->get_list();
		//$list = $model->order('tag,sort')-> select(); //-> where($map) 
		$this -> assign('list', $list);
		$this ->_assign_tag_list();
		$this -> display();
		return;
	}

	public function mark() {
   		$action = $_REQUEST['action'];
		$id = $_REQUEST["id"];
		$key = $_REQUEST["key"];
		$val = $_REQUEST["val"];
		if (!empty($id)) {
			switch ($action){
				case 'del' :					
					$model = D($this->dbname);
					if($id){
						$data=$model->find($id);
						$data['id']=$id;
						if($data['is_del']==1){
							$data['is_del']=0;
							$msg='启用';
						}else{
							$data['is_del']=1;
							$msg='禁用';
						}
						$result=$model->save($data);
					}
					if ($result !== false) {
						$this->mtReturn(200,L('_OPERATION_SUCCESS_'),'',false);
					} else {
						$this->mtReturn(300,L('_OPERATION_FAIL_'),'',false);
					}
					break;
				case 'move' :
					if (!empty($id) && !empty($id)){
						$Form = M($this->dbname); 
						$result=$Form->where('id in ('.$id.')')->setField('tag',$key);
					};
					if ($result !== false) {
						$this->mtReturn(200,L('_OPERATION_SUCCESS_'),'',false);
					} else {
						$this->mtReturn(300,L('_OPERATION_FAIL_'),'',false);
					}
					break;
				case 'delfield' :					
					$model = D('FlowField');
					if($id){
						$data=$model->find($id);
						$data['id']=$id;
						if($data['is_del']==1){
							$data['is_del']=0;
							$msg='启用';
						}else{
							$data['is_del']=1;
							$msg='禁用';
						}
						$result=$model->save($data);
					}
					if ($result !== false) {
						$this->mtReturn(200,L('_OPERATION_SUCCESS_'),'',false);
					} else {
						$this->mtReturn(300,L('_OPERATION_FAIL_'),'',false);
					}
					break;
			}
		}
	}
	
	protected function _assign_tag_list() {
		$model = D('SystemTag');
		$tag_list = $model -> get_tag_list('id,name', 'FlowType');
		$this -> assign("tag_list", $tag_list);
	}
	
	protected function _assign_duty_list() {
		$model = D("Duty");
		$where['is_del']=array('eq',0);
		$duty_list = $model ->where($where)->order('sort')->getField("id,name");
		$this -> assign("duty_list",$duty_list);
	}
	
	public function tag_manage() {
		$this -> _tag_manage("分组管理",false);
	}

	public function fieldadd(){
		//添加信息
		if(IS_POST){
			$model = D('FlowField');
			//$data=I('post.');
			$data['type_id']=I('post.type_id');
			$data['name']=I('post.name');
			$data['control_type']=I('post.control_type');
			$data['control_layout']=I('post.control_layout');
			$data['control_data']=I('post.control_data');
			$data['sort']=I('post.sort');
			$data['validate']=I('post.validate');
			$data['msg']=I('post.msg');
			$list1 = $model -> add($data);
			if($list1){
				$this->mtReturn(200,L('_OPERATION_SUCCESS_'),'navtab-flow_type-field',true,1);
			}
			else
			{
				$this->mtReturn(300,L('_OPERATION_FAIL_'),'navtab-flow_type-field',false,1);
			}
		}
		$type_id = $_REQUEST['type_id'];
		$this -> assign('type_id', $type_id);
		$this->display();
	}
	
	public function fieldedit() {
		//修改信息
		if(IS_POST){
			$model = D('FlowField');
			//$data=I('post.');
			$data['id']=I('post.id');
			//$data['type_id']=I('post.type_id');
			$data['name']=I('post.name');
			$data['control_type']=I('post.control_type');
			$data['control_layout']=I('post.control_layout');
			$data['control_data']=I('post.control_data');
			$data['sort']=I('post.sort');
			$data['validate']=I('post.validate');
			$data['msg']=I('post.msg');
			$list1 = $model -> save($data);
			//dump($data);
			//exit();
			if($list1){
				$this->mtReturn(200,L('_OPERATION_SUCCESS_'),'navtab-flow_type-field',true,1);
			}
			else
			{
				$this->mtReturn(300,L('_OPERATION_FAIL_'),'navtab-flow_type-field',false,1);
			}
		}else{
			$model = D("FlowField");
			$id = $_REQUEST['id'];
			$vo = $model -> getById($id);
			$this -> assign('vo', $vo);
			$this -> display();
		}
	}

	public function field(){
		$widget['editor'] = true;
		$this -> assign("widget", $widget);
				
		if($_POST){
			$opmode = I('post.opmode');
			$model = D("FlowField");
			if (false === $model -> create()) {
				$this -> error($model -> getError());
			}
			if ($opmode == "add"){
				$list = $model -> add();
				if ($list !== false) {
					$this->mtReturn(200,L('_OPERATION_SUCCESS_'),$_REQUEST['navTabId'],true);
				} else {
					$this->mtReturn(300,L('_OPERATION_FAIL_'),$_REQUEST['navTabId'],false);
				}
			}
			if ($opmode == "edit") {
				$list = $model -> save();
				if ($list !== false) {
					$this->mtReturn(200,L('_OPERATION_SUCCESS_'),$_REQUEST['navTabId'],true);
				} else {
					$this->mtReturn(300,L('_OPERATION_FAIL_'),$_REQUEST['navTabId'],false);
				}
			}
			if ($opmode == "del") {
				$id = $_REQUEST['id'];
				$list=$model ->where("id=$id")->delete();
				if ($list !== false) {
					$this->mtReturn(200,L('_OPERATION_SUCCESS_'),$_REQUEST['navTabId'],true);
				} else {
					$this->mtReturn(300,L('_OPERATION_FAIL_'),$_REQUEST['navTabId'],false);
				}
			}
		}

		$widget['date'] = true;					
		$this -> assign("widget", $widget);
		$model = D("FlowField");
		$type_id=$_REQUEST['type_id'];
		$this->assign('type_id',$type_id);
		$where['type_id']=array('eq',$type_id);
		$field_list = $model ->where($where)->order('sort asc')->select();
		$this -> assign("field_list", $field_list);
		//$tree = list_to_tree($field_list);
		//$this -> assign('menu',sub_tree_menu($tree));
		//dump($field_list);
		$where_show['type_id']=array('eq',$type_id);
		$where_show['is_del']=0;
		$field_list_show = $model ->where($where_show)->order('sort asc')->select();
		$this -> assign("field_list_show", $field_list_show);
		$this -> display();
	}

	public function get_field(){
		$id=$_REQUEST['id'];
		$model=M("FlowField");
		$vo = $model -> getById($id);
		if ($this -> isAjax()) {
			if ($vo !== false) {// 读取成功
				$this -> ajaxReturn($vo, "", 0);
			} else {
				die ;
			}
		}
	}
}
?>