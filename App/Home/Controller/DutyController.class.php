<?php
namespace Home\Controller;
use Think\Controller;
 
class DutyController extends CommonController {
	//protected $config=array('app_type'=>'master');

	public function _initialize() {
		parent::_initialize();
        $this->dbname = 'duty';
	}
	
	public function index(){ 
		$info = M($this->dbname); 
		$list = $info->order('sort')->select();
		$this->assign('list',$list);
		$this->display(); 
	}

	public function role(){ 
		$list=orgcateTree($pid=0,$level=0,$type=1);
		$this->assign('list',$list);
		$this->display(); 
	}

	public function EditRole(){ 
		if (IS_POST){
/*			$data['role_id']=I('id');
			$data['rules']=implode(',',I('rules'));
			M('auth_group')->data($data)->save();
			$this->mtReturn(200,'权限设置成功',$_REQUEST['navTabId']);
*/			
			$role_id = $_POST["id"];
			$duty_list = $_POST["rules"];
	
			$model = D("RoleDuty");
			$model -> del_duty($role_id);
	
			$result = $model -> set_duty($role_id,$duty_list);
			if ($result === false) {
				$this->mtReturn(300,'权限设置失败','');
			} else {
				$this->mtReturn(200,'权限设置成功','');//$_REQUEST['navTabId']
			}
		}
		
		$duty = M("Duty");
		$duty_list = $duty -> select();
		$this -> assign("duty_list", $duty_list);

		$id=I('get.id');
		$info = M('role_duty'); 
		$rs='0';
		$rss = $info->where('role_id='.I('get.id'))->order('duty_id')->field('duty_id')->select();
		for ($i=0;$i<count($rss);$i++){
			$rs .= ','.$rss[$i]['duty_id'];
		}
		$rs = explode(',',$rs);
		//dump($rs);
		//exit();
		$this->assign('id',$id);
		$this->assign('rs',$rs);
		$this->display(); 
	}

	public function user() {
		$keyword = "";
		if (!empty($_POST['keyword'])) {
			$keyword = $_POST['keyword'];
		}
		$user_list = D("User") -> get_user_list($keyword);
		$this -> assign("user_list", $user_list);

		$role = M("Duty");
		$duty_list = $role-> order('sort asc') -> select();
		$this -> assign("duty_list", $duty_list);
		$this -> display();
	}
}
?>