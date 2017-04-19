<?php if (!defined('THINK_PATH')) exit();?><div class="bjui-pageContent tableContent">
<form action="" class="pageForm" data-toggle="validate" id="form_jxcstorage_add" name="form_jxcstorage_add">
        <!--2016-06-06 【新增】上传附件参数【开始】-->
        <input type="hidden" name="mp_id" value="<?php echo ($Rs["id"]); ?>">
        <input type="hidden" name="attid" value="<?php echo ($attid); ?>">
        <input type="hidden" name="randid" value="<?php echo ($attid); ?>">
        <input type="hidden" name="mp_num" value="<?php echo ($mp_num); ?>"><!--采购订单总数量-->
        <input type="hidden" name="mp_ddbh" value="<?php echo ($Rs["mp_ddbh"]); ?>"><!--采购订单编号-->
        
        <input type="hidden" name="jxcstorage_add_MaxNum" id="jxcstorage_add_MaxNum" value="10" />
        <input type="hidden" name="jxcstorage_add_FileNum" id="jxcstorage_add_FileNum" value="0" />
        <!--2016-06-06 【新增】上传附件参数【结束】-->
    <div class="col-md-12 mt10">
<table class="table table-top" width="100%">
<thead>
<tr height="35"><th>
	<label for="jxc_ghd_add_mp_ywtype" class="control-label x85">业务类别：</label><select data-width="80" id="jxc_ghd_add_mp_ywtype" name="mp_ywtype" data-toggle="selectpicker" data-rule="required">
		<?php echo fill_option($ms_type_list);?>
	</select>
</th>
<th>
	<label for="jxc_ghd_add_ms_id" class="control-label x85">供应商：</label><select data-width="120" id="jxc_ghd_add_ms_id" name="ms_id" data-toggle="selectpicker" data-rule="required">
		<?php if(is_array($list_jxcsuppliers)): foreach($list_jxcsuppliers as $key=>$v): ?><option value="<?php echo ($v["id"]); ?>" <?php if($v["id"] == $Rs['ms_id'] ): ?>selected<?php else: endif; ?> ><?php echo ($v["ms_mc"]); ?> <?php if($v["status"] == 1 ): else: ?><font color=red>[未启用]</font><?php endif; ?>
		</option><?php endforeach; endif; ?>
	</select>
</th>
<th><label for='jxc_ghd_add_mp_ddrq' class='control-label x85'>单据日期：</label><input type='text' data-rule='required;date' data-toggle='datepicker' id='jxc_ghd_add_mp_ddrq' name='mp_ddrq' size='12' value='<?php echo date("Y-m-d",time()); ?>' data-min-date="{%y-10}-%M-%d" data-max-date="{%y+10}-%M-%d" ></th>
<th><label for='jxc_ghd_add_mp_jhrq' class='control-label x85'>交货日期：</label><input type='text' data-rule='required;date' data-toggle='datepicker' id='jxc_ghd_add_mp_jhrq' name='mp_jhrq' size='12' value='<?php echo date("Y-m-d",time()); ?>' data-min-date="{%y-10}-%M-%d" data-max-date="{%y+10}-%M-%d" ></th>
</tr>
</thead>
</table>
    </div>
    

<!--购货单开始-->

    <div class="col-md-12">
