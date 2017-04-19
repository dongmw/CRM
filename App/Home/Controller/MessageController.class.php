<?php
/**
 * 消息控制器
 */

namespace Home\Controller;
use Think\Controller;

class MessageController extends CommonController{

	public function _initialize() {
		parent::_initialize();
	}
	
	public function index(){ 
		//$this->dbname = 'auth_group';
		$list=orgcateTree($pid=0,$level=0,$type=0);
		$this->assign('list',$list);
		
/*---------------------------------------------------------

1. 获取部门表数据，分析结果后数组：部门ID => 部门标题
2. 获取用户表数据，分析结果后数组：部门ID => 用户信息数组
3. 页面模板中，循环用户数组： 部门标题（按部门ID从部门数组中取标题），列出用户

//Action:
$str_depname =M('auth_group')->where('type=0')->order("id")->select();
foreach($str_depname as $k=>$v){
	$depArr[$v['title']] = $v['title'];
}

$str_user=M('user')->where('status=1')->order("id")->select();
foreach($str_user as $k=>$v){
	$infoArr[$v['depname']][] =$v;
}

$this->assign('depArr', $depArr);
$this->assign('infoArr', $infoArr);

//view:
<foreach name="infoArr" item="list" key='k'>
<tr data-id="{$depArr[$k]}">
<td></td>
<td>{$depArr[$k]}</td>
<td> 
	<foreach name="list" item="item">
      {$item.truename}
	</foreach>
</td>
</tr>
</foreach>

---------------------------------------------------------*/

		$this->display();
	}
	
	public function add($id,$name) {
		//添加信息
		if(IS_POST){
			$model1 = D('message');
			//$data=I('post.');			
			$data['sender_id']=getuserid();
			$data['sender_name']=gettruename();
			$data['receiver_id']=$_POST['receiver_id'];
			$data['receiver_name']=$_POST['receiver_name'];
			$data['content']=htmlspecialchars($_POST['content']);
			$data['create_time']=time();
			$data['owner_id']=getuserid();
			$list1 = $model1 -> add($data);
			//dump($data);
		
			$data['owner_id']=$_POST['receiver_id'];
			$list2 = $model1 -> add($data);
			//dump($data);
			
			if (method_exists($this, '_befor_insert')) {
				$data = $this->_befor_insert($data);
			}
			if($list1 && $list2){
				if (method_exists($this, '_after_add')) {
					$id = $model1->getLastInsID();
					$this->_after_add($id);
				}
				$id = $model1->getLastInsID();
				$this->mtReturn(200,'','dialog-user-'.$data['receiver_id'],false,1);
			}
			else
			{
				$this->mtReturn(300,L('_OPERATION_FAIL_'),'',false);
			}
		}
		
		//更新信息状态为已读
		$m = new \Think\Model();
		$tablePrefix = C('DB_PREFIX');
		$user_id = getuserid();
		$sqlMessage = "update ".$tablePrefix."message set is_read=1 where receiver_id = ".$user_id." and owner_id = ".$user_id." and sender_id = ".$id." and status = 0 and is_read = 0";
		$rsMessage = $m->execute($sqlMessage);
		
		//显示用户聊天信息
		$this->dbname = 'message';
		$this->assign('sender_id',getuserid());
		$this->assign('sender_name',gettruename());
		$this->assign('receiver_id',$id);
		$this->assign('receiver_name',$name);
		$this->assign('list',get_MessageList($id));
		if (method_exists($this, '_befor_add')) {
			$this->_befor_add();
		}
		$this->display();
	}

	public function del($id,$name) {
		//更新信息状态为删除
		$m = new \Think\Model();
		$tablePrefix = C('DB_PREFIX');
		$user_id = getuserid();
		$sqlMessage = "update ".$tablePrefix."message set status=1 where (owner_id = ".$user_id." and sender_id = ".$user_id." and receiver_id = ".$id." and status = 0) or (owner_id = ".$user_id." and sender_id = ".$id." and receiver_id = ".$user_id." and status = 0)";
		$rsMessage = $m->execute($sqlMessage);
		if($rsMessage){
			$this->mtReturn(200,L('_OPERATION_SUCCESS_'),$_REQUEST['navTabId'],false);
		}
		else
		{
			$this->mtReturn(300,L('_OPERATION_FAIL_'),$_REQUEST['navTabId'],false);
		}
	}

}