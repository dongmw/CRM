<?php

/**
 *      购货订单管理控制器
 *      [ZLSYS] (C)2008-2099  
 *      This is NOT a freeware, use is subject to license terms
 *      http://www.zhelininternet.com
 *      tel:13811836808
 *      qq:185530523
 */

namespace Home\Controller;
use Think\Controller;

class JxcpurchaseController extends CommonController{

	public function _initialize() {
		parent::_initialize();
		$this->dbname = CONTROLLER_NAME;
	}
	
	function _filter(&$map) {
		//if(!in_array(session('uid'),C('ADMINISTRATOR'))){
		//$map['id'] = array('EQ', session("uid"));
		//}
	}
	
	function _filter_audit(&$map) {
		//if(!in_array(session('uid'),C('ADMINISTRATOR'))){
		//$map['mp_shr'] = array( array('gt', 0),array('eq', 0), 'or');
		$map['mp_shr'] = array('EQ', 0);
		//$map['mp_ddzt'] = array('EQ', 107);
		//}
	}
	
	public function _befor_index(){ 
	}
	
	public function audit(){ 
		$model = D($this->dbname);
		//$map = $this->_search();
		if (method_exists($this, '_filter_audit')) {
			$this->_filter_audit($map);
		}
		
		if (!empty($model)) {
			$this->_list($model, $map);
		}
		$this->display();
	}

	public function _befor_add(){
		$model1 = D('SystemTag');
		$ms_type_list = $model1 -> get_tag_list('id,name', 'YwType', 10, '采购,销退');
		$this->assign("ms_type_list", $ms_type_list);
		$model0 = D('jxcsuppliers');
		$list_jxcsuppliers=$model0->where('status=1')->field('id,ms_mc,ms_bh,ms_type,status')->order('sort,id')->select();
		$this->assign('list_jxcsuppliers',$list_jxcsuppliers);	
		$attid=get_sid(10);
		$this->assign('attid',$attid);
		
		
		$list_str.='<tr id="jxcpurchase_add_0">
<th title="No." width="38"><input type="text" readonly="readonly" name="jxcpurchase_add_group[0]" class="no textcenter" data-rule="required" value="" size="1"><input type="hidden" id="jxcpurchase_add" name="jxcpurchase_add" value="" size="1"></th>
<th title="商品"><button href="javascript:;" data-url="index.php?m=home&c=public&a=jxcinformation" data-toggle="lookupbtn" data-group="mi_id[0]" style="width:7%" data-title="查找商品"><i class="fa fa-search"></i></button><input type="text" readonly="readonly" name="mi_id[0].mc" data-rule="required;length[~100]" value="" style="width:89%"><input type="hidden" name="mi_id[0].id" value=""></th>
<th title="仓库"><input type="text" readonly="readonly" name="mw_id[0].name" data-rule="required;length[~50]" value="" style="width:100%" data-group="mw_id[0]" data-toggle="lookup" data-url="index.php?m=home&c=public&a=jxcwarehouse"><input type="hidden" name="mw_id[0].id" value=""></th>
<th title="购货单价"><input type="text" name="mpl_jg[0]" data-rule="required;number;length[~20]" onkeyup="jxc_ghdd_add_get_num_(\'jxcpurchase_add_group\',$(this).attr(\'data-group\'),\'jxcpurchase_add\')" id="jxc_ghdd_add_mpl_jg[0]" value="0" style="width:100%" data-group="jxcpurchase_add_group[0]" onfocus="select()" class="textright"></th>
<th title="数量"><input type="text" name="mpl_sl[0]" data-rule="required;number;length[~20]" onkeyup="jxc_ghdd_add_get_num_(\'jxcpurchase_add_group\',$(this).attr(\'data-group\'),\'jxcpurchase_add\')" id="jxc_ghdd_add_mpl_sl[0]" value="0" style="width:100%" data-group="jxcpurchase_add_group[0]" onfocus="select()" class="textright"></th>
<th title="金额"><input type="text" name="mpl_je[0]" data-rule="required;number;length[~20]" onkeyup="jxc_ghdd_add_get_num_(\'jxcpurchase_add_group\',$(this).attr(\'data-group\'),\'jxcpurchase_add\')" id="jxc_ghdd_add_mpl_je[0]" value="0" style="width:100%" data-group="jxcpurchase_add_group[0]" onfocus="select()" class="textright"></th>
<th title="备注"><input type="text" name="mpl_bz[0]" data-rule="length[~50]" value="" style="width:100%"></th>
<th title="" data-addtool="true"><a href="'.U('public/flow','id='.$id.'&type=del').'" onclick="delay_time_run(\'jxc_ghdd_add_num_all(\\\'jxcpurchase_add\\\')\', \'500\')" class="btn row-del"><i class="fa red fa-remove"></i></a></th>
</tr>
';
		$this->assign('list',$list_str);
	}
	
