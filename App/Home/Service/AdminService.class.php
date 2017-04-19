<?php
namespace Home\Service;

class AdminService extends CommonService {
   
    public function login($admin) {
	
		if (!$this->existAccount($admin['username'])) {
			return array('status' => 0,
				'data' => '用户名或密码不正确！');//2015-06-23 【修改】 'data' => '用户不存在！'
		}

		$account = M('user')->getByUsername($admin['username']);
       
        if ($account['password'] != $this->encrypt($admin['password'])) {
			return array('status' => 0,
				'data' => '用户名或密码不正确！');//2015-06-23 【修改】 'data' => '密码不正确！'
        }
		
		if (isset($_POST['remember']) && $_POST['remember'] == 'true') {
			$data['web_mac']=md5($account['id'].''.time().''.rand_string(10,'3'));
			cookie('YHHttpCookie',$data['web_mac'],2592000);
		} else {
			$data['web_mac']=null;
		}

		session('uid',$account['id']);
		session('username',$account['username']);
		session('username_up',$account['username_up']); //2015-06-20 【新增】 直接上级
		session("truename",$account['truename']);
		session('depname',$account['depname']);
		session('posname',$account['posname']);
		session('loginip',get_client_ip());
		session('logintime',date("Y-m-d H:i:s",time()));
		session('logins',$account['logins']);

        $data['id'] = session('uid');
        $data['logintime'] = date("Y-m-d H:i:s",time());
        $data['loginip'] = get_client_ip();
		$data['logins'] = array('exp','logins+1');
		$data['update_time']=time();
        M("user")->save($data);
		  
        $dat['username'] = session('username');
        $dat['content'] = '登录成功！';
		$dat['os']=$_SERVER['HTTP_USER_AGENT'];
        $dat['url'] = U();
        $dat['addtime'] = date("Y-m-d H:i:s",time());
        $dat['ip'] = get_client_ip();
        M("log")->add($dat);

        return array('status' => 1);
    }

    public function login_auto($web_mac) {
	
		if (!$this->existAccount_auto($web_mac)) {
			cookie('YHHttpCookie',$web_mac,-3600);
			return array('status' => 0,
				'data' => '自动登录失败！');//2015-06-23 【修改】 'data' => '用户不存在！'
		}

		$account = M('user')->getByWeb_mac($web_mac);

		session('uid',$account['id']);
		session('username',$account['username']);
		session('username_up',$account['username_up']); //2015-06-20 【新增】 直接上级
		session("truename",$account['truename']);
		session('depname',$account['depname']);
		session('posname',$account['posname']);
		session('loginip',get_client_ip());
		session('logintime',date("Y-m-d H:i:s",time()));
		session('logins',$account['logins']);

        $data['id'] = session('uid');
        $data['logintime'] = date("Y-m-d H:i:s",time());
        $data['loginip'] = get_client_ip();
		$data['logins'] = array('exp','logins+1');
		$data['update_time']=time();
        M("user")->save($data);
		  
        $dat['username'] = session('username');
        $dat['content'] = '自动登录成功！';
		$dat['os']=$_SERVER['HTTP_USER_AGENT'];
        $dat['url'] = U();
        $dat['addtime'] = date("Y-m-d H:i:s",time());
        $dat['ip'] = get_client_ip();
        M("log")->add($dat);

        return array('status' => 1);
    }

	public function logout() {
		$dat['username'] = session('username');
		$dat['content'] = '退出成功！';
		$dat['os']=$_SERVER['HTTP_USER_AGENT'];
		$dat['url'] = U();
		$dat['addtime'] = date("Y-m-d H:i:s",time());
		$dat['ip'] = get_client_ip();
		M("log")->add($dat);
		if (isset($_COOKIE['YHHttpCookie'])) {
			cookie('YHHttpCookie',$_COOKIE['YHHttpCookie'],-3600);
		}
		session_unset();
		session_destroy();
	}

	public function existAccount($username) {
		if (M('user')->where(array("username"=>$username,"status"=>1))->count() > 0) {
			return true;
		}
		return false;
	}

	public function existAccount_auto($web_mac) {
		if (M('user')->where(array("web_mac"=>$web_mac,"status"=>1))->count() > 0) {
			return true;
		}
		return false;
	}
	
	public function encrypt($data) {
		//return md5(C('AUTH_MASK') . md5($data));
		return md5(md5($data));
	}
}
