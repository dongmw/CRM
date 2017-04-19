<?php
namespace Home\Controller;
use Think\Controller;
class PublicController extends Controller {

	public function jumpurl($url){
		if (!empty($url))
		{
			$strurl = $url; //{:U('popup/flow')}
		}
		$this->display(); 
    }
	
	public function flowselect(){
		$id = $_REQUEST["id"];
		$type = $_REQUEST["type"];
		$ac = $_REQUEST["ac"];
		if (IS_POST){ 
			if ($ac =='save')
			{
				//dump($_POST['customList']);
				//exit();
				$str_confirm='';
				$str_confirm_name='';
				$item = $_POST['customList'];
				$str_len = count($item);
				$i=0;
				foreach ($item as $tag){
					$i++;
					$str_arrow = '→';
					if ($i == $str_len){
						$str_arrow = '';
					}
					$items = explode("|",$tag);
					$items_1 = explode(":",$items[0]);
					switch ($items_1[0]){
						case '部门' :
							$str_confirm.='dept_'.$items[1].'|';
							$str_confirm_name.=$items[0].$str_arrow;
							break;
						case '职位' :
							$str_confirm.='dp_'.$items[1].'|';
							$str_confirm_name.=$items[0].$str_arrow;
							break;
						case '人员' :
							$str_confirm.='emp_'.$items[1].'|';
							$str_confirm_name.=$items[0].$str_arrow;
							break;
						default:
							$str_confirm.='emp_'.$items[1].'|';
							$str_confirm_name.=$items[0].$str_arrow;
							break;
					}
				}
				//dump($id);
				//dump($str_len);
				//dump($str_confirm);
				//dump($str_confirm_name);
				//exit();	

/*				if (!empty($type)) {
					$data['id']=$id;
					switch ($type){
						case 'confirm' :
							$data['confirm']=$str_confirm;
							$data['confirm_name']=$str_confirm_name;
							break;
						case 'consult' :
							$data['consult']=$str_confirm;
							$data['consult_name']=$str_confirm_name;
							break;
						case 'refer' :
							$data['refer']=$str_confirm;
							$data['refer_name']=$str_confirm_name;
							break;
						default:
							$data['confirm']=$str_confirm;
							$data['confirm_name']=$str_confirm_name;
							break;
					}
					$data['update_time']=time();
					$Rs=M("FlowType")->save($data);
				}
*/
			echo('{"statusCode":"200","message":"","closeCurrent":true,"confirm_s":"'.$str_confirm.'","confirm_wrap":"'.$str_confirm_name.'"}');
/*echo('<script>document.getElementById("confirm_wrap").innerHTML = '.$str_confirm_name.';</script>');*/
				//echo('{"statusCode":"200","message":"'.L('_OPERATION_SUCCESS_').'","tabid":"'.$_REQUEST['navTabId'].'","closeCurrent":true,"forward":"","forwardConfirm":""}');
			}
		} else {
			$this->assign('id', $id); 
			$this->assign('type', $type); 
			if (!empty($type)) {
				switch ($type){
					case 'del' :
						echo('{"statusCode":"200","message":"'.L('_OPERATION_SUCCESS_').'","tabid":"","closeCurrent":false,"forward":"","forwardConfirm":""}');
						break;
					case 'hold' :					
						echo('{"statusCode":"200","message":"'.L('_OPERATION_SUCCESS_').'","tabid":"","closeCurrent":false,"forward":"","forwardConfirm":""}');
					case 'confirm' :					
						$this->assign('title', '审批'); 
						$model = D("FlowType");
						$where['id']=array('eq',$id);
						$rs = M('FlowType')->where($where)->find($id);
						$items1 = explode("|",$rs['confirm']);
						$count = count($items1);
						$str = '';
						if ($count > 0) {
							for ($i=0; $i<count($items1)-1; $i++){
								$str_confirm_name = '';
								$items_1 = explode("_",$items1[$i]);
								switch ($items_1[0]){
									case 'dept' :
										$str_confirm_name.='部门:'.M('AuthGroup')->getFieldById(str_replace("dept_","",$items1[$i]),'title').'|'.$items_1[1];
										break;
									case 'dp' :
										$str_confirm_name.='职位:'.M('AuthGroup')->getFieldById(str_replace("dp_","",$items1[$i]),'title').'|'.$items_1[1];
										break;
									case 'emp' :
										$str_confirm_name.='人员:'.M('User')->getFieldByUsername(str_replace("emp_","",$items1[$i]),'truename').'/'.M('User')->getFieldByUsername(str_replace("emp_","",$items1[$i]),'posname').'|'.$items_1[1];
										break;
									default:
										$str_confirm_name.='人员:'.M('User')->getFieldByUsername(str_replace("emp_","",$items1[$i]),'truename').'/'.M('User')->getFieldByUsername(str_replace("emp_","",$items1[$i]),'posname').'|'.$items_1[1];
										break;
								}
								
								$str.='
								<tr data-idname="customList['.$i.'].id">
								<th title="No." width="38"><input type="text" name="customList['.$i.'].no" class="no" data-rule="required" value="1" size="2"></th>
								<th title="审核对象"><input type="text" readonly="readonly" name="customList['.$i.'].confirm_name" data-rule="required" size="28" data-toggle="lookup" data-url="'.U('public/flowlookupuser').'" data-group="customList['.$i.']" data-width="700" data-height="500" data-id="dialog-max" data-max="true" data-mask="true" value="'.$str_confirm_name.'"></th>
								<th title="" data-addtool="true" width="65">
								<a href="'.U('public/flow','id='.$id.'&type=del').'" class="btn btn-red row-del">删</a>
								</th>
								</tr>
								';
							}
						}
						$this -> assign("list",$str);
						$this->display(); 
						break;
					case 'consult' :					
						$this->assign('title', '协商'); 
						$model = D("FlowType");
						$where['id']=array('eq',$id);
						$rs = M('FlowType')->where($where)->find($id);

						$items1 = explode("|",$rs['consult']);
						$items2 = explode("|",$rs['consult_name']);
						$count = count($items1);
						$str = '';
						if ($count > 0) {
							for ($i=0; $i<count($items1)-1; $i++){
								$str_confirm_name = '';
								$items_1 = explode("_",$items1[$i]);
								switch ($items_1[0]){
									case 'dept' :
										$str_confirm_name.='部门:'.M('AuthGroup')->getFieldById(str_replace("dept_","",$items1[$i]),'title').'|'.$items_1[1];
										break;
									case 'dp' :
										$str_confirm_name.='职位:'.M('AuthGroup')->getFieldById(str_replace("dp_","",$items1[$i]),'title').'|'.$items_1[1];
										break;
									case 'emp' :
										$str_confirm_name.='人员:'.M('User')->getFieldByUsername(str_replace("emp_","",$items1[$i]),'truename').'/'.M('User')->getFieldByUsername(str_replace("emp_","",$items1[$i]),'posname').'|'.$items_1[1];
										break;
									default:
										$str_confirm_name.='人员:'.M('User')->getFieldByUsername(str_replace("emp_","",$items1[$i]),'truename').'/'.M('User')->getFieldByUsername(str_replace("emp_","",$items1[$i]),'posname').'|'.$items_1[1];
										break;
								}
								
								$str.='
								<tr data-idname="customList['.$i.'].id">
								<th title="No." width="38"><input type="text" name="customList['.$i.'].no" class="no" data-rule="required" value="1" size="2"></th>
								<th title="审核对象"><input type="text" readonly="readonly" name="customList['.$i.'].confirm_name" data-rule="required" size="28" data-toggle="lookup" data-url="'.U('public/flowlookupuser').'" data-group="customList['.$i.']" data-width="700" data-height="500" data-id="dialog-max" data-max="true" data-mask="true" value="'.$str_confirm_name.'"></th>
								<th title="" data-addtool="true" width="65">
								<a href="'.U('public/flow','id='.$id.'&type=del').'" class="btn btn-red row-del">删</a>
								</th>
								</tr>
								';
							}
						}
						$this -> assign("list",$str);
						$this->display(); 
						break;
					case 'refer' :					
						$this->assign('title', '抄送'); 
						$model = D("FlowType");
						$where['id']=array('eq',$id);
						$rs = M('FlowType')->where($where)->find($id);

						$items1 = explode("|",$rs['refer']);
						$items2 = explode("|",$rs['refer_name']);
						$count = count($items1);
						$str = '';
						if ($count > 0) {
							for ($i=0; $i<count($items1)-1; $i++){
								$str_confirm_name = '';
								$items_1 = explode("_",$items1[$i]);
								switch ($items_1[0]){
									case 'dept' :
										$str_confirm_name.='部门:'.M('AuthGroup')->getFieldById(str_replace("dept_","",$items1[$i]),'title').'|'.$items_1[1];
										break;
									case 'dp' :
										$str_confirm_name.='职位:'.M('AuthGroup')->getFieldById(str_replace("dp_","",$items1[$i]),'title').'|'.$items_1[1];
										break;
									case 'emp' :
										$str_confirm_name.='人员:'.M('User')->getFieldByUsername(str_replace("emp_","",$items1[$i]),'truename').'/'.M('User')->getFieldByUsername(str_replace("emp_","",$items1[$i]),'posname').'|'.$items_1[1];
										break;
									default:
										$str_confirm_name.='人员:'.M('User')->getFieldByUsername(str_replace("emp_","",$items1[$i]),'truename').'/'.M('User')->getFieldByUsername(str_replace("emp_","",$items1[$i]),'posname').'|'.$items_1[1];
										break;
								}
								
								$str.='
								<tr data-idname="customList['.$i.'].id">
								<th title="No." width="38"><input type="text" name="customList['.$i.'].no" class="no" data-rule="required" value="1" size="2"></th>
								<th title="审核对象"><input type="text" readonly="readonly" name="customList['.$i.'].confirm_name" data-rule="required" size="28" data-toggle="lookup" data-url="'.U('public/flowlookupuser').'" data-group="customList['.$i.']" data-width="700" data-height="500" data-id="dialog-max" data-max="true" data-mask="true" value="'.$str_confirm_name.'"></th>
								<th title="" data-addtool="true" width="65">
								<a href="'.U('public/flow','id='.$id.'&type=del').'" class="btn btn-red row-del">删</a>
								</th>
								</tr>
								';
							}
						}
						$this -> assign("list",$str);
						$this->display(); 
						break;
					default:
						$this->mtReturn(300,L('_OPERATION_FAIL_'),'',false);
						break;
				}
			}
			
		}
    }