<table id="table_jxcstorage_add" class="table table-bordered table-hover table-striped table-top" data-toggle="tabledit" data-initnum="0" data-action="<?php echo U('public/contactselect','id='.$id.'&type=hold');?>" data-single-noindex="true">
<thead>
<tr data-idname="jxcstorage_add_group[#index#].id" id="jxcstorage_add_#index#">
<th title="No." width="38"><input type="text" readonly="readonly" name="jxcstorage_add_group[#index#]" class="no textcenter" data-rule="required" value="#index#" size="1"><input type="hidden" id="jxcstorage_add" name="jxcstorage_add" value="#index#" size="1"></th>
<th title="商品" style="min-width:180px;"><button href="javascript:;" data-url="index.php?m=home&c=public&a=jxcinformation" data-toggle="lookupbtn" data-group="mi_id[#index#]" style="width:9%" data-title="查找商品"><i class="fa fa-search"></i></button><input type="text" readonly="readonly" name="mi_id[#index#].mc" data-rule="required;" value="" style="width:89%"><input type="hidden" name="mi_id[#index#].id" value=""></th>
<th title="仓库" width="100"><input type="text" readonly="readonly" name="mw_id[#index#].name" data-rule="required;length[~50]" value="" style="width:100%" data-group="mw_id[#index#]" data-toggle="lookup" data-url="index.php?m=home&c=public&a=jxcwarehouse"><input type="hidden" name="mw_id[#index#].id" value=""></th>
<th title="购货单价" width="100"><input type="text" name="mpl_jg[#index#]" data-rule="required;number;length[~20]" onkeyup="jxc_ghd_add_get_num_('jxcstorage_add_group',$(this).attr('data-group'),'jxcstorage_add')" id="jxc_ghd_add_mpl_jg[#index#]" value="0" style="width:100%" data-group="jxcstorage_add_group[#index#]" onfocus="select()" class="textright"></th>
<th title="数量" width="80"><input type="text" name="mpl_sl[#index#]" data-rule="required;number;length[~20]" onkeyup="jxc_ghd_add_get_num_('jxcstorage_add_group',$(this).attr('data-group'),'jxcstorage_add')" id="jxc_ghd_add_mpl_sl[#index#]" value="0" style="width:100%" data-group="jxcstorage_add_group[#index#]" onfocus="select()" class="textright"></th>
<th title="金额" width="100"><input type="text" name="mpl_je[#index#]" data-rule="required;number;length[~20]" onkeyup="jxc_ghd_add_get_num_('jxcstorage_add_group',$(this).attr('data-group'),'jxcstorage_add')" id="jxc_ghd_add_mpl_je[#index#]" value="0" style="width:100%" data-group="jxcstorage_add_group[#index#]" onfocus="select()" class="textright"></th>
<th title="批次" width="70"><input type="text" name="mpl_pc[#index#]" data-rule="length[~50]" value="" style="width:100%"></th>
<th title="生产日期" width="120"><input type="text" name="mpl_scrq[#index#]" data-rule="required;date" data-toggle="datepicker" data-min-date="{%y-10}-%M-%d" data-max-date="{%y+10}-%M-%d" value="" style="width:100%"></th>
<th title="有效期至" width="120"><input type="text" name="mpl_yxqz[#index#]" data-rule="required;date" data-toggle="datepicker" data-min-date="{%y-10}-%M-%d" data-max-date="{%y+10}-%M-%d" value="" style="width:100%"></th>
<th title="备注" width="70"><input type="text" name="mpl_bz[#index#]" data-rule="length[~50]" value="" style="width:100%"></th>
<th title="" data-addtool="true" width="55"><a href="<?php echo U('public/flow','id='.$id.'&type=del');?>" onclick="delay_time_run('jxc_ghd_add_num_all(\'jxcstorage_add\')', '500')" class="btn row-del"><i class="fa red fa-remove"></i></a></th>
</tr>
</thead>
<tbody><?php echo ($list); ?>
</tbody>
<thead>
<tr style="height:27px">
<th></th>
<th>合计：</th>
<th></th>
<th></th>
<th><input class="textright" type="text" name="mp_ghsl" id="jxc_ghd_add_mp_ghsl" data-rule="required;number;length[~20]" value="0.0000" style="width:100%" readonly="readonly" /></th>
<th><input class="textright" type="text" name="mp_ghje" id="jxc_ghd_add_mp_ghje" data-rule="required;number;length[~20]" value="0.0000" style="width:100%" readonly="readonly" /></th>
<th></th>
<th></th>
<th></th>
<th></th>
<th></th>
</tr>
</thead>
</table>
    </div>

<!--购货单结束-->
<!--订单编号：ms_ddbh 购货金额：ms_ghje 表单提交时候赋值-->

    <div class="col-md-12 m00100">
<table class="table table-top" width="100%">
<thead><tr><th colspan=3><div style='display: inline-block; vertical-align: middle; width:100%;'><textarea class="form-control" placeholder="暂无备注信息" style="width:100%;height:50px;border:0px;line-height:150%" name="beizhu"><?php echo ($Rs["beizhu"]); ?></textarea></div></th></tr></thead>
<tbody>
<tr>
<td><label for='jxc_ghd_add_ms_yhl' class='control-label x85'>优惠率：</label><input type="text" id="jxc_ghd_add_ms_yhl" name="ms_yhl" data-rule="required;number;length[~20]" value="0" onfocus="select()" onkeyup="jxc_ghd_add_get_num_fk_('jxc_ghd_add_mp_ghje','jxc_ghd_add_ms_yhl','jxc_ghd_add_ms_bcqk','jxc_ghd_add_ms_yhje','jxc_ghd_add_ms_yhhje','jxc_ghd_add_ms_bcfk')" class="textright" size="10">%</td>
<td><label for='jxc_ghd_add_ms_yhje' class='control-label x85'>优惠金额：</label><input readonly="readonly" type="text" id="jxc_ghd_add_ms_yhje" name="ms_yhje" data-rule="required;number;length[~20]" value="0" onfocus="select()" class="textright" size="10"></td>
<td><label for='jxc_ghd_add_ms_yhhje' class='control-label x85'>优惠后金额：</label><input readonly="readonly" type="text" id="jxc_ghd_add_ms_yhhje" name="ms_yhhje" data-rule="required;number;length[~20]" value="0" onfocus="select()" class="textright" size="10"></td>
</tr>
<tr>
<td><label for='jxc_ghd_add_ma_id' class='control-label x85'>结算账户：</label><select id="jxc_ghd_add_ma_id" name="ma_id" data-toggle="selectpicker" data-rule="required">
		<?php if(is_array($list_jxcaccount)): foreach($list_jxcaccount as $key=>$v): ?><option value="<?php echo ($v["id"]); ?>"><?php echo ($v["number"]); ?> <?php echo ($v["name"]); ?></if>
		</option><?php endforeach; endif; ?>
	</select></td>
