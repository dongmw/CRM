<?php

/**
 *      流程控制器
 *      [ZLSYS] (C)2008-2099  
 *      This is NOT a freeware, use is subject to license terms
 *      http://www.zhelininternet.com
 *      tel:13811836808
 *      qq:185530523
 */

namespace Home\Controller;
use Think\Controller;

class FlowController extends CommonController {

	public function _initialize() {
		parent::_initialize();
        $this->dbname = CONTROLLER_NAME;
	}
	
	function _filter(&$map) {
		$map['is_del'] = array('eq', '0');
		if (IS_POST) {
			if (!empty($_REQUEST['keys'])) {
				$keys = $_POST['keys'];
				$map['name'] = array('like', "%" . $keys . "%");
			}
			if (!empty($_REQUEST['user_name'])) {
				$user_name = $_POST['user_name'];
				$map['user_name'] = array('like', "%" . $user_name . "%");
			}
			if (!empty($_REQUEST['type'])) {
				$type = $_POST['type'];
				$map['type'] = array('eq', $type);
			}
			if($_REQUEST['datetime'] == true &&isset($_REQUEST['time1']) && $_REQUEST['time1'] != '' && isset($_REQUEST['time2']) && $_REQUEST['time2'] != ''){
				$map['create_time'] =array(array('egt',strtotime(I('time1'))),array('elt',strtotime(I('time2'))));
			}
		}
	}

	public function index() {
		$model = D('FlowType');
		$where['is_del'] = 0;
		$user_id = getuserid();
		$role_list = D("RoleDuty") -> get_role_list($user_id);
		$role_list = rotate($role_list);
		$role_list = $role_list['group_id'];
		if (!empty($role_list)) {
			$duty_list = D("RoleDuty") -> get_duty_list($role_list);
			$duty_list = rotate($duty_list);
			$duty_list = $duty_list['duty_id'];
			if (!empty($duty_list)) {
				$where['request_duty'] = array('in', $duty_list);
			} else {
				$where['_string'] = '1=2';
			}
		} else {
			$where['_string'] = '1=2';
		}
		$list = $model -> where($where) -> select();//$list = $model -> where($where) -> order('sort') -> select();
		$this -> assign("list", $list);
		$this -> _assign_tag_list();
		$this -> display();
	}


/********* 待办 *********/
	function confirm() {
		$emp_no = getusername();
		$user_id = getuserid();
		
		$FlowLog = M("FlowLog");
		$where['emp_no'] = $emp_no;
		$where['_string'] = "result is null";
		$log_list = $FlowLog -> where($where) -> field('flow_id') -> select();
		$log_list = rotate($log_list);
		if (!empty($log_list)) {
			$map['id'] = array('in', $log_list['flow_id']);
		} else {
			$map['_string'] = '1=2';
		}
		//$map = $this->_search();
		if (method_exists($this, '_filter')) {
			$this->_filter($map);
		}
		$model = D("FlowView");
		if ($_REQUEST['mode'] == 'export') {
			$this -> _folder_export($model, $map);
		} else {
			$this -> _list($model, $map);
		}
		$this -> _assign_flow_type_list();
		$this -> display();
	}
	
/********* 提交 *********/
	function submit() {
		$emp_no = getusername();
		$user_id = getuserid();
		
		$map['user_id'] = array('eq', $user_id);
		$map['step'] = array( array('gt', 10),array('eq', 0), 'or');
		if (method_exists($this, '_filter')) {
			$this -> _filter($map);
		}
		$model = D("FlowView");
		if ($_REQUEST['mode'] == 'export') {
			$this -> _folder_export($model, $map);
		} else {
			$this -> _list($model, $map);
		}
		$this -> _assign_flow_type_list();
		$this -> display();
	}
	
/********* 草稿 *********/
	function darft() {
		$emp_no = getusername();
		$user_id = getuserid();
		
		$map['user_id'] = $user_id;
		$map['step'] = 10;
		if (method_exists($this, '_filter')) {
			$this -> _filter($map);
		}
		$model = D("FlowView");
		if ($_REQUEST['mode'] == 'export') {
			$this -> _folder_export($model, $map);
		} else {
			$this -> _list($model, $map);
		}
		$this -> _assign_flow_type_list();
		$this -> display();
	}

/********* 办理 *********/
	function finish() {
		$emp_no = getusername();
		$user_id = getuserid();
		
		$FlowLog = M("FlowLog");
		$where['emp_no'] = $emp_no;
		$where['_string'] = "result is not null";
		$log_list = $FlowLog -> where($where) -> field('flow_id') -> select();
		$log_list = rotate($log_list);
		if (!empty($log_list)) {
			$map['id'] = array('in', $log_list['flow_id']);
		} else {
			$map['_string'] = '1=2';
		}
		if (method_exists($this, '_filter')) {
			$this -> _filter($map);
		}
		$model = D("FlowView");
		if ($_REQUEST['mode'] == 'export') {
			$this -> _folder_export($model, $map);
		} else {
			$this -> _list($model, $map);
		}
		$this -> _assign_flow_type_list();
		$this -> display();
	}

/********* 收到 *********/
	function receive() {
		$emp_no = getusername();
		$user_id = getuserid();
		
		$FlowLog = M("FlowLog");
		$where['emp_no'] = $emp_no;
		$where['step'] = 100;
		$log_list = $FlowLog -> where($where) -> field('flow_id') -> select();
		$log_list = rotate($log_list);
		if (!empty($log_list)) {
			$map['id'] = array('in', $log_list['flow_id']);
		} else {
			$map['_string'] = '1=2';
		}
		if (method_exists($this, '_filter')) {
			$this -> _filter($map);
		}
		$model = D("FlowView");
		if ($_REQUEST['mode'] == 'export') {
			$this -> _folder_export($model, $map);
		} else {
			$this -> _list($model, $map);
		}
		$this -> _assign_flow_type_list();
		$this -> display();
	}

