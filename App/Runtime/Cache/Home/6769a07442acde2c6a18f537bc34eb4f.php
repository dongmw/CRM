<?php if (!defined('THINK_PATH')) exit();?><div class="bjui-pageContent tableContent">
    <!--//任务 开始-->
    
    <div class="w100">
		<div class="panel panel-default">
        	<div class="panel-heading"><h3 class="panel-title"><i class="fa fa-pencil-square-o"></i> <?php echo L('_INDEX_LAYOUT_ReceivedTask_');?><!--接收的任务--> <a class="pull-right" href="javascript:;" data-url="<?php echo U('mytask/index');?>" data-toggle="navtab" data-id="mytask/index" data-title="<?php echo L('_INDEX_LAYOUT_ReceivedTask_');?>"><i class="fa fa-caret-right"></i>  <?php echo L('_INDEX_LAYOUT_Detail_');?></a></h3></div>
			<div style="min-height:185px;">
          
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th height=30><?php echo L('_INDEX_LAYOUT_TaskTitle_');?></th>
                            <th><?php echo L('_INDEX_LAYOUT_Author_');?></th>
                            <th><?php echo L('_INDEX_LAYOUT_StartTime_');?></th>
                            <th><?php echo L('_INDEX_LAYOUT_EndTime_');?></th>
                       </tr>
                    </thead>
                    <tbody>
                        <?php $list=M('task')->where(array('juid'=>array('like','%,'.getuserid().',%')))->order("id desc")->limit(5)->select(); ?>
                        <?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?><tr>
                            <td><?php echo (msubstr($v["title"],0,20)); ?></td>
                            <td><?php echo ($v["uname"]); ?></td>
                            <td><?php echo (substr($v["kssj"],0,10)); ?></td>
                            <td><?php echo (substr($v["jssj"],0,10)); ?></td>
                        </tr><?php endforeach; endif; else: echo "" ;endif; ?>
                    </tbody>
                </table>
          
			</div>
		</div>
	</div>
    
    <div class="w100">
		<div class="panel panel-default">
        	<div class="panel-heading"><h3 class="panel-title"><i class="fa fa-pencil-square-o"></i> <?php echo L('_INDEX_LAYOUT_InitiateTask_');?><!--发起的任务--> <a class="pull-right" href="javascript:;" data-url="<?php echo U('task/index');?>" data-toggle="navtab" data-id="mytask/index" data-title="<?php echo L('_INDEX_LAYOUT_InitiateTask_');?>"><i class="fa fa-caret-right"></i>  <?php echo L('_INDEX_LAYOUT_Detail_');?></a></h3></div>
			<div style="min-height:185px;">
          
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th height=30><?php echo L('_INDEX_LAYOUT_TaskTitle_');?></th>
                            <th><?php echo L('_INDEX_LAYOUT_StartTime_');?></th>
                            <th><?php echo L('_INDEX_LAYOUT_EndTime_');?></th>
                            <th><?php echo L('_INDEX_LAYOUT_Status_');?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $list=M('task')->where(array('uid'=>array('EQ',getuserid())))->order("id desc")->limit(5)->select(); ?>
                        <?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?><tr>
                            <td><?php echo (msubstr($v["title"],0,20)); ?></td>
                            <td><?php echo (substr($v["kssj"],0,10)); ?></td>
                            <td><?php echo (substr($v["jssj"],0,10)); ?></td>
                            <td><?php if ($v['zhuangtai'] == '已完成') {echo '<span class="label label-success">'.$v['zhuangtai'].'</span>';} else {echo '<span class="label label-default">'.$v['zhuangtai'].'</span>';} ?></td>
                        </tr><?php endforeach; endif; else: echo "" ;endif; ?>
                    </tbody>
                </table>
          
			</div>
		</div>
	</div>
    <!--//任务 结束-->