<td><label for='jxc_ghd_add_ms_bcfk' class='control-label x85'>本次付款：</label><input type="text" id="jxc_ghd_add_ms_bcfk" name="ms_bcfk" data-rule="required;number;length[~20]" value="0" onfocus="select()" onkeyup="jxc_ghd_add_get_num_fk_('jxc_ghd_add_mp_ghje','jxc_ghd_add_ms_yhl','jxc_ghd_add_ms_bcqk','jxc_ghd_add_ms_yhje','jxc_ghd_add_ms_yhhje','jxc_ghd_add_ms_bcfk')" class="textright" size="10"></td>
<td><label for='jxc_ghd_add_ms_bcqk' class='control-label x85'>本次欠款：</label><input readonly="readonly" type="text" id="jxc_ghd_add_ms_bcqk" name="ms_bcqk" data-rule="required;number;length[~20]" value="0" onfocus="select()" class="textright" size="10"></td>
</tr>
<tr><td colspan=3>制单人：<?php echo gettruename();?></td></tr>
</tbody>
</table>
    </div>
   
<!--附件开始-->

    <div class="col-md-12">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                <div class="panel-heading"><h3 class="panel-title"><i class="fa fa-paperclip"></i> 附件 <span class="font-normal font12">（允许：最大文件30MB，最多数量10个）</span> </h3></div>
                    <div class="panel-body">

    <?php echo W('FileUpload/edit',array('id'=>'jxcpurchase_edit','attid'=>$Rs['attid'],'module'=>'Jxcpurchase'));?>

                    </div>
                </div>
            </div>
        </div>
    </div>

<!--附件结束-->

          
</div>
<div class="bjui-pageFooter">
<ul>
<li><button type="button" class="btn-close" data-icon="close">取消</button></li>
<li><button type="button" class="btn-success" data-icon="save" onclick="save_jxcstorage_add();">提交</button></li>
</ul>
</form>
</div>



<script type="text/javascript">

/*购货单合计*/
function jxc_ghd_add_get_num_(id,group,num) {
	var i = group.replace(id+'[','').replace(']','');/*当前行数*/
	var n = document.getElementsByName(num).length;/*数组长度*/
	var id_mpl_jg = document.getElementById("jxc_ghd_add_mpl_jg[" + i +"]").value;
	var id_mpl_sl = document.getElementById("jxc_ghd_add_mpl_sl[" + i +"]").value;
	document.getElementById("jxc_ghd_add_mpl_je[" + i +"]").value = (parseFloat(id_mpl_jg) * parseFloat(id_mpl_sl)).toFixed(4);
	var mp_ghje = 0;
	var mp_ghsl = 0;
	for (var j=0;j<n;j++){
		var str_mp_ghje = "jxc_ghd_add_mpl_je[" + j +"]";
		var str_mp_ghsl = "jxc_ghd_add_mpl_sl[" + j +"]";
		mp_ghje = mp_ghje + parseFloat(document.getElementById(str_mp_ghje).value);
		mp_ghsl = mp_ghsl + parseFloat(document.getElementById(str_mp_ghsl).value);
	}
	document.getElementById("jxc_ghd_add_mp_ghje").value = mp_ghje.toFixed(4);
	document.getElementById("jxc_ghd_add_mp_ghsl").value = mp_ghsl.toFixed(4);
	document.getElementById("jxc_ghd_add_ms_yhhje").value = mp_ghje.toFixed(4);
	document.getElementById("jxc_ghd_add_ms_bcqk").value = mp_ghje.toFixed(4);
}
/*购货单付款*/
function jxc_ghd_add_get_num_fk_(mp_ghje,j_form_ms_yhl,j_form_mp_ghje,j_form_ms_yhje,j_form_ms_yhhje,j_form_ms_bcfk) {
	var j_ms_yhl = parseFloat(document.getElementById(j_form_ms_yhl).value)/100;
	var j_mp_ghje = parseFloat(document.getElementById(mp_ghje).value);
	var j_ms_bcfk = parseFloat(document.getElementById(j_form_ms_bcfk).value);
	if(isNaN(j_ms_yhl)){
		j_ms_yhl=0;
	}
	if(isNaN(j_ms_bcfk)){
		j_ms_bcfk=0;
	}
	document.getElementById(j_form_ms_yhje).value = j_ms_yhl.toFixed(4)*j_mp_ghje.toFixed(4);
	document.getElementById(j_form_ms_yhhje).value = j_mp_ghje.toFixed(4)-(j_ms_yhl.toFixed(4)*j_mp_ghje.toFixed(4));
	document.getElementById(j_form_mp_ghje).value = j_mp_ghje.toFixed(4)-(j_ms_yhl.toFixed(4)*j_mp_ghje.toFixed(4))-j_ms_bcfk.toFixed(4);
}

