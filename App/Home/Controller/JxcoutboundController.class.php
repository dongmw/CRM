<?php

/**
 *      销货单管理控制器
 *      [ZLSYS] (C)2008-2099  
 *      This is NOT a freeware, use is subject to license terms
 *      http://www.zhelininternet.com
 *      tel:13811836808
 *      qq:185530523
 */

namespace Home\Controller;
use Think\Controller;

class JxcoutboundController extends CommonController{

	public function _initialize() {
		parent::_initialize();
		$this->dbname = CONTROLLER_NAME;
	}
	
	function _filter(&$map) {
		//if(!in_array(session('uid'),C('ADMINISTRATOR'))){
		$map['mp_ywtype'] = array('EQ', '100');
		//$map['id'] = array('EQ', session("uid"));
		//}
	}
	
	public function _befor_index(){ 
		//$model0 = D('jxcsuppliers');
		//$list_jxcsuppliers=$model0->where('status=1')->field('id,ms_mc,ms_bh,ms_type,status')->order('sort,id')->select();
		//$this->assign('list_jxcsuppliers',$list_jxcsuppliers);
	}
	
	function _filter_audit(&$map) {
		//if(!in_array(session('uid'),C('ADMINISTRATOR'))){
		//$map['mp_shr'] = array( array('gt', 0),array('eq', 0), 'or');
		$map['mp_ywtype'] = array('EQ', '100');
		$map['mp_shr'] = array('EQ', 0);
		//$map['mp_ddzt'] = array('EQ', 110);//未收款
		//}
	}
	
	public function audit(){ 
		//$model0 = D('jxcsuppliers');
		//$list_jxcsuppliers=$model0->where('status=1')->field('id,ms_mc,ms_bh,ms_type,status')->order('sort,id')->select();
		//$this->assign('list_jxcsuppliers',$list_jxcsuppliers);
		
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
		$ms_type_list = $model1 -> get_tag_list('id,name', 'YwType', 10, '销货');
		$this->assign("ms_type_list", $ms_type_list);
		$this->assign('mp_num',$i);

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

		$attid=get_sid(10);
		$this->assign('attid',$attid);
		$model0 = D('jxcaccount');
		$list_jxcaccount=$model0->where('status=1')->field('id,name,number,balance')->order('sort,id')->select();
		$this->assign('list_jxcaccount',$list_jxcaccount);
		
		$list.='<tr id="jxcoutbound_add_0">
<th title="No." width="38"><input type="text" readonly="readonly" name="jxcoutbound_add_group[0]" class="no textcenter" data-rule="required" value="" size="1"><input type="hidden" id="jxcoutbound_add" name="jxcoutbound_add" value="" size="1"></th>
<th title="商品"><span style="position: relative; display: inline-block;width: 100%;" class="wrap_bjui_btn_box"><input aria-required="true" class="form-control" readonly="readonly" name="mi_id[0].mc" value="" style="width: 100%; padding-right: 15px;" data-rule="required;length[~50]" data-group="mi_id[0]" type="text"><a style="height: 22px; line-height: 22px;" class="bjui-lookup" href="javascript:;" data-url="index.php?m=home&c=public&a=jxcinformation" data-toggle="lookupbtn" data-group="mi_id[0]" data-title="查找商品"><i class="fa fa-search"></i></a></span><input type="hidden" name="mi_id[0].id" value="" id="mi_id0"></th>
<th title="仓库"><span style="position: relative; display: inline-block;" class="wrap_bjui_btn_box"><input aria-required="true" class="form-control" readonly="readonly" name="mw_id[0].name" value="" style="width: 100%; padding-right: 15px;" data-rule="required;length[~50]" data-group="mw_id[0]" type="text"><a style="height: 22px; line-height: 22px;" class="bjui-lookup"  href="javascript:;" data-url="index.php?m=home&c=public&a=jxcwarehouse&type={#mi_id0}" data-toggle="lookupbtn" data-group="mw_id[0]" data-warn="请先选择商品"><i class="fa fa-search"></i></a></span><input type="hidden" name="mw_id[0].id" value=""></th>
<th title="购货单价"><input type="text" name="mpl_jg[0]" data-rule="required;number;length[~20]" onkeyup="jxc_xhd_add_get_num_(\'jxcoutbound_add_group\',$(this).attr(\'data-group\'),\'jxcoutbound_add\')" id="jxc_xhd_add_mpl_jg[0]" value="0" style="width:100%" data-group="jxcoutbound_add_group[0]" onfocus="select()" class="textright"></th>
<th title="数量"><input type="text" name="mpl_sl[0]" data-rule="required;number;length[~20]" onkeyup="jxc_xhd_add_get_num_(\'jxcoutbound_add_group\',$(this).attr(\'data-group\'),\'jxcoutbound_add\')" id="jxc_xhd_add_mpl_sl[0]" value="0" style="width:100%" data-group="jxcoutbound_add_group[0]" onfocus="select()" class="textright"></th>
<th title="金额"><input type="text" name="mpl_je[0]" data-rule="required;number;length[~20]" onkeyup="jxc_xhd_add_get_num_(\'jxcoutbound_add_group\',$(this).attr(\'data-group\'),\'jxcoutbound_add\')" id="jxc_xhd_add_mpl_je[0]" value="0" style="width:100%" data-group="jxcoutbound_add_group[0]" onfocus="select()" class="textright"></th>
<th title="备注"><input type="text" name="mpl_bz[0]" data-rule="length[~50]" value="" style="width:100%"></th>
<th title="" data-addtool="true"><a href="'.U('public/flow','id='.$id.'&type=del').'" onclick="delay_time_run(\'jxc_xhd_add_num_all(\\\'jxcoutbound_add\\\')\', \'500\')" class="btn row-del"><i class="fa red fa-remove"></i></a></th>
</tr>
';
		$this->assign('list',$list);
	}
	
