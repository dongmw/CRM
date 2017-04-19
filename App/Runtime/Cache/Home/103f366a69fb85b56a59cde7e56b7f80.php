<?php if (!defined('THINK_PATH')) exit();?><div class="bjui-pageContent tableContent">
<form action="/renhe/crm/index.php/home/public/usersettings/navTabId/usersettings" class="pageForm" data-toggle="validate">
		<input type="hidden" name="id" value="<?php echo ($id); ?>">
          <table class="table table-condensed table-hover" width="100%">
           <tbody>
			<tr><td>
                <label for="j_title" class="control-label x85">每页显示：</label>
                <input type="text"  size="7" name="numperpage" data-min="10" data-max="10000" maxlength="5" value="<?php echo ($Rs['numperpage']); ?>" data-toggle="spinner" data-step="10" data-rule="required;integer;range[1~10000]"> 条记录
            </td></tr>
            <tr><td>
            <label for="j_title" class="control-label x85">导航栏：</label>
              <select name="navigation" data-toggle="selectpicker" data-rule="required">
			    <?php if($Rs['navigation'] == 1 ): ?><option value="1" selected>默认展开</option>
                <option value="0">默认隐藏</option>
                <?php else: ?>
                <option value="1">默认展开</option>
                <option value="0" selected>默认隐藏</option><?php endif; ?>
                 </select>
                 <?php if($Rs['navigation'] == 1 ): ?><span class=""><i class="glyphicon glyphicon-lock"></i></span><?php else: ?><span class="font16"><i class="fa fa-unlock-alt"></i></span><?php endif; ?>
             </td></tr>
            <tr><td>
            <label for="j_title" class="control-label x85">子菜单：</label>
              <select name="navigation1" data-toggle="selectpicker" data-rule="required">
			    <?php if($Rs['navigation1'] == 1 ): ?><option value="1" selected>默认展开</option>
                <option value="0">默认关闭</option>
                <?php else: ?>
                <option value="1">默认展开</option>
                <option value="0" selected>默认关闭</option><?php endif; ?>
                 </select>
                 <span class=""><?php if($Rs['navigation1'] == 1 ): ?><i class="glyphicon glyphicon-folder-open"></i><?php else: ?><i class="glyphicon glyphicon-folder-close"></i><?php endif; ?></span>
             </td></tr>
            </tbody>
            </table>

</div>
<div class="bjui-pageFooter">
<ul>
<li><button type="button" class="btn-close" data-icon="close">取消</button></li>
<li><button type="submit" class="btn-success" data-icon="save">保存</button></li>
<li><span class="alert alert-danger p3535" role="alert"><i class="fa fa-warning"></i> 提示：更改设置后，刷新页面生效</span></li>
</ul>
</form>
</div>