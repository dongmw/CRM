<?php

// 校验验证码	@return boolean
function checkVerify(){
	$verify = new \Think\Verify();
	return $verify->check(I('verify'));
}

/**
  * 检查权限
  * @param name string|array  需要验证的规则列表,支持逗号分隔的权限规则或索引数组
  * @param uid  int           认证用户的id
  * @param string mode        执行check的模式
  * @param relation string    如果为 'or' 表示满足任一条规则即通过验证;如果为 'and'则表示需满足所有规则才能通过验证
  * @return boolean           通过验证返回true;失败返回false
 */
function authcheck($name, $uid, $type=1, $mode='url', $relation='or'){
	if(!in_array($uid,C('ADMINISTRATOR'))){ 
		$auth=new \Think\Auth();
		return $auth->check($name, $uid, $type, $mode, $relation)?true:false;
	}else{
		return true;
	}
}
   
function display($name){
	$name='Home/'.$name;
	$uid=session('uid');
	if(!in_array($uid,C('ADMINISTRATOR'))){
		if(!authcheck($name, $uid, $type=1, $mode='url', $relation='or')){
			return "style='display:none'";
		}
	}
}

/**
  * 调用用户ID
 */
function getuserid(){
	//return session("uid");
	$uid = session("uid");
	return isset($uid) ? $uid : 0;
}

/**
  * 调用用户username
 */
function getusername(){
	return session("username");
}

/**
  * 调用用户姓名
 */
function gettruename(){
	return session("truename");
}

/**
  * 调用用户直接上级username
 */
function getusername_up(){
	return session("username_up");
}

function getdeptid(){
	return 0;
}

/**
  * 调用用户部门
 */
function getdepname(){
	return session("depname");
}

/**
  * 调用用户职位
 */
function getposname(){
	return session("posname");
}

/**
  * 获取当前时间
 */
function gettime(){
	return date('Y-m-d H:i:s',time());
}

/**
  * 遍历数组
 */
function cateTree($pid=0,$level=0,$db=0){
    $cate=M(''.$db.'');
    $array=array();
    $tmp=$cate->where(array('pid'=>$pid))->order("sort")->select();
    if(is_array($tmp)){
        foreach($tmp as $v){
            $v['level']=$level;
            //$v['pid']>0;
            $array[count($array)]=$v;
            $sub=cateTree($v['id'],$level+1,$db);
            if(is_array($sub))$array=array_merge($array,$sub);
        }
    }
    return $array;
}

function orgcateTree($pid=0,$level=0,$type=0){
    $cate=M('auth_group');
    $array=array();
    $tmp=$cate->where(array('pid'=>$pid,'type'=>$type))->order("sort")->select();
    if(is_array($tmp)){
        foreach($tmp as $v){
            $v['level']=$level;
            //$v['pid']>0;
            $array[count($array)]=$v;
            $sub=orgcateTree($v['id'],$level+1,$type);
            if(is_array($sub))$array=array_merge($array,$sub);
        }
    }
    return $array;
}

function userTree($level=0){
    $cate=M('user');
    $array=array();
    $tmp=$cate->where(array('status'=>'1'))->field(array('username','truename','depname','posname'))->order("username")->select();
    if(is_array($tmp)){
        foreach($tmp as $v){
            $v['level']=$level;
            $array[count($array)]=$v;
            //$sub=userTree($level+1);
            //if(is_array($sub))$array=array_merge($array,$sub);
        }
    }
    return $array;
}

function cateTreed($pid=0,$level=0){
    $cate=M('datalist');
    $array=array();
    $tmp=$cate->where(array('pid'=>$pid))->order("sort")->select();
    if(is_array($tmp)){
        foreach($tmp as $v){
		    $v['level']=$level;
            //$v['pid']>0;
            $array[count($array)]=$v;
            $sub=cateTreed($v['id'],$level+1);
            if(is_array($sub))$array=array_merge($array,$sub);
        }
    }
    return $array;
}

/**
 * 格式化字节大小
 * @param  number $size      字节数
 * @param  string $delimiter 数字和单位分隔符
 * @return string            格式化后的带单位的大小
 * @author 麦当苗儿 <zuojiazi@vip.qq.com>
 */
