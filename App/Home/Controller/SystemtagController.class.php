<?php
/*---------------------------------------------------------------------------
  YHOA - 
 
              
 -------------------------------------------------------------------------*/

namespace Home\Controller;
use Think\Controller;
class SystemtagController extends CommonController {
	//protected $config=array('app_type'=>'asst');

	public function _initialize() {
		parent::_initialize();
		$this->dbname = 'SystemTag';
	}

	public function index() {
		if ($_POST) {
			$opmode = $_POST["opmode"];
			$model = D($this->dbname);
			if (false === $model -> create()) {
				$this -> error($model -> getError());
			}
			if ($opmode == "add") {
				$model -> module = MODULE_NAME;
				$list = $model -> add();
			}
			if ($opmode == "edit") {
				$list = $model -> save();
			}
			if ($opmode == "del") {
				$tag_id = $model -> id;
				$model -> del_tag($tag_id);
			}
		}
		$type = $_GET["type"];
		$model = D($this->dbname);
		if (isset($type)){
			$tag_list = $model -> get_tag_list("id,pid,name,sort,remark,is_del",$type);
		} else {
			$tag_list = $model -> get_tag_list("id,pid,name,sort,remark,is_del");
		}
		$this -> assign("type", $type);
		$this -> assign("tag_list", $tag_list);
		$tree = list_to_tree($tag_list);
		$this -> assign('menu',sub_tree_menu($tree));
		$this -> display();

		/*$tag_list = $model -> get_tag_list();
		$this -> assign("tag_list", $tag_list);
		$this -> assign('js_file',"SystemTag:js/index");
		$this -> display('SystemTag:index');*/
	}

	//流程分组
	public function flowtype() {
		if ($_POST) {
			//$opmode = $_POST["opmode"];
			$opmode = 'FlowType';
			$model = D($this->dbname);
			if (false === $model -> create()) {
				$this -> error($model -> getError());
			}
			if ($opmode == "add") {
				$model -> module = MODULE_NAME;
				$list = $model -> add();
			}
			if ($opmode == "edit") {
				$list = $model -> save();
			}
			if ($opmode == "del") {
				$tag_id = $model -> id;
				$model -> del_tag($tag_id);
			}
		}
		//$type = $_GET["type"];
		$type = 'FlowType';
		$model = D($this->dbname);
		if (isset($type)){
			$tag_list = $model -> get_tag_list("id,pid,name,sort,remark,is_del",$type);
		} else {
			$tag_list = $model -> get_tag_list("id,pid,name,sort,remark,is_del");
		}
		$this -> assign("type", $type);
		$this -> assign("tag_list", $tag_list);
		$tree = list_to_tree($tag_list);
		$this -> assign('menu',sub_tree_menu($tree));
		$this -> display();

		/*$tag_list = $model -> get_tag_list();
		$this -> assign("tag_list", $tag_list);
		$this -> assign('js_file',"SystemTag:js/index");
		$this -> display('SystemTag:index');*/
	}
	
	//供应商类别
	public function supplytype() {
		if ($_POST) {
			$opmode = 'SupplyType';
			$model = D($this->dbname);
			if (false === $model -> create()) {
				$this -> error($model -> getError());
			}
			if ($opmode == "add") {
				$model -> module = MODULE_NAME;
				$list = $model -> add();
			}
			if ($opmode == "edit") {
				$list = $model -> save();
			}
			if ($opmode == "del") {
				$tag_id = $model -> id;
				$model -> del_tag($tag_id);
			}
		}
		$type = 'SupplyType';
		$model = D($this->dbname);
		if (isset($type)){
			$tag_list = $model -> get_tag_list("id,pid,name,sort,remark,is_del",$type);
		} else {
			$tag_list = $model -> get_tag_list("id,pid,name,sort,remark,is_del");
		}
		$this -> assign("type", $type);
		$this -> assign("tag_list", $tag_list);
		$tree = list_to_tree($tag_list);
		$this -> assign('menu',sub_tree_menu($tree));
		$this -> display();
	}
	