function jxc_ghd_add_num_all(num) {
	var n = document.getElementsByName(num).length;/*数组长度*/
	//alert(n);
	var mp_ghje = 0;
	var mp_ghsl = 0;
	for (var j=0;j<n;j++){
		var str_mp_ghje = "jxc_ghd_add_mpl_je[" + j +"]";
		var str_mp_ghsl = "jxc_ghd_add_mpl_sl[" + j +"]";
		mp_ghje = mp_ghje + parseFloat(document.getElementById(str_mp_ghje).value);
		mp_ghsl = mp_ghsl + parseFloat(document.getElementById(str_mp_ghsl).value);
	}
	document.getElementById("jxc_ghd_add_mp_ghje").value = mp_ghje.toFixed(4);
	document.getElementById("jxc_ghd_add_mp_ghsl").value = mp_ghsl.toFixed(4);
	document.getElementById("jxc_ghd_add_ms_yhhje").value = mp_ghje.toFixed(4);
	document.getElementById("jxc_ghd_add_ms_bcqk").value = mp_ghje.toFixed(4);
}

	function save_jxcstorage_add(){
		window.onbeforeunload=null;
		var ijxcstorage_add_FileNum = parseInt($("#jxcstorage_add_FileNum").val(), 10);
		var ijxcstorage_add_MaxNum = parseInt($("#jxcstorage_add_MaxNum").val(), 10);
		if (ijxcstorage_add_FileNum > ijxcstorage_add_MaxNum) {
			alert('上传文件数量最多'+ijxcstorage_add_MaxNum+'个');
			return false;
		}
		sendForm("form_jxcstorage_add", "/renhe/crm/index.php/home/jxcstorage/add/navTabId/<?php echo CONTROLLER_NAME;?>");
	}
	
	/*上传成功*/
	function jxcstorage_add_upload_success(file, data) {
		var json = $.parseJSON(data)
		$(this).bjuiajax('ajaxDone', json)
		if (json[BJUI.keys.statusCode] == BJUI.statusCode.ok) {
			$('#j_jxcstorage_add_file').val(json.filename).trigger('validate');
			var sLi = '<li id=\"j_jxcstorage_add_file_span-' + json.id.toString() + '\" class="tbody">';
			sLi += '<div style="width: 100%;" class="loading"></div>';
			sLi += '<div class="data">';
			sLi += '<span class="del text-center"><a href="javascript:DeleteFile_id_name_reduce(\'j_jxcstorage_add_file_span-' + json.id.toString() + '\',\'' + json.id + '\',\'<?php echo(getuserid()); ?>\',\'jxcstorage_add_FileNum\')" style="display: inline;" class="link del"><i class="fa fa-remove"></i></a></span>';
			sLi += '<span class="size text-right">' + GetFileSize(json.size) + '</span>';
			sLi += '<span class="auto autocut">' + json.filename + '</span></div></li>';
			$('#j_jxcstorage_add_file_span').html($('#j_jxcstorage_add_file_span').html()+sLi);
			/*上传数量加1*/
			var ijxcstorage_add_FileNum = parseInt($("#jxcstorage_add_FileNum").val(), 10);
			$("#jxcstorage_add_FileNum").val(ijxcstorage_add_FileNum + 1);
		}
	}

</script>