	public function flow(){
		$id = $_REQUEST["id"];
		$type = $_REQUEST["type"];
		$ac = $_REQUEST["ac"];
		if (IS_POST){ 
			if ($ac =='save')
			{
				//dump($_POST['customList']);
				//exit();
				$str_confirm='';
				$str_confirm_name='';
				$item = $_POST['customList'];
				$str_len = count($item);
				$i=0;
				foreach ($item as $tag){
					$i++;
					$str_arrow = '→';
					if ($i == $str_len){
						$str_arrow = '';
					}
					$items = explode("|",$tag);
					$items_1 = explode(":",$items[0]);
					switch ($items_1[0]){
						case '部门' :
							$str_confirm.='dept_'.$items[1].'|';
							$str_confirm_name.=$items[0].$str_arrow;
							break;
						case '职位' :
							$str_confirm.='dp_'.$items[1].'|';
							$str_confirm_name.=$items[0].$str_arrow;
							break;
						case '人员' :
							$str_confirm.='emp_'.$items[1].'|';
							$str_confirm_name.=$items[0].$str_arrow;
							break;
						case '上级' :
							$str_confirm.='higher|';
							$str_confirm_name.=$items[0].$str_arrow;
							break;
						default:
							$str_confirm.='emp_'.$items[1].'|';
							$str_confirm_name.=$items[0].$str_arrow;
							break;
					}
				}
				//dump($id);
				//dump($str_len);
				//dump($str_confirm);
				//dump($str_confirm_name);
				//exit();	

				if (!empty($type)) {
					$data['id']=$id;
					switch ($type){
						case 'confirm' :
							$data['confirm']=$str_confirm;
							$data['confirm_name']=$str_confirm_name;
							break;
						case 'consult' :
							$data['consult']=$str_confirm;
							$data['consult_name']=$str_confirm_name;
							break;
						case 'refer' :
							$data['refer']=$str_confirm;
							$data['refer_name']=$str_confirm_name;
							break;
						default:
							$data['confirm']=$str_confirm;
							$data['confirm_name']=$str_confirm_name;
							break;
					}
					$data['update_time']=time();
					$Rs=M("FlowType")->save($data);
				}

				echo('{"statusCode":"200","message":"'.L('_OPERATION_SUCCESS_').'","tabid":"'.$_REQUEST['navTabId'].'","closeCurrent":true,"forward":"","forwardConfirm":""}');
			}
		} else {
			$this->assign('id', $id); 
			$this->assign('type', $type); 
			if (!empty($type)) {
				switch ($type){
					case 'del' :
						echo('{"statusCode":"200","message":"'.L('_OPERATION_SUCCESS_').'","tabid":"","closeCurrent":false,"forward":"","forwardConfirm":""}');
						break;
					case 'hold' :					
						echo('{"statusCode":"200","message":"'.L('_OPERATION_SUCCESS_').'","tabid":"","closeCurrent":false,"forward":"","forwardConfirm":""}');
					case 'confirm' :					
						$this->assign('title', '审批'); 
						$model = D("FlowType");
						$where['id']=array('eq',$id);
						$rs = M('FlowType')->where($where)->find($id);
						$items1 = explode("|",$rs['confirm']);
						$count = count($items1);
						$str = '';
						if ($count > 0) {
							for ($i=0; $i<count($items1)-1; $i++){
								$str_confirm_name = '';
								$items_1 = explode("_",$items1[$i]);
								switch ($items_1[0]){
									case 'dept' :
										$str_confirm_name.='部门:'.M('AuthGroup')->getFieldById(str_replace("dept_","",$items1[$i]),'title').'|'.$items_1[1];
										break;
									case 'dp' :
										$str_confirm_name.='职位:'.M('AuthGroup')->getFieldById(str_replace("dp_","",$items1[$i]),'title').'|'.$items_1[1];
										break;
									case 'emp' :
										$str_confirm_name.='人员:'.M('User')->getFieldByUsername(str_replace("emp_","",$items1[$i]),'truename').'/'.M('User')->getFieldByUsername(str_replace("emp_","",$items1[$i]),'posname').'|'.$items_1[1];
										break;
									case 'higher' :
										$str_confirm_name.='上级:直接上级|higher';
										break;
									default:
										$str_confirm_name.='人员:'.M('User')->getFieldByUsername(str_replace("emp_","",$items1[$i]),'truename').'/'.M('User')->getFieldByUsername(str_replace("emp_","",$items1[$i]),'posname').'|'.$items_1[1];
										break;
								}
								
								$str.='
								<tr data-idname="customList['.$i.'].id">
								<th title="No." width="38"><input type="text" readonly="readonly" name="customList['.$i.'].no" class="no" data-rule="required" value="1" size="2"></th>
								<th title="审核对象"><input type="text" readonly="readonly" name="customList['.$i.'].confirm_name" data-rule="required" size="28" data-toggle="lookup" data-url="'.U('public/flowlookupuser').'" data-group="customList['.$i.']" data-width="700" data-height="500" data-id="dialog-max" data-max="true" data-mask="true" value="'.$str_confirm_name.'"></th>
								<th title="" data-addtool="true" width="65">
								<a href="'.U('public/flow','id='.$id.'&type=del').'" class="btn btn-red row-del">删</a>
								</th>
								</tr>
								';
							}
						}
						$this -> assign("list",$str);
						$this->display(); 
						break;
					case 'consult' :					
						$this->assign('title', '协商'); 
						$model = D("FlowType");
						$where['id']=array('eq',$id);
						$rs = M('FlowType')->where($where)->find($id);

						$items1 = explode("|",$rs['consult']);
						$items2 = explode("|",$rs['consult_name']);
						$count = count($items1);
						$str = '';
						if ($count > 0) {
							for ($i=0; $i<count($items1)-1; $i++){
								$str_confirm_name = '';
								$items_1 = explode("_",$items1[$i]);
								switch ($items_1[0]){
									case 'dept' :
										$str_confirm_name.='部门:'.M('AuthGroup')->getFieldById(str_replace("dept_","",$items1[$i]),'title').'|'.$items_1[1];
										break;
									case 'dp' :
										$str_confirm_name.='职位:'.M('AuthGroup')->getFieldById(str_replace("dp_","",$items1[$i]),'title').'|'.$items_1[1];
										break;
									case 'emp' :
										$str_confirm_name.='人员:'.M('User')->getFieldByUsername(str_replace("emp_","",$items1[$i]),'truename').'/'.M('User')->getFieldByUsername(str_replace("emp_","",$items1[$i]),'posname').'|'.$items_1[1];
										break;
									case 'higher' :
										$str_confirm_name.='上级:直接上级|higher';
										break;
									default:
										$str_confirm_name.='人员:'.M('User')->getFieldByUsername(str_replace("emp_","",$items1[$i]),'truename').'/'.M('User')->getFieldByUsername(str_replace("emp_","",$items1[$i]),'posname').'|'.$items_1[1];
										break;
								}
								
								$str.='
								<tr data-idname="customList['.$i.'].id">
								<th title="No." width="38"><input type="text" readonly="readonly" name="customList['.$i.'].no" class="no" data-rule="required" value="1" size="2"></th>
								<th title="审核对象"><input type="text" readonly="readonly" name="customList['.$i.'].confirm_name" data-rule="required" size="28" data-toggle="lookup" data-url="'.U('public/flowlookupuser').'" data-group="customList['.$i.']" data-width="700" data-height="500" data-id="dialog-max" data-max="true" data-mask="true" value="'.$str_confirm_name.'"></th>
								<th title="" data-addtool="true" width="65">
								<a href="'.U('public/flow','id='.$id.'&type=del').'" class="btn btn-red row-del">删</a>
								</th>
								</tr>
								';
							}
						}
						$this -> assign("list",$str);
						$this->display(); 
						break;
					case 'refer' :					
						$this->assign('title', '抄送'); 
						$model = D("FlowType");
						$where['id']=array('eq',$id);
						$rs = M('FlowType')->where($where)->find($id);

						$items1 = explode("|",$rs['refer']);
						$items2 = explode("|",$rs['refer_name']);
						$count = count($items1);
						$str = '';
						if ($count > 0) {
							for ($i=0; $i<count($items1)-1; $i++){
								$str_confirm_name = '';
								$items_1 = explode("_",$items1[$i]);
								switch ($items_1[0]){
									case 'dept' :
										$str_confirm_name.='部门:'.M('AuthGroup')->getFieldById(str_replace("dept_","",$items1[$i]),'title').'|'.$items_1[1];
										break;
									case 'dp' :
										$str_confirm_name.='职位:'.M('AuthGroup')->getFieldById(str_replace("dp_","",$items1[$i]),'title').'|'.$items_1[1];
										break;
									case 'emp' :
										$str_confirm_name.='人员:'.M('User')->getFieldByUsername(str_replace("emp_","",$items1[$i]),'truename').'/'.M('User')->getFieldByUsername(str_replace("emp_","",$items1[$i]),'posname').'|'.$items_1[1];
										break;
									case 'higher' :
										$str_confirm_name.='上级:直接上级|higher';
										break;
									default:
										$str_confirm_name.='人员:'.M('User')->getFieldByUsername(str_replace("emp_","",$items1[$i]),'truename').'/'.M('User')->getFieldByUsername(str_replace("emp_","",$items1[$i]),'posname').'|'.$items_1[1];
										break;
								}
								
								$str.='
								<tr data-idname="customList['.$i.'].id">
								<th title="No." width="38"><input type="text" readonly="readonly" name="customList['.$i.'].no" class="no" data-rule="required" value="1" size="2"></th>
								<th title="审核对象"><input type="text" readonly="readonly" name="customList['.$i.'].confirm_name" data-rule="required" size="28" data-toggle="lookup" data-url="'.U('public/flowlookupuser').'" data-group="customList['.$i.']" data-width="700" data-height="500" data-id="dialog-max" data-max="true" data-mask="true" value="'.$str_confirm_name.'"></th>
								<th title="" data-addtool="true" width="65">
								<a href="'.U('public/flow','id='.$id.'&type=del').'" class="btn btn-red row-del">删</a>
								</th>
								</tr>
								';
							}
						}
						$this -> assign("list",$str);
						$this->display(); 
						break;
					default:
						$this->mtReturn(300,L('_OPERATION_FAIL_'),'',false);
						break;
				}
			}
			
		}
    }
	