function format_bytes($size, $delimiter = '') {
    $units = array('B', 'KB', 'MB', 'GB', 'TB', 'PB');
    for ($i = 0; $size >= 1024 && $i < 5; $i++) $size /= 1024;
    return round($size, 2) . $delimiter . $units[$i];
}

/**
 * 调用系统的API接口方法（静态方法）
 * api('User/getName','id=5'); 调用公共模块的User接口的getName方法
 * api('Admin/User/getName','id=5');  调用Admin模块的User接口
 * @param  string  $name 格式 [模块名]/接口名/方法名
 * @param  array|string  $vars 参数
 */
function api($name,$vars=array()){
    $array     = explode('/',$name);
    $method    = array_pop($array);
    $classname = array_pop($array);
    $module    = $array? array_pop($array) : 'Common';
    $callback  = $module.'\\Api\\'.$classname.'Api::'.$method;
    if(is_string($vars)) {
        parse_str($vars,$vars);
    }
    return call_user_func_array($callback,$vars);
}

/**
  * 检查数据库中是否有该表
 */
function check_table_exist($tableName){
    $tableName = C('DB_PREFIX') . strtolower($tableName);
    $tables = M()->query('show tables');
    if(empty($tables)){
        exit('数据库中没有表');
    }
    foreach($tables as $v){
        if($v['tables_in_test']==$tableName){
            return true ;
        }
    }
    exit('数据库中没有 '.$tableName.' 表，请创建');
}

/**
 * 根据条件字段获取指定表的数据
 * @param mixed $value 条件，可用常量或者数组
 * @param string $condition 条件字段
 * @param string $field 需要返回的字段，不传则返回整个数据
 * @param string $table 需要查询的表
 * @author huajie <banhuajie@163.com>
 */
function get_table_field($value = null, $condition = 'id', $field = null, $table = null){
    if(empty($value) || empty($table)){
        return false;
    }

    //拼接参数
    $map[$condition] = $value;
    $info = M(ucfirst($table))->where($map);
    if(empty($field)){
        $info = $info->field(true)->find();
    }else{
        $info = $info->getField($field);
    }
    return $info;
}

function Hex($indata){
	$lX8 = $indata & 0x80000000;
	if($lX8)
	{
		$indata=$indata & 0x7fffffff;
	}
	while ($indata>16)
	{
		$temp_1=$indata % 16;
		$indata=$indata /16 ;
		if($temp_1<10)
		   $temp_1=$temp_1+0x30;
		else
		   $temp_1=$temp_1+0x41-10; 
		
		$outstring= chr($temp_1) . $outstring ; 
		   
	}
	$temp_1=$indata;
	if($lX8)$temp_1=$temp_1+8;
	if($temp_1<10)
	   $temp_1=$temp_1+0x30;
	else
	   $temp_1=$temp_1+0x41-10; 
	
	$outstring= chr($temp_1) . $outstring ; 
	
	return $outstring;
		 
}

/**
 * 字符串转换为数组，主要用于把分隔符调整到第二个参数
 * @param  string $str  要分割的字符串
 * @param  string $glue 分割符
 * @return array
 * @author 麦当苗儿 <zuojiazi@vip.qq.com>
 */
function str2arr($str, $glue = ','){
    return explode($glue, $str);
}

/**
 * 数组转换为字符串，主要用于把分隔符调整到第二个参数
 * @param  array  $arr  要连接的数组
 * @param  string $glue 分割符
 * @return string
 * @author 麦当苗儿 <zuojiazi@vip.qq.com>
 */
function arr2str($arr, $glue = ','){
    return implode($glue, $arr);
}

/**
 * 字符串截取，支持中文和其他编码
 * @static
 * @access public
 * @param string $str 需要转换的字符串
 * @param string $start 开始位置
 * @param string $length 截取长度
 * @param string $charset 编码格式
 * @param string $suffix 截断显示字符
 * @return string
 */
