<?php if (!defined('THINK_PATH')) exit();?><div class="bjui-pageHeader">
	<div class="bjui-searchBar">
		<h4 class="panel-title lineh22">发起流程&nbsp;<span class="font-normal font12">（点击流程项目发起流程）</span>
		<div class="btn-group floatright" role="group">
			<button type="button" class="btn-green" onclick="$(this).navtab('reloadForm', true);" data-icon="refresh"><?php echo L('_REFRESH_');?></button>
			<button type="button" class="btn-close" data-icon="close"><?php echo L('_CLOSE_');?></button>
        </div>
		</h4>
	</div>
</div>

<div class="bjui-pageContent tableContent">

     <table data-toggle="tablefixed" data-width="100%" data-layout-h="0" data-nowrap="false">
        <thead>
            <tr class="font14">
            <th width="10" height="32"></th>
			<th width="80">流程分组</th>
			<th>流程项目</th>
            </tr>
        </thead>
        <tbody>

<?php if(empty($tag_list)): ?><div class="m5 textcenter"><div class="alert-warning alert form-inline"><i class="fa fa-warning"></i> 没找到数据</div></div>
<?php else: ?>
<?php if(is_array($tag_list)): foreach($tag_list as $key=>$tag): $var = $key; ?>
	<tr data-id="<?php echo ($tag); ?>">
		<td></td>
        <td class="font14"><?php echo ($tag); ?></td>
		<td>

<?php if(empty($list)): else: ?>
<?php if(is_array($list)): foreach($list as $key=>$vo): if(($var) == $vo["tag"]): ?><a class="btn btn-green" href="<?php echo U('add','type='.$vo['id']);?>" data-toggle="navtab" data-id="navtab-flow-read"><?php echo ($vo["name"]); ?></a><?php endif; endforeach; endif; endif; ?>

		</td>
	</tr><?php endforeach; endif; endif; ?>

        </tbody>
    </table>

</div>