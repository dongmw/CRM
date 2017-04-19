<?php

/**
 *      仓库管理控制器
 *      [ZLSYS] (C)2008-2099  
 *      This is NOT a freeware, use is subject to license terms
 *      http://www.zhelininternet.com
 *      tel:13811836808
 *      qq:185530523
 */

namespace Home\Controller;
use Think\Controller;

class JxcwarehouseController extends CommonController{

	public function _initialize() {
		parent::_initialize();
		$this->dbname = CONTROLLER_NAME;
	}
	
	function _filter(&$map) {
		//if(!in_array(session('uid'),C('ADMINISTRATOR'))){
		//$map['id'] = array('EQ', session("uid"));
		//}
	}
	
	public function _befor_index(){ 
		$list=cateTree($pid=0,$level=0,$this->dbname);
		$this->assign('list',$list);	
	}
	
	public function _befor_add(){
		$list=cateTree($pid=0,$level=0,$this->dbname);
		$this->assign('list',$list);	
		$attid=get_sid(10);
		$this->assign('attid',$attid);
	}
	
	public function _after_add($id){
	
	}
	
	public function _befor_insert($data){
		$data['uid']=getuserid();
		$data['uname']=getusername();
		$data['addtime']=date("Y-m-d H:i:s",time());
		return $data;
	}
	
	public function _befor_edit(){
		$list=cateTree($pid=0,$level=0,$this->dbname);
		$this->assign('list',$list);	
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
		if(I('post.pid') != $info['pid']){
			$str.='所属类别:'.$info['pid'].' 改为 '.I('post.pid').';';
			$i++;
		}
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
		$data['uuid']=getuserid();
		$data['uuname']=getusername();
		$data['updatetime']=date("Y-m-d H:i:s",time());
		return $data;
	}
	
	public function _after_edit($id){
	
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
		$filename='仓库管理';
		$this->xlsout($filename,$headArr,$list);
	}
	

}