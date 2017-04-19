<?php
namespace Home\Model;
use Think\Model;

class RoleDutyModel extends Model {

	function get_role_list($user_id) {
		$table = $this -> tablePrefix . 'auth_group_access';
		$rs = $this -> db -> query('select a.group_id from ' . $table . ' as a where a.uid=' . $user_id . ' ');
		return $rs;
	}

	function get_duty_list($role_list) {
		if (is_array($role_list)) {
			$role_list = array_filter($role_list);
		} else {
			$role_list = explode(",", $role_list);
			$role_list = array_filter($role_list);
		}
		$role_list = implode(",", $role_list);		
		$rs = $this -> db -> query('select distinct duty_id from ' . $this -> tablePrefix . 'role_duty as a where a.role_id in(' . $role_list . ')');
		return $rs;
	}

	function del_duty($role_list) {
		if (empty($role_list)) {
			return true;
		}
		if (is_array($role_list)) {
			$role_list = array_filter($role_list);
		} else {
			$role_list = explode(",", $role_list);
			$role_list = array_filter($role_list);
		}
		$role_list = implode(",", $role_list);

		$table = $this -> tablePrefix . 'role_duty';

		$result = $this -> db -> execute('delete from ' . $table . ' where role_id in (' . $role_list . ')');
		if ($result === false) {
			return false;
		} else {
			return true;
		}
	}

	function set_duty($role_list, $duty_list) {
		if (empty($role_list)) {
			return true;
		}
		//dump($role_id);
		if (is_array($role_list)) {
			$role_list = array_filter($role_list);
		} else {
			$role_list = array_filter(explode(",", $role_list));
		}
		$role_list = implode(",", $role_list);

		if (empty($duty_list)) {
			return true;
		}
		if (is_array($duty_list)) {
			$duty_list = array_filter($duty_list);
		} else {
			$duty_list = array_filter(explode(",", $duty_list));
		}
		$duty_list = implode(",", $duty_list);

		$where = 'a.id in(' . $role_list . ') AND b.id in(' . $duty_list . ')';
		$sql = 'INSERT INTO ' . $this -> tablePrefix . 'role_duty (role_id,duty_id)';
		$sql .= ' SELECT a.id, b.id FROM ' . $this -> tablePrefix . 'auth_group a, ' . $this -> tablePrefix . 'duty b WHERE ' . $where;
		$result = $this -> execute($sql);
		return result;
	}

}
?>