function msubstr($str, $start=0, $length) {
	$charset="utf-8";
	$suffix=true;
    if(function_exists("mb_substr"))
        $slice = mb_substr($str, $start, $length, $charset);
    elseif(function_exists('iconv_substr')) {
        $slice = iconv_substr($str,$start,$length,$charset);
        if(false === $slice) {
            $slice = '';
        }
    }else{
        $re['utf-8']   = "/[\x01-\x7f]|[\xc2-\xdf][\x80-\xbf]|[\xe0-\xef][\x80-\xbf]{2}|[\xf0-\xff][\x80-\xbf]{3}/";
        $re['gb2312'] = "/[\x01-\x7f]|[\xb0-\xf7][\xa0-\xfe]/";
        $re['gbk']    = "/[\x01-\x7f]|[\x81-\xfe][\x40-\xfe]/";
        $re['big5']   = "/[\x01-\x7f]|[\x81-\xfe]([\x40-\x7e]|\xa1-\xfe])/";
        preg_match_all($re[$charset], $str, $match);
        $slice = join("",array_slice($match[0], $start, $length));
    }
    return $suffix ? $slice.'' : $slice;
}

function encrypt($data) {
	//return md5(C('AUTH_MASK') . md5($data));
	return md5(md5($data));
}

//html代码输出
function html_out($str){
    if(function_exists('htmlspecialchars_decode')){
        $str=htmlspecialchars_decode($str);
    }else{
        $str=html_entity_decode($str);
    }
    $str = stripslashes($str);
    return $str;
}

/**
  * 调用用户名称 通过ID
 */
function truename($id){
 $data=M('user')->where('id='.$id)->getField('truename');
 return $data;
}

function comname($id){
 $data=M('cust')->where('id='.$id)->getField('title');
 return $data;
}

/**
 * 清除缓存
 * 2015-05-18
 * 新增
 */
function delDirAndFile($path, $delDir = FALSE) {
	$handle = opendir($path);
	if ($handle) {
		while (false !== ( $item = readdir($handle) )) {
			if ($item != "." && $item != "..")
				is_dir("$path/$item") ? delDirAndFile("$path/$item", $delDir) : unlink("$path/$item");
		}
		closedir($handle);
		if ($delDir)
			return rmdir($path);
	} else {
		if (file_exists($path)) {
			return unlink($path);
		} else {
			return FALSE;
		}
	}
}

/**
 * 日期转换
 * 2015-05-20
 * 新增
 */
function toDate($time, $format = 'Y-m-d H:i:s') {
	if (empty($time)) {
		return '';
	}
	$format = str_replace('#', ':', $format);
	return date($format, $time);
}

function get_MessageCount($userid) {
	//$sql = "select * from xy_message";
	//$sql = "select count(id) num from xy_message";
	$user_id = getuserid();
	$tablePrefix = C('DB_PREFIX');
	
	$sql.= "select count(*) count ";
	$sql.= "              from   (select id, sender_id, receiver_id, create_time ";
	$sql.= "                        from ".$tablePrefix."message ";
	$sql.= "                       where  status = 0 and owner_id = '$user_id' and receiver_id = '$user_id' and sender_id = '$userid' ";
	$sql.= "                      union ";
	$sql.= "                      select id, a.receiver_id, a.sender_id, create_time ";
	$sql.= "                        from ".$tablePrefix."message a ";
	$sql.= "                       where  a.status = 0 and owner_id = '$user_id' and sender_id = '$user_id' and receiver_id = '$userid') ";
	$sql.= "                     t1 ";
	
	$m = new \Think\Model();
	$res = $m->query($sql);
	$count = $res[0]['count'];
	//$res = M('Message')->count();
	//$count = count($res);
	//dump($count);
	//dump($res);
	return $count;
}

