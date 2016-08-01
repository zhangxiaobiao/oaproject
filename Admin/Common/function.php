<?php
/**
 * Created by 张世彪.
 * Date: 2016/7/9 18:08
 */
function getName($pid) {
    $model = D('Dept');
    $info = $model->where('id=' . $pid)->select();
    return $info.name;
}
function test() {
    echo phpinfo();
}
