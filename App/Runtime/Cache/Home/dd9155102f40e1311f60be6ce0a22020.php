<?php if (!defined('THINK_PATH')) exit();?><div class="col-sm-12">
<div style="display: inline-block; vertical-align: middle;">
    <div id="j_<?php echo ($id); ?>_file_up" data-toggle="upload" data-uploader="<?php echo U('Public/uploading','sessionid='.$uid.'&attid='.$attid.'&module='.$module);?>" 
    data-file-size-limit="31457280"
    data-file-type-exts="*.jpg;*.jpeg;*.png;*.gif;*.bmp;*.mpg;*.rar;*.zip;*.txt;*.doc;*.docx;*.xls;*.xlsx;*.pdf;*.ppt;*.pptx"
    data-multi="true"
    data-button-text="添加附件"
    data-auto="true"
    data-remove-timeout="0"
    data-on-upload-success="<?php echo ($id); ?>_upload_success"
    data-icon="cloud-upload"
    data-button-css="btn-default"></div>
    <input type="hidden" name="<?php echo ($id); ?>.file" value="" id="j_<?php echo ($id); ?>_file">
</div>
<div class="uploader" id="j_<?php echo ($id); ?>_file_span"></div>
</div>