	public function folder(){
		$id = $_REQUEST["id"];
		$type = $_REQUEST["type"];
		$ac = $_REQUEST["ac"];
		if (IS_POST){ 
			if ($ac =='save')
			{
				//dump($_POST['customList']);
				//exit();
				$str_confirm='';
				$str_confirm_name='';
				$item = $_POST['customList'];
				$str_len = count($item);
				$i=0;
				foreach ($item as $tag){
					$i++;
					$str_arrow = '→';
					if ($i == $str_len){
						$str_arrow = '';
					}
					$items = explode(":",$tag);
					$items_1 = explode("|",$items[1]);
					
					switch ($items[0]){
						case '部门' :
							$str_confirm.=$items_1[0].'|dept_'.$items_1[1].';';
							break;
						case '人员' :
							$str_confirm.=$items[1].';';
							break;
						default:
							$str_confirm.=$items[1].';';
							break;
					}
				}
				//dump($id);
				//dump($str_len);
				//dump($str_confirm);
				//dump($str_confirm_name);
				//exit();	

				if (!empty($type)) {
					$data['id']=$id;
					switch ($type){
						case 'admin' :
							$data['admin']=$str_confirm;
							break;
						case 'write' :
							$data['write']=$str_confirm;
							break;
						case 'read' :
							$data['read']=$str_confirm;
							break;
						default:
							$data['admin']=$str_confirm;
							break;
					}
					$Rs=M("SystemFolder")->save($data);
				}

				echo('{"statusCode":"200","message":"'.L('_OPERATION_SUCCESS_').'","tabid":"'.$_REQUEST['navTabId'].'","closeCurrent":true,"forward":"","forwardConfirm":""}');
			}
		} else {
			$this->assign('id', $id); 
			$this->assign('type', $type); 
			if (!empty($type)) {
				switch ($type){
					case 'del' :
						echo('{"statusCode":"200","message":"'.L('_OPERATION_SUCCESS_').'","tabid":"","closeCurrent":false,"forward":"","forwardConfirm":""}');
						break;
					case 'hold' :					
						echo('{"statusCode":"200","message":"'.L('_OPERATION_SUCCESS_').'","tabid":"","closeCurrent":false,"forward":"","forwardConfirm":""}');
					case 'admin' :					
						$this->assign('title', '管理权限'); 
						$model = D("SystemFolder");
						$where['id']=array('eq',$id);
						$rs = M('SystemFolder')->where($where)->find($id);
						$items1 = explode(";",$rs['admin']);
						$count = count($items1);
						$str = '';
						if ($count > 0) {
							for ($i=0; $i<count($items1)-1; $i++){
								$str_confirm_name = '';
								if (strpos($items1[$i],'|dept_')) {
									$str_confirm_name.='部门:'.str_replace("dept_","",$items1[$i]);
								} else {
									$str_confirm_name.='人员:'.$items1[$i];
								}
								$str.='
								<tr data-idname="customList['.$i.'].id">
								<th title="No." width="38"><input type="text" readonly="readonly" name="customList['.$i.'].no" class="no" data-rule="required" value="1" size="2"></th>
								<th title="操作对象"><input type="text" readonly="readonly" name="customList['.$i.'].confirm_name" data-rule="required" size="28" data-toggle="lookup" data-url="'.U('public/folderlookupuser').'" data-group="customList['.$i.']" data-width="700" data-height="500" data-id="dialog-max" data-max="true" data-mask="true" value="'.$str_confirm_name.'"></th>
								<th title="" data-addtool="true" width="65">
								<a href="'.U('public/folder','id='.$id.'&type=del').'" class="btn btn-red row-del">删</a>
								</th>
								</tr>
								';
							}
						}
						$this -> assign("list",$str);
						$this->display(); 
						break;
					case 'write' :					
						$this->assign('title', '改写权限'); 
						$model = D("SystemFolder");
						$where['id']=array('eq',$id);
						$rs = M('SystemFolder')->where($where)->find($id);
						$items1 = explode(";",$rs['write']);
						$count = count($items1);
						$str = '';
						if ($count > 0) {
							for ($i=0; $i<count($items1)-1; $i++){
								$str_confirm_name = '';
								if (strpos($items1[$i],'|dept_')) {
									$str_confirm_name.='部门:'.str_replace("dept_","",$items1[$i]);
								} else {
									$str_confirm_name.='人员:'.$items1[$i];
								}
								$str.='
								<tr data-idname="customList['.$i.'].id">
								<th title="No." width="38"><input type="text" readonly="readonly" name="customList['.$i.'].no" class="no" data-rule="required" value="1" size="2"></th>
								<th title="操作对象"><input type="text" readonly="readonly" name="customList['.$i.'].confirm_name" data-rule="required" size="28" data-toggle="lookup" data-url="'.U('public/folderlookupuser').'" data-group="customList['.$i.']" data-width="700" data-height="500" data-id="dialog-max" data-max="true" data-mask="true" value="'.$str_confirm_name.'"></th>
								<th title="" data-addtool="true" width="65">
								<a href="'.U('public/folder','id='.$id.'&type=del').'" class="btn btn-red row-del">删</a>
								</th>
								</tr>
								';
							}
						}
						$this -> assign("list",$str);
						$this->display(); 
						break;
					case 'read' :					
						$this->assign('title', '读取权限'); 
						$model = D("SystemFolder");
						$where['id']=array('eq',$id);
						$rs = M('SystemFolder')->where($where)->find($id);
						$items1 = explode(";",$rs['read']);
						$count = count($items1);
						$str = '';
						if ($count > 0) {
							for ($i=0; $i<count($items1)-1; $i++){
								$str_confirm_name = '';
								if (strpos($items1[$i],'|dept_')) {
									$str_confirm_name.='部门:'.str_replace("dept_","",$items1[$i]);
								} else {
									$str_confirm_name.='人员:'.$items1[$i];
								}
								$str.='
								<tr data-idname="customList['.$i.'].id">
								<th title="No." width="38"><input type="text" readonly="readonly" name="customList['.$i.'].no" class="no" data-rule="required" value="1" size="2"></th>
								<th title="操作对象"><input type="text" readonly="readonly" name="customList['.$i.'].confirm_name" data-rule="required" size="28" data-toggle="lookup" data-url="'.U('public/folderlookupuser').'" data-group="customList['.$i.']" data-width="700" data-height="500" data-id="dialog-max" data-max="true" data-mask="true" value="'.$str_confirm_name.'"></th>
								<th title="" data-addtool="true" width="65">
								<a href="'.U('public/folder','id='.$id.'&type=del').'" class="btn btn-red row-del">删</a>
								</th>
								</tr>
								';
							}
						}
						$this -> assign("list",$str);
						$this->display(); 
						break;
					default:
						$this->mtReturn(300,L('_OPERATION_FAIL_'),'',false);
						break;
				}
			}
			
		}
    }

	
	public function flowlookup(){
		$model = D("user");
		$where['status']=array('eq',1);
		$user_list = $model ->where($where)->order('username')->getField("username,truename");
		$this -> assign("user_list",$user_list);
		$this->display(); 
	}
	
