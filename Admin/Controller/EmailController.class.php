<?php
/**
 * Created by 张世彪.
 * Date: 2016/7/18 14:46
 * 站内信模块
 */
namespace Admin\Controller;

use Think\Controller;
use Think\Upload;

class EmailController extends CommonController
{
    public function send()
    {
        $model = D('User');
        $data = $model->where('id !=' . session('uid'))->select();
        $this->assign('data', $data);
        $this->display();
    }
    public function sendOk()
    {
        $post = I('post.');
        $post['from_id'] = session('uid');
        $post['addtime'] = time();
        $post['isread'] = 0;
        if ($_FILES['file']['size'] > 0) {
            $cfg = array(
                'rootPath' => WORKING_PATH . UPLOAD_ROOT_PATH,
            );
            $upload = new Upload($cfg);
            $info = $upload->uploadOne($_FILES['file']);
            if ($info) {
                $post['file'] = UPLOAD_ROOT_PATH . $info['savepath'] . $info['savename'];
                $post['hasfile'] = 1;
                $post['filename'] = $info['name'];
            }
        }
        $model = D('Email');
        $rst = $model->add($post);
        if ($rst) {
            $this->success('发送成功', U('sendBox'), 3);
        } else {
            $this->error('发送失败', U('send'), 3);
        }
    }
    public function sendBox()
    {
        $model = D('Email');
        $data = $model->field('t1.*, t2.truename as to_name')
                        ->table('tp_email as t1, tp_user as t2')
                        ->where('t1.to_id = t2.id and t1.from_id =' . session('uid'))
                        ->select();
        $this->assign('data', $data);
        $this->display();
    }
    public function download()
    {
        $id = I('get.id');
        $model = D('Email');
        $data = $model->find($id);
        $file = WORKING_PATH . $data['file'];
        header("Content-Type:application/octet-stream");
        header('Content-Disposition:attachment; filename="' . basename($file) . '"');
        header("Content-Length:" . filesize($file));
        readfile($file);
    }
    public function del()
    {
        $id = I('get.id');
        $model = D('Email');
        $rst = $model->delete($id);
        if ($rst) {
            $this->success('删除成功', U('sendBox'), 3);
        } else {
            $this->error('删除失败', U('sendBox'), 3);
        }
    }
    public function recBox()
    {
        //select t1.*, t2.truename as from_name
        // from tp_email as t1,tp_user as t2 where t1.from_id=t2.id
        $model = D('Email');
        $data = $model->field('t1.*, t2.truename as from_name')
                        ->table('tp_email as t1,tp_user as t2')
                        ->where('t1.from_id=t2.id and t1.to_id=' . session('uid'))
                        ->select();
        $this->assign('data', $data);
        $this->display();
    }
    //读取邮件
    public function getContent()
    {
        $id = I('get.id');
        $model = D('Email');
        $data = $model->where('to_id = ' . session('uid'))->find($id);
        if ($data) {
            $arr = array('id' => $id, 'isread' => '1');
            $model->save($arr);
            echo $data['content'];
        }
    }
    public function getMsgCount()
    {
        $model = D('Email');
        $count = $model->where('isread = 0 and to_id =' . session('uid'))
                        ->count();
        echo $count;

    }
}