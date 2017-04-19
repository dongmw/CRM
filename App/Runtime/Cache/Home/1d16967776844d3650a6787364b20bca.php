<?php if (!defined('THINK_PATH')) exit();?><div class="bjui-pageHeader">
<form id="pagerForm" data-toggle="ajaxsearch" action="/renhe/crm/index.php/home/jxcpurchase" method="post">
	<input type="hidden" name="pageSize" value="<?php echo ($numPerPage); ?>">
	<input type="hidden" name="pageCurrent" value="<?php echo ((isset($_REQUEST['pageNum']) && ($_REQUEST['pageNum'] !== ""))?($_REQUEST['pageNum']):1); ?>">
	<div class="bjui-searchBar">
		<label>关键词：</label><input type="text" value="<?php echo ($_REQUEST['keys']); ?>" name="keys" class="form-control" size="15" />
		<div class="btn-group " role="group">
			<button type="submit" class="btn-success" data-icon="search">查询</button>
			<button type="button" class="btn-orange" data-icon="undo" onclick="$(this).navtab('reloadForm', true);">清空查询</button>
		</div>
		<div class="btn-group " role="group">
			<!--<button type="button" class="btn btn-success" data-url="/renhe/crm/index.php/home/jxcpurchase/add/navTabId/<?php echo CONTROLLER_NAME;?>" data-toggle="dialog" data-width="950" data-height="500" data-id="dialog-mask" data-mask="true" data-icon="plus"> 添加</button>-->
			<button type="button" class="btn btn-blue" data-url="/renhe/crm/index.php/home/jxcpurchase/outxls" data-toggle="doexport" data-icon="arrow-down" data-confirm-msg="确定要导出吗？"> 导出</button>
			<!--<button type="button" class="btn btn-red" data-url="/renhe/crm/index.php/home/jxcpurchase/del/navTabId/<?php echo CONTROLLER_NAME;?>" data-toggle="doajax" data-confirm-msg="确定要清理吗？" data-icon="remove"> 清理</button>-->
		</div>
		<div class="btn-group " role="group">
			<!--<button type="button" class="btn btn-success" data-url="/renhe/crm/index.php/home/jxcpurchase/confirm/id/{#bjui-selected}/navTabId/<?php echo CONTROLLER_NAME;?>" data-toggle="doajax"  data-confirm-msg="确定要审核吗？" data-icon=""> 审核</button>-->
			<!--<button type="button" class="btn btn-danger" data-url="/renhe/crm/index.php/home/jxcpurchase/confirm/id/{#bjui-selected}/navTabId/<?php echo CONTROLLER_NAME;?>" data-toggle="doajax"  data-confirm-msg="确定要反审吗？" data-icon=""> 反审</button>-->
		</div>
		<div class="btn-group floatright" role="group">
			<button type="button" class="btn-green" onclick="$(this).navtab('reloadForm', true);" data-icon="refresh">刷新</button>
			<button type="button" class="btn-close" data-icon="close">关闭</button>
		</div>
	</div> 
</form>
</div>
<div class="bjui-pageContent tableContent">
     <table data-toggle="tablefixed" data-width="100%" data-layout-h="0" data-nowrap="false">
        <thead>
            <tr>
<th width="10" height="30"></th>
<th data-order-field='id' title='ID'>ID</th>
<th data-order-field='mp_ddrq' title='订单日期'>订单日期</th>
<th data-order-field='mp_ddbh' title='订单编号'>订单编号</th>
<th data-order-field='mp_ywtype' title='业务类别'>业务类别</th>
<th data-order-field='ms_id' title='供应商'>供应商</th>
<th data-order-field='mp_ghje' title='购货金额'>购货金额</th>
<th data-order-field='mp_ghsl' title='数量'>数量</th>
<th data-order-field='mp_ddzt' title='订单状态' class="textcenter">订单状态</th>
<th data-order-field='mp_jhrq' title='交货日期'>交货日期</th>
<th data-order-field='mp_zdr' title='制单人'>制单人</th>
<!--<th data-order-field='mp_cgr' title='采购人'>采购人</th>-->
<th data-order-field='mp_shr' title='审核人'>审核人</th>
<th title='备注'>备注</th>
<th class="textcenter" width="50" title='详细'>详细</th>
<th class="textcenter" width="50" <?php echo display(CONTROLLER_NAME.'/edit'); ?> title='编辑'>编辑</th>
<th class="textcenter" width="50" <?php echo display(CONTROLLER_NAME.'/del'); ?> title='状态'>状态</th>
<th class="textcenter" width="50" <?php echo display(CONTROLLER_NAME.'/edit'); ?> title='退回到上一步'>反审</th>
<th class="textcenter" width="50" <?php echo display(CONTROLLER_NAME.'/make'); ?> title='生成'>生成</th>
            </tr>
        </thead>
        <tbody>

          <?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?><tr data-id="<?php echo ($v["id"]); ?>">
