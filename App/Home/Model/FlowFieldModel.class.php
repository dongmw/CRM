<?php
namespace Home\Model;
use Think\Model;

class FlowFieldModel extends Model {
	public function get_field_list($type_id){
		$where['type_id']=array('eq',$type_id);
		$where['is_del']=0;
		$list = $this -> where($where) -> order('sort asc') -> select();
		return $list;
	}

	public function get_data_list($flow_id){
		$model=M("FlowFieldData");
		$where = "flow_id=$flow_id";
		$join = 'join ' . $this -> tablePrefix . 'flow_field field on field_id=field.id';
		$list = $model -> join($join) -> where($where) ->  order('sort asc') ->select();
		return $list;
	}

	function set_field($flow_id){
		//dump($flow_id);
		//exit();
		$model=M("FlowFieldData");
		$model->where("flow_id=$flow_id")->delete();
		
		$model=M("FlowFieldData");
		$data['flow_id']=$flow_id;
		$flow_field = array_filter(array_keys($_REQUEST),"filter_flow_field");
		//dump($flow_field);
		//exit();
		foreach ($flow_field as $field){
			$tmp=array_filter(explode("_",$field));
			$data['field_id']=$tmp[2];
			$val=$_REQUEST[$field];
			
			if(is_array($val)){
				$val=implode(",",$val);
			}
			$data['val']=$val;
			$model->add($data);
		}
		if ($result === false) {
			return false;
		} else {
			return true;
		}
	}
}
?>