function get_MessageCountAll($userid) {
	$user_id = getuserid();
	$tablePrefix = C('DB_PREFIX');
	
	$sql.= "select count(*) count ";
	$sql.= "              from   (select id, sender_id, receiver_id, create_time ";
	$sql.= "                        from ".$tablePrefix."message ";
	$sql.= "                       where  status = 0 and owner_id = '$user_id' and receiver_id = '$user_id' and sender_id = '$userid' ";
	$sql.= "                      union ";
	$sql.= "                      select id, a.receiver_id, a.sender_id, create_time ";
	$sql.= "                        from ".$tablePrefix."message a ";
	$sql.= "                       where  a.status = 0 and owner_id = '$user_id' and sender_id = '$user_id' and receiver_id = '$userid') ";
	$sql.= "                     t1 ";
	
	$m = new \Think\Model();
	$res = $m->query($sql);
	$count = $res[0]['count'];
	return $count;
}

function get_MessageCountNew($userid) {
	$m = new \Think\Model();
	$user_id = getuserid();
	$tablePrefix = C('DB_PREFIX');
	
	$sqlMessage.= "select count(*) count from ".$tablePrefix."message where receiver_id = '$user_id' and owner_id = '$user_id' and sender_id = '$userid' and status = 0 and is_read = 0 ";
	$rsMessage = $m->query($sqlMessage);
	$countMessage = $rsMessage[0]['count'];
	
	return $countMessage;
}

function get_MessageList($userid) {
	//$sql = "select * from xy_message";
	//$sql = "select count(id) num from xy_message";
	$user_id = getuserid();
	$tablePrefix = C('DB_PREFIX');
	
	$sql.= "select id, sender_name, content, create_time ";
	$sql.= "              from   (select id, sender_name, content, create_time ";
	$sql.= "                        from ".$tablePrefix."message ";
	$sql.= "                       where  status = 0 and owner_id = '$user_id' and receiver_id = '$user_id' and sender_id = '$userid' ";
	$sql.= "                      union ";
	$sql.= "                      select id, a.sender_name, a.content, create_time ";
	$sql.= "                        from ".$tablePrefix."message a ";
	$sql.= "                       where  a.status = 0 and owner_id = '$user_id' and sender_id = '$user_id' and receiver_id = '$userid') ";
	$sql.= "                     t1 order by id asc";
	
	$m = new \Think\Model();
	$res = $m->query($sql);
	//$count = $res[0]['count'];
	//$res = M('Message')->count();
	//$count = count($res);
	//dump($count);
	//dump($res);
	return $res;
}

function get_OnlineRecentlyList() {
	//$sql = "select * from xy_message";
	//$sql = "select count(id) num from xy_message";
	$user_id = getuserid();
	$tablePrefix = C('DB_PREFIX');
	
	$sql.= "select sender_id, sender_name, MAX(create_time) AS create_time ";
	$sql.= "              from   (select sender_id, sender_name, create_time ";
	$sql.= "                        from ".$tablePrefix."message ";
	$sql.= "                       where  status = 0 and owner_id = '$user_id' and receiver_id = '$user_id' ";
	$sql.= "                      union ";
	$sql.= "                      select receiver_id as sender_id, receiver_name as sender_name, create_time ";
	$sql.= "                        from ".$tablePrefix."message ";
	$sql.= "                       where  status = 0 and owner_id = '$user_id' and sender_id = '$user_id') ";
	$sql.= "                     t1 GROUP BY sender_name ORDER BY create_time DESC";
	
	$m = new \Think\Model();
	$res = $m->query($sql);
	//$count = $res[0]['count'];
	//$res = M('Message')->count();
	//$count = count($res);
	//dump($count);
	//dump($res);
	return $res;
}

function get_OnlineIncList() {
	$m = new \Think\Model();
	$user_id = getuserid();
	$tablePrefix = C('DB_PREFIX');
	
	//更新用户在线状态
	$dataOnline['id']=$user_id; //session('uid')
	$dataOnline['update_time']=time();
	$rsdataOnline=M("user")->save($dataOnline);
	
	//在线用户数量
	$whereOnline['update_time']=array('gt',time()-120);
	$countOnline = M('user')->where($whereOnline)->count();
	
	//新消息数量
	$sqlMessage= "select count(*) count from ".$tablePrefix."message where receiver_id = '$user_id' and owner_id = '$user_id' and status = 0 and is_read = 0";
	$rsMessage = $m->query($sqlMessage);
	$countMessage = $rsMessage[0]['count'];

	//新邮件数量
	$countMail = 0;
	
	//显示结果
	$str = '{"Online":"'.$countOnline.'","Message":"'.$countMessage.'","Mail":"'.$countMail.'","Error":"","sound":""}';
	return $str;
}