	public function _after_add($id){
	
	}
	
	public function _befor_insert($data){
		//根据销货订单生成
		$str_mp_id = I('post.mp_id');
		if (!empty($str_mp_id)){//采购订单ID
			$data1['uid']=getuserid();
			$data1['uname']=getusername();
			$data1['addtime']=date("Y-m-d H:i:s",time());
			$data1['attid']=$data['attid'];
			
			$mpl_id = I('post.mpl_id');
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
			
			//$strlen = 0;
			//for ($i=0;$i<count(I('post.jxcsalesorder_make_group'));$i++) {
			//	if(strlen($mi_id[$i])>0){$strlen++;}
			//}
			//if($strlen==0){$this->mtReturn(300,L('_OPERATION_FAIL_').'至少添加一条销货记录！','',false);return;}
			
			
			//判断 是否有记录 或 仓库是否存在
			$strlen = 0;//数组真实长度
			$strlen_mw = 0;//仓库和库存是否有错 当strlen_mw长度=数组长度时无错误
			$strerr1 = '';//库存不足
			$strerr2 = '';//仓库不存在
			
			//判断 商品和仓库不能重复
			$strlen_mw_id = 0;//商品和仓库是否重复
			$strlen_mw_id = count(get_repeat_array2($mi_id,$mw_id,1));
			if($strlen_mw_id>0){$this->mtReturn(300,L('_OPERATION_FAIL_').'商品和仓库不能重复！','',false);return;}
			//判断 商品和仓库不能重复

			for ($i=0;$i<count(I('post.jxcsalesorder_make_group'));$i++) {
				if(strlen($mi_id[$i])>0){$strlen++;}
				$err=0;
				$data1['mi_id']=$mi_id[$i];
				$data1['mw_id']=$mw_id[$i];
				$data1['mpl_sl']=$mpl_sl[$i];
				$m_jxcwarehouselist = M('jxcwarehouselist');
				$m_info = $m_jxcwarehouselist->field('id,mwl_num')->where('mi_id='.$data1['mi_id'].' and mw_id='.$data1['mw_id'].'')->find();
				if (!empty($m_info)){
					if($m_info['mwl_num']<$data1['mpl_sl']){
						$strerr1.='['.get_table_field($data1['mw_id'],'id','name','jxcwarehouse').']';
						$err++;
					}
					if($err==0){$strlen_mw++;}
				}else{
					$strerr2.='['.get_table_field($data1['mw_id'],'id','name','jxcwarehouse').']';
				}
			}
			if(strlen($strerr1)>0){$strerr1=$strerr1.'库存不足;';}
			if(strlen($strerr2)>0){$strerr2=$strerr2.'不存在;';}
			if($strlen==0){$this->mtReturn(300,L('_OPERATION_FAIL_').'至少添加一条销货记录！','',false);return;}
			if($strlen_mw!=count(I('post.jxcsalesorder_make_group'))){$this->mtReturn(300,'仓库：'.$strerr1.$strerr2.'','',false);return;}
			//判断 是否有记录 或 仓库是否存在

			
			$del=M("jxcoutboundlist")->where("attid='".$data['attid']."'")->delete();
			
			$mp_num=I('post.mp_num');//采购订单总数量
			$mp_num_sj=0;//实际采购订单数量
			for ($i=0;$i<count(I('post.jxcsalesorder_make_group'));$i++) {
				if($mpl_id[$i]>0){//实际采购订单总数量
					$mp_num_sj++;
					//更新审核状态，标识为出库状态
					$m_u = M("jxcsalesorderlist");
					$m_u -> where('id='.$mpl_id[$i].'')->setField('mp_shr',getuserid());
				}
				$data1['mpl_id']=$mpl_id[$i];
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
				$model1 = M('jxcoutboundlist');
				$list = $model1 -> add($data1);
			}
	
			//$m = new \Think\Model();
			$m = M();
			$tablePrefix = C('DB_PREFIX');
			//$sql = "SELECT CONCAT('XSDD',DATE_FORMAT(".$data['mp_ddrq'].",'%Y%m%d'),'',LPAD(count(*)+1,3,0)) ms_ddbh FROM ".$tablePrefix."jxcpurchase WHERE 1 and year(mp_ddrq)=year(now())";
			$sql = "SELECT LPAD(count(*)+1,3,0) ms_ddbh FROM ".$tablePrefix."jxcoutbound WHERE mp_ddrq=DATE_FORMAT('".$data['mp_ddrq']."','%Y-%m-%d')";
			$rs = $m->query($sql);
			if($rs){
				$data['ms_ddbh']='XS'.date("Ymd",strtotime($data['mp_ddrq'])).''.$rs[0]['ms_ddbh'];
			}else{
				$data['ms_ddbh']='XS'.date("Ymd",strtotime($data['mp_ddrq'])).''.'001';
			}
			
			/*更新销货订单库存状态*/
			if($mp_num_sj==0){
				$data_1['mp_ddzt']=116;//未出库
			}else if($mp_num_sj==$mp_num){
				$data_1['mp_ddzt']=117;//全部出库
			}else if($mp_num_sj<$mp_num){
				$data_1['mp_ddzt']=118;//部分出库
			}
			$mp_id = I('post.mp_id');//采购订单ID
			$jxcsalesorder = M("jxcsalesorder");
			$jxcsalesorder->where('id='.$mp_id.'')->save($data_1);
			/*更新销货订单库存状态*/
	
			$ms_bcfk = I('post.ms_bcfk');//本次收款
			$ms_bcqk = I('post.ms_bcqk');//本次欠款
			if($ms_bcfk==0){
				$data['mp_ddzt']= 119;//未收款
			}else if($ms_bcqk<=0){
				$data['mp_ddzt']=120;//全部收款
			}else{
				$data['mp_ddzt']=121;//部分收款
			}
	
			$data['mp_zdr']=getuserid();
			$data['mp_cgr']=getuserid();
			$data['uid']=getuserid();
			$data['uname']=getusername();
			$data['addtime']=date("Y-m-d H:i:s",time());
			return $data;

		}else{
			//添加销货单	
			$data1['uid']=getuserid();
			$data1['uname']=getusername();
			$data1['addtime']=date("Y-m-d H:i:s",time());
			$data1['attid']=$data['attid'];
			
			$mpl_id = I('post.mpl_id');
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
			
			//$strlen = 0;
			//for ($i=0;$i<count(I('post.jxcoutbound_add_group'));$i++) {
			//	if(strlen($mi_id[$i])>0){$strlen++;}
			//}
			//if($strlen==0){$this->mtReturn(300,L('_OPERATION_FAIL_').'至少添加一条销货记录！','',false);return;}
			
			
			//判断 是否有记录 或 仓库是否存在
			$strlen = 0;//数组真实长度
			$strlen_mw = 0;//仓库和库存是否有错 当strlen_mw长度=数组长度时无错误
			$strerr1 = '';//库存不足
			$strerr2 = '';//仓库不存在
			
			//判断 商品和仓库不能重复
			$strlen_mw_id = 0;//商品和仓库是否重复
			$strlen_mw_id = count(get_repeat_array2($mi_id,$mw_id,1));
			if($strlen_mw_id>0){$this->mtReturn(300,L('_OPERATION_FAIL_').'商品和仓库不能重复！','',false);return;}
			//判断 商品和仓库不能重复

			for ($i=0;$i<count(I('post.jxcoutbound_add_group'));$i++) {
				if(strlen($mi_id[$i])>0){$strlen++;}
				$err=0;
				$data1['mi_id']=$mi_id[$i];
				$data1['mw_id']=$mw_id[$i];
				$data1['mpl_sl']=$mpl_sl[$i];
				$m_jxcwarehouselist = M('jxcwarehouselist');
				$m_info = $m_jxcwarehouselist->field('id,mwl_num')->where('mi_id='.$data1['mi_id'].' and mw_id='.$data1['mw_id'].'')->find();
				//dump($m_info);
				//exit();
				if (!empty($m_info)){
					if($m_info['mwl_num']<$data1['mpl_sl']){
						$strerr1.='['.get_table_field($data1['mw_id'],'id','name','jxcwarehouse').']';
						$err++;
					}
					if($err==0){$strlen_mw++;}
				}else{
					$strerr2.='['.get_table_field($data1['mw_id'],'id','name','jxcwarehouse').']';
				}
			}
			if(strlen($strerr1)>0){$strerr1=$strerr1.'库存不足;';}
			if(strlen($strerr2)>0){$strerr2=$strerr2.'不存在;';}
			if($strlen==0){$this->mtReturn(300,L('_OPERATION_FAIL_').'至少添加一条销货记录！','',false);return;}
			if($strlen_mw!=count(I('post.jxcoutbound_add_group'))){$this->mtReturn(300,'仓库：'.$strerr1.$strerr2.'','',false);return;}
			//判断 是否有记录 或 仓库是否存在

			
			$del=M("jxcoutboundlist")->where("attid='".$data['attid']."'")->delete();
			
			for ($i=0;$i<count(I('post.jxcoutbound_add_group'));$i++) {
				$data1['mpl_id']=$mpl_id[$i];
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
				$model1 = M('jxcoutboundlist');
				$list = $model1 -> add($data1);
			}
	
			//$m = new \Think\Model();
			$m = M();
			$tablePrefix = C('DB_PREFIX');
			$sql = "SELECT LPAD(count(*)+1,3,0) ms_ddbh FROM ".$tablePrefix."jxcoutbound WHERE mp_ddrq=DATE_FORMAT('".$data['mp_ddrq']."','%Y-%m-%d')";
			$rs = $m->query($sql);
			if($rs){
				$data['ms_ddbh']='XS'.date("Ymd",strtotime($data['mp_ddrq'])).''.$rs[0]['ms_ddbh'];
			}else{
				$data['ms_ddbh']='XS'.date("Ymd",strtotime($data['mp_ddrq'])).''.'001';
			}
			
			$ms_bcfk = I('post.ms_bcfk');//本次收款
			$ms_bcqk = I('post.ms_bcqk');//本次欠款
			if($ms_bcfk==0){
				$data['mp_ddzt']=119;//未收款
			}else if($ms_bcqk<=0){
				$data['mp_ddzt']=120;//全部收款
			}else{
				$data['mp_ddzt']=121;//部分收款
			}
	
			$data['mp_zdr']=getuserid();
			$data['mp_cgr']=getuserid();
			$data['uid']=getuserid();
			$data['uname']=getusername();
			$data['addtime']=date("Y-m-d H:i:s",time());
			return $data;
			
		}
		
	}
		
