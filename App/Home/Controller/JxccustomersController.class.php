<?php

/**
 *      客户管理控制器
 *      [ZLSYS] (C)2008-2099  
 *      This is NOT a freeware, use is subject to license terms
 *      http://www.zhelininternet.com
 *      tel:13811836808
 *      qq:185530523
 */

namespace Home\Controller;
use Think\Controller;

class JxccustomersController extends CommonController{

	public function _initialize() {
		parent::_initialize();
		$this->dbname = CONTROLLER_NAME;
	}
	
	//function _filter(&$map) {
		//if(!in_array(session('uid'),C('ADMINISTRATOR'))){
		//$map['id'] = array('EQ', session("uid"));
		//}
	//}


	function _filter(&$map) {
		//$map['is_del'] = array('eq', '0');
		if (IS_POST) {
			if (!empty($_REQUEST['keys'])) {
				$keys = $_POST['keys'];
				$map['ms_mc'] = array('like', "%" . $keys . "%");
			}
		}
	}
	
	public function view(){
		$model = D($this->dbname);
		$id = $_REQUEST [$model->getPk()];
		$vo = $model->getById($id);
		$this->assign('Rs', $vo);
		$attid=$vo['attid'];
		$this->assign('attid',$attid);
		$where['attid']=array('eq',$attid);
		$value = M('Jxccontact')->where($where)->order('id asc')->select();
		$list='';
		$i=0;
		foreach($value as $v) {
$list.='<tr>
<td title="No." width="38">'.($i+1).'</td>
<td title="联系人">'.$v['xingming'].'</td>
<td title="性别">'.$v['sex'].'</td>
<td title="手机">'.$v['phone'].'</td>
<td title="座机">'.$v['dianhua'].'</td>
<td title="QQ">'.$v['qq'].'</td>
<td title="联系地址">'.$v['address'].'</td>
<td title="首要">'.$v['first'].'</td>
</tr>
';
			$i++;
		}
		$this->assign('list',$list);
		$this->display();
	}


	public function index(){
		$list_jxccategory=cateTree($pid=0,$level=0,'jxccategory');
		$this->assign('list_jxccategory',$list_jxccategory);
		
		$model = D('JxccustomersView');
		//$map = $this->_search();
		if (method_exists($this, '_filter')) {
			$this->_filter($map);
		}
		$map['first'] = array('EQ', '是');
		if (!empty($model)) {
			$this->_list($model, $map);
		}
		if (method_exists($this, '_befor_index')) {
			$this->_befor_index();
		}
		$this->display();

	}
	
	/*public function _befor_index(){
		$list_jxccategory=cateTree($pid=0,$level=0,'jxccategory');
		$this->assign('list_jxccategory',$list_jxccategory);
		$model = D('Jxcsuppliers');
		$list = $model->order('sort,id')-> select();
		$this -> assign('list', $list);
		//$this -> display();
	}*/
	
	public function _befor_add(){
		$model1 = D('SystemTag');
		$ms_type_list = $model1 -> get_tag_list('id,name', 'CustomerType');
		$this->assign("ms_type_list", $ms_type_list);
		$attid=get_sid(10);
		$this->assign('attid',$attid);
	}
	
	public function _after_add($id){
	
	}
	
	public function _befor_insert($data){
		$data1['uid']=getuserid();
		$data1['uname']=getusername();
		$data1['addtime']=date("Y-m-d H:i:s",time());
		$data1['attid']=$data['attid'];
		$xingming = I('post.xingming');
		$sex = I('post.sex');
		$phone = I('post.phone');
		$dianhua = I('post.dianhua');
		$qq = I('post.qq');
		$address = I('post.address');
		$first = I('post.first');
		//dump($first);
		//exit();
		$len = 0;
		for ($i=0;$i<count(I('post.first'));$i++) {
			if($first[$i]=='是'){$len++;}
		}
		if ($len > 1) {$this->mtReturn(300,L('_OPERATION_FAIL_').'首要联系人不能选择多个！','',false);return;}
		$del=M("Jxccontact")->where("attid='".$attid."'")->delete();

		for ($i=0;$i<count(I('post.jxccontact'));$i++) {
			$data1['xingming']=$xingming[$i];
			$data1['sex']=$sex[$i];
			$data1['phone']=$phone[$i];
			$data1['dianhua']=$dianhua[$i];
			$data1['qq']=$qq[$i];
			$data1['address']=$address[$i];
			$data1['first']=$first[$i];
			$model1 = M('Jxccontact');
			$list = $model1 -> add($data1);
		}
		
		$data['uid']=getuserid();
		$data['uname']=getusername();
		$data['addtime']=date("Y-m-d H:i:s",time());
		return $data;

	}
	
