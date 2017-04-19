<?php

/**
 *      供应商管理控制器
 *      [ZLSYS] (C)2008-2099  
 *      This is NOT a freeware, use is subject to license terms
 *      http://www.zhelininternet.com
 *      tel:13811836808
 *      qq:185530523
 */

namespace Home\Controller;
use Think\Controller;

class JxcsuppliersController extends CommonController{

	public function _initialize() {
		parent::_initialize();
		$this->dbname = CONTROLLER_NAME;
	}
	
	//function _filter(&$map) {
		//if(!in_array(session('uid'),C('ADMINISTRATOR'))){
		//$map['id'] = array('EQ', session("uid"));
		//}
	//}


	function _filter(&$map) {
		//$map['is_del'] = array('eq', '0');
		if (IS_POST) {
			if (!empty($_REQUEST['keys'])) {
				$keys = $_POST['keys'];
				$map['ms_mc'] = array('like', "%" . $keys . "%");
			}
		}
	}
	
	public function view(){
		$model = D($this->dbname);
		$id = $_REQUEST [$model->getPk()];
		$vo = $model->getById($id);
		$this->assign('Rs', $vo);
		$attid=$vo['attid'];
		$this->assign('attid',$attid);
		$where['attid']=array('eq',$attid);
		$value = M('Jxccontact')->where($where)->order('id asc')->select();
		$list='';
		$i=0;
		foreach($value as $v) {
$list.='<tr>
<td title="No." width="38">'.($i+1).'</td>
<td title="联系人">'.$v['xingming'].'</td>
<td title="性别">'.$v['sex'].'</td>
<td title="手机">'.$v['phone'].'</td>
<td title="座机">'.$v['dianhua'].'</td>
<td title="QQ">'.$v['qq'].'</td>
<td title="联系地址">'.$v['address'].'</td>
<td title="首要">'.$v['first'].'</td>
</tr>
';
			$i++;
		}
		$this->assign('list',$list);
		$this->display();
	}


	public function index(){
		$list_jxccategory=cateTree($pid=0,$level=0,'jxccategory');
		$this->assign('list_jxccategory',$list_jxccategory);
		
		/*$m = M();
		$tablePrefix = C('DB_PREFIX');
		$sql.= "select A.*,B.xingming,B.phone,B.dianhua,B.qq,B.first,C.name as tag_name ";
		$sql.= " from ".$tablePrefix."jxcsuppliers A left join ".$tablePrefix."jxccontact B on A.attid=B.attid left join ".$tablePrefix."system_tag C on A.ms_type=C.id group by id order by A.id desc ";
		$rs = $m->query($sql);
		$this->assign('list',$rs);*/
		
		$model = D('JxcsuppliersView');
		//$map = $this->_search();
		if (method_exists($this, '_filter')) {
			$this->_filter($map);
		}
		//$map['first'] = array('EQ', '是');
		if (!empty($model)) {
			$this->_list($model, $map);
		}
		if (method_exists($this, '_befor_index')) {
			$this->_befor_index();
		}
		$this->display();

	}
	
	/*public function _befor_index(){
		$list_jxccategory=cateTree($pid=0,$level=0,'jxccategory');
		$this->assign('list_jxccategory',$list_jxccategory);
		$model = D('Jxcsuppliers');
		$list = $model->order('sort,id')-> select();
		$this -> assign('list', $list);
		//$this -> display();
	}*/
	
	public function _befor_add(){
		$model1 = D('SystemTag');
		$ms_type_list = $model1 -> get_tag_list('id,name', 'SupplyType');
		$this->assign("ms_type_list", $ms_type_list);
		$attid=get_sid(10);
		$this->assign('attid',$attid);
	}
	
	public function _after_add($id){
	
	}
	
	public function _befor_insert($data){
		$data1['uid']=getuserid();
		$data1['uname']=getusername();
		$data1['addtime']=date("Y-m-d H:i:s",time());
		$data1['attid']=$data['attid'];
		$xingming = I('post.xingming');
		$sex = I('post.sex');
		$phone = I('post.phone');
		$dianhua = I('post.dianhua');
		$qq = I('post.qq');
		$address = I('post.address');
		$first = I('post.first');
		//dump($first);
		//exit();
		$len = 0;
		for ($i=0;$i<count(I('post.first'));$i++) {
			if($first[$i]=='是'){$len++;}
		}
		if ($len > 1) {$this->mtReturn(300,L('_OPERATION_FAIL_').'首要联系人不能选择多个！','',false);return;}
		$del=M("Jxccontact")->where("attid='".$attid."'")->delete();

		for ($i=0;$i<count(I('post.jxccontact'));$i++) {
			$data1['xingming']=$xingming[$i];
			$data1['sex']=$sex[$i];
			$data1['phone']=$phone[$i];
			$data1['dianhua']=$dianhua[$i];
			$data1['qq']=$qq[$i];
			$data1['address']=$address[$i];
			$data1['first']=$first[$i];
			$model1 = M('Jxccontact');
			$list = $model1 -> add($data1);
		}
		
		$data['uid']=getuserid();
		$data['uname']=getusername();
		$data['addtime']=date("Y-m-d H:i:s",time());
		return $data;

	}
	