	public function flowlookupuser($au=''){
		$posname_list=orgcateTree($pid=0,$level=0,$type=1);
		$this->assign('posname_list',$posname_list);
		
		$depname_list=orgcateTree($pid=0,$level=0,$type=0);
		$this->assign('depname_list',$depname_list);
		
		$model = D("user");
		$where['status']=array('eq',1);
		$user_list = $model ->where($where)->order('username')->getField("id,truename,posname,depname,username");
		$this -> assign("au",$au);
		$this -> assign("user_list",$user_list);
		$this->display();
	}
	
	public function folderlookupuser(){
		//$posname_list=orgcateTree($pid=0,$level=0,$type=1);
		//$this->assign('posname_list',$posname_list);
		
		$depname_list=orgcateTree($pid=0,$level=0,$type=0);
		$this->assign('depname_list',$depname_list);
		
		$model = D("user");
		$where['status']=array('eq',1);
		$user_list = $model ->where($where)->order('username')->getField("id,truename,posname,depname,username");
		$this -> assign("user_list",$user_list);
		$this->display();
	}

	public function flowlookupuserselect(){
		$posname_list=orgcateTree($pid=0,$level=0,$type=1);
		$this->assign('posname_list',$posname_list);
		
		$depname_list=orgcateTree($pid=0,$level=0,$type=0);
		$this->assign('depname_list',$depname_list);
		
		$model = D("user");
		$where['status']=array('eq',1);
		$user_list = $model ->where($where)->order('username')->getField("id,truename,posname,depname,username");
		$this -> assign("user_list",$user_list);
		$this->display();
	}