function get_onlineChatRefreshIncList($id) {
	$m = new \Think\Model();
	$user_id = getuserid();
	
	//新消息
	$message=M('message');
    $rsMessage=$message->where("receiver_id = '".$user_id."' and owner_id = '".$user_id."' and sender_id = '".$id."' and status = 0 and is_read = 0")->field(array('create_time','sender_name','content'))->order("id")->select();
	if (is_array($rsMessage)) {
		foreach($rsMessage as $v){
			$string1 .= "<div class='lineh20'><span class='cg'>".$v['sender_name']."</span>　<span class='c9'>(". date('Y-m-d H:i:s',$v['create_time']).")</span></div><div class='m0080 lineh20'>".$v['content']."</div>";
        }
		//更新用户在线状态
		$datawhere['receiver_id']=$user_id;
		$datawhere['owner_id']=$user_id;
		$datawhere['sender_id']=$id;
		$datawhere['status']=0;
		$datawhere['is_read']=0;
		$datasave['is_read']=1;
		$rsdataOnline=M("message")->where($datawhere)->save($datasave);
		$str = '{"nb":"1","Content":"'.$string1.'"}';
	} else {
		$str = '{"nb":"0","Content":""}';
	}
	return $str;
}

/*2015-06-01 【新增】*/
function list_to_tree($list, $root = 0, $pk = 'id', $pid = 'pid', $child = '_child') {
	// 创建Tree
	$tree = array();
	if (is_array($list)) {
		// 创建基于主键的数组引用
		$refer = array();
		foreach ($list as $key => $data) {
			$refer[$data[$pk]] = &$list[$key];
		}
		foreach ($list as $key => $data) {
			// 判断是否存在parent
			$parentId = 0;
			if (isset($data[$pid])) {
				$parentId = $data[$pid];
			}
			if ((string)$root == $parentId) {
				$tree[] = &$list[$key];
			} else {
				if (isset($refer[$parentId])) {
					$parent = &$refer[$parentId];
					$parent[$child][] = &$list[$key];
				}
			}
		}
	}
	return $tree;
}

function tree_to_list($tree, $level = 0, $pk = 'id', $pid = 'pid', $child = '_child'){
	$list = array();
	if (is_array($tree)) {
		foreach ($tree as $val) {
			$val['level'] = $level;			
			if (isset($val['_child'])) {
				$child = $val['_child'];
				if (is_array($child)) {
					unset($val['_child']);
					$list[] = $val;
					$list = array_merge($list, tree_to_list($child, $level + 1));
				}
			} else {
				$list[] = $val;
			}
		}
		return $list;
	}
}

function sub_tree_menu($tree, $level = 0) {
	$level++;
	$html = "";
	if (is_array($tree)) {
		$html = "<ul class=\"tree_menu\">\r\n";
		foreach ($tree as $val) {
			if (isset($val["name"])) {
				$title = $val["name"];
				$id = $val["id"];
				if (empty($val["id"])) {
					$id = $val["name"];
				}
				if (isset($val['_child'])) {
					$html = $html . "<li>\r\n<a node=\"$id\"><i class=\"fa fa-angle-right level$level\"></i><span>$title</span></a>\r\n";
					$html = $html . sub_tree_menu($val['_child'], $level);
					$html = $html . "</li>\r\n";
				} else {
					$html = $html . "<li>\r\n<a  node=\"$id\" ><i class=\"fa fa-angle-right level$level\"></i><span>$title</span></a>\r\n</li>\r\n";
				}
			}
		}
		$html = $html . "</ul>\r\n";
	}
	return $html;
}

