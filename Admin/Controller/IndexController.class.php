<?php
/**
 * Created by 张世彪.
 * Date: 2016/7/10 18:34
 */
namespace Admin\Controller;

//引入父类控制器元素
use Think\Controller;

//定义控制器类
class IndexController extends CommonController{

    public function index(){
        $this -> display();	//展示模版
    }

    //展示iframe主页面 home.html
    public function home(){
        $this -> display();
    }
    public function _empty()
    {
        $this->display('Empty/error');
    }
}