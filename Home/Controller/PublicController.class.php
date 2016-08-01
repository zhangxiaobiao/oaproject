<?php
/**
 * Created by 张世彪.
 * Date: 2016/7/7 21:31
 */
namespace Home\Controller;

use Think\Controller;

class PublicController extends Controller{
    public function index(){
        $time = time();
        $this->assign('time', $time);
        $this->display();
    }
    public function redir(){
        $this->error('操作shibai', 'index', 3);
    }
}