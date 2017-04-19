<?php
/**
 * 主页
 */

namespace Home\Controller;
use Think\Controller;
class IndexController extends Controller {
   
    public function _initialize(){
		if(!session('uid')){
			redirect(U('public/login'));
		}
		$config = S('DB_CONFIG_DATA');
        if(!$config){
            $config = api('Config/lists');
            S('DB_CONFIG_DATA',$config);
        }
        C($config); 
	}
    
	public function index(){
		if(isset($_GET['l'])){
			cookie('think_language',strtolower($_GET['l']),2592000);
			$this->assign('l', $_GET['l']);
		}elseif(isset($_COOKIE['think_language'])){
			cookie('think_language',strtolower(cookie('think_language')),2592000); //获取上次用户的选择
		}else{
			$this->assign('l', 'zh-cn');
			cookie('think_language','zh-cn',2592000);
		}
		
		if ($_COOKIE['think_language'] == 'en-us'){
			$this->assign('TrueName', session('username'));
		}else{
			$this->assign('TrueName', session('truename'));
		}
		$this->assign('catename', 'catename_'.$_COOKIE['think_language']);
		$getuserid = getuserid();
		$this->assign('userid', $getuserid);
		$Rs=M('user')->find($getuserid);
		$this->assign('Rs', $Rs);
		
/*导航菜单 开始*/
/*
$str = '';
$cate=M('menu')->where('level=0 and status=1')->order('sort')->select();
foreach ($cate as $c) {
	if (authcheck('Home/'.$c['alink'],getuserid())){
		$str.='<li><a data-toggle="slidebar" href="javascript:;" ><i class="'.$c['icon'].' bigger-100"></i> '.$c['catename'].'</a>';
		$str.='<div class="items hide" data-noinit="true">';
		$str_s='false';
		if ($Rs['navigation1']==1) {$str_s='true';} else {$str_s='false';}
		$str.='<ul id="bjui-hnav-tree'.$c['id'].'" class="ztree ztree_main" data-toggle="ztree" data-on-click="MainMenuClick" data-expand-all="'.$str_s.'" data-noinit="true" data-faicon="'.$c['icon'].' bigger-100">';
		$cate1=M('menu')->where('level=1 and status=1 and pid='.$c['id'])->order('sort')->select();
		foreach ($cate1 as $v) {
			if (authcheck('Home/'.$v['alink'],getuserid())){
				$count1=M('menu')->where('level=2 and status=1 and pid='.$v['id'])->count(id);
				if ($count1==0){
					$str_icon='caret-right';
					if(!empty($v['icon'])){$str_icon=$v['icon'];}else{$str_icon='caret-right';}
                	$str.='<li data-id="'.$v['id'].'" data-pid="'.$c['id'].'" data-url="index.php/home/'.$v['alink'].'" data-tabid="'.$v['alink'].'" data-fresh="true" data-faicon="'.$str_icon.'">'.$v['catename'].'</li>';
				} else {
					$str.='<li data-id="'.$v['id'].'" data-pid="'.$c['id'].'">'.$v['catename'].'</li>';
					$cate2=M('menu')->where('level=2 and status=1 and pid='.$v['id'])->order('sort')->select();
					foreach ($cate2 as $vv) {
						if (authcheck('Home/'.$vv['alink'],getuserid())){
							$count2=M('menu')->where('level=2 and status=1 and pid='.$vv['id'])->count(id);
							if ($count2==0){
								$str_icon2='caret-right';
								if(!empty($vv['icon'])){$str_icon2=$v['icon'];}else{$str_icon2='caret-right';}
								$str.='<li data-id="'.$vv['id'].'" data-pid="'.$v['id'].'" data-url="index.php/home/'.$vv['alink'].'" data-tabid="'.$vv['alink'].'" data-fresh="true" data-faicon="'.$str_icon2.'">'.$vv['catename'].'</li>';
							} else {
								$str.='<li data-id="'.$vv['id'].'" data-pid="'.$v['id'].'">'.$vv['catename'].'</li>';
								$cate3=M('menu')->where('level=2 and status=1 and pid='.$vv['id'])->order('sort')->select();
								foreach ($cate3 as $vvv) {
									if (authcheck('Home/'.$vvv['alink'],getuserid())){
										$str_icon3='caret-right';
										if(!empty($vvv['icon'])){$str_icon3=$v['icon'];}else{$str_icon3='caret-right';}
										$str.='<li data-id="'.$vvv['id'].'" data-pid="'.$vv['id'].'" data-url="index.php/home/'.$vvv['alink'].'" data-tabid="'.$vvv['alink'].'" data-fresh="true" data-faicon="'.$str_icon3.'">'.$vvv['catename'].'</li>';
									}
								}
							}
						}
						
					}
				}
			}
			
		}
		
	}

}
		
		$this->assign('strmenu', $str);*/
/*导航菜单 结束*/
		$this->display();
	}
	
	public function index_layout() {
		//工作流程
		//待办
		$emp_no = getusername();
		$FlowLog = M("FlowLog");
		$where['emp_no'] = $emp_no;
		$where['_string'] = "result is null";
		$log_list = $FlowLog -> where($where) -> field('flow_id') -> select();
		$log_list = rotate($log_list);
		if (!empty($log_list)) {
			$map['id'] = array('in', $log_list['flow_id']);
		} else {
			$map['_string'] = '1=2';
		}
		$model = D("FlowView");
		$list_confirm = $model -> where($map) -> limit(4) -> select();
		$this -> assign("list_confirm", $list_confirm);
		
		//已提交
		$model = D("FlowView");
		$map_submit['user_id'] = array('eq', getuserid());
		$map_submit['step'] = array( array('gt', 10),array('eq', 0), 'or');
		$list_submit = $model -> where($map_submit) -> limit(4) -> select();
		$this -> assign("list_submit", $list_submit);
		$this -> display();
	}

	public function index_flow() {
		//工作流程
		//待办
		$emp_no = getusername();
		$FlowLog = M("FlowLog");
		$where['emp_no'] = $emp_no;
		$where['_string'] = "result is null";
		$log_list = $FlowLog -> where($where) -> field('flow_id') -> select();
		$log_list = rotate($log_list);
		if (!empty($log_list)) {
			$map['id'] = array('in', $log_list['flow_id']);
		} else {
			$map['_string'] = '1=2';
		}
		$model = D("FlowView");
		$list_confirm = $model -> where($map) -> limit(4) -> select();
		$this -> assign("list_confirm", $list_confirm);
		
		//已提交
		$model = D("FlowView");
		$map_submit['user_id'] = array('eq', getuserid());
		$map_submit['step'] = array( array('gt', 10),array('eq', 0), 'or');
		$list_submit = $model -> where($map_submit) -> limit(4) -> select();
		$this -> assign("list_submit", $list_submit);
		$this -> display();
	}

	public function index_task() {
		$this -> display();
	}

	public function index_notice() {
		$this -> display();
	}

	public function index_document() {
		//文档查看
		$user_id = getuserid();
		$folder_list=D("SystemFolder")->get_authed_folder($user_id,'DocumentFolder');
		$map1['folder'] = array("in", $folder_list);
		$map1['is_del'] = array('eq', '0');
		$model1 = D("DocumentView");
		if (!empty($model1)) {
			$list_document = $model1 -> where($map1) -> limit(10) -> select();
		}
		$this -> assign("list_document", $list_document);
		$this -> display();
	}

	public function index_whereabouts() {
		$this -> display();
	}


}