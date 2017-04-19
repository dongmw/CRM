<?php

/**
 *      文档模型
 *      [ZLSYS] (C)2008-2099  
 *      This is NOT a freeware, use is subject to license terms
 *      http://www.zhelininternet.com
 *      tel:13811836808
 *      qq:185530523
 */

namespace Home\Model;
use Think\Model;

class DocumentModel extends Model {
	// 自动验证设置
	protected $_validate	 =	 array(
		array('name','require','文件名必须',1),
		array('content','require','内容必须'),
		);

	function _before_insert(&$data,$options){
        $sql = "SELECT CONCAT(year(now()),'-',LPAD(count(*)+1,4,0)) doc_no FROM `".$this->tablePrefix."document` WHERE 1 and year(FROM_UNIXTIME(create_time))>=year(now())";       
        $rs = $this->db->query($sql);
        if($rs){
            $data['doc_no']=$rs[0]['doc_no'];    
        }else{
            $data['doc_no']=date('Y')."-0001"; 
        }
		$data['user_id']=getuserid();
		$data['user_name']=gettruename();
		$data['create_time']=time();
	}

}	
?>