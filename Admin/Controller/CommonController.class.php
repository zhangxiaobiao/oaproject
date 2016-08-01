<?php
/**
 * Created by 张世彪.
 * Date: 2016/7/19 14:46
 */
namespace Admin\Controller;

use Think\Controller;

class CommonController extends Controller
{
//    public function __construct()
//    {
//        parent::__construct();
//    }
    //thinkphp内置的构造函数，不需要去构造父类
    public function _initialize()
    {
        $uid = session('uid');
        //empty方法只接受变量
        if (empty($uid)) {
            //$this->error('请登录', U('Public/login'), 3);die;
            $url = U('Public/login');
            echo "<script>top.location.href='$url'</script>";die;
        }
        //RBAC权限判断
        //
        $controller = strtolower(CONTROLLER_NAME);
        $action = strtolower(ACTION_NAME);
        $ac = $controller . '/' . $action;

        $roleid = session('roleid');
        $auths = C('RBAC_AUTHS');
        $auth = $auths[$roleid];
        //判断是否是管理员
        if ($roleid != '1') {
            if (!in_array($ac, $auth) && !in_array($controller . '/*', $auth)) {
                $this->error("您没有权限访问当前页面", U('Index/home'), 3);die;
            }
        }
    }
}