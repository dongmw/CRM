<?php if (!defined('THINK_PATH')) exit();?><form action="/renhe/crm/index.php/home/public/changeinfo/navTabId/changeinfo" class="pageForm" data-toggle="validate">
<div class="bjui-pageContent tableContent">
		<input type="hidden" name="id" value="<?php echo ($id); ?>">
          <table class="table table-condensed table-hover" width="100%">
           <tbody>
            <tr><td>
                <label for="j_title" class="control-label x85">姓名：</label>
                <input type="text" data-rule="required" size="25" name="truename" id="j_truename" value="<?php echo ($Rs['truename']); ?>" disabled >
             </td></tr>
            <tr><td>
            <label for="j_title" class="control-label x85">性别：</label>
            <select name="sex" data-toggle="selectpicker" data-rule="required">
                <?php if($Rs['sex'] == 男 ): ?><option value="男" selected>男</option>
                <option value="女">女</option>
                <?php else: ?>
                <option value="男">男</option>
                <option value="女" selected>女</option><?php endif; ?>
            </select>
             </td></tr>
            <tr><td>
                <label for="j_title" class="control-label x85">电话：</label>
                <input type="text" data-rule="电话:required;mobile|tel" size="25" name="tel" id="j_tel" value="<?php echo ($Rs['tel']); ?>" >
             </td></tr>
            <tr><td>
                <label for="j_title" class="control-label x85">手机：</label>
                <input type="text" data-rule="手机:required;mobile" size="25" name="phone" id="j_phone" value="<?php echo ($Rs['phone']); ?>" >
            </td></tr>
            <tr><td>
                <label for="j_title" class="control-label x85">邮箱：</label>
                <input type="text" data-rule="邮箱:required;email;length[~100]" size="25" name="email" id="j_email" value="<?php echo ($Rs['email']); ?>" >
             </td></tr>
            <tr><td>
                <label for="j_title" class="control-label x85">QQ：</label>
                <input type="text" data-rule="QQ:required;digits;length[5~12]" size="25" name="qq" id="j_qq" value="<?php echo ($Rs['qq']); ?>" >
            </td></tr>
			<tr><td>
                <label for="j_title" class="control-label x85">内线：</label>
                <input type="text" data-rule="length[~20]" size="25" name="neixian" value="<?php echo ($Rs['neixian']); ?>" >
            </td></tr>
            </tbody>
            </table>
</div>
<div class="bjui-pageFooter">
<ul>
<li><button type="button" class="btn-close" data-icon="close">取消</button></li>
<li><button type="submit" class="btn-success" data-icon="save">保存</button></li>
</ul>
</div>
</form>