<td></td>
<td><?php echo ($v["id"]); ?></td>
<td><?php echo ($v["mp_ddrq"]); ?></td>
<td><?php echo ($v["mp_ddbh"]); ?></td>
<td><?php echo (get_table_field($v["mp_ywtype"],'id','name','system_tag')); ?></td>
<td><?php echo (get_table_field($v["ms_id"],'id','ms_mc','jxcsuppliers')); ?></td>
<td class="textright"><?php echo (doubleval($v["mp_ghje"])); ?></td>
<td class="textright"><?php echo (doubleval($v["mp_ghsl"])); ?></td>
<td class="textcenter"><?php echo (get_table_field($v["mp_ddzt"],'id','name','system_tag')); ?></td>
<td><?php echo ($v["mp_jhrq"]); ?></td>
<td><?php echo (get_table_field($v["mp_zdr"],'id','truename','user')); ?></td>
<!--<td><?php echo (get_table_field($v["mp_cgr"],'id','truename','user')); ?></td>-->
<td><?php echo (get_table_field($v["mp_shr"],'id','truename','user')); ?></td>
<td><?php echo (html_out($v["beizhu"])); ?></td>
<td class="textcenter"><a href="/renhe/crm/index.php/home/jxcpurchase/view/id/<?php echo ($v['id']); ?>/navTabId/<?php echo CONTROLLER_NAME;?>" class="btn btn-green btn-sm" data-toggle="dialog" data-width="900" data-height="500" data-id="dialog-mask" data-mask="true" >详细</a></td>
<td class="textcenter" <?php echo display(CONTROLLER_NAME.'/edit'); ?> ><?php if(($v["mp_shr"]) == "0"): ?><a href="/renhe/crm/index.php/home/jxcpurchase/edit/id/<?php echo ($v['id']); ?>/navTabId/<?php echo CONTROLLER_NAME;?>" class="btn btn-green btn-sm" data-toggle="navtab" data-id="jxcpurchase/add" data-title="编辑购货订单" title="编辑购货订单">编辑</a><?php else: endif; ?></td>
<td class="textcenter" <?php echo display(CONTROLLER_NAME.'/del'); ?> ><?php if($v["status"] == 1 ): ?><span class="label label-success">有效</span><?php else: ?><span class="label label-default">无效</span><?php endif; ?></td>
<td class="textcenter" <?php echo display(CONTROLLER_NAME.'/edit'); ?> ><?php if($v["status"] == 1 ): if(($v["mp_shr"]) != "0"): ?><a href="javascript:;" data-url="/renhe/crm/index.php/home/jxcpurchase/confirm/id/<?php echo ($v['id']); ?>/navTabId/<?php echo CONTROLLER_NAME;?>" data-toggle="doajax"><span class="label label-success" title="退回到上一步">反审</span></a><?php else: endif; endif; ?></td>
<td class="textcenter" <?php echo display(CONTROLLER_NAME.'/make'); ?> >
<?php if(($v["mp_shr"]) != "0"): if(($v["mp_ddzt"]) != "108"): ?><a href="/renhe/crm/index.php/home/jxcpurchase/make/type/1/id/<?php echo ($v['id']); ?>/navTabId/<?php echo CONTROLLER_NAME;?>" data-toggle="navtab" data-id="jxcpurchase/add" data-title="生成购货单"><?php if($v["status"] == 1 ): ?><span class="label label-success" title="生成购货单">生成</span><?php endif; ?></a><?php endif; endif; ?></td>
         </tr><?php endforeach; endif; else: echo "" ;endif; ?>
        </tbody>
    </table>
</div>
<div class="bjui-pageFooter">
<div class="pages"><span>共 <?php echo ($totalCount); ?> 条  每页 <?php echo ($numPerPage); ?> 条</span></div>
<div class="pagination-box" data-toggle="pagination" data-total="<?php echo ($totalCount); ?>" data-page-size="<?php echo ($numPerPage); ?>" data-page-current="<?php echo ($currentPage); ?>"></div>
</div>