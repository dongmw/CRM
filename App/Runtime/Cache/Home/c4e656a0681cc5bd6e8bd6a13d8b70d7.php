<?php if (!defined('THINK_PATH')) exit();?><script language=JavaScript>
function CheckAll_Dep_copy(form)
{
	for (var i=0;i<form.elements.length;i++)
	{
		var e = form.elements[i];
		if (e.name != 'chkall' )
		e.checked = form.chkall.checked;
	}
}
</script>
<div class="bjui-pageContent tableContent">
    <form action="/renhe/crm/index.php/home/dep/copy/navTabId/<?php echo CONTROLLER_NAME;?>" class="pageForm" data-toggle="validate">
		<input type="hidden" name="id" value="<?php echo ($id); ?>"><input type="hidden" name="type" value="<?php echo ($type); ?>">
          <table class="table table-bordered table-hover table-striped table-top" width="100%">
           <tbody>
            <tr>
            <td height="30" colspan="2">
			<span class="control-label x85">复制【<a><?php echo (get_table_field($id,'id','title','auth_group')); ?></a>】权限 到</span>
             <select name="pid" data-toggle="selectpicker" data-rule="required">
               <option value="">请选择职位</option>
	          <?php if(is_array($list_rule)): foreach($list_rule as $key=>$v): ?><option <?php if($v["id"] == $Rs['pid'] ): ?>selected value="<?php echo ($Rs['pid']); ?>" <?php else: ?>value="<?php echo ($v["id"]); ?>"<?php endif; ?> >
	          <?php switch($v["level"]): case "0": break; case "1": ?>—<?php break; case "2": ?>——<?php break; case "3": ?>———<?php break; case "4": ?>————<?php break; case "5": ?>—————<?php break; case "6": ?>——————<?php break; case "7": ?>———————<?php break; default: endswitch; echo ($v["title"]); ?> <?php if($v["status"] == 1 ): else: ?><font color=red>[未启用]</font><?php endif; endforeach; endif; ?>
             </select>
            </td>
            </tr>
             <tr>
            <td height="30"><input onclick='CheckAll_Dep_EditRule(this.form)' type='checkbox' value='on' name='chkall' /> 全选</td>
			<td>菜单</td>
             </tr>
            
            
		<?php if(is_array($list)): foreach($list as $key=>$v): ?><tr>
        <td height=25 width=75>
		<input type="checkbox" name="rules[]" <?php if(in_array($v[id],$rs)): ?>checked="checked"<?php endif; ?> value="<?php echo ($v["id"]); ?>">  <?php echo ($v["title"]); ?>
	    </td>
		<td>
		<table width="100%">
		<?php $list1 = M('auth_rule')->where('level=1 and pid='.$v['id'])->order('sort')->select(); ?>
		<?php if(is_array($list1)): foreach($list1 as $key=>$v): ?><tr><td height=30 width=100>
        <input type="checkbox" name="rules[]" <?php if(in_array($v[id],$rs)): ?>checked="checked"<?php endif; ?> value="<?php echo ($v["id"]); ?>">  <?php echo ($v["title"]); ?>
	    </td>
		<td>
		
		<?php $list2 = M('auth_rule')->where('level=2 and pid='.$v['id'])->order('sort')->select(); ?>
		<?php if(is_array($list2)): foreach($list2 as $key=>$v): ?><span style="width:150px;">
	    <input type="checkbox" name="rules[]" <?php if(in_array($v[id],$rs)): ?>checked="checked"<?php endif; ?> value="<?php echo ($v["id"]); ?>">  <?php echo ($v["title"]); endforeach; endif; ?> 
	
		</td>
		</tr><?php endforeach; endif; ?> 
		</table>
		</td>
        </tr><?php endforeach; endif; ?>

            
            </tbody>
            </table>
</div>
<div class="bjui-pageFooter">
<ul>
<li><button type="button" class="btn-close" data-icon="close">取消</button></li>
<li><button type="submit" class="btn-success" data-icon="save">确定</button></li>
</ul>
</form>
</div>