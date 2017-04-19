<?php
namespace Home\Widget;
use Think\Controller;
class JxcContactWidget extends Controller {
	
	/*public function add($id,$attid,$module) {
		$data['id'] = $id;
		$data['uid'] = getuserid();
		$data['attid'] = $attid;
		$data['module'] = $module;
		$this -> assign($data);
		$this -> display('Widget:FileUpload/add');
	}*/

	public function edit($id,$attid,$module) {
		if (!empty($attid) && !empty($id)) {
			$where['attid'] = $attid;
			$where['status'] = 1;
			$model = M("Jxccontact");
			$contact_list = $model -> where($where) -> select();
			$data['id'] = $id;
			$data['attid'] = $attid;
			$data['uid'] = getuserid();
			$data['module'] = $module;
			$data['contact_list'] = $contact_list;
			$this -> assign($data);
		}		
		$this -> display('Widget:JxcContact/edit');
	}

	/*public function view($attid) {
		if (!empty($attid)) {
			$where['attid'] = $attid;
			$where['status'] = 1;
			$model = M("Files");
			$file_list = $model -> where($where) -> select();
			$data['file_list'] = $file_list;
			$this -> assign($data);
		}
		$this -> display('Widget:FileUpload/view');
	}*/

}
?>