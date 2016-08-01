<?php
/**
 * Created by 张世彪.
 * Date: 2016/7/9 18:28
 */
namespace Admin\Controller;

use Think\Controller;
use Think\Verify;

class TestController extends Controller
{
    public function test()
    {
        dump(session());
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
    public function zhcaptcha()
    {
        $cfg = array(
            'useZh'    => true,
            'useCurve' => false,
            'useNoise' => false,
        );
        $verify = new Verify($cfg);
        $verify->entry();
    }
    public function test()
    {
        $ip = \Org\Net\IpLocation();

    }
}