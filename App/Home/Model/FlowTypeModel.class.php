<?php
namespace Home\Model;
use Think\Model;

class FlowTypeModel extends Model {
	public $viewFields=array(
		'FlowType'=>array('*'),
		'SystemTag'=>array('name'=>'tag_name','_on'=>'FlowType.tag=SystemTag.id')
		);
		
	public function get_list(){

		$sql.= "select t1.*, t2.name as tag_name ";
		$sql.= " from ".$this->tablePrefix."flow_type t1, ".$this->tablePrefix."system_tag t2 ";
		$sql.= " where t1.tag=t2.id order by t1.sort asc";

		$rs = $this->db->query($sql);
		return $rs;
	}
	
	public function get_tag_list() {

		$sql.= "select id,name ";
		$sql.= " from ".$this->tablePrefix."flow_type ";
		$sql.= " order by sort asc";

		$rs = $this->db->query($sql);
		return $rs;
	}

}
?>