	function _flow_auth_filter($folder, &$map) {
		$emp_no = getusername();
		$user_id = getuserid();
		switch ($folder) {
			case 'confirm' :
				$this -> assign("folder_name", '待办');
				$FlowLog = M("FlowLog");
				$where['emp_no'] = $emp_no;
				//$where['_string'] = "result is null";
				$log_list = $FlowLog -> where($where) -> field('flow_id') -> select();
				//dump($where);
				$log_list = rotate($log_list);
				if (!empty($log_list)) {
					$map['id'] = array('in', $log_list['flow_id']);
				} else {
					$map['_string'] = '1=2';
				}
				//dump($map);
				break;

			case 'darft' :
				$this -> assign("folder_name", '草稿');
				$map['user_id'] = $user_id;
				$map['step'] = 10;
				break;

			case 'submit' :
				$this -> assign("folder_name", '提交');
				$map['user_id'] = array('eq', $user_id);
				$map['step'] = array( array('gt', 10),array('eq', 0), 'or');

				break;

			case 'finish' :
				$this -> assign("folder_name", '办理');
				$FlowLog = M("FlowLog");
				$where['emp_no'] = $emp_no;
				$where['_string'] = "result is not null";
				$log_list = $FlowLog -> where($where) -> field('flow_id') -> select();
				$log_list = rotate($log_list);
				if (!empty($log_list)) {
					$map['id'] = array('in', $log_list['flow_id']);
				} else {
					$map['_string'] = '1=2';
				}
				break;

			case 'receive' :
				$this -> assign("folder_name", '收到');
				$FlowLog = M("FlowLog");
				$where['emp_no'] = $emp_no;
				$where['step'] = 100;
				$log_list = $FlowLog -> where($where) -> field('flow_id') -> select();
				$log_list = rotate($log_list);
				if (!empty($log_list)) {
					$map['id'] = array('in', $log_list['flow_id']);
				} else {
					$map['_string'] = '1=2';
				}
				break;
			case 'report' :
				$this -> assign("folder_name", '统计报告');
				$role_list = D("Role") -> get_role_list($user_id);
				$role_list = rotate($role_list);
				$role_list = $role_list['role_id'];

				$duty_list = D("Role") -> get_duty_list($role_list);
				$duty_list = rotate($duty_list);
				$duty_list = $duty_list['duty_id'];

				if (!empty($duty_list)) {
					$map['report_duty'] = array('in', $duty_list);
					$map['step'] = array('gt', 10);
				} else {
					$this -> error("没有权限：_flow_auth_filter");
				}
				break;
		}
	}