    public function login(){
		if(IS_POST){ 
			$is_verify_code = C('IS_VERIFY_CODE');
			if (!empty($is_verify_code)) {
				$check=$this->check_verify($_POST['verify'],1);
				if (!$check) {
					$this -> error('验证码错误！');
				}
			}
			$admin = I('post.');
			$rs = D('Admin', 'Service')->login($admin);
			if (!$rs['status']) {
				$this->error($rs['data']);
			}
			$this->success('登录成功，正在跳转...',__ROOT__.'/?l='.$_POST['l'],1);
		}
		else{
			$config =   S('DB_CONFIG_DATA');
			if(!$config){
				$config =   api('Config/lists');
				S('DB_CONFIG_DATA',$config);
			}
			C($config); 
			
			//如果启用自动登录
			if(session('uid')){
				$this->redirect(__ROOT__,'',0,'',1);
				return;
			} else if (isset($_COOKIE['YHHttpCookie'])) {
				$rs = D('Admin', 'Service')->login_auto($_COOKIE['YHHttpCookie']);
				if (!$rs['status']) {
					$this->error($rs['data']);
				}
				$this->redirect(__ROOT__,'',0,'',1);
				return;
			}
			
			//如果存在语种COOKIE
			if (isset($_COOKIE['think_language'])) {
				switch($_COOKIE['think_language']){
					case 'zh-cn':
						$language = '<option value="zh-cn" selected="selected">中文(简体)</option><option value="zh-tw">中文(繁體)</option><option value="en-us">English</option>';
						break;
					case 'zh-tw':
						$language = '<option value="zh-cn">中文(简体)</option><option value="zh-tw" selected="selected">中文(繁體)</option><option value="en-us">English</option>';
						break;
					case 'en-us':
						$language = '<option value="zh-cn">中文(简体)</option><option value="zh-tw">中文(繁體)</option><option value="en-us" selected="selected">English</option>';
						break;
					default:
						$language = '<option value="zh-cn" selected="selected">中文(简体)</option><option value="zh-tw">中文(繁體)</option><option value="en-us">English</option>';
						break;
				}
			} else {
				$language = '<option value="zh-cn" selected="selected">中文(简体)</option><option value="zh-tw">中文(繁體)</option><option value="en-us">English</option>';
			}
			$this->assign("language", $language);
			
			$this->assign("is_verify_code", C('IS_VERIFY_CODE'));
			$this->display();
		}
    }
	
	// 检测输入的验证码是否正确，$code为用户输入的验证码字符串
	function check_verify($code, $id = ''){
	    $verify = new \Think\Verify();
	    return $verify->check($code, $id);
	}

	public function verify(){
	    ob_clean();
		$config =    array(
			'fontSize'    =>    16,    // 验证码字体大小
		    'length'      =>    4,     // 验证码位数
		    'imageH'	  => 	35,
		    'useNoise'    =>    false, // 关闭验证码杂点
		);
		$verify = new \Think\Verify($config);
		$verify->codeSet = '0123456789';
		$verify->entry(1);
	}
	
	public function logout() {
		D('Admin', 'Service')->logout();
		$this->redirect('Public/login');
	}
	
	public function changepwd() {
		if(IS_POST){
	    $password=I('post.password');
		$map = array();
		if(I('post.password')!=I('post.repassword'))
		{
			$data['statusCode']=300;
			$data['message']='两次输入密码不一致！';
		}
		$map['password'] = md5(md5((I('post.oldpassword'))));
		$map['id'] = getuserid();
		$User = M("User");
		if (!$User->where($map)->field('id')->find()) {
			
			$data['statusCode']=300;
			$data['message']='旧密码不符或者用户名错误！';
			
		} else {
			if (empty($password) || strlen($password) < 5) {
				$data['statusCode']=300;
			    $data['message']='密码长度必须大于6个字符！';
			
			}else{
			$User->password =md5(md5(($password)));
			$User->save();
			$data['statusCode']=200;
			$data['message']='密码修改成功！';
			$data['tabid']=$_REQUEST['navTabId'];
			$data['closeCurrent']='true';
			$data['forward']='';
			$data['forwardConfirm']='';
			}
			
		}
		$this->dwzajaxReturn($data);
		}else{
		  $this->display();	
		}
	}
	
	//修改资料
	public function changeinfo() {
		$id=getuserid();
		$rs=M('user')->find($id);
		if(IS_POST){
			M('user')->save(I('post.'));
			$data['statusCode']=200;
			$data['message']='资料修改成功！';
			$data['tabid']=$_REQUEST['navTabId'];
			$data['closeCurrent']='true';
			$data['forward']='';
		   $this->dwzajaxReturn($data);
		}else{
		  $this->assign('id', $id);
		  $this->assign('Rs', $rs);
		  $this->display();	
		}
	}
	
	//用户设置
	public function usersettings() {
		$id=getuserid();
		$rs=M('user')->find($id);
		if(IS_POST){
			M('user')->save(I('post.'));
			$data['statusCode']=200;
			$data['message']='设置修改成功！';
			$data['tabid']=$_REQUEST['navTabId'];
			$data['closeCurrent']='true';
			$data['forward']='';
		   $this->dwzajaxReturn($data);
		}else{
		  $this->assign('id', $id);
		  $this->assign('Rs', $rs);
		  $this->display();	
		}
	}
	
    protected function dwzajaxReturn($data, $type='') {
        
		$udata['id']=getuserid();
        $udata['update_time']=time();
        $Rs=M("user")->save($udata);
        $dat['username'] = session('username');
        $dat['content'] = $data['message'];
		$dat['os']=$_SERVER['HTTP_USER_AGENT'];
        $dat['url'] = U();
        $dat['addtime'] = date("Y-m-d H:i:s",time());
        $dat['ip'] = get_client_ip();
        M("log")->add($dat);
        
        $result = array();
        $result['statusCode'] = $data['statusCode'];
        $result['tabid'] = $data['tabid'];
        $result['closeCurrent'] = $data['closeCurrent'];
        $result['message'] = $data['message'];
        $result['forward'] = $data['forward'];
		$result['forwardConfirm']=$data['forwardConfirm'];


       
        if (empty($type))
            $type = C('DEFAULT_AJAX_RETURN');
        if (strtoupper($type) == 'JSON') {
            // 返回JSON数据格式到客户端 包含状态信息
            header("Content-Type:text/html; charset=utf-8");
            exit(json_encode($result));
        } elseif (strtoupper($type) == 'XML') {
            // 返回xml格式数据
            header("Content-Type:text/xml; charset=utf-8");
            exit(xml_encode($result));
        } elseif (strtoupper($type) == 'EVAL') {
            // 返回可执行的js脚本
            header("Content-Type:text/html; charset=utf-8");
            exit($data);
        } else {
            // TODO 增加其它格式
        }
    }	