	public function _after_add($id){
	
	}
	
	public function _befor_insert($data){
		$data1['uid']=getuserid();
		$data1['uname']=getusername();
		$data1['addtime']=date("Y-m-d H:i:s",time());
		$data1['attid']=$data['attid'];
		
		$mi_id = I('post.mi_id');
		$mw_id = I('post.mw_id');
		$mpl_sl = I('post.mpl_sl');
		$mpl_jg = I('post.mpl_jg');
		//$mpl_zkl = I('post.mpl_zkl');
		//$mpl_zke = I('post.mpl_zke');
		$mpl_je = I('post.mpl_je');
		//$mpl_sl = I('post.mpl_sl');
		//$mpl_se = I('post.mpl_se');
		//$mpl_jshj = I('post.mpl_jshj');
		$mpl_bz = I('post.mpl_bz');

		//dump(I('post.mi_id'));
		//exit();
		
		$strlen = 0;
		for ($i=0;$i<count(I('post.jxcpurchase_add_group'));$i++) {
			if(strlen($mi_id[$i])>0){$strlen++;}
		}
		if($strlen==0){$this->mtReturn(300,L('_OPERATION_FAIL_').'至少添加一条采购记录！','',false);return;}
		
		$del=M("Jxcpurchaselist")->where("attid='".$data['attid']."'")->delete();

		for ($i=0;$i<count(I('post.jxcpurchase_add_group'));$i++) {
			$data1['mi_id']=$mi_id[$i];
			$data1['mw_id']=$mw_id[$i];
			$data1['mpl_sl']=$mpl_sl[$i];
			$data1['mpl_jg']=$mpl_jg[$i];
			//$data1['mpl_zkl']=$mpl_zkl[$i];
			//$data1['mpl_zke']=$mpl_zke[$i];
			$data1['mpl_je']=$mpl_je[$i];
			//$data1['mpl_sl']=$mpl_sl[$i];
			//$data1['mpl_se']=$mpl_se[$i];
			//$data1['mpl_jshj']=$mpl_jshj[$i];
			$data1['mpl_bz']=$mpl_bz[$i];
			$model1 = M('Jxcpurchaselist');
			$list = $model1 -> add($data1);
		}

		//$m = new \Think\Model();
		$m = M();
		$tablePrefix = C('DB_PREFIX');
        //$sql = "SELECT CONCAT('CGDD',DATE_FORMAT(".$data['mp_ddrq'].",'%Y%m%d'),'',LPAD(count(*)+1,3,0)) mp_ddbh FROM ".$tablePrefix."jxcpurchase WHERE 1 and year(mp_ddrq)=year(now())";
		$sql = "SELECT LPAD(count(*)+1,3,0) mp_ddbh FROM ".$tablePrefix."jxcpurchase WHERE mp_ddrq=DATE_FORMAT('".$data['mp_ddrq']."','%Y-%m-%d')";
        $rs = $m->query($sql);
        if($rs){
            $data['mp_ddbh']='CGDD'.date("Ymd",strtotime($data['mp_ddrq'])).''.$rs[0]['mp_ddbh'];
        }else{
            $data['mp_ddbh']='CGDD'.date("Ymd",strtotime($data['mp_ddrq'])).''.'001';
        }
		
		$data['mp_ddzt']=107;//未入库
		$data['mp_zdr']=getuserid();
		$data['mp_cgr']=getuserid();
		$data['uid']=getuserid();
		$data['uname']=getusername();
		$data['addtime']=date("Y-m-d H:i:s",time());
		return $data;

	}
	
