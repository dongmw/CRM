<?php

/**
 *      资金转账单管理控制器
 *      [ZLSYS] (C)2008-2099  
 *      This is NOT a freeware, use is subject to license terms
 *      http://www.zhelininternet.com
 *      tel:13811836808
 *      qq:185530523
 */

namespace Home\Controller;
use Think\Controller;

class JxcfundtransferController extends CommonController{

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
		//$map['mp_ddzt'] = array('EQ', 110);//未收款
		//}
	}
	
	public function _befor_index(){ 
		$model0 = D('jxcsuppliers');
		$list_jxcsuppliers=$model0->where('status=1')->field('id,ms_mc,ms_bh,ms_type,status')->order('sort,id')->select();
		$this->assign('list_jxcsuppliers',$list_jxcsuppliers);
	}
	
	public function audit(){ 
		$model0 = D('jxcsuppliers');
		$list_jxcsuppliers=$model0->where('status=1')->field('id,ms_mc,ms_bh,ms_type,status')->order('sort,id')->select();
		$this->assign('list_jxcsuppliers',$list_jxcsuppliers);
		
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
		$ms_type_list = $model1 -> get_tag_list('id,name', 'YwType', 10, '资金转账');
		$this->assign("ms_type_list", $ms_type_list);

		$attid=get_sid(10);
		$this->assign('attid',$attid);
		
		$list.='<tr id="jxcfundtransfer_add_0">
<th title="No." width="38"><input type="text" readonly="readonly" name="jxcfundtransfer_add_group[0]" class="no textcenter" data-rule="required" value="" size="1" style="width:100%"><input type="hidden" id="jxcfundtransfer_add" name="jxcfundtransfer_add" value="" size="1"></th>
<th title="转出账户"><input type="text" readonly="readonly" name="mw_id0[0].name" data-rule="required;length[~50]" value="" style="width:100%" data-group="mw_id0[0]" data-toggle="lookup" data-url="index.php?m=home&c=public&a=jxcaccount"><input type="hidden" name="mw_id0[0].id" value=""></th>
<th title="转入账户"><input type="text" readonly="readonly" name="mw_id[0].name" data-rule="required;length[~50]" value="" style="width:100%" data-group="mw_id[0]" data-toggle="lookup" data-url="index.php?m=home&c=public&a=jxcaccount"><input type="hidden" name="mw_id[0].id" value=""></th>
<th title="金额"><input type="text" name="mpl_sl[0]" data-rule="required;number;length[~20]" onkeyup="jxcfundtransfer_add_get_num_(\'jxcfundtransfer_add_group\',$(this).attr(\'data-group\'),\'jxcfundtransfer_add\')" id="jxc_ftf_add_transfer_sl[0]" value="0" style="width:100%" data-group="jxcfundtransfer_add_group[0]" onfocus="select()" class="textright"></th>
<th title="结算方式"><input type="text" readonly="readonly" name="mi_id[0].name" data-rule="required;" value="" style="width:100%" data-group="mi_id[0]" data-toggle="lookup" data-url="index.php?m=home&c=public&a=settlementtype"><input type="hidden" name="mi_id[0].id" value=""></th>
<th title="结算号"><input type="text" name="mpl_number[0]" data-rule="length[~50]" value="" style="width:100%"></th>
<th title="备注"><input type="text" name="mpl_bz[0]" data-rule="length[~50]" value="" style="width:100%"></th>
<th title="" data-addtool="true"><a href="'.U('public/flow','id='.$id.'&type=del').'" onclick="delay_time_run(\'jxcfundtransfer_add_num_all(\\\'jxcfundtransfer_add\\\')\', \'500\')" class="btn row-del"><i class="fa red fa-remove"></i></a></th>
</tr>
';
		$this->assign('list',$list);
	}
	
	public function _after_add($id){
	
	}
	
	//添加资金转账单	
	public function _befor_insert($data){
		$data1['uid']=getuserid();
		$data1['uname']=getusername();
		$data1['addtime']=date("Y-m-d H:i:s",time());
		$data1['attid']=$data['attid'];
		
		$mi_id = I('post.mi_id');
		$mw_id0 = I('post.mw_id0');
		$mw_id = I('post.mw_id');
		$mpl_sl = I('post.mpl_sl');
		$mpl_number = I('post.mpl_number');
		$mpl_bz = I('post.mpl_bz');
		
		//判断 是否有记录 或 账户是否存在
		$strlen = 0;
		$strlen_mw = 0;
		$strerr = '';
		for ($i=0;$i<count(I('post.jxcfundtransfer_add_group'));$i++) {
			if(strlen($mi_id[$i])>0){$strlen++;}
			$err=0;
			$data1['mi_id']=$mi_id[$i];
			$data1['mw_id0']=$mw_id0[$i];
			$data1['mw_id']=$mw_id[$i];
			$data1['mpl_sl']=$mpl_sl[$i];
			$m_jxcaccount = M('jxcaccount');
			$m_info0 = $m_jxcaccount->field('id,balance')->where('id='.$data1['mw_id0'].'')->find();
			$m_info = $m_jxcaccount->field('id,balance')->where('id='.$data1['mw_id'].'')->find();
			if (isset($m_info0) && isset($m_info)){
				if($m_info0['balance']<$data1['mpl_sl']){
					$strerr.='['.get_table_field($data1['mw_id0'],'id','name','jxcaccount').']';
					$err++;
				}
				/*if($m_info['balance']<$data1['mpl_sl']){
					$strerr.='['.get_table_field($data1['mw_id'],'id','name','jxcaccount').']';
					$err++;
				}*/
				if($err==0){$strlen_mw++;}
			}else{
				if (!isset($m_info0)){
					$strerr.='['.get_table_field($data1['mw_id0'],'id','name','jxcaccount').']';
				}
				if (!isset($m_info)){
					$strerr.='['.get_table_field($data1['mw_id'],'id','name','jxcaccount').']';
				}
			}
		}
		if($strlen==0){$this->mtReturn(300,'至少添加一条资金转账记录！','',false);return;}
		if($strlen_mw!=count(I('post.jxcfundtransfer_add_group'))){$this->mtReturn(300,'账户：'.$strerr.'不存在或金额不可用！','',false);return;}
		//判断 是否有记录 或 账户是否存在
		
		$del=M("jxcfundtransferlist")->where("attid='".$data['attid']."'")->delete();
		for ($i=0;$i<count(I('post.jxcfundtransfer_add_group'));$i++) {
			$data1['mi_id']=$mi_id[$i];
			$data1['mw_id0']=$mw_id0[$i];
			$data1['mw_id']=$mw_id[$i];
			$data1['mpl_sl']=$mpl_sl[$i];
			$data1['mpl_number']=$mpl_number[$i];			
			$data1['mpl_bz']=$mpl_bz[$i];
			$model1 = M('jxcfundtransferlist');
			$list = $model1 -> add($data1);
		}

		$m = M();//$m = new \Think\Model();
		$tablePrefix = C('DB_PREFIX');
		$sql = "SELECT LPAD(count(*)+1,3,0) ms_ddbh FROM ".$tablePrefix."jxcfundtransfer WHERE mp_ddrq=DATE_FORMAT('".$data['mp_ddrq']."','%Y-%m-%d')";
		$rs = $m->query($sql);
		if($rs){
			$data['ms_ddbh']='ZJZZ'.date("Ymd",strtotime($data['mp_ddrq'])).''.$rs[0]['ms_ddbh'];
		}else{
			$data['ms_ddbh']='ZJZZ'.date("Ymd",strtotime($data['mp_ddrq'])).''.'001';
		}
		
		$data['mp_zdr']=getuserid();
		$data['uid']=getuserid();
		$data['uname']=getusername();
		$data['addtime']=date("Y-m-d H:i:s",time());
		return $data;
	}
	
	public function _befor_edit(){
		$model1 = D('SystemTag');
		$ms_type_list = $model1 -> get_tag_list('id,name', 'YwType', 10, '资金转账');
		$this->assign("ms_type_list", $ms_type_list);

		//客户
		$model0 = D('jxccustomers');
		$list_jxcsuppliers=$model0->where('status=1')->field('id,mc_mc,mc_bh,mc_type,status')->order('sort,id')->select();
		$this->assign('list_jxcsuppliers',$list_jxcsuppliers);	
		//客户
		
		//销售人员
		$id=16;
		$info = M('role_duty'); 
		$rs='0';
		$rss = $info->where('duty_id='.$id)->order('role_id')->field('role_id')->select();
		for ($i=0;$i<count($rss);$i++){
			$rs .= ','.$rss[$i]['role_id'];
		}
		$list_sales=M('user')->where('position_id in ('.$rs.')')->order('username')->field('id,posname,truename')->select();
		$this->assign('list_sales',$list_sales);	
		//销售人员

		$model0 = D('jxcaccount');
		$list_jxcaccount=$model0->where('status=1')->field('id,name,number,balance')->order('sort,id')->select();
		$this->assign('list_jxcaccount',$list_jxcaccount);
		
		$model = D($this->dbname);
		$vo = $model->find(I('get.id'));
		$mp_shr=$vo['mp_shr'];
		$ms_ddbh=$vo['ms_ddbh'];
		
		//判断是否审核
		if($mp_shr>0){$this->mtReturn(300,'订单 '.$ms_ddbh.' 已经审核，不能对它进行编辑！',$_REQUEST['navTabId'],false);}
		//判断是否审核

		$this->assign('Rs',$vo);
		
		$i=0;
		$list_str=M('jxcfundtransferlist')->where("attid='".$vo['attid']."' and status=1")->order('id')->select();
		foreach($list_str as $v){
			$list.='<tr id="jxcfundtransfer_edit_'.$i.'">
<th title="No." width="38"><input type="text" readonly="readonly" name="jxcfundtransfer_edit_group['.$i.']" class="no textcenter" data-rule="required" value="'.$i.'" size="1" style="width:100%"><input type="hidden" id="jxcfundtransfer_edit" name="jxcfundtransfer_edit" value="'.$i.'" size="1"></th>
<th title="转出账户"><input type="text" readonly="readonly" name="mw_id0['.$i.'].name" data-rule="required;length[~50]" value="'.get_table_field($v['mw_id0'],'id','name','jxcaccount').'" style="width:100%" data-group="mw_id0['.$i.']" data-toggle="lookup" data-url="index.php?m=home&c=public&a=jxcaccount"><input type="hidden" name="mw_id0['.$i.'].id" value="'.$v['mw_id0'].'"></th>
<th title="转入账户"><input type="text" readonly="readonly" name="mw_id['.$i.'].name" data-rule="required;length[~50]" value="'.get_table_field($v['mw_id'],'id','name','jxcaccount').'" style="width:100%" data-group="mw_id['.$i.']" data-toggle="lookup" data-url="index.php?m=home&c=public&a=jxcaccount"><input type="hidden" name="mw_id['.$i.'].id" value="'.$v['mw_id'].'"></th>
<th title="金额"><input type="text" name="mpl_sl['.$i.']" data-rule="required;number;length[~20]" onkeyup="jxcfundtransfer_edit_get_num_(\'jxcfundtransfer_edit_group\',$(this).attr(\'data-group\'),\'jxcfundtransfer_edit\')" id="jxc_ftf_edit_transfer_sl['.$i.']" value="'.$v['mpl_sl'].'" style="width:100%" data-group="jxcfundtransfer_edit_group['.$i.']" onfocus="select()" class="textright"></th>
<th title="结算方式"><input type="text" readonly="readonly" name="mi_id['.$i.'].name" data-rule="required;" value="'.get_table_field($v['mi_id'],'id','name','system_tag').'" style="width:100%" data-group="mi_id['.$i.']" data-toggle="lookup" data-url="index.php?m=home&c=public&a=settlementtype"><input type="hidden" name="mi_id['.$i.'].id" value="'.$v['mi_id'].'"></th>
<th title="结算号"><input type="text" name="mpl_number['.$i.']" data-rule="length[~50]" value="'.$v['mpl_number'].'" style="width:100%"></th>
<th title="备注"><input type="text" name="mpl_bz['.$i.']" data-rule="length[~50]" value="'.$v['mpl_bz'].'" style="width:100%"></th>
<th title="" data-addtool="true"><a href="'.U('public/flow','id='.$id.'&type=del').'" onclick="delay_time_run(\'jxcfundtransfer_edit_num_all(\\\'jxcfundtransfer_edit\\\')\', \'500\')" class="btn row-del"><i class="fa red fa-remove"></i></a></th>
</tr>
';
			$i++;
		}
		$this->assign('list',$list);
	}
	
	public function _befor_update($data){
		
		$data1['uid']=getuserid();
		$data1['uname']=getusername();
		$data1['addtime']=date("Y-m-d H:i:s",time());
		$data1['attid']=$data['attid'];
		
		$mi_id = I('post.mi_id');
		$mw_id0 = I('post.mw_id0');
		$mw_id = I('post.mw_id');
		$mpl_sl = I('post.mpl_sl');
		$mpl_number = I('post.mpl_number');
		$mpl_bz = I('post.mpl_bz');
		
		//判断 是否有记录 或 账户是否存在
		$strlen = 0;
		$strlen_mw = 0;
		$strerr = '';
		for ($i=0;$i<count(I('post.jxcfundtransfer_edit_group'));$i++) {
			if(strlen($mi_id[$i])>0){$strlen++;}
			$err=0;
			$data1['mi_id']=$mi_id[$i];
			$data1['mw_id0']=$mw_id0[$i];
			$data1['mw_id']=$mw_id[$i];
			$data1['mpl_sl']=$mpl_sl[$i];
			$m_jxcaccount = M('jxcaccount');
			$m_info0 = $m_jxcaccount->field('id,balance')->where('id='.$data1['mw_id0'].'')->find();
			$m_info = $m_jxcaccount->field('id,balance')->where('id='.$data1['mw_id'].'')->find();
			if (isset($m_info0) && isset($m_info)){
				if($m_info0['balance']<$data1['mpl_sl']){
					$strerr.='['.get_table_field($data1['mw_id0'],'id','name','jxcaccount').']';
					$err++;
				}
				/*if($m_info['balance']<$data1['mpl_sl']){
					$strerr.='['.get_table_field($data1['mw_id'],'id','name','jxcaccount').']';
					$err++;
				}*/
				if($err==0){$strlen_mw++;}
			}else{
				if (!isset($m_info0)){
					$strerr.='['.get_table_field($data1['mw_id0'],'id','name','jxcaccount').']';
				}
				if (!isset($m_info)){
					$strerr.='['.get_table_field($data1['mw_id'],'id','name','jxcaccount').']';
				}
			}
		}
		if($strlen==0){$this->mtReturn(300,'至少添加一条资金转账记录！','',false);return;}
		if($strlen_mw!=count(I('post.jxcfundtransfer_edit_group'))){$this->mtReturn(300,'账户：'.$strerr.'不存在或金额不可用！','',false);return;}
		//判断 是否有记录 或 账户是否存在
		
		$del=M("jxcfundtransferlist")->where("attid='".$data['attid']."'")->delete();
		for ($i=0;$i<count(I('post.jxcfundtransfer_edit_group'));$i++) {
			$data1['mi_id']=$mi_id[$i];
			$data1['mw_id0']=$mw_id0[$i];
			$data1['mw_id']=$mw_id[$i];
			$data1['mpl_sl']=$mpl_sl[$i];
			$data1['mpl_number']=$mpl_number[$i];
			$data1['mpl_bz']=$mpl_bz[$i];
			$model1 = M('jxcfundtransferlist');
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
		if(I('post.mp_ddrq') != $info['mp_ddrq']){
			$str.='单据日期:'.$info['mp_ddrq'].' 改为 '.I('post.mp_ddrq').';';
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
		$ms_type_list = $model1 -> get_tag_list('id,name', 'YwType', 10, '资金转账');
		$this->assign("ms_type_list", $ms_type_list);
		$model0 = D('jxcsuppliers');
		$list_jxcsuppliers=$model0->where('status=1')->field('id,ms_mc,ms_bh,ms_type,status')->order('sort,id')->select();
		$this->assign('list_jxcsuppliers',$list_jxcsuppliers);	
		
		$model = D($this->dbname);
		$vo = $model->find(I('get.id'));
		$attid=$vo['attid'];
		$this->assign('Rs',$vo);
		
		$i=0;
		$list_str=M('jxcfundtransferlist')->where("attid='".$attid."' and status=1")->order('id')->select();
		foreach($list_str as $v){
			$list.='<tr id="jxcfundtransfer_add_'.$i.'">
<td title="No." widtd="38" class="textcenter">'.($i+1).'</td>
<td title="结算方式">'.get_table_field($v['mi_id'],'id','mi_bh','jxcinformation').' '.get_table_field($v['mi_id'],'id','mi_mc','jxcinformation').'_规格:'.get_table_field($v['mi_id'],'id','mi_gg','jxcinformation').'_单位:'.get_table_field(get_table_field($v['mi_id'],'id','mi_dw','jxcinformation'),'id','name','system_tag').'</td>
<td title="账户">'.get_table_field($v['mw_id'],'id','name','jxcaccount').'</td>
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
	* 审核/反审
	*/
	public function confirm(){
		$model=D($this->dbname);
		$type=I('get.type');
		$id=I('get.id');
		if($type && $id){
			$data=$model->find($id);
			$data['id']=$id;
			//审核
			if($type==1 && $data['status']==1 && $data['mp_shr']==0){
				
				//更新总表审核状态
				$data['mp_shr']=getuserid();
				$attid=$data['attid'];
				$model->save($data);
				
				//判断账户是否存在
				$strlen_mw = 0;
				$strerr = '';
				$data1_list=M('jxcfundtransferlist')->where("attid='".$attid."' and status=1")->order('id')->select();
				foreach($data1_list as $data1){
					$err=0;
					$m_jxcaccount = M('jxcaccount');
					$m_info0 = $m_jxcaccount->field('id,balance')->where('id='.$data1['mw_id0'].'')->find();
					$m_info = $m_jxcaccount->field('id,balance')->where('id='.$data1['mw_id'].'')->find();
					if (isset($m_info0) && isset($m_info)){
						if($m_info0['balance']<$data1['mpl_sl']){
							$strerr.='['.get_table_field($data1['mw_id0'],'id','name','jxcaccount').']';
							$err++;
						}
						if($err==0){$strlen_mw++;}
					}else{
						if (!isset($m_info0)){
							$strerr.='['.get_table_field($data1['mw_id0'],'id','name','jxcaccount').']';
						}
						if (!isset($m_info)){
							$strerr.='['.get_table_field($data1['mw_id'],'id','name','jxcaccount').']';
						}
					}
				}
				if($strlen_mw!=count($data1_list)){$this->mtReturn(300,'账户：'.$strerr.'不存在或金额不可用！','',false);return;}
				//判断账户是否存在
				
				//明细
				$data1_list1=M('jxcfundtransferlist')->where("attid='".$attid."' and status=1")->order('id')->select();
				foreach($data1_list1 as $data1){

					//更新金额信息
					$m_jxcaccount = M('jxcaccount');
					$m_info0 = $m_jxcaccount->field('id,balance')->where('id='.$data1['mw_id0'].'')->find();//$balance0=$m_info0['balance'];
					$m_info = $m_jxcaccount->field('id,balance')->where('id='.$data1['mw_id'].'')->find();
					$m_info0['balance']=doubleval($m_info0['balance'])-doubleval($data1['mpl_sl']);//减金额
					$m_info0['mp_shr']=getuserid();
					$m_info['balance']=doubleval($m_info['balance'])+doubleval($data1['mpl_sl']);//增金额
					$m_info['mp_shr']=getuserid();
					$m_jxcaccount->where('id='.$data1['mw_id0'].'')->save($m_info0);
					$m_jxcaccount->where('id='.$data1['mw_id'].'')->save($m_info);
					
					//更新分表审核状态
					$model3=M("jxcfundtransferlist");
					$model3->where('id='.$data1['id'])->setField('mp_shr',getuserid());
					
					//更新账户明细表 减金额
					$a_model1 = D('jxcaccountlist');
					$a_data1['pid'] = $data1['mw_id0'];
					$a_data1['addtime'] = $data['mp_ddrq'];//date("Y-m-d H:i:s",time());
					$a_data1['uid']=getuserid();
					$a_data1['uname']=getusername();
					$a_data1['number'] = $data['ms_ddbh'];//单据编号
					$a_data1['ywtype'] = $data['mp_ywtype'];//业务类型
					$a_data1['income'] = 0;//收入
					$a_data1['expenditure'] = $data1['mpl_sl'];//支出
					$a_data1['balance'] = $m_info0['balance'];//当前余额
					//$a_data1['buid'] = 0;//往来单位ID
					//$a_data1['buname'] = get_table_field($data['ms_id'],'id','ms_mc','jxcsuppliers');//往来单位
					$a_model1->add($a_data1);
					//更新账户明细表
					
					//更新账户明细表 增金额
					$a_model2 = D('jxcaccountlist');
					$a_data2['pid'] = $data1['mw_id'];
					$a_data2['addtime'] = $data['mp_ddrq'];//date("Y-m-d H:i:s",time());
					$a_data2['uid']=getuserid();
					$a_data2['uname']=getusername();
					$a_data2['number'] = $data['ms_ddbh'];//单据编号
					$a_data2['ywtype'] = $data['mp_ywtype'];//业务类型
					$a_data2['income'] = $data1['mpl_sl'];//收入
					$a_data2['expenditure'] = 0;//支出
					$a_data2['balance'] = $m_info['balance'];//当前余额
					//$a_data2['buid'] = 0;//往来单位ID
					//$a_data2['buname'] = get_table_field($data['ms_id'],'id','ms_mc','jxcsuppliers');//往来单位
					$a_model2->add($a_data2);
					//更新账户明细表

				}
				$msg='审核成功！';
				$this->mtReturn(200,$msg,$_REQUEST['navTabId'],false);
				return;
			}else if($type==2 && $data['status']==1 && $data['mp_shr']!=0){
				
				//更新总表审核状态
				$data['mp_shr']=0;
				$attid=$data['attid'];
				$model->save($data);
				
				//判断账户是否存在
				$strlen_mw = 0;
				$strerr = '';
				$data1_list=M('jxcfundtransferlist')->where("attid='".$attid."' and status=1")->order('id')->select();
				foreach($data1_list as $data1){
					$err=0;
					$m_jxcaccount = M('jxcaccount');
					$m_info0 = $m_jxcaccount->field('id,balance')->where('id='.$data1['mw_id0'].'')->find();
					$m_info = $m_jxcaccount->field('id,balance')->where('id='.$data1['mw_id'].'')->find();
					if (isset($m_info0) && isset($m_info)){
						if($m_info['balance']<$data1['mpl_sl']){
							$strerr.='['.get_table_field($data1['mw_id'],'id','name','jxcaccount').']';
							$err++;
						}
						if($err==0){$strlen_mw++;}
					}else{
						if (!isset($m_info0)){
							$strerr.='['.get_table_field($data1['mw_id0'],'id','name','jxcaccount').']';
						}
						if (!isset($m_info)){
							$strerr.='['.get_table_field($data1['mw_id'],'id','name','jxcaccount').']';
						}
					}
				}
				if($strlen_mw!=count($data1_list)){$this->mtReturn(300,'账户：'.$strerr.'不存在或金额不可用！','',false);return;}
				//判断账户是否存在
				
				//明细
				$data1_list1=M('jxcfundtransferlist')->where("attid='".$attid."' and status=1")->order('id')->select();
				foreach($data1_list1 as $data1){

					//更新金额信息
					$m_jxcaccount = M('jxcaccount');
					$m_info0 = $m_jxcaccount->field('id,balance')->where('id='.$data1['mw_id0'].'')->find();
					$m_info = $m_jxcaccount->field('id,balance')->where('id='.$data1['mw_id'].'')->find();
					$m_info0['balance']=doubleval($m_info0['balance'])+doubleval($data1['mpl_sl']);//增金额
					$m_info0['mp_shr']=getuserid();
					$m_info['balance']=doubleval($m_info['balance'])-doubleval($data1['mpl_sl']);//减金额
					$m_info['mp_shr']=getuserid();
					$m_jxcaccount->where('id='.$data1['mw_id0'].'')->save($m_info0);
					$m_jxcaccount->where('id='.$data1['mw_id'].'')->save($m_info);
					
					//更新分表审核状态
					$model3=M("jxcfundtransferlist");
					$model3->where('id='.$data1['id'])->setField('mp_shr',0);
				}
				
				//更新账户明细表
				M('jxcaccountlist')->where("number='".$data['ms_ddbh']."'")->delete();
				//更新账户明细表

				$msg='已经成功退回到上一步！';
				$this->mtReturn(200,$msg,$_REQUEST['navTabId'],false);
				return;
			}
		}else{
			$this->mtReturn(300,'操作有误！',$_REQUEST['navTabId'],false);
		}
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
				M('jxcfundtransferlist')->where(array("attid"=>$attid))->save($st);
				
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
			M('jxcfundtransferlist')->where('status=0')->delete();
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