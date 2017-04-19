<?php

/**
 *      现金银行报表控制器
 *      [ZLSYS] (C)2008-2099  
 *      This is NOT a freeware, use is subject to license terms
 *      http://www.zhelininternet.com
 *      tel:13811836808
 *      qq:185530523
 */

namespace Home\Controller;
use Think\Controller;

class JxccashbankjournalController extends CommonController{

	public function _initialize() {
		parent::_initialize();
		$this->dbname = 'jxcaccountlist';
	}
	
	function _filter(&$map) {
		//if(!in_array(session('uid'),C('ADMINISTRATOR'))){
		//$map['id'] = array('EQ', session("uid"));
		//}
		//$map['id'] = array('EQ', session("uid"));
	}
	
	//现金银行报表列表页
	public function index(){
		$model1 = D($this->dbname);
		$m = M();
		$tablePrefix = C('DB_PREFIX');
		
		$str_where = '';
		if (!empty($_REQUEST['pid'])) {
			$pid = $_REQUEST['pid'];
			$str_where.=" and t1.pid = ".$pid."";
		}
		if(isset($_REQUEST['time1']) && $_REQUEST['time1'] != '' && isset($_REQUEST['time2']) && $_REQUEST['time2'] != ''){
			//$str_where.=" and t1.addtime >= '".I('time1')."' and t1.addtime <= '".I('time2')."'";
			$str_where.=" and DATE_FORMAT(t1.addtime,'%Y-%m-%d') >= '".I('time1')."' and DATE_FORMAT(t1.addtime,'%Y-%m-%d') <= '".I('time2')."'";
		}else{
			//$str_where.=" and t1.addtime >= '".date('Y-m-01 00:00:00',time())."' and t1.addtime <= '".date('Y-m-d H:m:s',time())."'";
			$str_where.=" and DATE_FORMAT(t1.addtime,'%Y-%m-%d') >= '".date('Y-m-01',time())."' and DATE_FORMAT(t1.addtime,'%Y-%m-%d') <= '".date('Y-m-d',time())."'";
		}
	
		$sql.= "select t1.*, t2.name,t2.number as caccount_number,t3.name as tag_name ";
		$sql.= " from ".$tablePrefix."jxcaccountlist t1, ".$tablePrefix."jxcaccount t2, ".$tablePrefix."system_tag t3 ";
		$sql.= " where t1.pid=t2.id and t1.ywtype=t3.id ".$str_where." order by t1.pid asc,t1.addtime asc,t1.id asc";
		//dump($sql);
		//exit();
		$list = $m->query($sql);
		$this -> assign("id", $id);
		$this -> assign("list", $list);
    	
		/*合计
		$str_all = $m->query("select sum(t1.income) num1,sum(t1.expenditure) num2,sum(t1.balance) num3 from ".$tablePrefix."jxcaccountlist t1 where 1=1 ".$str_where."");
		if($str_all){
            $num_all1 = $str_all[0]['num1'];
            $num_all2 = $str_all[0]['num2'];
            $num_all3 = $str_all[0]['num3'];
		}else{
			$num_all1 = 0;
			$num_all2 = 0;
			$num_all3 = 0;
		}
		$this -> assign("num_all1", $num_all1);
		$this -> assign("num_all2", $num_all2);
		$this -> assign("num_all3", $num_all3);*/
		
		$model0 = D('jxcaccount');
		$list_jxcaccount=$model0->where('status=1')->field('id,name,number,balance')->order('sort,id')->select();
		$this->assign('list_jxcaccount',$list_jxcaccount);

		$this->display();
	}
	
	public function outxls() {
/*		$model = D($this->dbname);
		$map = $this->_search();
		if (method_exists($this, '_filter')) {
			$this->_filter($map);
		}
		$list = $model->where($map)->field('id,pid,addtime,number,ywtype,income,expenditure,balance,buname')->select();
		$headArr=array('ID','账户编号','日期','单据编号','业务类型','收入','支出','账户余额','往来单位');
		$filename='现金银行报表';
		$this->xlsout($filename,$headArr,$list);
*/		
		
		$model = D($this->dbname);
		$m = M();
		$tablePrefix = C('DB_PREFIX');
		
		$str_where = '';
		if (!empty($_REQUEST['pid'])) {
			$pid = $_REQUEST['pid'];
			$str_where.=" and t1.pid = ".$pid."";
		}
		if(isset($_REQUEST['time1']) && $_REQUEST['time1'] != '' && isset($_REQUEST['time2']) && $_REQUEST['time2'] != ''){
			$str_where.=" and DATE_FORMAT(t1.addtime,'%Y-%m-%d') >= '".I('time1')."' and DATE_FORMAT(t1.addtime,'%Y-%m-%d') <= '".I('time2')."'";
		}else{
			$str_where.=" and DATE_FORMAT(t1.addtime,'%Y-%m-%d') >= '".date('Y-m-01',time())."' and DATE_FORMAT(t1.addtime,'%Y-%m-%d') <= '".date('Y-m-d',time())."'";
		}
	
		$sql.= "select t2.name,t2.number as caccount_number,t1.addtime,t1.number,t3.name as tag_name,t1.income,t1.expenditure,t1.balance,t1.buname ";
		$sql.= " from ".$tablePrefix."jxcaccountlist t1, ".$tablePrefix."jxcaccount t2, ".$tablePrefix."system_tag t3 ";
		$sql.= " where t1.pid=t2.id and t1.ywtype=t3.id ".$str_where." order by t1.pid asc,t1.addtime asc";
		$list = $m->query($sql);

		$headArr=array('账户编号','账户名称','日期','单据编号','业务类型','收入','支出','账户余额','往来单位');
		$filename='现金银行报表';
		$this->xlsout($filename,$headArr,$list);
	}
	

}