	public function _befor_edit(){
		$model1 = D('SystemTag');
		$ms_type_list = $model1 -> get_tag_list('id,name', 'SupplyType');
		$this->assign("ms_type_list", $ms_type_list);
		$model = D($this->dbname);
		$Rs = $model->find(I('get.id'));
		$attid=$Rs['attid'];
		$this->assign('attid',$attid);
		$this->assign('Rs',$Rs);
				
		$where['attid']=array('eq',$attid);
		$value = M('Jxccontact')->where($where)->order('id asc')->select();
		$list='';
		$i=0;
		foreach($value as $v) {
			$str_sex1='';
			$str_sex2='';
			$str_first1='';
			$str_first2='';
			if ($v['sex']=='男') {$str_sex1='selected';} else {$str_sex2='selected';}
			if ($v['first']=='是') {$str_first1='selected';} else {$str_first2='selected';}
$list.='<tr data-idname="jxccontact['.$i.'].id" id="jxccontact_edit_'.$i.'">
<th title="No." width="38"><input type="text" readonly="readonly" name="jxccontact['.$i.']" class="no" data-rule="required" value="'.($i+1).'" size="2"></th>
<th title="联系人"><input type="text" name="xingming['.$i.']" data-rule="required;length[~50]" value="'.$v['xingming'].'" size="8" data-group="jxccontact['.$i.']"></th>
<th title="性别"><select name="sex['.$i.']" data-toggle="selectpicker" ><option value="男" '.$str_sex1.'>男</option><option value="女" '.$str_sex2.'>女</option></select></th>
<th title="手机"><input type="text" name="phone['.$i.']" data-rule="mobile" value="'.$v['phone'].'" size="8" data-group="jxccontact['.$i.']"></th>
<th title="座机"><input type="text" name="dianhua['.$i.']" data-rule="length[~20]" value="'.$v['dianhua'].'" size="8" data-group="jxccontact['.$i.']"></th>
<th title="QQ"><input type="text" name="qq['.$i.']" data-rule="digits;length[5~12]" value="'.$v['qq'].'" size="8" data-group="jxccontact['.$i.']"></th>
<th title="联系地址"><input type="text" name="address['.$i.']" data-rule="length[~100]" value="'.$v['address'].'" size="8" data-group="jxccontact['.$i.']"></th>
<th title="首要"><select name="first['.$i.']" data-toggle="selectpicker" ><option value="是" '.$str_first1.'>是</option><option value="否" '.$str_first2.'>否</option></select></th>
<th title="" data-addtool="true" width="65"><a href="'.U('public/flow','id='.$id.'&type=del').'" onclick="del_html_inc(jxccontact_edit_'.$i.')" class="btn btn-red row-del">删</a></th>
</tr>
';
			$i++;
		}
		$this->assign('list',$list);
	}
	