	public function _befor_edit(){

		$model1 = D('SystemTag');
		$ms_type_list = $model1 -> get_tag_list('id,name', 'YwType', 10, '采购,销退');
		$this->assign("ms_type_list", $ms_type_list);
		$model0 = D('jxcsuppliers');
		$list_jxcsuppliers=$model0->where('status=1')->field('id,ms_mc,ms_bh,ms_type,status')->order('sort,id')->select();
		$this->assign('list_jxcsuppliers',$list_jxcsuppliers);	
		
		$model = D($this->dbname);
		$vo = $model->find(I('get.id'));
		$attid=$vo['attid'];
		$this->assign('Rs',$vo);
		
		$i=0;
		$list_str=M('jxcpurchaselist')->where("attid='".$attid."' and status=1")->order('id')->select();
		foreach($list_str as $v){
			$list.='<tr id="jxcpurchase_edit_'.$i.'">
<th title="No." width="38"><input type="text" readonly="readonly" name="jxcpurchase_edit_group['.$i.']" class="no textcenter" data-rule="required" value="'.$i.'" size="1"><input type="hidden" id="jxcpurchase_edit" name="jxcpurchase_edit" value="'.$i.'" size="1"></th>
<th title="商品"><button href="javascript:;" data-url="index.php?m=home&c=public&a=jxcinformation" data-toggle="lookupbtn" data-group="mi_id['.$i.']" style="width:7%" data-title="查找商品"><i class="fa fa-search"></i></button><input type="text" readonly="readonly" name="mi_id['.$i.'].mc" data-rule="required;" value="'.get_table_field($v['mi_id'],'id','mi_bh','jxcinformation').' '.get_table_field($v['mi_id'],'id','mi_mc','jxcinformation').'_规格:'.get_table_field($v['mi_id'],'id','mi_gg','jxcinformation').'_单位:'.get_table_field(get_table_field($v['mi_id'],'id','mi_dw','jxcinformation'),'id','name','system_tag').'" style="width:89%"><input type="hidden" name="mi_id['.$i.'].id" value="'.$v['mi_id'].'"></th>
<th title="仓库"><input type="text" readonly="readonly" name="mw_id['.$i.'].name" data-rule="required;length[~50]" value="'.get_table_field($v['mw_id'],'id','name','jxcwarehouse').'" style="width:100%" data-group="mw_id['.$i.']" data-toggle="lookup" data-url="index.php?m=home&c=public&a=jxcwarehouse"><input type="hidden" name="mw_id['.$i.'].id" value="'.$v['mw_id'].'"></th>
<th title="购货单价"><input type="text" name="mpl_jg['.$i.']" data-rule="required;number;length[~20]" onkeyup="jxc_ghdd_edit_get_num_(\'jxcpurchase_edit_group\',$(this).attr(\'data-group\'),\'jxcpurchase_edit\')" id="jxc_ghdd_edit_mpl_jg['.$i.']" value="'.$v['mpl_jg'].'" style="width:100%" data-group="jxcpurchase_edit_group['.$i.']" onfocus="select()" class="textright"></th>
<th title="数量"><input type="text" name="mpl_sl['.$i.']" data-rule="required;number;length[~20]" onkeyup="jxc_ghdd_edit_get_num_(\'jxcpurchase_edit_group\',$(this).attr(\'data-group\'),\'jxcpurchase_edit\')" id="jxc_ghdd_edit_mpl_sl['.$i.']" value="'.$v['mpl_sl'].'" style="width:100%" data-group="jxcpurchase_edit_group['.$i.']" onfocus="select()" class="textright"></th>
<th title="金额"><input type="text" name="mpl_je['.$i.']" data-rule="required;number;length[~20]" onkeyup="jxc_ghdd_edit_get_num_(\'jxcpurchase_edit_group\',$(this).attr(\'data-group\'),\'jxcpurchase_edit\')" id="jxc_ghdd_edit_mpl_je['.$i.']" value="'.$v['mpl_je'].'" style="width:100%" data-group="jxcpurchase_edit_group['.$i.']" onfocus="select()" class="textright"></th>
<th title="备注"><input type="text" name="mpl_bz['.$i.']" data-rule="length[~50]" value="'.$v['mpl_bz'].'" style="width:100%"></th>
<th title="" data-addtool="true"><a href="'.U('public/flow','id='.$id.'&type=del').'" onclick="delay_time_run(\'jxc_ghdd_edit_num_all(\\\'jxcpurchase_edit\\\')\', \'500\')" class="btn row-del"><i class="fa red fa-remove"></i></a></th>
</tr>
';
			$i++;
		}
		
		$this->assign('list',$list);

		$model0 = D('jxcsuppliers');
		$list_jxcsuppliers=$model0->where('status=1')->field('id,ms_mc,ms_bh,ms_type,status')->order('sort,id')->select();
		$this->assign('list_jxcsuppliers',$list_jxcsuppliers);	
	}
	
