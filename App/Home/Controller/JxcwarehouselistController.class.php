<?php

/**
 *      库存明细管理控制器
 *      [ZLSYS] (C)2008-2099  
 *      This is NOT a freeware, use is subject to license terms
 *      http://www.zhelininternet.com
 *      tel:13811836808
 *      qq:185530523
 */

namespace Home\Controller;
use Think\Controller;

class JxcwarehouselistController extends CommonController{

	public function _initialize() {
		parent::_initialize();
		$this->dbname = CONTROLLER_NAME;
	}
	
	function _filter(&$map) {
		//if(!in_array(session('uid'),C('ADMINISTRATOR'))){
		//$map['id'] = array('EQ', session("uid"));
		//}
		//$map['id'] = array('EQ', session("uid"));
	}
	
	//盘点
	public function inventory(){
		$id = I('get.id');
		$model1 = D($this->dbname);
		$m = M();
		$tablePrefix = C('DB_PREFIX');
		//$map1['mi_id'] = array('eq', $id);
		
		$str_where = '';
		//if (IS_POST) {
			if (!empty($_REQUEST['mw_id'])) {
				$mw_id = $_REQUEST['mw_id'];
				$str_where.=" and t1.mw_id = ".$mw_id."";
			}
			if($_REQUEST['iszero'] == true){
				
			} else {
				$str_where.=" and t1.mwl_num > 0";
			}
		//}
		
		$sql.= "select t1.*, t2.mc_id,t2.mi_bh,t2.mi_mc,t2.mi_gg,t2.mi_dw ";
		$sql.= " from ".$tablePrefix."jxcwarehouselist t1, ".$tablePrefix."jxcinformation t2 ";
		$sql.= " where t1.mi_id=t2.id ".$str_where." order by t1.mw_id asc,t1.sort asc";
		
		$list = $m->query($sql);
		$this -> assign("id", $id);
		$this -> assign("list", $list);
    	//$str_all = $m->query("select sum(mwl_num) num1, sum(mwl_initnum) num2 from ".$tablePrefix."jxcwarehouselist where mi_id=".$id."");
    	$str_all = $m->query("select sum(t1.mwl_num) num1 from ".$tablePrefix."jxcwarehouselist t1 where 1=1 ".$str_where."");
		if($str_all){
            $num_all1 = $str_all[0]['num1'];
		}else{
			$num_all1 = 0;
		}
		$this -> assign("num_all1", $num_all1);
		
		$mw_id_list=cateTree($pid=0,$level=0,'jxcwarehouse');
		$this->assign('mw_id_list',$mw_id_list);	

		$this->display();
	}
	
	public function index(){
		$id = I('get.id');
		$model1 = D($this->dbname);
		$map1['mi_id'] = array('eq', $id);
		if (!empty($model1)) {
			$list = $model1 -> where($map1) -> order('sort asc,id asc') -> select();
		}
		$this -> assign("id", $id);
		$this -> assign("list", $list);
		$m = M();
		$tablePrefix = C('DB_PREFIX');
    	$str_all = $m->query("select sum(mwl_num) num1, sum(mwl_initnum) num2 from ".$tablePrefix."jxcwarehouselist where mi_id=".$id."");
		if($str_all){
            $num_all1 = $str_all[0]['num1'];
            $num_all2 = $str_all[0]['num2'];
		}else{
			$num_all1 = 0;
			$num_all2 = 0;
		}
		$this -> assign("num_all1", $num_all1);
		$this -> assign("num_all2", $num_all2);
		$this->display();
	}
	