	//客户类别
	public function customertype() {
		if ($_POST) {
			$opmode = 'CustomerType';
			$model = D($this->dbname);
			if (false === $model -> create()) {
				$this -> error($model -> getError());
			}
			if ($opmode == "add") {
				$model -> module = MODULE_NAME;
				$list = $model -> add();
			}
			if ($opmode == "edit") {
				$list = $model -> save();
			}
			if ($opmode == "del") {
				$tag_id = $model -> id;
				$model -> del_tag($tag_id);
			}
		}
		$type = 'CustomerType';
		$model = D($this->dbname);
		if (isset($type)){
			$tag_list = $model -> get_tag_list("id,pid,name,sort,remark,is_del",$type);
		} else {
			$tag_list = $model -> get_tag_list("id,pid,name,sort,remark,is_del");
		}
		$this -> assign("type", $type);
		$this -> assign("tag_list", $tag_list);
		$tree = list_to_tree($tag_list);
		$this -> assign('menu',sub_tree_menu($tree));
		$this -> display();
	}

	//计量单位
	public function unittype() {
		if ($_POST) {
			$opmode = 'UnitType';
			$model = D($this->dbname);
			if (false === $model -> create()) {
				$this -> error($model -> getError());
			}
			if ($opmode == "add") {
				$model -> module = MODULE_NAME;
				$list = $model -> add();
			}
			if ($opmode == "edit") {
				$list = $model -> save();
			}
			if ($opmode == "del") {
				$tag_id = $model -> id;
				$model -> del_tag($tag_id);
			}
		}
		$type = 'UnitType';
		$model = D($this->dbname);
		if (isset($type)){
			$tag_list = $model -> get_tag_list("id,pid,name,sort,remark,is_del",$type);
		} else {
			$tag_list = $model -> get_tag_list("id,pid,name,sort,remark,is_del");
		}
		$this -> assign("type", $type);
		$this -> assign("tag_list", $tag_list);
		$tree = list_to_tree($tag_list);
		$this -> assign('menu',sub_tree_menu($tree));
		$this -> display();
	}

	//业务类别
	public function ywtype() {
		if ($_POST) {
			$opmode = 'YwType';
			$model = D($this->dbname);
			if (false === $model -> create()) {
				$this -> error($model -> getError());
			}
			if ($opmode == "add") {
				$model -> module = MODULE_NAME;
				$list = $model -> add();
			}
			if ($opmode == "edit") {
				$list = $model -> save();
			}
			if ($opmode == "del") {
				$tag_id = $model -> id;
				$model -> del_tag($tag_id);
			}
		}
		$type = 'YwType';
		$model = D($this->dbname);
		if (isset($type)){
			$tag_list = $model -> get_tag_list("id,pid,name,sort,remark,is_del",$type);
		} else {
			$tag_list = $model -> get_tag_list("id,pid,name,sort,remark,is_del");
		}
		$this -> assign("type", $type);
		$this -> assign("tag_list", $tag_list);
		$tree = list_to_tree($tag_list);
		$this -> assign('menu',sub_tree_menu($tree));
		$this -> display();
	}
	
	//信息状态
	public function infostatetype() {
		if ($_POST) {
			$opmode = 'InfostateType';
			$model = D($this->dbname);
			if (false === $model -> create()) {
				$this -> error($model -> getError());
			}
			if ($opmode == "add") {
				$model -> module = MODULE_NAME;
				$list = $model -> add();
			}
			if ($opmode == "edit") {
				$list = $model -> save();
			}
			if ($opmode == "del") {
				$tag_id = $model -> id;
				$model -> del_tag($tag_id);
			}
		}
		$type = 'InfostateType';
		$model = D($this->dbname);
		if (isset($type)){
			$tag_list = $model -> get_tag_list("id,pid,name,sort,remark,is_del",$type);
		} else {
			$tag_list = $model -> get_tag_list("id,pid,name,sort,remark,is_del");
		}
		$this -> assign("type", $type);
		$this -> assign("tag_list", $tag_list);
		$tree = list_to_tree($tag_list);
		$this -> assign('menu',sub_tree_menu($tree));
		$this -> display();
	}

	//支出类型
	public function expensetype() {
		if ($_POST) {
			$opmode = 'ExpenseType';
			$model = D($this->dbname);
			if (false === $model -> create()) {
				$this -> error($model -> getError());
			}
			if ($opmode == "add") {
				$model -> module = MODULE_NAME;
				$list = $model -> add();
			}
			if ($opmode == "edit") {
				$list = $model -> save();
			}
			if ($opmode == "del") {
				$tag_id = $model -> id;
				$model -> del_tag($tag_id);
			}
		}
		$type = 'ExpenseType';
		$model = D($this->dbname);
		if (isset($type)){
			$tag_list = $model -> get_tag_list("id,pid,name,sort,remark,is_del",$type);
		} else {
			$tag_list = $model -> get_tag_list("id,pid,name,sort,remark,is_del");
		}
		$this -> assign("type", $type);
		$this -> assign("tag_list", $tag_list);
		$tree = list_to_tree($tag_list);
		$this -> assign('menu',sub_tree_menu($tree));
		$this -> display();
	}
	