	public function _befor_update($data){
		
		$data1['uid']=getuserid();
		$data1['uname']=getusername();
		$data1['addtime']=date("Y-m-d H:i:s",time());
		$data1['attid']=$data['attid'];
		
		$mi_id = I('post.mi_id');
		$mw_id = I('post.mw_id');
		$mpl_sl = I('post.mpl_sl');
		$mpl_jg = I('post.mpl_jg');
		//$mpl_zkl = I('post.mpl_zkl');
		//$mpl_zke = I('post.mpl_zke');
		$mpl_je = I('post.mpl_je');
		//$mpl_sl = I('post.mpl_sl');
		//$mpl_se = I('post.mpl_se');
		//$mpl_jshj = I('post.mpl_jshj');
		$mpl_bz = I('post.mpl_bz');

		//dump(I('post.mi_id'));
		//exit();
		
		$strlen = 0;
		for ($i=0;$i<count(I('post.jxcpurchase_edit_group'));$i++) {
			if(strlen($mi_id[$i])>0){$strlen++;}
		}
		if($strlen==0){$this->mtReturn(300,L('_OPERATION_FAIL_').'至少添加一条采购记录！','',false);return;}
		
		$del=M("Jxcpurchaselist")->where("attid='".$data['attid']."'")->delete();

		for ($i=0;$i<count(I('post.jxcpurchase_edit_group'));$i++) {
			$data1['mi_id']=$mi_id[$i];
			$data1['mw_id']=$mw_id[$i];
			$data1['mpl_sl']=$mpl_sl[$i];
			$data1['mpl_jg']=$mpl_jg[$i];
			//$data1['mpl_zkl']=$mpl_zkl[$i];
			//$data1['mpl_zke']=$mpl_zke[$i];
			$data1['mpl_je']=$mpl_je[$i];
			//$data1['mpl_sl']=$mpl_sl[$i];
			//$data1['mpl_se']=$mpl_se[$i];
			//$data1['mpl_jshj']=$mpl_jshj[$i];
			$data1['mpl_bz']=$mpl_bz[$i];
			$model1 = M('Jxcpurchaselist');
			$list = $model1 -> add($data1);
		}
		
		/* 修改信息保存历史记录 开始 */
		$i=0;
		$model = D($this->dbname);
		$info = $model->find(I('post.id'));
		$id=$info['id'];
		$history=$info['history'];
		$str_br = '';
		if (!empty($history)) {
			$str_br = '<br>';
		}
		$str=$history.$str_br.gettruename().'['.date("Y-m-d H:i:s",time())."] ";
		if(I('post.mp_ywtype') != $info['mp_ywtype']){
			$str.='业务类别:'.$info['mp_ywtype'].' 改为 '.I('post.mp_ywtype').';';
			$i++;
		}
		if(I('post.ms_id') != $info['ms_id']){
			$str.='供应商:'.$info['ms_id'].' 改为 '.I('post.ms_id').';';
			$i++;
		}
		if(I('post.mp_ddrq') != $info['mp_ddrq']){
			$str.='单据日期:'.$info['mp_ddrq'].' 改为 '.I('post.mp_ddrq').';';
			$i++;
		}
		if(I('post.mp_jhrq') != $info['mp_jhrq']){
			$str.='交货日期:'.$info['mp_jhrq'].' 改为 '.I('post.mp_jhrq').';';
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
		$data['uuid']=getuserid();
		$data['uuname']=getusername();
		$data['updatetime']=date("Y-m-d H:i:s",time());
		return $data;
	}
	
	public function view(){

		$model1 = D('SystemTag');
		$ms_type_list = $model1 -> get_tag_list('id,name', 'YwType', 10, '采购,销退');
		$this->assign("ms_type_list", $ms_type_list);
		$model0 = D('jxcsuppliers');
		$list_jxcsuppliers=$model0->where('status=1')->field('id,ms_mc,ms_bh,ms_type,status')->order('sort,id')->select();
		$this->assign('list_jxcsuppliers',$list_jxcsuppliers);	
		
		$model = D($this->dbname);
		$vo = $model->find(I('get.id'));
		$attid=$vo['attid'];
		$this->assign('Rs',$vo);
		
		$i=0;
		$list_str=M('jxcpurchaselist')->where("attid='".$attid."' and status=1")->order('id')->select();
		foreach($list_str as $v){
			$list.='<tr id="jxcpurchase_add_'.$i.'">
<td title="No." widtd="38" class="textcenter">'.($i+1).'</td>
<td title="商品">'.get_table_field($v['mi_id'],'id','mi_bh','jxcinformation').' '.get_table_field($v['mi_id'],'id','mi_mc','jxcinformation').'_规格:'.get_table_field($v['mi_id'],'id','mi_gg','jxcinformation').'_单位:'.get_table_field(get_table_field($v['mi_id'],'id','mi_dw','jxcinformation'),'id','name','system_tag').'</td>
<td title="仓库">'.get_table_field($v['mw_id'],'id','name','jxcwarehouse').'</td>
<td title="购货单价">'.$v['mpl_jg'].'</td>
<td title="数量">'.$v['mpl_sl'].'</td>
<td title="金额">'.$v['mpl_je'].'</td>
<td title="备注">'.$v['mpl_bz'].'</td>
</tr>
';
			$i++;
		}
		
		$this->assign('list',$list);

		$model0 = D('jxcsuppliers');
		$list_jxcsuppliers=$model0->where('status=1')->field('id,ms_mc,ms_bh,ms_type,status')->order('sort,id')->select();
		$this->assign('list_jxcsuppliers',$list_jxcsuppliers);
		$this->display();
	}
	
	/**
	* 确认审核
	*/
	public function confirm(){
		$model = D($this->dbname);
		$id = I('get.id');
		if($id){
			$data=$model->find($id);
			$data['id']=$id;
			if($data['status']==1 && $data['mp_shr']==0){
				$data['mp_shr']=getuserid();
				$msg='通过审核';
				$model->save($data);
			}else if($data['status']==1 && $data['mp_shr']!=0){
				//查询购货单是否存在
				$model_m=M('jxcstorage');
				$data_m=$model_m->where('mp_id='.$data['id'])->find();
				if(isset($data_m)){
					$msg='订单 '.$data['mp_ddbh'].' 有关联的购货单，不能对它进行反审核！';
					$this->mtReturn(300,$msg,$_REQUEST['navTabId'],false);
				}else{
					$data['mp_shr']=0;
					$msg='已经成功退回到上一步！';
					$model->save($data);
				}
			}else{
				$msg='操作有误！';
				$this->mtReturn(300,$msg,$_REQUEST['navTabId'],false);
			}
			$this->mtReturn(200,$msg,$_REQUEST['navTabId'],false);
		}else{
			$this->mtReturn(300,'操作有误！',$_REQUEST['navTabId'],false);
		}
	}

	/**
	* 生成购货单
	*/
	public function make($type=1){
		$model1 = D('SystemTag');
		
		if($type==1){
			$ms_type_list = $model1 -> get_tag_list('id,name', 'YwType', 10, '购货');
		}else if($type==2){
			$ms_type_list = $model1 -> get_tag_list('id,name', 'YwType', 10, '销退');
		}else{
			$this->mtReturn(300,'操作有误！',$_REQUEST['navTabId'],false);
		}
		$this->assign("ms_type_list", $ms_type_list);
		
		$model = D($this->dbname);
		$vo = $model->find(I('get.id'));
		$this->assign('Rs',$vo);
		$attid=get_sid(10);
		$this->assign('attid',$attid);
		
		//判断是否存在购货单记录
		$mjxcstorage = M('jxcstorage');
		$mCount = $mjxcstorage->where('mp_id='.$vo['id'].' and status=1')->count();
		if($mCount>0){$this->mtReturn(300,'订单 '.$vo['mp_ddbh'].' 有关联的入库记录，不能对它进行生成！',$_REQUEST['navTabId'],false);}
		//判断是否存在购货单记录
		
		$i=0;
		$list_str=M('jxcpurchaselist')->where("attid='".$vo['attid']."' and status=1")->order('id')->select();
		foreach($list_str as $v){
			$list.='<tr id="jxcpurchase_make_'.$i.'">
<th title="No." width="38"><input type="text" readonly="readonly" name="jxcpurchase_make_group['.$i.']" class="no textcenter" data-rule="required" value="'.$i.'" size="1"><input type="hidden" id="jxcpurchase_make" name="jxcpurchase_make" value="'.$i.'" size="1"><input type="hidden" name="mpl_id['.$i.']" value="'.$v['id'].'" size="1"></th>
<th title="商品"><input type="text" readonly="readonly" name="mi_id['.$i.'].mc" data-rule="required;" value="'.get_table_field($v['mi_id'],'id','mi_bh','jxcinformation').' '.get_table_field($v['mi_id'],'id','mi_mc','jxcinformation').'_规格:'.get_table_field($v['mi_id'],'id','mi_gg','jxcinformation').'_单位:'.get_table_field(get_table_field($v['mi_id'],'id','mi_dw','jxcinformation'),'id','name','system_tag').'" style="width:100%"><input type="hidden" name="mi_id['.$i.'].id" value="'.$v['mi_id'].'"></th>
<th title="仓库"><input type="text" readonly="readonly" name="mw_id['.$i.'].name" data-rule="required;length[~50]" value="'.get_table_field($v['mw_id'],'id','name','jxcwarehouse').'" style="width:100%" data-group="mw_id['.$i.']" data-toggle="lookup" data-url="index.php?m=home&c=public&a=jxcwarehouse"><input type="hidden" name="mw_id['.$i.'].id" value="'.$v['mw_id'].'"></th>
<th title="购货单价"><input type="text" readonly="readonly" name="mpl_jg['.$i.']" data-rule="required;number;length[~20]" onkeyup="jxc_ghdd_add_get_num_(\'jxcpurchase_make_group\',$(this).attr(\'data-group\'),\'jxcpurchase_make\')" id="jxc_ghdd_add_mpl_jg['.$i.']" value="'.$v['mpl_jg'].'" style="width:100%" data-group="jxcpurchase_make_group['.$i.']" onfocus="select()" class="textright"></th>
<th title="数量"><input type="text" readonly="readonly" name="mpl_sl['.$i.']" data-rule="required;number;length[~20]" onkeyup="jxc_ghdd_add_get_num_(\'jxcpurchase_make_group\',$(this).attr(\'data-group\'),\'jxcpurchase_make\')" id="jxc_ghdd_add_mpl_sl['.$i.']" value="'.$v['mpl_sl'].'" style="width:100%" data-group="jxcpurchase_make_group['.$i.']" onfocus="select()" class="textright"></th>
<th title="金额"><input type="text" readonly="readonly" name="mpl_je['.$i.']" data-rule="required;number;length[~20]" onkeyup="jxc_ghdd_add_get_num_(\'jxcpurchase_make_group\',$(this).attr(\'data-group\'),\'jxcpurchase_make\')" id="jxc_ghdd_add_mpl_je['.$i.']" value="'.$v['mpl_je'].'" style="width:100%" data-group="jxcpurchase_make_group['.$i.']" onfocus="select()" class="textright"></th>
<th title="批次""><input type="text" name="mpl_pc['.$i.']" data-rule="length[~50]" value="" style="width:100%"></th>
<th title="生产日期"><input type="text" name="mpl_scrq['.$i.']" data-rule="required;date" data-toggle="datepicker" data-min-date="{%y-10}-%M-%d" data-max-date="{%y+10}-%M-%d" value="" style="width:100%"></th>
<th title="有效期至"><input type="text" name="mpl_yxqz['.$i.']" data-rule="required;date" data-toggle="datepicker" data-min-date="{%y-10}-%M-%d" data-max-date="{%y+10}-%M-%d" value="" style="width:100%"></th>
<th title="备注"><input type="text" name="mpl_bz['.$i.']" data-rule="length[~50]" value="'.$v['mpl_bz'].'" style="width:100%"></th>
</tr>
';
			$i++;
		}
		$this->assign('list',$list);
		$this->assign('mp_num',$i);
		$model0 = D('jxcsuppliers');
		$list_jxcsuppliers=$model0->where('status=1')->field('id,ms_mc,ms_bh,ms_type,status')->order('sort,id')->select();
		$this->assign('list_jxcsuppliers',$list_jxcsuppliers);
		$model0 = D('jxcaccount');
		$list_jxcaccount=$model0->where('status=1')->field('id,name,number,balance')->order('sort,id')->select();
		$this->assign('list_jxcaccount',$list_jxcaccount);
		$this->display();
	}
	
	//清理
	public function del(){
		$model = D($this->dbname);
		$id = I('get.id');
		if($id){
			$data=$model->find($id);
			$data['id']=$id;
			if($data['status']==1 && $data['mp_shr']==0){
				$data['status']=0;
				$msg='已经设置为无效！';
				$model->save($data);
				$this->mtReturn(200,$msg,$_REQUEST['navTabId'],false);
			}else if($data['status']==0 && $data['mp_shr']==0){
				$data['status']=1;
				$msg='已经设置为有效！';
				$model->save($data);
				$this->mtReturn(200,$msg,$_REQUEST['navTabId'],false);
			}else if($data['mp_shr']!=0){
				$msg='已审核单据不能设为无效！';
				$this->mtReturn(300,$msg,$_REQUEST['navTabId'],false);
			}else{
				$msg='操作有误！';
				$this->mtReturn(300,$msg,$_REQUEST['navTabId'],false);
			}
		}else{
			$info=$model->where('status=0 and mp_shr=0')->select();
			foreach($info as $key=>$v){
				$attid=$v['attid'];
				$st['status']=0;
				M('jxcpurchaselist')->where(array("attid"=>$attid))->save($st);
				
				$ad['attid']=0;
				M('files')->where(array("attid"=>$attid))->save($ad);
			}
			$info=M('files')->where('attid=0')->select();
			foreach($info as $key=>$v){
				$filepath=$v['folder'].$v['filename'];
				unlink($filepath);
			}
			M('files')->where('attid=0')->delete();
			$Rs=$model->where('status=0')->delete();
			M('jxcpurchaselist')->where('status=0')->delete();
			$this->mtReturn(200,'清理'.$Rs.'条无用的记录',$_REQUEST['navTabId'],false);
		}
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
		$filename='采购订单记录';
		$this->xlsout($filename,$headArr,$list);
	}
	

}