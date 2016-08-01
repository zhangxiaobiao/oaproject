<?php
/**
 * Created by 张世彪.
 * Date: 2016/7/18 16:06
 */
namespace Admin\Controller;

use Think\Controller;

class EmptyController extends Controller
{
    public function _empty()
    {
        $this->display('Empty/error');
    }
}