	public function online(){
/*		$info=M('user');
		$where['update_time']=array('gt',time()-3600);
		$numPerPage=100;
		cookie('_currentUrl_', __SELF__);
		$list=$info->where($where)->limit($numPerPage)->page($_GET['pageNum'].','.$numPerPage.'')->select();
		$this->assign('list',$list);
		$count = $info->where($where)->count();
		$this->assign('totalCount', $count);
		$this->assign('currentPage', !empty($_GET['pageNum']) ? $_GET['pageNum'] : 1);
		$this->assign('numPerPage', $numPerPage); 
*/
		$info=M('user');
		$where['update_time']=array('gt',time()-120);
		//$numPerPage=100;
		$list=$info->where($where)->select();
		$this->assign('list',$list);
		$this->display();
	}

	public function onlineonline(){
		$info=M('user');
		$where['update_time']=array('gt',time()-120);
		//$numPerPage=100;
		$list=$info->where($where)->select();
		$this->assign('list',$list);
		$this->display();
	}

	public function onlineall(){
		$info=M('user');
		$where['status']=1;
		//$numPerPage=100;
		$list=$info->where($where)->order("`username` asc")->select();
		$this->assign('list',$list);
		$this->display();
	}

	public function onlinerecently(){
		$this->assign('list',get_OnlineRecentlyList());
		$this->display();
	}
   
	public function onlineinc(){
		$this->assign('list',get_OnlineIncList());
		$this->display();
	}
   
	public function onlinechatrefreshinc($u){
		$this->assign('list',get_onlineChatRefreshIncList($u));
		$this->display();
	}
   
	public function note(){
		if(IS_POST){
			M('user')->data(I("post."))->save();
			echo('{"statusCode":"200","message":"'.L('_OPERATION_SUCCESS_').'","tabid":"","closeCurrent":false,"forward":"","forwardConfirm":""}');
			//$this->mtReturn(200,'保存成功','',false);
		} else {
			$Rs=M('user')->find(getuserid());
			$this->assign('Rs', $Rs);
			$this->display();
		}
	}
   
   public function attfile(){
       $attid=I('attid');
	   $this->assign('attid',$attid);
       $this->display();
   }
   
   
   public function upload(){
     $upload = new \Think\Upload();
	 $upload->maxSize   =     C('UPLOAD_MAXSIZE') ;
	 $upload->exts      =     C('UPLOAD_EXTS');
	 $upload->savePath  =     C('UPLOAD_SAVEPATH');
	 $info   =  $upload->upload(); 
	 $gourl = 'index.php/home/public/attfile/attid/'.I('attid').'/'; 
	 if(!$info) {
        echo "<script language='javascript' type='text/javascript'>"; 
		echo "alert('上传失败！$upload->getError()');";
		echo "window.location.href='$gourl'"; 
		echo "</script>";  			 
	   //$this->error($upload->getError());    
	}else{     
	   //dump($info);
	   $data['attid']=I('attid');
	   $data['folder']='Uploads/'.str_replace('./','',$info["filename"]["savepath"]);
	   $data['filename']=$info["filename"]["savename"];
	   $data['filetype']=$info["filename"]["ext"];
	   $data['filedesc']=$info["filename"]["name"];
	   $data['uid']=getuserid();
	   $data['addtime']=date("Y-m-d H:i:s",time());
	   //dump($data);
	   M('files')->data($data)->add();
		$filename=$info["filename"]["name"];
		echo "<script language='javascript' type='text/javascript'>"; 
		echo "alert('文件$filename 上传成功');";
		echo "window.location.href='$gourl'"; 
		echo "</script>";  
	  }
	}
	
	public function uploading(){
		$upload = new \Think\Upload();
		$upload->maxSize   =     C('UPLOAD_MAXSIZE') ;
		$upload->exts      =     C('UPLOAD_EXTS');
		$upload->savePath  =     C('UPLOAD_SAVEPATH');
		$info = $upload->upload(); 
		if(!$info) {
			echo('{"statusCode":"200","message":"上传失败~","filename":""}');
		}else{
			//$data['attid']=I('attid');
			if (isset($_GET['attid'])) {//I('get.attid')
				$data['attid']=$_GET['attid'];
				$data['module']=$_GET['module']; //MODULE_NAME
				$data['folder']='Uploads/'.str_replace('./','',$info["file"]["savepath"]);
				$data['filename']=$info["file"]["savename"];
				$data['filetype']=$info["file"]["ext"];
				$data['filedesc']=$info["file"]["name"];
				$data['size']=$info["file"]["size"];
				$data['uid']=getuserid();
				$data['addtime']=date("Y-m-d H:i:s",time());
				//M('files')->data($data)->add();
				$model = M('files');
				$model->data($data)->add();
				$id = $model->getLastInsID();
				$filename=$info["file"]["name"];
				echo('{"statusCode":"200","message":"上传成功！","filename":"'.$filename.'","size":"'.$data['size'].'","id":"'.$id.'"}');
			}else{
				echo('{"statusCode":"200","message":"上传失败！","filename":""}');
			}
		}
	}
	
	public function delfile(){
		$model = M("files");
		$id=I('tid');
		$uid=I('uid');
		$data['status'] = 0;
		$model->where('id='.$id.' and uid='.$uid.'')->save($data);
		if(!$model) {
			echo('{"statusCode":"300","message":"操作失败！","Error":""}');
		}else{
			echo('{"statusCode":"200","message":"操作成功！","Error":""}');
		}
	}
	
	public function mycate(){
	$list = M("contact")->where(array("uid"=>session("uid")))->distinct('fenlei')->field('fenlei')->select();
    $this->assign('list', $list); 
    $this->display(); 
    }
   
   public function docate(){
	$list = M("doc")->where(array("uid"=>session("uid")))->distinct('fenlei')->field('fenlei')->select();
    $this->assign('list', $list); 
    $this->display(); 
    }
   
   public function htuser(){
	$list = M("hetong")->distinct('name')->field('name')->select();
    $this->assign('list', $list); 
    $this->display(); 
    }
	
	 public function procate(){
	$list = M("pro")->distinct('fenlei')->field('fenlei')->select();
    $this->assign('list', $list); 
    $this->display(); 
    }
	
	public function sktype(){
	$list = M("shou")->distinct('type')->field('type')->select();
    $this->assign('list', $list); 
    $this->display(); 
    }
	
	public function fktype(){
	$list = M("fu")->distinct('type')->field('type')->select();
    $this->assign('list', $list); 
    $this->display(); 
    }
	
	public function fkfenlei(){
	$list = M("fu")->distinct('fenlei')->field('fenlei')->select();
    $this->assign('list', $list); 
    $this->display(); 
    }
	