	function folder() {
		$widget['date'] = true;
		$this -> assign("widget", $widget);
		$emp_no = getusername();
		$user_id = getuserid();
		$flow_type_where['is_del'] = array('eq', 0);
		$flow_type_list = M("FlowType") -> where($flow_type_where) -> getField("id,name");
		$this -> assign("flow_type_list", $flow_type_list);
		$map = $this -> _search();
		if (method_exists($this, '_search_filter')) {
			$this -> _search_filter($map);
		}
		$folder = $_REQUEST['fid'];
		$this -> assign("folder", $folder);
		if (empty($folder)) {
			$this -> error("系统错误");
		}
		$this -> _flow_auth_filter($folder, $map);
		$model = D("FlowView");
		if ($_REQUEST['mode'] == 'export') {
			$this -> _folder_export($model, $map);
		} else {
			$this -> _list($model, $map);
		}
		$this -> display();
	}

	private function _folder_export($model, $map) {
		$list = $model -> where($map) -> select();

		//导入thinkphp第三方类库
		Vendor('Excel.PHPExcel');

		//$inputFileName = "Public/templete/contact.xlsx";
		//$objPHPExcel = PHPExcel_IOFactory::load($inputFileName);
		$objPHPExcel = new PHPExcel();

		$objPHPExcel -> getProperties() -> setCreator("YHOA") -> setLastModifiedBy("YHOA") -> setTitle("Office 2007 XLSX Test Document") -> setSubject("Office 2007 XLSX Test Document") -> setDescription("Test document for Office 2007 XLSX, generated using PHP classes.") -> setKeywords("office 2007 openxml php") -> setCategory("Test result file");
		// Add some data
		$i = 1;
		//dump($list);

		//编号，类型，标题，登录时间，部门，登录人，状态，审批，协商，抄送，审批情况，自定义字段
		$objPHPExcel -> setActiveSheetIndex(0) -> setCellValue("A$i", "编号") -> setCellValue("B$i", "类型") -> setCellValue("C$i", "标题") -> setCellValue("D$i", "登录时间") -> setCellValue("E$i", "部门") -> setCellValue("F$i", "登录人") -> setCellValue("G$i", "状态") -> setCellValue("H$i", "审批") -> setCellValue("I$i", "协商") -> setCellValue("J$i", "抄送") -> setCellValue("J$i", "审批情况");
		foreach ($list as $val) {
			$i++;
			//dump($val);
			$id = $val['id'];
			$doc_no = $val["doc_no"];
			//编号
			$name = $val["name"];
			//标题
			$confirm_name = strip_tags($val["confirm_name"]);
			//审批
			$consult_name = strip_tags($val["consult_name"]);
			//协商
			$refer_name = strip_tags($val["refer_name"]);
			//协商
			$type_name = $val["type_name"];
			//流程类型
			$user_name = $val["user_name"];
			//登记人
			$dept_name = $val["dept_name"];
			//不美分
			$create_time = $val["create_time"];
			$create_time = toDate($val["create_time"], 'Y-m-d H:i:s');
			//创建时间
			$step = show_step_type($val["step"]);
			//

			//编号，类型，标题，登录时间，部门，登录人，状态，审批，协商，抄送，审批情况，自定义字段
			$objPHPExcel -> setActiveSheetIndex(0) -> setCellValue("A$i", $doc_no) -> setCellValue("B$i", $type_name) -> setCellValue("C$i", $name) -> setCellValue("D$i", $create_time) -> setCellValue("E$i", $dept_name) -> setCellValue("F$i", $user_name) -> setCellValue("G$i", $step) -> setCellValue("H$i", $confirm_name) -> setCellValue("I$i", $consult_name);

			$model_flow_field = D("FlowField");
			$field_list = $model_flow_field -> get_data_list($id);
			//	dump($field_list);
			$k = 0;
			if (!empty($field_list)) {
				foreach ($field_list as $field) {
					$k++;
					$field_data = $field['name'] . ":" . $field['val'];
					$location = get_cell_location("J", $i, $k);
					$objPHPExcel -> setActiveSheetIndex(0) -> setCellValue($location, $field_data);
				}
			}
		}
		// Rename worksheet
		$objPHPExcel -> getActiveSheet() -> setTitle('流程统计');

		// Set active sheet index to the first sheet, so Excel opens this as the first sheet
		$objPHPExcel -> setActiveSheetIndex(0);
		$file_name = "流程统计.xlsx";
		// Redirect output to a client’s web browser (Excel2007)
		header("Content-Type: application/force-download");
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header("Content-Disposition:attachment;filename =" . str_ireplace('+', '%20', URLEncode($file_name)));
		header('Cache-Control: max-age=0');

		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
		//readfile($filename);
		$objWriter -> save('php://output');
		exit ;
	}

/********* 添加 *********/
	function add() {
		if(IS_POST){
			$model = D('Flow');
			//$data=I('post.');
			$data['user_id']=getuserid();
			//$data['emp_no']=getusername();
			$data['user_name']=gettruename();
			//$data['receiver_name']=$_POST['receiver_name'];
			$data['create_time']=time();
			$data['name']=$_POST['name'];
			if (isset($_POST['content'])){
				$data['content']=$_POST['content'];
			}
			$data['confirm']=$_POST['confirm'];
			$data['confirm_name']=$_POST['confirm_name'];
			$data['consult']=$_POST['consult'];
			$data['consult_name']=$_POST['consult_name'];
			$data['refer']=$_POST['refer'];
			$data['refer_name']=$_POST['refer_name'];
			$data['type']=$_POST['type'];
			$data['add_file']=$_POST['add_file'];
			$data['step']=$_POST['step'];
			$data['attid']=$_POST['attid'];
			//dump($data['confirm']);
			//dump($data['consult']);
			//dump($data['refer']);
			//exit();
			$list = $model -> add($data);
			$model_flow_filed = D("FlowField") -> set_field($list);
			if($list){
				$this->mtReturn(200,L('_OPERATION_SUCCESS_'),$_REQUEST['navTabId'],true);
			}
			else
			{
				$this->mtReturn(300,L('_OPERATION_FAIL_'),$_REQUEST['navTabId'],false);
			}
			return;
		}

		/*2016-06-06 新增*/
		$attid=get_sid('10');//time()
		$this->assign('attid',$attid);
		$user_id = getuserid();
		$this -> assign("uid", $user_id);
		/*2016-06-06 新增*/
		
		$widget['date'] = true;
		$widget['uploader'] = true;
		$widget['editor'] = true;
		$this -> assign("widget", $widget);

		$type_id = $_REQUEST['type'];
		$model = M("FlowType");
		$flow_type = $model -> find($type_id);
		$this -> assign("flow_type", $flow_type);

		$model_flow_field = D("FlowField");
		$field_list = $model_flow_field -> get_field_list($type_id);
		$this -> assign("field_list", $field_list);
		$this -> display();
	}

/********* 显示 *********/
	function read() {
		$widget['uploader'] = true;
		$widget['editor'] = true;
		$this -> assign("widget", $widget);
		$folder = $_REQUEST['fid'];
		$this -> assign("folder", $folder);
		if (empty($folder)) {
			$this->mtReturn(300,L('_OPERATION_FAIL_'),$_REQUEST['navTabId'],false);
		}
		$this -> _flow_auth_filter($folder, $map);

		$model = D("Flow");
		$id = $_REQUEST['id'];
		$where['id'] = array('eq', $id);
		$where['_logic'] = 'and';
		$map['_complex'] = $where;
		$vo = $model -> where($map) -> find();
		//if (empty($vo)) {
		//	$this->mtReturn(300,L('_OPERATION_FAIL_'),$_REQUEST['navTabId'],false);
		//}

		$flow_type_id = $vo['type'];
		$this -> assign('vo', $vo);
		$this -> assign("emp_no", $vo['emp_no']);
		$this -> assign("user_name", $vo['user_name']);

		$model_flow_field = D("FlowField");
		$field_list = $model_flow_field -> get_data_list($id);
		$this -> assign("field_list", $field_list);

		$model = M("FlowType");
		$flow_type = $model -> find($flow_type_id);
		$this -> assign("flow_type", $flow_type);

		$model = M("FlowLog");
		$where = array();
		$where['flow_id'] = $id;
		$where['step'] = array('lt', 100);
		$where['_string'] = "result is not null";
		$flow_log = $model -> where($where) -> order("id") -> select();
		$this -> assign("flow_log", $flow_log);

		$where = array();
		$where['flow_id'] = $id;
		$where['emp_no'] = getusername();
		$where['_string'] = "result is null";
		$to_confirm = $model -> where($where) -> find();
		$this -> assign("to_confirm", $to_confirm);

		if (!empty($to_confirm)) {
			$is_edit = $flow_type['is_edit'];
			$this -> assign("is_edit", $is_edit);
		} else {
			$is_edit = $flow_type['is_edit'];
			if ($is_edit <> "2") {
				$this -> assign("is_edit", 0);
			}
		}

		$where = array();
		$where['flow_id'] = $id;
		$where['_string'] = "result is not null";
		$where['emp_no'] = array('neq', $vo['emp_no']);
		$confirmed = $model -> Distinct(true) -> where($where) -> field('emp_no,user_name') -> select();
		$this -> assign("confirmed", $confirmed);
		$this -> display();
	}

/********* 更新 *********/
	function edit() {
		if(IS_POST){
			$model = D('Flow');
			//$data=I('post.');
			$data['id']=$_POST['id'];
			$data['user_id']=getuserid();
			$data['user_name']=gettruename();
			$data['create_time']=time();
			$data['name']=$_POST['name'];
			if (isset($_POST['content'])){
				$data['content']=$_POST['content'];
			}
			$data['confirm']=$_POST['confirm'];
			$data['confirm_name']=$_POST['confirm_name'];
			$data['consult']=$_POST['consult'];
			$data['consult_name']=$_POST['consult_name'];
			$data['refer']=$_POST['refer'];
			$data['refer_name']=$_POST['refer_name'];
			$data['type']=$_POST['type'];
			$data['add_file']=$_POST['add_file'];
			$data['step']=$_POST['step'];
			//$data['attid']=$_POST['attid'];
			
			//dump($data['confirm']);
			//dump($data['consult']);
			//dump($data['refer']);
			//exit();
			$list = $model -> save($data);
			$model_flow_filed = D("FlowField") -> set_field($data['id']);
			if($list){
				$this->mtReturn(200,L('_OPERATION_SUCCESS_'),'flow/darft',true,1);//$_REQUEST['navTabId']
			}
			else
			{
				$this->mtReturn(300,L('_OPERATION_FAIL_'),$_REQUEST['navTabId'],false);
			}
		}

		$widget['date'] = true;
		$widget['uploader'] = true;
		$widget['editor'] = true;
		$this -> assign("widget", $widget);

		$folder = $_REQUEST['fid'];
		$this -> assign("folder", $folder);

		if (empty($folder)) {
			$this->mtReturn(300,L('_OPERATION_FAIL_'),$_REQUEST['navTabId'],false);
		}
		$this -> _flow_auth_filter($folder, $map);

		$model = D("Flow");
		$id = $_REQUEST['id'];
		$where['id'] = array('eq', $id);
		$where['_logic'] = 'and';
		$map['_complex'] = $where;
		$vo = $model -> where($map) -> find();
		if (empty($vo)) {
			$this->mtReturn(300,L('_OPERATION_FAIL_').'没有数据该数据！',$_REQUEST['navTabId'],false);
		}
		$this -> assign('vo', $vo);
		$model_flow_field = D("FlowField");
		$field_list = $model_flow_field -> get_data_list($id);
		$this -> assign("field_list", $field_list);

		$model = M("FlowType");
		$type = $vo['type'];
		$flow_type = $model -> find($type);
		$this -> assign("flow_type", $flow_type);
		$model = M("FlowLog");
		$where['flow_id'] = $id;
		$where['_string'] = "result is not null";
		$flow_log = $model -> where($where) -> select();

		$this -> assign("flow_log", $flow_log);
		$where = array();
		$where['flow_id'] = $id;
		$where['emp_no'] = getusername();
		$where['_string'] = "result is null";
		$confirm = $model -> where($where) -> select();
		$this -> assign("confirm", $confirm[0]);
		$this -> display();
	}

/********* 审核 *********/
	public function mark() {
		$action = $_REQUEST['action'];
		switch ($action) {
			case 'approve' ://同意
				$model = D("FlowLog");
				if (false === $model -> create()) {
					$this -> error($model -> getError());
				}
				$model -> result = 1;
				$model -> update_time = time();
				$flow_id = $model -> flow_id;
				$step = $model -> step;
				$list = $model -> save();
				$model = D("FlowLog");
				$model -> where("step=$step and flow_id=$flow_id and result is null") -> delete();

				if ($list !== false) {
					D("Flow") -> next_step($flow_id, $step);
					//echo('{"statusCode":"200","message":"'.L('_OPERATION_SUCCESS_').'","closeCurrent":true}');
					$this->mtReturn(200,L('_OPERATION_SUCCESS_'),'flow/confirm',true,1);//保存成功 $_REQUEST['navTabId']
				} else {
					//echo('{"statusCode":"300","message":"'.L('_OPERATION_FAIL_').'","closeCurrent":false}');
					$this->mtReturn(300,L('_OPERATION_FAIL_'),"",false);//失败提示
				}
				break;
			case 'reject' ://否决
				$model = D("FlowLog");
				if (false === $model -> create()) {
					$this -> error($model -> getError());
				}
				$model -> result = 0;
				$model -> update_time = time();
				$flow_id = $model -> flow_id;
				$step = $model -> step;
				$list = $model -> save();
				$model = D("FlowLog");
				$model -> where("step=$step and flow_id=$flow_id and result is null") -> delete();

				if ($list !== false) {
					D("Flow") -> where("id=$flow_id") -> setField('step', 0);
					//$user_id = M("Flow") -> where("id=$flow_id") -> getField('user_id');
					//$this -> _pushReturn($new, "您有一个流程被否决", 1, $user_id);
					$this->mtReturn(200,L('_OPERATION_SUCCESS_'),'flow/confirm',true,1);//保存成功 $_REQUEST['navTabId']
				} else {
					$this->mtReturn(300,L('_OPERATION_FAIL_'),"",false);//失败提示
				}
				break;
			case 'back' :
				$model = D("FlowLog");
				if (false === $model -> create()) {
					$this -> error($model -> getError());
				}
				$model -> result = 2;
				if (in_array('user_id', $model -> getDbFields())) {
					$model -> user_id = getuserid();
				};
				if (in_array('user_name', $model -> getDbFields())) {
					$model -> user_name = gettruename();
				};
				$model -> update_time = time();
				$flow_id = $model -> flow_id;
				$step = $model -> step;
				$list = $model -> save();
				//dump($model-> getLastSql());
				//exit();
				$emp_no=$_REQUEST['emp_no'];
				if ($list !== false) {
					D("Flow") -> next_step($flow_id,$step,$emp_no);
					$this->mtReturn(200,L('_OPERATION_SUCCESS_'),'flow/confirm',true,1);//保存成功
				} else {
					$this->mtReturn(300,L('_OPERATION_FAIL_'),"",false);//失败提示
				}
				break;
			default :
				break;
		}
	}

