<?php

/**
 *      产品管理控制器
 *      [ZLSYS] (C)2008-2099  
 *      This is NOT a freeware, use is subject to license terms
 *      http://www.zhelininternet.com
 *      tel:13811836808
 *      qq:185530523
 */

namespace Home\Controller;
use Think\Controller;

class StockController extends CommonController{

   public function _initialize() {
        parent::_initialize();
        $this->dbname = "pro";
    }
	
   function _filter(&$map) {
	   //if(!in_array(session('uid'),C('ADMINISTRATOR'))){
		//$map['id'] = array('EQ', session("uid"));
	   //}

	}
	
   public function _befor_index(){ 
   
   }
  
  
  public function _befor_add(){
	  $attid=time();
	  $this->assign('attid',$attid);
    
  }
	
   public function _after_add($id){
    
   }

  public function _befor_insert($data){
	 //$data['addtime']=date("Y-m-d H:i:s",time());
	// return $data;
  }
  
  public function _befor_edit(){
     $model = D($this->dbname);
	 $info = $model->find(I('get.id'));
	 $attid=$info['attid'];
	 $this->assign('attid',$attid);
  }
   
  public function _befor_update($data){

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
		$list = $model->where($map)->field('id,name,fenlei,jiage,sjiage,type,ruku,kucun,chuku,title,uname,addtime,updatetime')->select();
	    $headArr=array('ID','产品名称','产品分类','采购价格','销售价格','计量单位','入库数量','库存数量','出库数量','型号规格','添加人','添加时间','更新时间');
	    $filename='产品管理';
		$this->xlsout($filename,$headArr,$list);
	}
	
	public function baojing() {
		$model = D($this->dbname);
		$map = $this->_search();
		if (method_exists($this, '_filter')) {
			$this->_filter($map);
		}
		$list = $model->where("kucun<10")->select();
        $this->assign('list',$list);
		$this->display("index");
	}
	

}