<?php if (!defined('THINK_PATH')) exit();?><div class="bjui-pageHeader">
<form id="pagerForm" data-toggle="ajaxsearch" action="/renhe/crm/index.php/home/jxccustomers" method="post">
	<input type="hidden" name="pageSize" value="<?php echo ($numPerPage); ?>">
	<input type="hidden" name="pageCurrent" value="<?php echo ((isset($_REQUEST['pageNum']) && ($_REQUEST['pageNum'] !== ""))?($_REQUEST['pageNum']):1); ?>">
	<div class="bjui-searchBar">
		<label>关键词：</label><input type="text" value="<?php echo ($_REQUEST['keys']); ?>" name="keys" class="form-control" size="15" />
		<div class="btn-group " role="group">
			<button type="submit" class="btn-success" data-icon="search">查询</button>
			<button type="button" class="btn-orange" data-icon="undo" onclick="$(this).navtab('reloadForm', true);">清空查询</button>
		</div>
		<div class="btn-group " role="group">
			<button type="button" class="btn btn-success" data-url="/renhe/crm/index.php/home/jxccustomers/add/navTabId/<?php echo CONTROLLER_NAME;?>" data-toggle="dialog" data-width="900" data-height="500" data-id="dialog-mask" data-mask="true" data-icon="plus"> 添加</button>
			<button type="button" class="btn btn-blue" data-url="/renhe/crm/index.php/home/jxccustomers/outxls" data-toggle="doexport" data-icon="arrow-down" data-confirm-msg="确定要导出吗？"> 导出</button>
			<!--<button type="button" class="btn btn-red" data-url="/renhe/crm/index.php/home/jxccustomers/del/navTabId/<?php echo CONTROLLER_NAME;?>" data-toggle="doajax" data-confirm-msg="确定要清理吗？" data-icon="remove"> 清理</button>-->
		</div>
		<div class="btn-group floatright" role="group">
			<button type="button" class="btn-green" onclick="$(this).navtab('reloadForm', true);" data-icon="refresh">刷新</button>
			<button type="button" class="btn-close" data-icon="close">关闭</button>
		</div>
	</div> 
</form>
</div>
<div class="bjui-pageContent tableContent">
     <table data-toggle="tablefixed" data-width="100%" data-layout-h="0" data-nowrap="true">
        <thead>
            <tr>
<th width="10" height="30"></th>
<th data-order-direction='desc' data-order-field='id'>ID</th>
<th data-order-direction='desc' data-order-field='mc_type'>客户类别</th>
<th data-order-direction='desc' data-order-field='mc_bh'>客户编号</th>
<th data-order-direction='desc' data-order-field='mc_mc'>客户名称</th>
<th>期初往来余额</th>
<th>首要联系人</th>
<th>手机</th>
<th>座机</th>
<th>QQ</th>
<th>送货地址</th>
<th class="textcenter" width="35" data-order-direction='desc' data-order-field='sort'>排序</th>
<th class="textcenter" width="55">详细</th>
<th class="textcenter" width="55" <?php echo display(CONTROLLER_NAME.'/edit'); ?> >编辑</th>
<th class="textcenter" width="55" <?php echo display(CONTROLLER_NAME.'/del'); ?> >状态</th>
            </tr>
        </thead>
        <tbody>

          <?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?><tr>
<td></td>
<td><?php echo ($v["id"]); ?></td>
<td><?php echo ($v["tag_name"]); ?></td>
<td><?php echo ($v["mc_bh"]); ?></td>
<td><?php echo ($v["mc_mc"]); ?></td>
<td><?php echo(doubleval($v['mc_receivefunds'])-doubleval($v['mc_earlypayment'])); ?></td>
<td><?php echo ($v["xingming"]); ?></td><td><?php echo ($v["phone"]); ?></td><td><?php echo ($v["dianhua"]); ?></td><td><?php echo ($v["qq"]); ?></td><td><?php echo ($v["address"]); ?></td>
<td class="textcenter"><?php echo ($v["sort"]); ?></td>
<td class="textcenter"><a href="/renhe/crm/index.php/home/jxccustomers/view/id/<?php echo ($v['id']); ?>/navTabId/<?php echo CONTROLLER_NAME;?>" data-toggle="dialog" data-width="900" data-height="500" data-id="dialog-mask" data-mask="true" class="btn btn-green btn-sm" >详细</a></td>
<td class="textcenter" <?php echo display(CONTROLLER_NAME.'/edit'); ?> > <a href="/renhe/crm/index.php/home/jxccustomers/edit/id/<?php echo ($v['id']); ?>/navTabId/<?php echo CONTROLLER_NAME;?>" class="btn btn-green btn-sm" data-toggle="dialog" data-width="900" data-height="500" data-id="dialog-mask" data-mask="true" >编辑</a></td>
<td class="textcenter" <?php echo display(CONTROLLER_NAME.'/del'); ?> ><a href="/renhe/crm/index.php/home/jxccustomers/del/id/<?php echo ($v['id']); ?>/navTabId/<?php echo CONTROLLER_NAME;?>" data-toggle="doajax" data-confirm-msg="确定要操作吗？"><?php if($v["status"] == 1 ): ?><span class="label label-success">启用</span><?php else: ?><span class="label label-default">禁用</span><?php endif; ?></a></td>
         </tr><?php endforeach; endif; else: echo "" ;endif; ?>
        </tbody>
    </table>
</div>
<div class="bjui-pageFooter">
<div class="pages"><span>共 <?php echo ($totalCount); ?> 条  每页 <?php echo ($numPerPage); ?> 条</span></div>
<div class="pagination-box" data-toggle="pagination" data-total="<?php echo ($totalCount); ?>" data-page-size="<?php echo ($numPerPage); ?>" data-page-current="<?php echo ($currentPage); ?>"></div>
</div>