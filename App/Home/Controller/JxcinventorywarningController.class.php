<?php

/**
 *      库存预警控制器
 *      [ZLSYS] (C)2008-2099  
 *      This is NOT a freeware, use is subject to license terms
 *      http://www.zhelininternet.com
 *      tel:13811836808
 *      qq:185530523
 */

namespace Home\Controller;
use Think\Controller;

class JxcinventorywarningController extends CommonController{

	public function _initialize() {
		parent::_initialize();
		$this->dbname = 'jxcwarehouselist';
	}
	
	function _filter(&$map) {
		//if(!in_array(session('uid'),C('ADMINISTRATOR'))){
		//$map['id'] = array('EQ', session("uid"));
		//}
		//$map['id'] = array('EQ', session("uid"));
	}
	
	//库存预警
	public function index(){
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
		
		//$sql.= "select t1.*, t2.mc_id,t2.mi_bh,t2.mi_mc,t2.mi_gg,t2.mi_dw,t2.mi_sx,t2.mi_xx ";
		//$sql.= " from ".$tablePrefix."jxcwarehouselist t1, ".$tablePrefix."jxcinformation t2 ";
		//$sql.= " where t1.mi_id=t2.id and ((t1.mwl_num > t2.mi_sx) or (t1.mwl_num < t2.mi_xx)) ".$str_where." order by t1.mw_id asc,t1.sort asc";
		
		$sql.= "select t3.name as mw_id,t4.name as mc_id,t2.mi_bh,t2.mi_mc,t2.mi_gg,t5.name as mi_dw,t2.mi_sx,t2.mi_xx,t1.mwl_num ";
		$sql.= " from ".$tablePrefix."jxcwarehouselist t1, ".$tablePrefix."jxcinformation t2, ".$tablePrefix."jxcwarehouse t3, ".$tablePrefix."jxccategory t4, ".$tablePrefix."system_tag t5 ";
		$sql.= " where t1.mi_id=t2.id and ((t1.mwl_num > t2.mi_sx) or (t1.mwl_num < t2.mi_xx)) and t1.mw_id=t3.id and t2.mc_id=t4.id and t2.mi_dw=t5.id ".$str_where." order by t1.mw_id asc,t1.sort asc";
		
		$list = $m->query($sql);
		$this -> assign("id", $id);
		$this -> assign("list", $list);
		
		$mw_id_list=cateTree($pid=0,$level=0,'jxcwarehouse');
		$this->assign('mw_id_list',$mw_id_list);	

		$this->display();
	}
		
	public function outxls() {
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
		$sql.= "select t3.name as mw_id,t4.name as mc_id,t2.mi_bh,t2.mi_mc,t2.mi_gg,t5.name as mi_dw,t2.mi_sx,t2.mi_xx,t1.mwl_num ";
		$sql.= " from ".$tablePrefix."jxcwarehouselist t1, ".$tablePrefix."jxcinformation t2, ".$tablePrefix."jxcwarehouse t3, ".$tablePrefix."jxccategory t4, ".$tablePrefix."system_tag t5 ";
		$sql.= " where t1.mi_id=t2.id and ((t1.mwl_num > t2.mi_sx) or (t1.mwl_num < t2.mi_xx)) and t1.mw_id=t3.id and t2.mc_id=t4.id and t2.mi_dw=t5.id ".$str_where." order by t1.mw_id asc,t1.sort asc";
		$list = $m->query($sql);

		//$list = $model->where($map)->field('t1.mwl_num,t1.mw_id,t1.mc_id,t2.mi_bh,t2.mi_mc,t2.mi_gg,t2.mi_dw,t2.mi_sx,t2.mi_xx')->select();
		$headArr=array('仓库','商品类别','商品编号','商品名称','规格型号','单位','最高库存','最低库存','当前库存');
		$filename='库存预警';
		$this->xlsout($filename,$headArr,$list);
	}
	

}