	public function _befor_update($data){
		/* 修改信息保存历史记录 开始 */
		$i=0;
		$model = D($this->dbname);
		$info = $model->find(I('post.id'));
		$id=$info['id'];
		$history=$info['history'];
		$attid=$info['attid'];
		$str_br = '';
		if (!empty($history)) {
			$str_br = '<br>';
		}
		$str=$history.$str_br.gettruename().'['.date("Y-m-d H:i:s",time())."] ";
		if(I('post.ms_type') != $info['ms_type']){
			$str.='类别:'.$info['ms_type'].' 改为 '.I('post.ms_type').';';
			$i++;
		}
		if(I('post.ms_mc') != $info['ms_mc']){
			$str.='名称:'.$info['ms_mc'].' 改为 '.I('post.ms_mc').';';
			$i++;
		}
		if(I('post.ms_bh') != $info['ms_bh']){
			$str.='编号:'.$info['ms_bh'].' 改为 '.I('post.ms_bh').';';
			$i++;
		}
		if(I('post.sort') != $info['sort']){
			$str.='排序:'.$info['sort'].' 改为 '.I('post.sort').';';
			$i++;
		}
		if(I('post.beizhu') != $info['beizhu']){
			$str.='备注:'.$info['beizhu'].' 改为 '.I('post.beizhu').';';
		}
		if(empty($info['uuname'])){
			if(getusername() != $info['uname']){
				$str.='修改用户:'.$info['uname'].' 改为 '.getusername().';';
				$str.='修改时间:'.$info['updatetime'].' 改为 '.date("Y-m-d H:i:s",time()).';';
				$i++;
			}
		} else if(getusername() != $info['uuname']){
			$str.='修改用户:'.$info['uuname'].' 改为 '.getusername().';';
			$str.='修改时间:'.$info['updatetime'].' 改为 '.date("Y-m-d H:i:s",time()).';';
			$i++;
		}
		if ($i > 0) {
			$data['history']=$str;//2015-06-27【新增】修改信息保存历史记录
		}
		/* 修改信息保存历史记录 结束 */
		
		$data1['uid']=getuserid();
		$data1['uname']=getusername();
		$data1['addtime']=date("Y-m-d H:i:s",time());
		$data1['attid']=$attid;
		$xingming = I('post.xingming');
		$sex = I('post.sex');
		$phone = I('post.phone');
		$dianhua = I('post.dianhua');
		$qq = I('post.qq');
		$address = I('post.address');
		$first = I('post.first');
		//dump($first);
		//exit();
		$len = 0;
		for ($i=0;$i<count(I('post.first'));$i++) {
			if($first[$i]=='是'){$len++;}
		}
		if ($len > 1) {$this->mtReturn(300,L('_OPERATION_FAIL_').'首要联系人不能选择多个！','',false);return;}
		//$model0 = M("Jxccontact");		
		$del=M("Jxccontact")->where("attid='".$attid."'")->delete();

		for ($i=0;$i<count(I('post.jxccontact'));$i++) {
			$data1['xingming']=$xingming[$i];
			$data1['sex']=$sex[$i];
			$data1['phone']=$phone[$i];
			$data1['dianhua']=$dianhua[$i];
			$data1['qq']=$qq[$i];
			$data1['address']=$address[$i];
			$data1['first']=$first[$i];
			$model1 = M('Jxccontact');
			$list = $model1 -> add($data1);
		}
		
		$data['uuid']=getuserid();
		$data['uuname']=getusername();
		$data['updatetime']=date("Y-m-d H:i:s",time());
		return $data;
	}
	
	public function _after_edit($id){
	
	}
	
	public function _befor_del($id){
	
	}
	
 /**
 * TODO 上传文件方法
 * @param $fileid form表单file的name值
 * @param $dir 上传到uploads目录的$dir文件夹里
 * @param int $maxsize 最大上传限制，默认1024000 byte
 * @param array $exts 允许上传文件类型 默认array('gif','jpg','jpeg','bmp','png')
 * @return array 返回array,失败status=0 成功status=1,filepath=newspost/2014-9-9/a.jpg
 */
function uploadfile($fileid,$dir,$maxsize=5242880,$exts=array('gif','jpg','jpeg','bmp','png'),$maxwidth=430){
    $upload = new \Think\Upload();// 实例化上传类
    $upload->maxSize   =     $maxsize;// 设置附件上传大小，单位字节(微信图片限制1M
    $upload->exts      =     $exts;// 设置附件上传类型
    $upload->rootPath  =     './uploads/'; // 设置附件上传根目录
    $upload->savePath  =     $dir.'/'; // 设置附件上传（子）目录
    // 上传文件
    $info   =   $upload->upload();

    if(!$info) {// 上传错误提示错误信息
        return array(status=>0,msg=>$upload->getError());
    }else{// 上传成功
        return array(status=>1,msg=>'上传成功',filepath=>$info[$fileid]['savepath'].$info[$fileid]['savename']);
    }
}
	
	public function outxls() {
		$model = D($this->dbname);
		$map = $this->_search();
		if (method_exists($this, '_filter')) {
			$this->_filter($map);
		}
		$list = $model->where($map)->field('id,ms_mc,ms_bh,ms_type,beizhu,addtime,updatetime')->select();
		$headArr=array('ID','名称','编号','类别','备注','添加时间','更新时间');
		$filename='供应商信息管理';
		$this->xlsout($filename,$headArr,$list);
	}
	
	
/*	//上传方法
	public function upload()
	{
        header("Content-Type:text/html;charset=utf-8");
        $upload = new \Think\Upload();// 实例化上传类
        $upload->maxSize   =     3145728 ;// 设置附件上传大小
        $upload->exts      =     array('xls', 'xlsx');// 设置附件上传类
        $upload->savePath  =      '/'; // 设置附件上传目录
        // 上传文件
        $info   =   $upload->uploadOne($_FILES['excelData']);
        $filename = './Uploads'.$info['savepath'].$info['savename'];
        $exts = $info['ext'];
        //print_r($info);exit;
		if(!$info) {// 上传错误提示错误信息
			$this->error($upload->getError());
		}else{// 上传成功
			$this->gys_import($filename, $exts);
		}
    }
*/
	