function dropdown_menu($tree, $level = 0) {
	$level++;
	$html = "";
	if (is_array($tree)) {
		foreach ($tree as $val) {
			if (isset($val["name"])) {
				$title = $val["name"];
				$id = $val["id"];
				if (empty($val["id"])) {
					$id = $val["name"];
				}
				if (isset($val['_child'])) {
					$html = $html . "<li id=\"$id\" class=\"level$level\"><a>$title</a>\r\n";
					$html = $html . dropdown_menu($val['_child'],$level);
					$html = $html . "</li>\r\n";
				} else {
					$html = $html . "<li  id=\"$id\"  class=\"level$level\">\r\n<a>$title</a>\r\n</li>\r\n";
				}
			}
		}
	}
	return $html;
}

function fill_option($list,$data) {
	$html = "";
	foreach ($list as $key => $val){
		if(is_array($val)) {
			$id = $val['id'];
			$name = $val['name'];
			if($id==$data){
				$selected="selected";
			}else{
				$selected="";
			}
			$html = $html . "<option value='{$id}' $selected>{$name}</option>";
		} else {
			if($key==$data){
				$selected="selected";
			}else{
				$selected="";
			}
			$html = $html . "<option value='{$key}' $selected>{$val}</option>";
		}
	}
	echo $html;
}

function status($status,$type=0) {
	if ($type == 1) {
		if ($status == 0) {
			return '<span class="label label-success">启用</span>';
		}
		if ($status == 1) {
			return '<span class="label label-default">禁用</span>';
		}
	} else {
		if ($status == 0) {
			return '启用';
		}
		if ($status == 1) {
			return '禁用';
		}
	}
}

function crm_status($status) {
	if ($status == 0) {
		return "未审核";
	}
	if ($status == 1) {
		return "通过";
	}
	if ($status == 2) {
		return "拒绝";
	}
}

function todo_status($status) {
	if ($status == 1) {
		return "尚未进行";
	}
	if ($status == 2) {
		return "正在进行";
	}
	if ($status == 3) {
		return "完成";
	}
}

function reunit($size) {
	$unit=" B";
	if ($size > 1024) {
		$size = $size / 1024;
		$unit = " KB";
	}
	if ($size > 1024) {
		$size = $size / 1024;
		$unit = " MB";
	}
	if ($size > 1024) {
		$size = $size / 1024;
		$unit = " GB";
	}
	return round($size, 2) . $unit;
}

function rotate($a) {
	$b = array();
	if (is_array($a)) {
		foreach ($a as $val) {
			foreach ($val as $k => $v) {
				$b[$k][] = $v;
			}
		}
	}
	return $b;
}

function show_step_type($step,$type=0) {
	if ($type == 1) {
		if ($step >= 20 && $step<30) {
			return '<span class="label label-primary">审批</span>';
		}
		if ($step >= 30) {
			return '<span class="label label-info">协商</span>';
		}
	} else {
		if ($step >= 20 && $step<30) {
			return "审批";
		}
		if ($step >= 30) {
			return "协商";
		}
	}
}

function show_result($result,$type=0) {
	if ($type == 1) {
		if ($result == 1) {
			return '<span class="label label-success">同意</span>';
		}
		if ($result == 0) {
			return '<span class="label label-danger">否决</span>';
		}
		if ($result == 2) {
			return '<span class="label label-warning">退回</span>';
		}
	} else {
		if ($result == 1) {
			return "同意";
		}
		if ($result == 0) {
			return "否决";
		}
		if ($result == 2) {
			return "退回";
		}
	}
}

function show_step($step,$type=0) {
	if ($type == 1) {
		if ($step == 40) {
			return '<span class="label label-success">通过</span>';
		}
		if ($step > 30) {
			return '<span class="label label-primary">协商中</span>';
		}
		if ($step == 30) {
			return '<span class="label label-primary">待协商</span>';
		}
		if ($step > 20) {
			return '<span class="label label-primary">审批中</span>';
		}
		if ($step == 20) {
			return '<span class="label label-primary">待审批</span>';
		}
		if ($step == 10) {
			return '<span class="label label-default">临时保管</span>';
		}
		if ($step == 0) {
			return '<span class="label label-danger">否决</span>';
		}
	} else {
		if ($step == 40) {
			return "通过";
		}
		if ($step > 30) {
			return "协商中";
		}
		if ($step == 30) {
			return "待协商";
		}
		if ($step > 20) {
			return "审批中";
		}
		if ($step == 20) {
			return "待审批";
		}
		if ($step == 10) {
			return "临时保管";
		}
		if ($step == 0) {
			return "否决";
		}
	}
}

