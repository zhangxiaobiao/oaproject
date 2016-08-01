<?php
/**
 * Created by 张世彪.
 * Date: 2016/7/7 21:52
 */
namespace Admin\Controller;

use Think\Controller;
use Think\Verify;

class PublicController extends Controller{
    public function _initialize()
    {
        $action = strtolower(ACTION_NAME);
        $uid = session('uid');
        if ($uid && $action != 'logout') {
            $this->success('您已成功登录', U('Index/index'), 3);exit;
        }
    }
    public function login(){
        $this->display();
    }
    public function captcha()
    {
        $cfg = array(
            'fontSize' => 12,
            'useCurve' => false,
            'useNoise' => false,
            'imageH'   => 40,
            'imageW'   => 100,
            'length'   => 4,
            'fontttf'  => '5.ttf',
        );
        $verify = new Verify($cfg);
        $verify->entry();
    }
    public function index()
    {
        $post = I('post.');
        $verify = new Verify();
        $rst = $verify->check($post['captcha']);
        if ($rst) {
            unset($post['captcha']);
            $model = D('User');
            $row = $model->where($post)->find();
            if ($row) {
                session('uid', $row['id']);
                session('roleid', $row['role_id']);
                session('username', $row['username']);
                session('nickname', $row['nickname']);
                session('truename', $row['truename']);
                $this->success('登陆成功', U('Index/index'), 3);
            } else {
                $this->error('用户名或密码错误', U('login'), 3);
            }
        }
    }
    public function logout()
    {
        session(null);
        $this->success('退出成功', U('login'), 3);
    }
}