	//导入数据页面
	public function import()
	{
		if(IS_POST){//上传方法
			header("Content-Type:text/html;charset=utf-8");
			$upload = new \Think\Upload();// 实例化上传类
			$upload->maxSize   =     3145728 ;// 设置附件上传大小
			$upload->exts      =     array('xls', 'xlsx');// 设置附件上传类
			$upload->savePath  =      '/Public/'; // 设置附件上传目录
			// 上传文件
			$info   =   $upload->uploadOne($_FILES['excelData']);
			$filename = './Uploads'.$info['savepath'].$info['savename'];
			$exts = $info['ext'];
			//print_r($info);exit;
			if(!$info) {// 上传错误提示错误信息
				$this->mtReturn(300,"供应商导入失败！",$_REQUEST['navTabId'],false);
			}else{// 上传成功
				$this->gys_import($filename, $exts);
			}
		}
        $this->display();
    }
	
    //导入数据方法
    protected function gys_import($filename, $exts='xls')
    {
        //导入PHPExcel类库，因为PHPExcel没有用命名空间，只能inport导入
        import("Org.Util.PHPExcel");
        //创建PHPExcel对象，注意，不能少了\
        $PHPExcel=new \PHPExcel();
        //如果excel文件后缀名为.xls，导入这个类
        if($exts == 'xls'){
            import("Org.Util.PHPExcel.Reader.Excel5");
            $PHPReader=new \PHPExcel_Reader_Excel5();
        }else if($exts == 'xlsx'){
            import("Org.Util.PHPExcel.Reader.Excel2007");
            $PHPReader=new \PHPExcel_Reader_Excel2007();
        }

        //载入文件
        $PHPExcel=$PHPReader->load($filename);
        //获取表中的第一个工作表，如果要获取第二个，把0改为1，依次类推
        $currentSheet=$PHPExcel->getSheet(0);
        //获取总列数
        $allColumn=$currentSheet->getHighestColumn();
        //获取总行数
        $allRow=$currentSheet->getHighestRow();
        //循环获取表中的数据，$currentRow表示当前行，从哪行开始读取数据，索引值从0开始
        for($currentRow=1;$currentRow<=$allRow;$currentRow++){
            //从哪列开始，A表示第一列
            for($currentColumn='A';$currentColumn<=$allColumn;$currentColumn++){
                //数据坐标
                $address=$currentColumn.$currentRow;
                //读取到的数据，保存到数组$arr中
                $data[$currentRow][$currentColumn]=$currentSheet->getCell($address)->getValue();
            }
        }
        $this->save_import($data);
    }

    //保存导入数据
    public function save_import($data)
    {
        //dump($data);exit;
        $model = M('jxcsuppliers');
        $addtime = date('Y-m-d H:i:s', time());
        foreach ($data as $k=>$v){
            if($k >= 2){
				
                $info[$k-2]['attid'] = get_sid(10);
                $info[$k-2]['uid'] = getuserid();
                $info[$k-2]['uname'] = getusername();
                $info[$k-2]['addtime'] = $addtime;
				$beizhu = $v['D'];
                $info[$k-2]['beizhu'] = $beizhu;
				$ms_mc = $v['A'];
                $info[$k-2]['ms_mc'] = $ms_mc;
				$ms_bh = $v['B'];
                $info[$k-2]['ms_bh'] = $ms_bh;
				$category_title=$v['C'];
                $category_id = M('SystemTag')->where(array('module' => 'SupplyType','name' => $category_title))->getField('id');
                if($category_id){
                    $info[$k-2]['ms_type'] = $category_id;
                }else{
                    $new_category_id = M('SystemTag')->add(array('module' => 'SupplyType','name' => $category_title, 'sort' => $k));
                    $info[$k-2]['ms_type'] = $new_category_id;
                }

                $result = $model->add($info[$k-2]);
            }
        }
		
        if($result){
			$this->mtReturn(200,"供应商导入成功！",$_REQUEST['navTabId'],true);
        }else{
			$this->mtReturn(300,"供应商导入失败！",$_REQUEST['navTabId'],false);
        }
    }
	
	
	

}