function check_str($str) {
	$s = '';
	if (!empty($str)){
		$s = $str;
	}
	return $s;
}

function filter_flow_field($val) {	
	//if (strpos($val,"doc_field_") !== false){
	if (strpos($val,"flow_field_") !== false){
		return true;
	}else{
		return false;
	}
}

/**
 +----------------------------------------------------------
 * 产生随机字串，可用来自动生成密码
 * 默认长度6位 字母和数字混合 支持中文
 +----------------------------------------------------------
 * @param string $len 长度
 * @param string $type 字串类型
 * 0 字母 1 数字 其它 混合
 * @param string $addChars 额外字符
 +----------------------------------------------------------
 * @return string
 +----------------------------------------------------------
 */
function rand_string($len = 6, $type = '', $addChars = '') {
	$str = '';
	switch ($type) {
		case 0 :
			$chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz' . $addChars;
			break;
		case 1 :
			$chars = str_repeat('0123456789', 3);
			break;
		case 2 :
			$chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ' . $addChars;
			break;
		case 3 :
			$chars = 'abcdefghijklmnopqrstuvwxyz' . $addChars;
			break;
		default :
			// 默认去掉了容易混淆的字符oOLl和数字01，要添加请使用addChars参数
			$chars = 'ABCDEFGHIJKMNPQRSTUVWXYZabcdefghijkmnpqrstuvwxyz23456789' . $addChars;
			break;
	}
	if ($len > 10) {//位数过长重复字符串一定次数
		$chars = $type == 1 ? str_repeat($chars, $len) : str_repeat($chars, 5);
	}
	if ($type != 4) {
		$chars = str_shuffle($chars);
		$str = substr($chars, 0, $len);
	} else {
		// 中文随机字
		for ($i = 0; $i < $len; $i++) {
			$str .= msubstr($chars, floor(mt_rand(0, mb_strlen($chars, 'utf-8') - 1)), 1);
		}
	}
	return $str;
}

/**
 +----------------------------------------------------------
 * 产生不重复的随机字串
 +----------------------------------------------------------
 * @return string
 +----------------------------------------------------------
 */
function get_sid($len){
	return md5(time().''.rand_string($len,'1'));//md5(bin2hex(time()).rand_string());
}

function _encode($arr) {
	$na = array();
	foreach ($arr as $k => $value) {
		$na[_urlencode($k)] = _urlencode($value);
	}
	return addcslashes(urldecode(json_encode($na)), "\r\n");
}

function _urlencode($elem) {
	if (is_array($elem)) {
		foreach ($elem as $k => $v) {
			$na[_urlencode($k)] = _urlencode($v);
		}
		return $na;
	}
	return urlencode($elem);
}

function f_encode($str) {
	$str = base64_encode($str);
	$str = rand_string(10) . $str . rand_string(10);
	$str = str_replace("+", "-", $str);
	$str = str_replace("/", "_", $str);
	$str = str_replace("==", "*", $str);
	return $str;
}

function f_decode($str) {
	$str = str_replace("-", "+", $str);
	$str = str_replace("_", "/", $str);
	$str = str_replace("*", "==", $str);
	$str = substr($str, 10, strlen($str) - 20);
	$str = base64_decode($str);
	return $str;
}

function get_save_path(){
	$app_path=__APP__;
	$save_path=C('SAVE_PATH');
	$app_path=str_replace("/index.php?s=","",$app_path);
	$app_path=str_replace("/index.php","",$app_path);
	return C('SAVE_PATH');
}

function get_save_url(){
	$app_path=__APP__;
	$save_path=C('SAVE_PATH');
	$app_path=str_replace("/index.php?s=","",$app_path);
	$app_path=str_replace("/index.php","",$app_path);
	return $app_path."/".$save_path;
}