	public function approve() {

		$model = D("FlowLog");
		if (false === $model -> create()) {
			$this -> error($model -> getError());
		}
		$model -> result = 1;

		$flow_id = $model -> flow_id;
		$step = $model -> step;
		//保存当前数据对象
		$list = $model -> save();

		$model = D("FlowLog");
		$model -> where("step=$step and flow_id=$flow_id and result is null") -> setField('is_del', 1);

		if ($list !== false) {//保存成功
			D("Flow") -> next_step($flow_id, $step);
			$this -> assign('jumpUrl', U('flow/confirm'));
			$this -> success('操作成功!');
		} else {
			//失败提示
			$this -> error('操作失败!');
		}
	}

	public function reject() {
		$model = D("FlowLog");
		if (false === $model -> create()) {
			$this -> error($model -> getError());
		}
		$model -> result = 0;
		if (in_array('user_id', $model -> getDbFields())) {
			$model -> user_id = get_user_id();
		};
		if (in_array('user_name', $model -> getDbFields())) {
			$model -> user_name = get_user_name();
		};

		$flow_id = $model -> flow_id;
		$step = $model -> step;
		//保存当前数据对象
		$list = $model -> save();
		//可以裁决的人有多个人的时候，一个人评价完以后，禁止其他人重复裁决。
		$model = D("FlowLog");
		$model -> where("step=$step and flow_id=$flow_id and result is null") -> setField('is_del', 1);

		if ($list !== false) {//保存成功
			D("Flow") -> where("id=$flow_id") -> setField('step', 0);

			$user_id = M("Flow") -> where("id=$flow_id") -> getField('user_id');

			//$this -> _pushReturn($new, "您有一个流程被否决", 1, $user_id);

			$this -> assign('jumpUrl', U('flow/confirm'));
			$this -> success('操作成功!');
		} else {
			//失败提示
			$this -> error('操作失败!');
		}
	}

	public function down() {
		$this -> _down();
	}

	public function upload() {
		$this -> _upload();
	}

	protected function _assign_tag_list() {
		$model = D("SystemTag");
		$tag_list = $model -> get_tag_list('id,name', 'FlowType',0);
		$this -> assign("tag_list", $tag_list);
	}
	
	protected function _assign_flow_type_list() {
		
		//$flow_type_where['is_del'] = array('eq', 0);
		//$flow_type_list = M("FlowType") -> where($flow_type_where) -> getField("id,name");
		//$this -> assign("flow_type_list", $flow_type_list);

		$model = D("FlowType");
		$flow_type_list = $model -> get_tag_list();
		$this -> assign("flow_type_list", $flow_type_list);
	}

	
}
