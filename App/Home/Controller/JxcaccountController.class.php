<?php

/**
 *      账户管理-结算账户管理控制器
 *      [ZLSYS] (C)2008-2099  
 *      This is NOT a freeware, use is subject to license terms
 *      http://www.zhelininternet.com
 *      tel:13811836808
 *      qq:185530523
 */

namespace Home\Controller;
use Think\Controller;

class JxcaccountController extends CommonController{

	public function _initialize() {
		parent::_initialize();
		$this->dbname = CONTROLLER_NAME;
	}
	
	function _filter(&$map) {
		//if(!in_array(session('uid'),C('ADMINISTRATOR'))){
		//$map['id'] = array('EQ', session("uid"));
		//}
		$map['id'] = array('EQ', session("uid"));
	}
	
	public function _befor_index(){
		$model1 = D($this->dbname);
		$map1['is_del'] = array('eq', '0');
		if (!empty($model1)) {
			$list = $model1 -> where($map1) -> order('sort asc,id asc') -> select();
		}
		$this -> assign("list", $list);
		//$list=cateTree($pid=0,$level=0,$this->dbname);
		//$this->assign('list',$list);	
	}
	
	public function add() {
		if(IS_POST){
			$model = D($this->dbname);
			$data=I('post.');
			if (false === $data = $model->create()) {
				$this->mtReturn(300,'失败，请检查值是否已经存在',$_REQUEST['navTabId'],true);  
			}
			if (method_exists($this, '_befor_insert')) {
				$data = $this->_befor_insert($data);
			}
			if($model->add($data)){
				$id = $model->getLastInsID();
				//账户明细表
				$model1 = D('jxcaccountlist');
				$data1['pid'] = $id;
				$data1['addtime'] = date("Y-m-d H:i:s",time());
				$data1['uid']=getuserid();
				$data1['uname']=getusername();
				$data1['number'] = $data['number'];
				$data1['ywtype'] = 128;//业务类型
				$data1['income'] = $data['initbalance'];//收入
				$data1['expenditure'] = 0;//支出
				$data1['balance'] = $data['initbalance'];//当前余额
				$model1->add($data1);
				//账户明细表
				$this->mtReturn(200,"新增成功".$id,$_REQUEST['navTabId'],true);  
			}
			else
			{
				$this->mtReturn(300,'添加失败'.$this->dbname,$_REQUEST['navTabId'],true);  
			}
		}
		$attid=get_sid(10);
		$this->assign('attid',$attid);
		$this->display();
	}
	
	public function _befor_add(){
	}
	
	public function _after_add($id){
	}
	
	public function _befor_insert($data){
		$data['balance']=$data['initbalance'];
		$data['uid']=getuserid();
		$data['uname']=getusername();
		$data['addtime']=date("Y-m-d H:i:s",time());
		return $data;
	}
	
	public function _befor_edit(){
		//$list=cateTree($pid=0,$level=0,$this->dbname);
		//$this->assign('list',$list);	
		$model = D($this->dbname);
		$info = $model->find(I('get.id'));
		$attid=$info['attid'];
		$this->assign('attid',$attid);
	}
	
	public function _befor_update($data){
		/* 修改信息保存历史记录 开始 */
		$i=0;
		$model = D($this->dbname);
		$info = $model->find(I('post.id'));
		$id=$info['id'];
		$history=$info['history'];
		$str_br = '';
		if (!empty($history)) {
			$str_br = '<br>';
		}
		$str=$history.$str_br.gettruename().'['.date("Y-m-d H:i:s",time())."] ";
		if(I('post.name') != $info['name']){
			$str.='名称:'.$info['name'].' 改为 '.I('post.name').';';
			$i++;
		}
		if(I('post.number') != $info['number']){
			$str.='编号:'.$info['number'].' 改为 '.I('post.number').';';
			$i++;
		}
		if(I('post.sort') != $info['sort']){
			$str.='排序:'.$info['sort'].' 改为 '.I('post.sort').';';
			$i++;
		}
		if(I('post.beizhu') != $info['beizhu']){
			$str.='备注:'.$info['beizhu'].' 改为 '.I('post.beizhu').';';
		}
		if(empty($info['uuname'])){
			if(getusername() != $info['uname']){
				$str.='修改用户:'.$info['uname'].' 改为 '.getusername().';';
				$str.='修改时间:'.$info['updatetime'].' 改为 '.date("Y-m-d H:i:s",time()).';';
				$i++;
			}
		} else if(getusername() != $info['uuname']){
			$str.='修改用户:'.$info['uuname'].' 改为 '.getusername().';';
			$str.='修改时间:'.$info['updatetime'].' 改为 '.date("Y-m-d H:i:s",time()).';';
			$i++;
		}
		if ($i > 0) {
			$data['history']=$str;//2015-06-27【新增】修改信息保存历史记录
		}
		/* 修改信息保存历史记录 结束 */
		$data['balance']=$info['balance']-($info['initbalance']-$data['initbalance']);
		$data['uuid']=getuserid();
		$data['uuname']=getusername();
		$data['updatetime']=date("Y-m-d H:i:s",time());
		return $data;
	}
	
	public function _after_edit($id){
		$model0 = D($this->dbname);
		$info = $model0->find($id);
		//账户明细表
		$model1 = D('jxcaccountlist');
		$data1['uid']=getuserid();
		$data1['uname']=getusername();
		$data1['number'] = $info['number'];
		$data1['ywtype'] = 128;//业务类型
		$data1['income'] = $info['initbalance'];//收入
		$data1['expenditure'] = 0;//支出
		$data1['balance'] = $info['initbalance'];//当前余额
		$model1->where('ywtype=128 and pid='.$info['id'].'')->save($data1);
		//账户明细表
	}
	
	public function _befor_del($id){
	
	}
	
	public function outxls() {
		$model = D($this->dbname);
		$map = $this->_search();
		if (method_exists($this, '_filter')) {
			$this->_filter($map);
		}
		$list = $model->where($map)->field('id,name,number,sort,status,beizhu,addtime,updatetime')->select();
		$headArr=array('ID','名称','编号','排序','状态','备注','添加时间','更新时间');
		$filename='账户管理';
		$this->xlsout($filename,$headArr,$list);
	}
	

}