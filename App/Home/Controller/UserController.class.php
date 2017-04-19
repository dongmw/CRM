<?php
namespace Home\Controller;
use Think\Controller;
class UserController extends CommonController {
   
    public function _initialize() {
        parent::_initialize();
        $this->dbname = CONTROLLER_NAME;
    }
	
	public function _befor_add(){
		$list=orgcateTree($pid=0,$level=0,$type=0);
		$this->assign('list',$list);
		
		$listz=orgcateTree($pid=0,$level=0,$type=1);
		$this->assign('listz',$listz);

		$listu=userTree($level=0);
		$this->assign('listu',$listu);

		$this->display(); 
	}
  
	public function _befor_insert($data){
		$password=md5(md5(I('pwd')));
		$data['password']=$password;
		unset($data['pwd']);
		return $data;
	}

	public function _befor_edit(){
		$list=orgcateTree($pid=0,$level=0,$type=0);
		$this->assign('list',$list);
		
		$listz=orgcateTree($pid=0,$level=0,$type=1);
		$this->assign('listz',$listz);

		$listu=userTree($level=0);
		$this->assign('listu',$listu);

		$this->display(); 
	}
  
	public function _befor_update($data){
		if (strlen(I('pwd'))!==32){
			$password=md5(md5(I('pwd')));
			$data['password']=$password;
		}
		unset($data['pwd']);
		return $data;
	}
   
	public function editrule(){
		$uid=I('get.id');
		//if ($uid<>session('uid')){
		M('auth_group_access')->where('uid='.$uid.'')->delete(); 
		$gcdata['uid']=$uid;
		$gcdata['group_id']=M('auth_group')->where(array("title"=>I('get.depname')))->getField('id');
		M('auth_group_access')->data($gcdata)->add();
		$gcdata['group_id']=M('auth_group')->where(array("title"=>I('get.posname')))->getField('id');
		M('auth_group_access')->data($gcdata)->add();
		$this->mtReturn(200,"设置成功".$id,$_REQUEST['navTabId'],false); 
		//}
	}
	
	protected function _after_edit($id){
		$uid=$id;
		M('auth_group_access')->where('uid='.$uid.'')->delete(); 
		$gcdata['uid']=$uid;
		$dept_id = M('auth_group')->where(array("title"=>I('post.depname')))->getField('id');
		$gcdata['group_id']=$dept_id;
		M('auth_group_access')->data($gcdata)->add();
		$position_id = M('auth_group')->where(array("title"=>I('post.posname')))->getField('id');
		$gcdata['group_id']=$position_id;
		M('auth_group_access')->data($gcdata)->add();
		$udata['dept_id'] = $dept_id;
		$udata['position_id'] = $position_id;
		M('user')->where('id='.$uid)->save($udata);
		//dump($uid);
		//dump($udata['dept_id']);
		//dump($udata['position_id']);
		//exit();
	}
	
	protected function _after_add($id){
		$uid=$id;
		M('auth_group_access')->where('uid='.$uid.'')->delete(); 
		$gcdata['uid']=$uid;
		$dept_id = M('auth_group')->where(array("title"=>I('post.depname')))->getField('id');
		$gcdata['group_id']=$dept_id;
		M('auth_group_access')->data($gcdata)->add();
		$position_id = M('auth_group')->where(array("title"=>I('post.posname')))->getField('id');
		$gcdata['group_id']=$position_id;
		M('auth_group_access')->data($gcdata)->add();
		$udata['dept_id'] = $dept_id;
		$udata['position_id'] = $position_id;
		M('user')->where('id='.$uid)->save($udata);
		//dump($uid);
		//dump($udata['dept_id']);
		//dump($udata['position_id']);
		//exit();
	}

	public function _befor_del($id){
		$uid=$id; 
		M('auth_group_access')->where('uid='.$uid.'')->delete(); 
	}
	
}