	//业务类别
	public function incometype() {
		if ($_POST) {
			$opmode = 'IncomeType';
			$model = D($this->dbname);
			if (false === $model -> create()) {
				$this -> error($model -> getError());
			}
			if ($opmode == "add") {
				$model -> module = MODULE_NAME;
				$list = $model -> add();
			}
			if ($opmode == "edit") {
				$list = $model -> save();
			}
			if ($opmode == "del") {
				$tag_id = $model -> id;
				$model -> del_tag($tag_id);
			}
		}
		$type = 'IncomeType';
		$model = D($this->dbname);
		if (isset($type)){
			$tag_list = $model -> get_tag_list("id,pid,name,sort,remark,is_del",$type);
		} else {
			$tag_list = $model -> get_tag_list("id,pid,name,sort,remark,is_del");
		}
		$this -> assign("type", $type);
		$this -> assign("tag_list", $tag_list);
		$tree = list_to_tree($tag_list);
		$this -> assign('menu',sub_tree_menu($tree));
		$this -> display();
	}

	//结算方式
	public function settlementtype() {
		if ($_POST) {
			$opmode = 'SettlementType';
			$model = D($this->dbname);
			if (false === $model -> create()) {
				$this -> error($model -> getError());
			}
			if ($opmode == "add") {
				$model -> module = MODULE_NAME;
				$list = $model -> add();
			}
			if ($opmode == "edit") {
				$list = $model -> save();
			}
			if ($opmode == "del") {
				$tag_id = $model -> id;
				$model -> del_tag($tag_id);
			}
		}
		$type = 'SettlementType';
		$model = D($this->dbname);
		if (isset($type)){
			$tag_list = $model -> get_tag_list("id,pid,name,sort,remark,is_del",$type);
		} else {
			$tag_list = $model -> get_tag_list("id,pid,name,sort,remark,is_del");
		}
		$this -> assign("type", $type);
		$this -> assign("tag_list", $tag_list);
		$tree = list_to_tree($tag_list);
		$this -> assign('menu',sub_tree_menu($tree));
		$this -> display();
	}

	//添加信息
	public function add(){
		if(IS_POST){
			$model = D($this->dbname);
			//$data=I('post.');
			$data['pid']=$_POST['pid'];
			$data['module']=$_POST['module'];
			$data['name']=$_POST['name'];
			$data['sort']=$_POST['sort'];
			$data['remark']=$_POST['remark'];
			$list1 = $model -> add($data);
			if($list1){
				$this->mtReturn(200,L('_OPERATION_SUCCESS_'),'systemtag/'.$_REQUEST['navTabId'],true,1);
			}
			else
			{
				$this->mtReturn(300,L('_OPERATION_FAIL_'),'systemtag/'.$_REQUEST['navTabId'],false,1);
			}
			
		}
		$this->display();
	}

	//修改信息
	public function edit() {
		if(IS_POST){
			$model = D($this->dbname);
			//$data=I('post.');
			$data['id']=$_POST['id'];
			$data['pid']=$_POST['pid'];
			$data['module']=$_POST['module'];
			$data['name']=$_POST['name'];
			$data['sort']=$_POST['sort'];
			$data['remark']=$_POST['remark'];
			$list1 = $model -> save($data);
			if($list1){
				$this->mtReturn(200,L('_OPERATION_SUCCESS_'),'systemtag/'.$_REQUEST['navTabId'],true,1);
			}
			else
			{
				$this->mtReturn(300,L('_OPERATION_FAIL_'),'systemtag/'.$_REQUEST['navTabId'],false,1);
			}
			
		}

		$this -> assign("user_id",getuserid());
		$model = D($this->dbname);
		$id = $_REQUEST['id'];
		$type = $_REQUEST['type'];
		$vo = $model -> getById($id);
		$this -> assign('vo', $vo);
		$this -> assign("type",$type);
		$this -> display();
	}
	
	//启用|禁用
	public function mark() {
   		$action = $_REQUEST['action'];
		$id = $_REQUEST["id"];
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
			}
		}
	}

}
?>