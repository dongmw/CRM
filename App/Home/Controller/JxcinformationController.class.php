<?php

/**
 *      品种信息管理控制器
 *      [ZLSYS] (C)2008-2099  
 *      This is NOT a freeware, use is subject to license terms
 *      http://www.zhelininternet.com
 *      tel:13811836808
 *      qq:185530523
 */

namespace Home\Controller;
use Think\Controller;

class JxcinformationController extends CommonController{

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
		$list_jxccategory=cateTree($pid=0,$level=0,'jxccategory');
		$this->assign('list_jxccategory',$list_jxccategory);
	}
	
	public function _befor_add(){
		$model1 = D('SystemTag');
		$type_list = $model1 -> get_tag_list('id,name', 'UnitType', 10, '');
		$this->assign("type_list", $type_list);
		
		$list_jxccategory=cateTree($pid=0,$level=0,'jxccategory');
		$this->assign('list_jxccategory',$list_jxccategory);	
		$attid=get_sid(10);
		$this->assign('attid',$attid);
	}
	
	public function _after_add($id){
	
	}
	
	public function _befor_insert($data){
		$mi_cj=I('post.mi_cj');
		$data['mi_cj']=$mi_cj[1];//生产厂家
		$mw_id=I('post.mw_id');
		$data['mw_id']=$mw_id[1];//首选仓库
		$data['uid']=getuserid();
		$data['uname']=getusername();
		$data['addtime']=date("Y-m-d H:i:s",time());
		return $data;
	}
	
	public function _befor_edit(){
		$model1 = D('SystemTag');
		$type_list = $model1 -> get_tag_list('id,name', 'UnitType', 10, '');
		$this->assign("type_list", $type_list);
		
		$list_jxccategory=cateTree($pid=0,$level=0,'jxccategory');
		$this->assign('list_jxccategory',$list_jxccategory);	
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
		if(I('post.mc_id') != $info['mc_id']){
			$str.='类别:'.$info['mc_id'].' 改为 '.I('post.mc_id').';';
			$i++;
		}
		if(I('post.mi_mc') != $info['mi_mc']){
			$str.='名称:'.$info['mi_mc'].' 改为 '.I('post.mi_mc').';';
			$i++;
		}
		if(I('post.mi_bh') != $info['mi_bh']){
			$str.='编号:'.$info['mi_bh'].' 改为 '.I('post.mi_bh').';';
			$i++;
		}
		if(I('post.sort') != $info['sort']){
			$str.='排序:'.$info['sort'].' 改为 '.I('post.sort').';';
			$i++;
		}
		if(I('post.mi_bz') != $info['mi_bz']){
			$str.='备注:'.$info['mi_bz'].' 改为 '.I('post.mi_bz').';';
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
		
		$mi_cj=I('post.mi_cj');
		$data['mi_cj']=$mi_cj[1];//生产厂家
		$mw_id=I('post.mw_id');
		$data['mw_id']=$mw_id[1];//首选仓库
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
		$list = $model->where($map)->field('id,mi_bh,MI_mc,MI_gg,MI_bz,addtime,updatetime')->select();
		$headArr=array('ID','名称','编号','规格','备注','添加时间','更新时间');
		$filename='品种信息管理';
		$this->xlsout($filename,$headArr,$list);
	}
	

}