	public function user(){
		$info=M('user');
		if (isset($_REQUEST ['orderField'])) {$order = $_REQUEST ['orderField'];}
		if($order=='') {$order = $info->getPk();}
		
		if (isset($_REQUEST ['orderDirection'])) {$sort = $_REQUEST ['orderDirection'];}
		//if($sort=='') {$sort = $asc ? 'asc' : 'desc';}
		if($sort=='') {$sort = $asc ? 'desc' : 'asc';}

		if (isset($_REQUEST ['pageCurrent'])) {$pageCurrent = $_REQUEST ['pageCurrent'];}
		if($pageCurrent=='') {$pageCurrent =1;}   
		
		$key=I('keys');
		if($key){
			$where['username'] = array('like','%'.$key.'%');
			$where['truename'] = array('like','%'.$key.'%');
			$where['depname'] = array('like','%'.$key.'%');
			$where['posname'] = array('like','%'.$key.'%');
			$where['_logic'] = 'or'; 
		}
		if(IS_POST&&isset($_REQUEST['filter']) && $_REQUEST['filter'] != ''){
			$map['depname'] = array('EQ', I('filter'));
			$where['_complex'] = $map;
		}
		
		//2015-05-20 【修改】 分页数量 从用户配置信息中调用
		//$numPerPage=C('PERPAGE');
		$User = M("User"); 
		$numPerPage = $User->where('id='.getuserid().'')->getField('numperpage');
		
		cookie('_currentUrl_', __SELF__);
		$list=$info->where($where)->order("`" . $order . "` " . $sort)->limit($numPerPage)->page($pageCurrent.','.$numPerPage.'')->select();
		$this->assign('list',$list);
		$count = $info->where($where)->count();
		$this->assign('totalCount', $count);
		$this->assign('currentPage', !empty($_GET['pageNum']) ? $_GET['pageNum'] : 1);
		$this->assign('numPerPage', $numPerPage);
		$filters=orgcateTree($pid=0,$level=0,$type=0);
		$this->assign('filters',$filters);
		$this->display();
	}
	
	//2015-07-02 【新增】 商品信息调用
	public function jxcinformation(){
		$info=M('jxcinformation');
		if (isset($_REQUEST ['orderField'])) {$order = $_REQUEST ['orderField'];}
		if($order=='') {$order = $info->getPk();}
		
		if (isset($_REQUEST ['orderDirection'])) {$sort = $_REQUEST ['orderDirection'];}
		//if($sort=='') {$sort = $asc ? 'asc' : 'desc';}
		if($sort=='') {$sort = $asc ? 'desc' : 'asc';}
	
		if (isset($_REQUEST ['pageCurrent'])) {$pageCurrent = $_REQUEST ['pageCurrent'];}
		if($pageCurrent=='') {$pageCurrent =1;}   
		
		$key=I('keys');
		if($key){
			$where['mi_mc'] = array('like','%'.$key.'%');
			$where['mi_bh'] = array('like','%'.$key.'%');
			$where['_logic'] = 'or'; 
		}
		if(IS_POST&&isset($_REQUEST['filter']) && $_REQUEST['filter'] != ''){
			$map['mc_id'] = array('EQ', I('filter'));
			$where['_complex'] = $map;
		}
		
		//2015-05-20 【修改】 分页数量 从用户配置信息中调用
		//$numPerPage=C('PERPAGE');
		$User = M("User"); 
		$numPerPage = $User->where('id='.getuserid().'')->getField('numperpage');
		
		cookie('_currentUrl_', __SELF__);
		$list=$info->where($where)->order("`" . $order . "` " . $sort)->limit($numPerPage)->page($pageCurrent.','.$numPerPage.'')->select();
		$this->assign('list',$list);
		$count = $info->where($where)->count();
		$this->assign('totalCount', $count);
		$this->assign('currentPage', !empty($_GET['pageNum']) ? $_GET['pageNum'] : 1);
		$this->assign('numPerPage', $numPerPage);
		
		
		$filters=cateTree($pid=0,$level=0,'jxccategory');
		$this->assign('filters',$filters);
		$this->display();
	}

	//2015-07-12 【新增】 库存信息调用
	public function jxcwarehouselist(){
		$info=M('jxcwarehouselist');
		if (isset($_REQUEST ['orderField'])) {$order = $_REQUEST ['orderField'];}
		if($order=='') {$order = $info->getPk();}
		
		if (isset($_REQUEST ['orderDirection'])) {$sort = $_REQUEST ['orderDirection'];}
		//if($sort=='') {$sort = $asc ? 'asc' : 'desc';}
		if($sort=='') {$sort = $asc ? 'desc' : 'asc';}
	
		if (isset($_REQUEST ['pageCurrent'])) {$pageCurrent = $_REQUEST ['pageCurrent'];}
		if($pageCurrent=='') {$pageCurrent =1;}   
		
		$User = M("User"); 
		$numPerPage = $User->where('id='.getuserid().'')->getField('numperpage');
		//$id=I('get.id');
		if (isset($_REQUEST['id'])) {$where['mi_id'] = array('eq',$_REQUEST['id']);}
		//if(!empty($id)){$where['mi_id'] = array('eq',$id);}
		cookie('_currentUrl_', __SELF__);
		$list=$info->where($where)->order("`" . $order . "` " . $sort)->limit($numPerPage)->page($pageCurrent.','.$numPerPage.'')->select();
		$this->assign('id',$id);
		$this->assign('list',$list);
		$count = $info->where($where)->count();
		$this->assign('totalCount', $count);
		$this->assign('currentPage', !empty($_GET['pageNum']) ? $_GET['pageNum'] : 1);
		$this->assign('numPerPage', $numPerPage);
		
		$this->display();
	}

	//2015-07-03 【新增】 仓库信息调用
	public function jxcwarehouse(){
		$list=cateTree($pid=0,$level=0,'jxcwarehouse');
		$this->assign('list',$list);
		$type=I('get.type');
		$this->assign('type',$type);	
		$this->display();
	}

	//2015-07-21 【新增】 账户信息调用
	public function jxcaccount(){
		$list=M('jxcaccount')->where(array('status'=>1))->select();
		$this->assign('list',$list);
		$this->display();
	}
   

	//2015-07-21 【新增】 结算方式调用
	public function settlementtype(){
		$list=M('SystemTag')->where("module='SettlementType' and is_del=0")->select();
		$this->assign('list',$list);
		$this->display();
	}

	//2015-07-22 【新增】 生产厂家调用
	public function jxcsuppliers(){
		$type=I('type');
		if(!empty($type)){
			$list=M('jxcsuppliers')->where("ms_type='".$type."' and status=1")->order('ms_mc asc')->select();
		}else{
			$list=M('jxcsuppliers')->where("status=1")->order('ms_mc asc')->select();
		}
		
		$this->assign('list',$list);	
		$this->display();
	}


	public function bumen(){
		$list=orgcateTree($pid=0,$level=0,$type=0);
		$this->assign('list',$list);
		$this->display();
	}
   
	public function zhiwei(){
		$list=M('auth_group')->where(array('type'=>1))->select();
		$this->assign('list',$list);
		$this->display();
	}
   	