	public function _befor_edit(){
		$model1 = D('SystemTag');
		$mc_type_list = $model1 -> get_tag_list('id,name', 'CustomerType');
		$this->assign("mc_type_list", $mc_type_list);
		$model = D($this->dbname);
		$Rs = $model->find(I('get.id'));
		$attid=$Rs['attid'];
		$this->assign('attid',$attid);
		$this->assign('Rs',$Rs);
				
		$where['attid']=array('eq',$attid);
		$value = M('Jxccontact')->where($where)->order('id asc')->select();
		$list='';
		$i=0;
		foreach($value as $v) {
			$str_sex1='';
			$str_sex2='';
			$str_first1='';
			$str_first2='';
			if ($v['sex']=='男') {$str_sex1='selected';} else {$str_sex2='selected';}
			if ($v['first']=='是') {$str_first1='selected';} else {$str_first2='selected';}
$list.='<tr data-idname="jxccontact['.$i.'].id" id="jxccontact_edit_'.$i.'">
<th title="No." width="38"><input type="text" readonly="readonly" name="jxccontact['.$i.']" class="no" data-rule="required" value="'.($i+1).'" size="2"></th>
<th title="联系人"><input type="text" name="xingming['.$i.']" data-rule="required;length[~50]" value="'.$v['xingming'].'" size="8" data-group="jxccontact['.$i.']"></th>
<th title="性别"><select name="sex['.$i.']" data-toggle="selectpicker" ><option value="男" '.$str_sex1.'>男</option><option value="女" '.$str_sex2.'>女</option></select></th>
<th title="手机"><input type="text" name="phone['.$i.']" data-rule="mobile" value="'.$v['phone'].'" size="8" data-group="jxccontact['.$i.']"></th>
<th title="座机"><input type="text" name="dianhua['.$i.']" data-rule="length[~20]" value="'.$v['dianhua'].'" size="8" data-group="jxccontact['.$i.']"></th>
<th title="QQ"><input type="text" name="qq['.$i.']" data-rule="digits;length[5~12]" value="'.$v['qq'].'" size="8" data-group="jxccontact['.$i.']"></th>
<th title="联系地址"><input type="text" name="address['.$i.']" data-rule="length[~100]" value="'.$v['address'].'" size="8" data-group="jxccontact['.$i.']"></th>
<th title="首要"><select name="first['.$i.']" data-toggle="selectpicker" ><option value="是" '.$str_first1.'>是</option><option value="否" '.$str_first2.'>否</option></select></th>
<th title="" data-addtool="true" width="65"><a href="'.U('public/flow','id='.$id.'&type=del').'" onclick="del_html_inc(jxccontact_edit_'.$i.')" class="btn btn-red row-del">删</a></th>
</tr>
';
			$i++;
		}
		$this->assign('list',$list);
	}
	
	public function _befor_update($data){
		/* 修改信息保存历史记录 开始 */
		$i=0;
		$model = D($this->dbname);
		$info = $model->find(I('post.id'));
		$id=$info['id'];
		$history=$info['history'];
		$attid=$info['attid'];
		$str_br = '';
		if (!empty($history)) {
			$str_br = '<br>';
		}
		$str=$history.$str_br.gettruename().'['.date("Y-m-d H:i:s",time())."] ";
		if(I('post.ms_type') != $info['ms_type']){
			$str.='类别:'.$info['ms_type'].' 改为 '.I('post.ms_type').';';
			$i++;
		}
		if(I('post.ms_mc') != $info['ms_mc']){
			$str.='名称:'.$info['ms_mc'].' 改为 '.I('post.ms_mc').';';
			$i++;
		}
		if(I('post.ms_bh') != $info['ms_bh']){
			$str.='编号:'.$info['ms_bh'].' 改为 '.I('post.ms_bh').';';
			$i++;
		}
		if(I('post.sort') != $info['sort']){
			$str.='排序:'.$info['sort'].' 改为 '.I('post.sort').';';
			$i++;
		}
		if(I('post.beizhu') != $info['beizhu']){
			$str.='备注:'.$info['beizhu'].' 改为 '.I('post.beizhu').';';
		}
		if(empty($info['uuname'])){
			if(getusername() != $info['uname']){
				$str.='修改用户:'.$info['uname'].' 改为 '.getusername().';';
				$str.='修改时间:'.$info['updatetime'].' 改为 '.date("Y-m-d H:i:s",time()).';';
				$i++;
			}
		} else if(getusername() != $info['uuname']){
			$str.='修改用户:'.$info['uuname'].' 改为 '.getusername().';';
			$str.='修改时间:'.$info['updatetime'].' 改为 '.date("Y-m-d H:i:s",time()).';';
			$i++;
		}
		if ($i > 0) {
			$data['history']=$str;//2015-06-27【新增】修改信息保存历史记录
		}
		/* 修改信息保存历史记录 结束 */
		
		$data1['uid']=getuserid();
		$data1['uname']=getusername();
		$data1['addtime']=date("Y-m-d H:i:s",time());
		$data1['attid']=$attid;
		$xingming = I('post.xingming');
		$sex = I('post.sex');
		$phone = I('post.phone');
		$dianhua = I('post.dianhua');
		$qq = I('post.qq');
		$address = I('post.address');
		$first = I('post.first');
		//dump($first);
		//exit();
		$len = 0;
		for ($i=0;$i<count(I('post.first'));$i++) {
			if($first[$i]=='是'){$len++;}
		}
		if ($len > 1) {$this->mtReturn(300,L('_OPERATION_FAIL_').'首要联系人不能选择多个！','',false);return;}
		//$model0 = M("Jxccontact");		
		$del=M("Jxccontact")->where("attid='".$attid."'")->delete();

		for ($i=0;$i<count(I('post.jxccontact'));$i++) {
			$data1['xingming']=$xingming[$i];
			$data1['sex']=$sex[$i];
			$data1['phone']=$phone[$i];
			$data1['dianhua']=$dianhua[$i];
			$data1['qq']=$qq[$i];
			$data1['address']=$address[$i];
			$data1['first']=$first[$i];
			$model1 = M('Jxccontact');
			$list = $model1 -> add($data1);
		}
		
		$data['uuid']=getuserid();
		$data['uuname']=getusername();
		$data['updatetime']=date("Y-m-d H:i:s",time());
		return $data;
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
		$list = $model->where($map)->field('id,mi_bh,MI_mc,MI_gg,MI_bz,addtime,updatetime')->select();
		$headArr=array('ID','名称','编号','规格','备注','添加时间','更新时间');
		$filename='品种信息管理';
		$this->xlsout($filename,$headArr,$list);
	}
	

}