	public function _befor_edit(){
		$model1 = D('SystemTag');
		$ms_type_list = $model1 -> get_tag_list('id,name', 'YwType', 10, '销货');
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
		$list_str=M('jxcoutboundlist')->where("attid='".$vo['attid']."' and status=1")->order('id')->select();
		foreach($list_str as $v){
			$list.='<tr id="jxcoutbound_edit_'.$i.'">
<th title="No." width="38"><input type="text" readonly="readonly" name="jxcoutbound_edit_group['.$i.']" class="no textcenter" data-rule="required" value="'.$i.'" size="1"><input type="hidden" id="jxcoutbound_edit" name="jxcoutbound_edit" value="'.$i.'" size="1"></th>
<th title="商品"><button href="javascript:;" data-url="index.php?m=home&c=public&a=jxcinformation" data-toggle="lookupbtn" data-group="mi_id['.$i.']" style="width:7%" data-title="查找商品"><i class="fa fa-search"></i></button><input type="text" readonly="readonly" name="mi_id['.$i.'].mc" data-rule="required;" value="'.get_table_field($v['mi_id'],'id','mi_bh','jxcinformation').' '.get_table_field($v['mi_id'],'id','mi_mc','jxcinformation').'_规格:'.get_table_field($v['mi_id'],'id','mi_gg','jxcinformation').'_单位:'.get_table_field(get_table_field($v['mi_id'],'id','mi_dw','jxcinformation'),'id','name','system_tag').'" style="width:89%"><input type="hidden" name="mi_id['.$i.'].id" value="'.$v['mi_id'].'"></th>
<th title="仓库"><input type="text" readonly="readonly" name="mw_id['.$i.'].name" data-rule="required;length[~50]" value="'.get_table_field($v['mw_id'],'id','name','jxcwarehouse').'" style="width:100%" data-group="mw_id['.$i.']" data-toggle="lookup" data-url="index.php?m=home&c=public&a=jxcwarehouse"><input type="hidden" name="mw_id['.$i.'].id" value="'.$v['mw_id'].'"></th>
<th title="单价"><input type="text" name="mpl_jg['.$i.']" data-rule="required;number;length[~20]" onkeyup="jxc_xhd_add_get_num_(\'jxcoutbound_edit_group\',$(this).attr(\'data-group\'),\'jxcoutbound_edit\')" id="jxc_xhd_edit_mpl_jg['.$i.']" value="'.$v['mpl_jg'].'" style="width:100%" data-group="jxcoutbound_edit_group['.$i.']" onfocus="select()" class="textright"></th>
<th title="数量"><input type="text" name="mpl_sl['.$i.']" data-rule="required;number;length[~20]" onkeyup="jxc_xhd_add_get_num_(\'jxcoutbound_edit_group\',$(this).attr(\'data-group\'),\'jxcoutbound_edit\')" id="jxc_xhd_edit_mpl_sl['.$i.']" value="'.$v['mpl_sl'].'" style="width:100%" data-group="jxcoutbound_edit_group['.$i.']" onfocus="select()" class="textright"></th>
<th title="金额"><input type="text" name="mpl_je['.$i.']" data-rule="required;number;length[~20]" onkeyup="jxc_xhd_add_get_num_(\'jxcoutbound_edit_group\',$(this).attr(\'data-group\'),\'jxcoutbound_edit\')" id="jxc_xhd_edit_mpl_je['.$i.']" value="'.$v['mpl_je'].'" style="width:100%" data-group="jxcoutbound_edit_group['.$i.']" onfocus="select()" class="textright"></th>
<th title="备注"><input type="text" name="mpl_bz['.$i.']" data-rule="length[~50]" value="'.$v['mpl_bz'].'" style="width:100%"></th>
<th title="" data-addtool="true"><a href="'.U('public/flow','id='.$id.'&type=del').'" onclick="delay_time_run(\'jxc_xhd_edit_num_all(\\\'jxcoutbound_edit\\\')\', \'500\')" class="btn row-del"><i class="fa red fa-remove"></i></a></th>
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
		
		//$strlen = 0;
		//for ($i=0;$i<count(I('post.jxcoutbound_edit_group'));$i++) {
		//	if(strlen($mi_id[$i])>0){$strlen++;}
		//}
		//if($strlen==0){$this->mtReturn(300,L('_OPERATION_FAIL_').'至少添加一条销货记录！','',false);return;}
		
		
		//判断 是否有记录 或 仓库是否存在
		$strlen = 0;//数组真实长度
		$strlen_mw = 0;//仓库和库存是否有错 当strlen_mw长度=数组长度时无错误
		$strerr1 = '';//库存不足
		$strerr2 = '';//仓库不存在
		
		//判断 商品和仓库不能重复
		$strlen_mw_id = 0;//商品和仓库是否重复
		$strlen_mw_id = count(get_repeat_array2($mi_id,$mw_id,1));
		if($strlen_mw_id>0){$this->mtReturn(300,L('_OPERATION_FAIL_').'商品和仓库不能重复！','',false);return;}
		//判断 商品和仓库不能重复

		for ($i=0;$i<count(I('post.jxcoutbound_edit_group'));$i++) {
			if(strlen($mi_id[$i])>0){$strlen++;}
			$err=0;
			$data1['mi_id']=$mi_id[$i];
			$data1['mw_id']=$mw_id[$i];
			$data1['mpl_sl']=$mpl_sl[$i];
			$m_jxcwarehouselist = M('jxcwarehouselist');
			$m_info = $m_jxcwarehouselist->field('id,mwl_num')->where('mi_id='.$data1['mi_id'].' and mw_id='.$data1['mw_id'].'')->find();
			if (!empty($m_info)){
				if($m_info['mwl_num']<$data1['mpl_sl']){
					$strerr1.='['.get_table_field($data1['mw_id'],'id','name','jxcwarehouse').']';
					$err++;
				}
				if($err==0){$strlen_mw++;}
			}else{
				$strerr2.='['.get_table_field($data1['mw_id'],'id','name','jxcwarehouse').']';
			}
		}
		if(strlen($strerr1)>0){$strerr1=$strerr1.'库存不足;';}
		if(strlen($strerr2)>0){$strerr2=$strerr2.'不存在;';}
		if($strlen==0){$this->mtReturn(300,L('_OPERATION_FAIL_').'至少添加一条销货记录！','',false);return;}
		if($strlen_mw!=count(I('post.jxcoutbound_edit_group'))){$this->mtReturn(300,'仓库：'.$strerr1.$strerr2.'','',false);return;}
		//判断 是否有记录 或 仓库是否存在

		
		$del=M("jxcoutboundlist")->where("attid='".$data['attid']."'")->delete();

		for ($i=0;$i<count(I('post.jxcoutbound_edit_group'));$i++) {
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
			$model1 = M('jxcoutboundlist');
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
			$str.='客户:'.$info['ms_id'].' 改为 '.I('post.ms_id').';';
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
		$ms_type_list = $model1 -> get_tag_list('id,name', 'YwType', 10, '销货,销退');
		$this->assign("ms_type_list", $ms_type_list);
		$model0 = D('jxcsuppliers');
		$list_jxcsuppliers=$model0->where('status=1')->field('id,ms_mc,ms_bh,ms_type,status')->order('sort,id')->select();
		$this->assign('list_jxcsuppliers',$list_jxcsuppliers);	
		
		$model = D($this->dbname);
		$vo = $model->find(I('get.id'));
		$attid=$vo['attid'];
		$this->assign('Rs',$vo);
		
		$i=0;
		$list_str=M('jxcoutboundlist')->where("attid='".$attid."' and status=1")->order('id')->select();
		foreach($list_str as $v){
			$list.='<tr id="jxcoutbound_edit_'.$i.'">
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
	* 反审核
	*/
	public function confirm(){
		$model=D($this->dbname);
		$id=I('get.id');
		if($id){
			$data=$model->find($id);
			$data['id']=$id;
			if($data['status']==1 && $data['mp_shr']!=0){
				
				$ma_id=$data['ma_id'];//结算账户
				$ms_bcfk=$data['ms_bcfk'];//本次收款
				
				//更新总表审核状态
				$data['mp_shr']=0;
				$model->save($data);
				
					//更新采购订单为未出库状态
					$model_m=M('jxcsalesorder');
					$data_m=$model_m->find($data['mp_id']);
					$data_m['id']=$data['mp_id'];//ID
					$data_m['mp_ddzt']=116;//未出库
					$model_m->save($data_m);
					
					//更新账户明细表
					M('jxcaccountlist')->where("number='".$data['ms_ddbh']."'")->delete();
					//更新账户明细表
				
				//更新账户信息
				$model0=M('jxcaccount');
				$data0=$model0->find($ma_id);
				$data0['id']=$ma_id;
				$data0['balance']=doubleval($data0['balance'])-doubleval($ms_bcfk);
				$model0->save($data0);
				
				//明细
				$attid=$data['attid'];
				$data1_list=M('jxcoutboundlist')->where("attid='".$attid."' and status=1")->order('id')->select();
				foreach($data1_list as $data1){
					$mpl_id=$data1['mpl_id'];//采购订单ID
					
					//更新库存信息
					$mi_id=$data1['mi_id'];//商品ID
					$mw_id=$data1['mw_id'];//仓库ID
					$mpl_sl=$data1['mpl_sl'];//数量
					$model2=M('jxcwarehouselist');
					$data2=$model2->where('mi_id='.$mi_id.' and mw_id='.$mw_id)->find();
					$data2['mwl_num']=doubleval($data2['mwl_num'])+doubleval($mpl_sl);
					$model2->where('mi_id='.$mi_id.' and mw_id='.$mw_id)->save($data2);
					
					//更新分表审核状态
					$model3=M("jxcoutboundlist");
					$model3->where('id='.$data1['id'])->setField('mp_shr','0');
					
					$i++;
				}
			}
			
			$msg='已经成功退回到上一步！';
			$this->mtReturn(200,$msg,$_REQUEST['navTabId'],false);
		}else{
			$this->mtReturn(300,'操作有误！',$_REQUEST['navTabId'],false);
		}
	}

	/**
	* 审核销货单
	*/
	public function make($type=1){
		$model = D($this->dbname);
		if(IS_POST){
			$mi_id = I('post.mi_id');
			$mw_id = I('post.mw_id');
			$mpl_sl = I('post.mpl_sl');
			$mpl_id = I('post.mpl_id');//销货单明细单
			//dump($mpl_id);
			//exit();
			
			
			//判断 是否有记录 或 仓库是否存在
			$strlen = 0;//数组真实长度
			$strlen_mw = 0;//仓库和库存是否有错 当strlen_mw长度=数组长度时无错误
			$strerr1 = '';//库存不足
			$strerr2 = '';//仓库不存在
			
			//判断 商品和仓库不能重复
			$strlen_mw_id = 0;//商品和仓库是否重复
			$strlen_mw_id = count(get_repeat_array2($mi_id,$mw_id,1));
			if($strlen_mw_id>0){$this->mtReturn(300,L('_OPERATION_FAIL_').'商品和仓库不能重复！','',false);return;}
			//判断 商品和仓库不能重复

			for ($i=0;$i<count(I('post.jxcoutbound_make_group'));$i++) {
				if(strlen($mi_id[$i])>0){$strlen++;}
				$err=0;
				$data1['mi_id']=$mi_id[$i];
				$data1['mw_id']=$mw_id[$i];
				$data1['mpl_sl']=$mpl_sl[$i];
				$m_jxcwarehouselist = M('jxcwarehouselist');
				$m_info = $m_jxcwarehouselist->field('id,mwl_num')->where('mi_id='.$data1['mi_id'].' and mw_id='.$data1['mw_id'].'')->find();
				if (!empty($m_info)){
					if($m_info['mwl_num']<$data1['mpl_sl']){
						$strerr1.='['.get_table_field($data1['mw_id'],'id','name','jxcwarehouse').']';
						$err++;
					}
					if($err==0){$strlen_mw++;}
				}else{
					$strerr2.='['.get_table_field($data1['mw_id'],'id','name','jxcwarehouse').']';
				}
			}
			if(strlen($strerr1)>0){$strerr1=$strerr1.'库存不足;';}
			if(strlen($strerr2)>0){$strerr2=$strerr2.'不存在;';}
			if($strlen==0){$this->mtReturn(300,L('_OPERATION_FAIL_').'至少添加一条销货记录！','',false);return;}
			if($strlen_mw!=count(I('post.jxcoutbound_make_group'))){$this->mtReturn(300,'仓库：'.$strerr1.$strerr2.'','',false);return;}
			//判断 是否有记录 或 仓库是否存在

			
			$j=0;
			for ($i=0;$i<count(I('post.jxcoutbound_make_group'));$i++) {
				
				if($mpl_id[$i]>0){
					//更新审核状态，标识为审核状态
					$m_u = M("jxcoutboundlist");
					$m_u -> where('id='.$mpl_id[$i].'')->setField('mp_shr',getuserid());
				}
				
				$data1['mi_id']=$mi_id[$i];
				$data1['mw_id']=$mw_id[$i];
				$data1['mpl_sl']=$mpl_sl[$i];
				//$model1 = M('jxcoutboundlist');
				$m_jxcwarehouselist = M('jxcwarehouselist');
				$m_info = $m_jxcwarehouselist->field('id,mwl_num')->where('mi_id='.$data1['mi_id'].' and mw_id='.$data1['mw_id'].'')->find();
				//$result = $m_jxcwarehouselist->fetchSql(true)->field('id,mwl_num')->where('mi_id='.$data1['mi_id'].' and mw_id='.$data1['mw_id'].'')->find();
				if (isset($m_info)){
					$m_jxcwarehouselist = M('jxcwarehouselist');
					$m_data1['id']=$m_info['id'];
					$m_data1['uuid']=getuserid();
					$m_data1['uuname']=getusername();
					$m_data1['updatetime']=date("Y-m-d H:i:s",time());
					$m_data1['mwl_num']=$m_info['mwl_num']-$data1['mpl_sl'];
					if($m_jxcwarehouselist -> save($m_data1)){$j++;}
					//$result1 = $m_jxcwarehouselist->fetchSql(true)->save($m_data1);
					//dump($m_data1);
				}else{
					$m_jxcwarehouselist = M('jxcwarehouselist');
					$m_data2['uid']=getuserid();
					$m_data2['uname']=getusername();
					$m_data2['addtime']=date("Y-m-d H:i:s",time());
					$m_data2['mi_id']=$data1['mi_id'];
					$m_data2['mw_id']=$data1['mw_id'];
					$m_data2['mwl_num']=-$data1['mpl_sl'];
					if($m_jxcwarehouselist -> add($m_data2)){$j++;}
					//$result1 = $m_jxcwarehouselist->fetchSql(true)->add($m_data2);
					//dump($m_data2);
				}
			}
			//exit();
			//if(count(I('post.jxcoutbound_add_group')==$j){}
			
			//更新结算账户余额
			$ma_id=I('post.ma_id');//结算账户
			$ms_bcfk=I('post.ms_bcfk');//收款金额
			$model0 = D('jxcaccount');
			$info0 = $model0->find($ma_id);
			$data0['id']=$info0['id'];
			$data0['balance']=$info0['balance']+$ms_bcfk;
			$data0['uuid']=getuserid();
			$data0['uuname']=getusername();
			$data0['updatetime']=date("Y-m-d H:i:s",time());
			$model0->save($data0);
			//更新结算账户余额
			
			$id = I('post.id');
			$data=$model->find($id);
			$data['id']=$id;
			
				//更新采购订单为全部出库状态
				$model_m=M('jxcsalesorder');
				$data_m=$model_m->find($data['mp_id']);
				$data_m['id']=$data['mp_id'];//ID
				$data_m['mp_ddzt']=117;//全部出库
				$model_m->save($data_m);
				
				//更新账户明细表
				$a_model1 = D('jxcaccountlist');
				$a_data1['pid'] = $ma_id;
				$a_data1['addtime'] = I('post.mp_ddrq');//date("Y-m-d H:i:s",time());
				$a_data1['uid']=getuserid();
				$a_data1['uname']=getusername();
				$a_data1['number'] = $data['ms_ddbh'];//单据编号
				$a_data1['ywtype'] = I('post.mp_ywtype');//业务类型
				$a_data1['income'] = $ms_bcfk;//收入
				$a_data1['expenditure'] = 0;//支出
				$a_data1['balance'] = $info0['balance']+$ms_bcfk;//当前余额
				$a_data1['buid'] = I('post.ms_id');//往来单位ID
				$a_data1['buname'] = get_table_field(I('post.ms_id'),'id','mc_mc','jxccustomers');//往来单位
				$a_model1->add($a_data1);
				//更新账户明细表

			$ms_bcfk = I('post.ms_bcfk');//本次收款
			$ms_bcqk = I('post.ms_bcqk');//本次欠款
			if($ms_bcfk==0){
				$data['mp_ddzt']=119;//未收款
			}else if($ms_bcqk<=0){
				$data['mp_ddzt']=120;//全部收款
			}else{
				$data['mp_ddzt']=121;//部分收款
			}
			$data['ms_yhl']= I('post.ms_yhl');
			$data['ms_yhje']= I('post.ms_yhje');
			$data['ms_yhhje']= I('post.ms_yhhje');
			$data['ma_id']= I('post.ma_id');
			$data['ms_bcfk']= I('post.ms_bcfk');
			$data['ms_bcqk']= I('post.ms_bcqk');
			
			if($data['status']==1 && $data['mp_shr']==0){
				$data['mp_shr']=getuserid();
				$msg='通过审核';
			}else if($data['status']==1 && $data['mp_shr']!=0){
				$data['mp_shr']=0;
				$msg='撤销审核';
			}
			
			$data['uuid']=getuserid();
			$data['uuname']=getusername();
			$data['updatetime']=date("Y-m-d H:i:s",time());
			
			if($model->save($data)){
				$this->mtReturn(200,$msg,strtolower($_REQUEST['navTabId']).'/audit',true,1);
			}else{
				$this->mtReturn(300,'操作有误！',strtolower($_REQUEST['navTabId']).'/audit',false,1);
			}
		} else {
			$model1 = D('SystemTag');
			if($type==1){
				$ms_type_list = $model1 -> get_tag_list('id,name', 'YwType', 10, '销货');
			}else if($type==2){
				$ms_type_list = $model1 -> get_tag_list('id,name', 'YwType', 10, '销退');
			}else{
				$this->mtReturn(300,'操作有误！',$_REQUEST['navTabId'],false);
			}
			$this->assign("ms_type_list", $ms_type_list);
			
			$model = D($this->dbname);
			$vo = $model->find(I('get.id'));
			$attid=$vo['attid'];
			$this->assign('Rs',$vo);
			
			$i=0;
			$list_str=M('jxcoutboundlist')->where("attid='".$attid."' and status=1")->order('id')->select();
			foreach($list_str as $v){
				$list.='<tr id="jxcoutbound_make_'.$i.'">
	<th title="No." width="38"><input type="text" readonly="readonly" name="jxcoutbound_make_group['.$i.']" class="no textcenter" data-rule="required" value="'.$i.'" size="1"><input type="hidden" id="jxcoutbound_make" name="jxcoutbound_make" value="'.$i.'" size="1"><input type="hidden" name="mpl_id['.$i.']" value="'.$v['id'].'" size="1"></th>
	<th title="商品"><input type="text" readonly="readonly" name="mi_id['.$i.'].mc" data-rule="required;" value="'.get_table_field($v['mi_id'],'id','mi_bh','jxcinformation').' '.get_table_field($v['mi_id'],'id','mi_mc','jxcinformation').'_规格:'.get_table_field($v['mi_id'],'id','mi_gg','jxcinformation').'_单位:'.get_table_field(get_table_field($v['mi_id'],'id','mi_dw','jxcinformation'),'id','name','system_tag').'" style="width:100%"><input type="hidden" name="mi_id['.$i.'].id" value="'.$v['mi_id'].'"></th>
	<th title="仓库"><input type="text" readonly="readonly" name="mw_id['.$i.'].name" data-rule="required;length[~50]" value="'.get_table_field($v['mw_id'],'id','name','jxcwarehouse').'" style="width:100%" data-group="mw_id['.$i.']" data-toggle="lookup" data-url="index.php?m=home&c=public&a=jxcwarehouse"><input type="hidden" name="mw_id['.$i.'].id" value="'.$v['mw_id'].'"></th>
	<th title="购货单价"><input type="text" readonly="readonly" name="mpl_jg['.$i.']" data-rule="required;number;length[~20]" onkeyup="jxc_xhd_make_get_num_(\'jxcoutbound_make_group\',$(this).attr(\'data-group\'),\'jxcoutbound_make\')" id="jxc_xhd_make_mpl_jg['.$i.']" value="'.$v['mpl_jg'].'" style="width:100%" data-group="jxcoutbound_make_group['.$i.']" onfocus="select()" class="textright"></th>
	<th title="数量"><input type="text" readonly="readonly" name="mpl_sl['.$i.']" data-rule="required;number;length[~20]" onkeyup="jxc_xhd_make_get_num_(\'jxcoutbound_make_group\',$(this).attr(\'data-group\'),\'jxcoutbound_make\')" id="jxc_xhd_make_mpl_sl['.$i.']" value="'.$v['mpl_sl'].'" style="width:100%" data-group="jxcoutbound_make_group['.$i.']" onfocus="select()" class="textright"></th>
	<th title="金额"><input type="text" readonly="readonly" name="mpl_je['.$i.']" data-rule="required;number;length[~20]" onkeyup="jxc_xhd_make_get_num_(\'jxcoutbound_make_group\',$(this).attr(\'data-group\'),\'jxcoutbound_make\')" id="jxc_xhd_make_mpl_je['.$i.']" value="'.$v['mpl_je'].'" style="width:100%" data-group="jxcoutbound_make_group['.$i.']" onfocus="select()" class="textright"></th>
	<th title="备注"><input type="text" readonly="readonly" name="mpl_bz['.$i.']" data-rule="length[~50]" value="'.$v['mpl_bz'].'" style="width:100%"></th>
	</tr>
	';
	/*<th title="" data-addtool="true"><a href="'.U('public/flow','id='.$id.'&type=del').'" onclick="del_html_inc(jxcoutbound_make_'.$i.')" class="btn row-del"><i class="fa red fa-remove"></i></a></th>*/
				$i++;
			}
			
			$this->assign('list',$list);
			
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
			$this->display();
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
				M('jxcoutboundlist')->where(array("attid"=>$attid))->save($st);
				
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
			M('jxcoutboundlist')->where('status=0')->delete();
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