	public function hruser(){
		$info=M('hr');
		if (isset($_REQUEST ['orderField'])) {$order = $_REQUEST ['orderField'];}
		if($order=='') {$order = $info->getPk();}
		
		if (isset($_REQUEST ['orderDirection'])) {$sort = $_REQUEST ['orderDirection'];}
		if($sort=='') {$sort = $asc ? 'asc' : 'desc';}
		
		if (isset($_REQUEST ['pageCurrent'])) {$pageCurrent = $_REQUEST ['pageCurrent'];}
		if($pageCurrent=='') {$pageCurrent =1;}   
		
		$key=I('keys');
		if($key){
			$where['xingming'] = array('like','%'.$key.'%');
			$where['gonghao'] = array('like','%'.$key.'%');
			$where['bumen'] = array('like','%'.$key.'%');
			$where['zhiwei'] = array('like','%'.$key.'%');
			$where['_logic'] = 'or'; 
		}
		if(IS_POST&&isset($_REQUEST['filter']) && $_REQUEST['filter'] != ''){
			$map['bumen'] = array('EQ', I('filter'));
			$where['_complex'] = $map;
		}
		$numPerPage=10;
		cookie('_currentUrl_', __SELF__);
		$list=$info->where($where)->order("`" . $order . "` " . $sort)->limit($numPerPage)->page($pageCurrent.','.$numPerPage.'')->select();
		$this->assign('list',$list);
		$count = $info->where($where)->count();
		$this->assign('totalCount', $count);
		$this->assign('currentPage', !empty($_GET['pageNum']) ? $_GET['pageNum'] : 1);
		$this->assign('numPerPage', $numPerPage);
		$filters=orgcateTree($pid=0,$level=0,$type=0);
		$this->assign('filters',$filters);
		$this->display();
	}
   
   public function cname(){
   $info=M('cust');
       if (isset($_REQUEST ['orderField'])) {$order = $_REQUEST ['orderField'];}
		if($order=='') {$order = $info->getPk();}
			
		if (isset($_REQUEST ['orderDirection'])) {$sort = $_REQUEST ['orderDirection'];}
		if($sort=='') {$sort = $asc ? 'asc' : 'desc';}

		if (isset($_REQUEST ['pageCurrent'])) {$pageCurrent = $_REQUEST ['pageCurrent'];}
		if($pageCurrent=='') {$pageCurrent =1;}   
		
       $key=I('keys');
	   if($key){
       $where['title'] = array('like','%'.$key.'%');
	   $where['fenlei'] = array('like','%'.$key.'%');
       $where['xingming'] = array('like','%'.$key.'%');
	   $where['phone'] = array('like','%'.$key.'%');
       $where['_logic'] = 'or'; }
	   if(IS_POST&&isset($_REQUEST['filter']) && $_REQUEST['filter'] != ''){
		 $map['fenlei'] = array('EQ', I('filter'));
		 $where['_complex'] = $map;
		}
   $numPerPage=10;
   cookie('_currentUrl_', __SELF__);
   $list=$info->where($where)->order("`" . $order . "` " . $sort)->limit($numPerPage)->page($pageCurrent.','.$numPerPage.'')->select();
    $this->assign('list',$list);
    $count = $info->where($where)->count();
    $this->assign('totalCount', $count);
    $this->assign('currentPage', !empty($_GET['pageNum']) ? $_GET['pageNum'] : 1);
    $this->assign('numPerPage', $numPerPage); 
    $this->display();
   }
   
   public function proname(){
   $info=M('pro');
       if (isset($_REQUEST ['orderField'])) {$order = $_REQUEST ['orderField'];}
		if($order=='') {$order = $info->getPk();}
			
		if (isset($_REQUEST ['orderDirection'])) {$sort = $_REQUEST ['orderDirection'];}
		if($sort=='') {$sort = $asc ? 'asc' : 'desc';}

		if (isset($_REQUEST ['pageCurrent'])) {$pageCurrent = $_REQUEST ['pageCurrent'];}
		if($pageCurrent=='') {$pageCurrent =1;}   
		
       $key=I('keys');
	   if($key){
       $where['name'] = array('like','%'.$key.'%');
	   $where['fenlei'] = array('like','%'.$key.'%');
       $where['type'] = array('like','%'.$key.'%');
	   $where['title'] = array('like','%'.$key.'%');
       $where['_logic'] = 'or'; }
	   if(IS_POST&&isset($_REQUEST['filter']) && $_REQUEST['filter'] != ''){
		 $map['fenlei'] = array('EQ', I('filter'));
		 $where['_complex'] = $map;
		}
   $numPerPage=10;
   cookie('_currentUrl_', __SELF__);
   $list=$info->where($where)->order("`" . $order . "` " . $sort)->limit($numPerPage)->page($pageCurrent.','.$numPerPage.'')->select();
    $this->assign('list',$list);
    $count = $info->where($where)->count();
    $this->assign('totalCount', $count);
    $this->assign('currentPage', !empty($_GET['pageNum']) ? $_GET['pageNum'] : 1);
    $this->assign('numPerPage', $numPerPage); 
    $this->display();
   }
   
   public function htname(){
   $info=M('hetong');
       if (isset($_REQUEST ['orderField'])) {$order = $_REQUEST ['orderField'];}
		if($order=='') {$order = $info->getPk();}
			
		if (isset($_REQUEST ['orderDirection'])) {$sort = $_REQUEST ['orderDirection'];}
		if($sort=='') {$sort = $asc ? 'asc' : 'desc';}

		if (isset($_REQUEST ['pageCurrent'])) {$pageCurrent = $_REQUEST ['pageCurrent'];}
		if($pageCurrent=='') {$pageCurrent =1;}   
		
       $key=I('keys');
	   if($key){
       $where['jcname'] = array('like','%'.$key.'%');
	   $where['xingming'] = array('like','%'.$key.'%');
       $where['name'] = array('like','%'.$key.'%');
	   $where['title'] = array('like','%'.$key.'%');
       $where['_logic'] = 'or'; }
	   if(IS_POST&&isset($_REQUEST['filter']) && $_REQUEST['filter'] != ''){
		 $map['fenlei'] = array('EQ', I('filter'));
		 $where['_complex'] = $map;
		}
   $numPerPage=10;
   cookie('_currentUrl_', __SELF__);
   $list=$info->where($where)->order("`" . $order . "` " . $sort)->limit($numPerPage)->page($pageCurrent.','.$numPerPage.'')->select();
    $this->assign('list',$list);
    $count = $info->where($where)->count();
    $this->assign('totalCount', $count);
    $this->assign('currentPage', !empty($_GET['pageNum']) ? $_GET['pageNum'] : 1);
    $this->assign('numPerPage', $numPerPage); 
    $this->display();
   }
	
	public function versionshow(){
		$this->display();
    }

	public function helpcenter(){
		$this->display();
    }

	public function feedback(){
		$this->display();
    }
	
	public function down($attach_id) {
		if (getuserid() != '0'){
			$this -> _down($attach_id);
		}
	}

	protected function _down($attach_id) {
		$attach_id = $_REQUEST["attach_id"];
		$file_id = f_decode($attach_id);
		$File = M("Files") -> find($file_id);
		$filepath = $File['folder'].$File['filename'];
		$filePath = realpath($filepath);
		if (file_exists($filePath)) {
			header('Content-Description: File Transfer');
			header('Content-Type: application/octet-stream');
			header('Content-Disposition: attachment; filename='.$File['filedesc']);//basename($filePath)
			header('Content-Transfer-Encoding: binary');
			header('Expires: 0');
			header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
			header('Pragma: public');
			header('Content-Length: ' . filesize($filePath));
			ob_clean();
			flush();
			readfile($filePath);
			exit; 
		}
	}


}