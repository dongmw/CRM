<?php

/**
 *      通知公告控制器
 *      [ZLSYS] (C)2008-2099  
 *      This is NOT a freeware, use is subject to license terms
 *      http://www.zhelininternet.com
 *      tel:13811836808
 *      qq:185530523
 */

namespace Home\Controller;
use Think\Controller;

class TestController extends CommonController{

   public function _initialize() {
        parent::_initialize();
        $this->dbname = "Message";
    }
	
	function test() {
		//$sql = "select * from xy_message";
		//$sql = "select count(id) num from xy_message";
		$user_id = getuserid();

		$userid = 8;
		$sql.= "select count(*) count ";
		$sql.= "              from   (select id, sender_id, receiver_id, create_time ";
		$sql.= "                        from xy_message ";
		$sql.= "                       where  status = 0 and owner_id = '$user_id' and receiver_id = '$user_id' and sender_id = '$userid' ";
		$sql.= "                      union ";
		$sql.= "                      select id, a.receiver_id, a.sender_id, create_time ";
		$sql.= "                        from xy_message a ";
		$sql.= "                       where  a.status = 0 and owner_id = '$user_id' and sender_id = '$user_id' and receiver_id = '$userid') ";
		$sql.= "                     t1 ";
		
		$m = new \Think\Model();
		$res = $m->query($sql);
		$count = $res[0]['count'];
		//$res = M('Message')->count();
		//$count = count($res);
		//dump($count);
		//dump($res);
		echo $count;
	}

}