	public function add() {
		if(IS_POST){
			$model = D($this->dbname);
			
			$mi_id = I('post.mi_id');
			$mw_id = I('post.mw_id');
			$mwl_initnum = I('post.mwl_initnum');
			$mwl_price = I('post.mwl_price');
			$sort = I('post.sort');

			$m_jxcwarehouselist = M($this->dbname);
			$m_info = $m_jxcwarehouselist->field('id,mwl_num,mwl_initnum')->where('mi_id='.$mi_id.' and mw_id='.$mw_id.'')->find();
			//$result = $m_jxcwarehouselist->fetchSql(true)->field('id,mwl_num')->where('mi_id='.$data1['mi_id'].' and mw_id='.$data1['mw_id'].'')->find();
			if (isset($m_info)){
				$this->mtReturn(300,L('_OPERATION_FAIL_').'期初仓库不能相同！',$_REQUEST['navTabId'],false,1);
			}else{
				$m_jxcwarehouselist = M($this->dbname);
				$m_data2['uid']=getuserid();
				$m_data2['uname']=getusername();
				$m_data2['addtime']=date("Y-m-d H:i:s",time());
				$m_data2['mi_id']=$mi_id;
				$m_data2['mw_id']=$mw_id;
				$m_data2['mwl_num']=$mwl_initnum;
				$m_data2['mwl_initnum']=$mwl_initnum;
				$m_data2['mwl_price']=$mwl_price;
				$m_data2['sort']=$sort;
				//$result1 = $m_jxcwarehouselist->fetchSql(true)->add($m_data2);
				//dump($m_data2);
				if($m_jxcwarehouselist -> add($m_data2)){
					$this->mtReturn(200,L('_OPERATION_SUCCESS_'),$_REQUEST['navTabId'],true,1);
				}
				else
				{
					$this->mtReturn(300,L('_OPERATION_FAIL_'),$_REQUEST['navTabId'],false,1);
				}
			}
		}
		if (method_exists($this, '_befor_add')) {
			$this->_befor_add();
		}
		$this->display();
	}
	
	public function _befor_add(){
		$id = I('get.id');
		$this -> assign("id", $id);
		$mw_id_list=cateTree($pid=0,$level=0,'jxcwarehouse');
		$this->assign('mw_id_list',$mw_id_list);	
		//$attid=get_sid(10);
		//$this->assign('attid',$attid);
	}
	public function _after_add($id){
	
	}
	
	public function _befor_insert($data){
		$data['mwl_num']=$data['mwl_initnum'];
		$data['uid']=getuserid();
		$data['uname']=getusername();
		$data['addtime']=date("Y-m-d H:i:s",time());
		return $data;
	}
	
	public function _befor_edit(){
		$id = I('get.id');
		$this -> assign("id", $id);
		$mw_id_list=cateTree($pid=0,$level=0,'jxcwarehouse');
		$this->assign('mw_id_list',$mw_id_list);	
		//$model = D($this->dbname);
		//$info = $model->find(I('get.id'));
		//$attid=$info['attid'];
		//$this->assign('attid',$attid);
	}
	
	public function edit() {
		$model = D($this->dbname);
		if(IS_POST){
			$data=I('post.');
			if (false === $data = $model->create()) {
				$this->mtReturn(300,'失败，请检查值是否已经存在',$_REQUEST['navTabId'],true);  
			}
			if (method_exists($this, '_befor_update')) {
				$data = $this->_befor_update($data);
			}
			if($model->save($data)){
				if (method_exists($this, '_after_edit')) {
					$id = $data['id'];
					$this->_after_edit($id);
				}
			}
			$id = $data['id'];
				$this->mtReturn(200,L('_OPERATION_SUCCESS_'),$_REQUEST['navTabId'],true,1);
		}
		if (method_exists($this, '_befor_edit')) {
			$this->_befor_edit();
		}
		$id = $_REQUEST [$model->getPk()];
		$vo = $model->getById($id);
		$this->assign('id',$id);
		$this->assign('Rs', $vo);
		$this->display();
	}
	
	public function _befor_update($data){
		$model = D($this->dbname);
		$info = $model->find(I('post.id'));
		$data['mwl_num']=$info['mwl_num']-($info['mwl_initnum']-$data['mwl_initnum']);
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
		$filename='账户管理';
		$this->xlsout($filename,$headArr,$list);
	}
	

}