/**
 * 转换字符串中直接上级为本人直接上级
 * @param  string  审核用户
 */
function get_flow_type_list($strings=''){
	$str = '';
    if (!empty($strings)) {
		$items1 = explode("|",$strings);
		$count = count($items1);
		if ($count > 0) {
			for ($i=0; $i<count($items1)-1; $i++){
				$str_confirm_name = '';
				$items_1 = explode("_",$items1[$i]);
				switch ($items_1[0]){
					case 'dept' :
					case 'dp' :
					case 'emp' :
						$str_confirm_name.=$items1[$i].'|';
						break;
					case 'higher' :
						$str_confirm_name.='emp_'.getusername_up().'|';
						break;
					default:
						$str_confirm_name.=$items1[$i].'|';
						break;
				}
				$str.=$str_confirm_name;
			}
		}
	}
	return $str;
}

/**
 * 判断字符串是否以指定字符串开始和结尾
 * @param  str1  指定字符串
 * @param  str2  需要判断的字符串
 * @param  str0  是否返回字符串 0:返回字符串 1:返回判断结果 true|false
 * @return  str4
 */
function judge_str_start_end($str1, $str2, $str0=0){
	$str3 = true;
	$str4 = $str2;
	if (!empty($str2)) {
		//判断字符串是否以 $str1 开始
		if (preg_match("/^(".$str1.")/",$str2)){
		   $str3 = true;
		}else{
		   $str3 = false;
		}
		//判断字符串是否以 $str1 结束   
		if (preg_match("/(".$str1.")$/",$str2)){
		   $str3 = true;
		}else{
		   $str3 = false;
		}
		//替换开始和结尾
		if ($str3 == false) {
			//$str4 = substr($str2, 1, strlen($str2)-1);
			$str4 = $str1.$str2.$str1;
		}
	}
	//判断返回类型
	if ($str0==0) {
		return $str4;//返回字符串
	} else {
		return $str3;//返回true|false
	}
}

/**
 * 调用往来单位 通过业务类别id和往来单位id
 * @param  ywtype  业务类别id
 * @param  buname  往来单位id
 * @return str
 */
function get_buname($ywtype,$buname){
	$str='';
	if($buname>0){
		switch($ywtype){
			case '96'://采购
			case '97'://购货
			case '98'://购退
			case '101'://销退
			case '122'://调拨
			case '123'://盘盈
			case '124'://其他入库
				$str=M('jxcsuppliers')->where('id='.$ywtype)->getField('ms_mc');
				break;
			case '99'://销售
			case '100'://销货
			case '102'://销毁
			case '125'://盘亏
			case '126'://其他出库
				$str=M('jxccustomers')->where('id='.$ywtype)->getField('mc_mc');
				break;
			default:
				$str='';
				break;
		}
		return $str;
	}else{
		return $str;
	}
}

/**
 * 判断数组是否存在重复数据
 * @param  array  数组
 * @param  type  "0"返回数组长度;"1"返回数组值
 * @return repeat_arr
 */
function get_repeat_array1($array,$type=0) {
	$len = count($array);
	for($i = 0; $i < $len; $i ++) {
		for($j = $i + 1; $j < $len; $j ++) {
			if ($array[$i] == $array[$j]) {
				$repeat_arr[] = $array[$i];
				break;
			}
		}
	}
	if($type==1){
		return $repeat_arr;
	}else{
		return count($repeat_arr);
	}
}

/**
 * 判断商品和仓库是否存在重复数据
 * @param  array1  商品
 * @param  array2  仓库
 * @param  type  "0"返回数组长度;"1"返回数组值
 * @return repeat_arr
 */
function get_repeat_array2($array1,$array2,$type=0) {
	$len = count($array1);
	for($i = 0; $i < $len; $i ++) {
		for($j = $i + 1; $j < $len; $j ++) {
			if ($array1[$i] == $array1[$j] && $array2[$i] == $array2[$j]) {
				$repeat_arr[] = $array1[$i].','.$array2[$i];
				break;
			}
		}
	}
	if($type==1){
		return $repeat_arr;
	}else{
		return count($repeat_arr);
	}
}
