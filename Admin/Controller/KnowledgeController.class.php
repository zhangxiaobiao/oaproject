<?php
/**
 * Created by 张世彪.
 * Date: 2016/7/18 10:25
 */
namespace Admin\Controller;

use Think\Controller;
use Think\Image;
use Think\Upload;

class KnowledgeController extends CommonController
{
    public function add()
    {
        if ($_POST['sub']) {
            $post = I('post.');
            $post['addtime'] = time();
            if ($_FILES['thumb']['size'] > 0) {
                $cfg = array(
                    'rootPath' => WORKING_PATH . UPLOAD_ROOT_PATH,
                );
                $upload = new Upload($cfg);
                $info = $upload->uploadOne($_FILES['thumb']);
                if ($info) {
                    $post['picture'] = UPLOAD_ROOT_PATH . $info['savepath'] . $info['savename'];
                    $im = new Image();
                    //打开
                    $im->open(WORKING_PATH . $post['picture']);
                    //制作
                    $im -> thumb(100, 100);//等比缩放原则
                    //保存图片
                    $im->save(WORKING_PATH . UPLOAD_ROOT_PATH . $info['savepath'] . 'thumb_' . $info['savename']);
                    $post['thumb'] = UPLOAD_ROOT_PATH . $info['savepath'] . 'thumb_' . $info['savename'];
                }
            }
            $model = D('Knowledge');
            $rst = $model->add($post);
            if ($rst) {
                $this->success('添加成功', U('showList'), 3);
                die;
            } else {
                $this->error('添加失败', U('add'), 3);
                die;
            }
        }
        $this->display();
    }
    public function showList()
    {
        $model = D('Knowledge');
        $data = $model->select();
        $this->assign('data', $data);
        $this->display();
    }

}