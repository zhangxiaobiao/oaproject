<?php
/**
 * Created by 张世彪.
 * Date: 2016/7/10 20:21
 */
namespace Admin\Controller;

use Think\Controller;
use Think\Upload;

class DocController extends CommonController
{
    public function showList()
    {
        $model = D('Doc');
        $data = $model->select();
        $this->assign('data', $data);
        $this->display();
    }
    public function add()
    {
        $this->display();
    }
    public function addOk()
    {
        $post = I('post.');
        $post['addtime'] = time();
        $cfg = array(
            'rootPath'   =>   WORKING_PATH . UPLOAD_ROOT_PATH,
        );
        $upload = new Upload($cfg);
        $info = $upload->uploadOne($_FILES['file']);
        if ($info) {
            $post['filepath'] = UPLOAD_ROOT_PATH . $info['savepath'] . $info['savename'];
            $post['filename'] = $info['name'];
            $post['hasfile'] = 1;
        }
        //dump($_FILES);die;
        $model = D('Doc');
        $model->create($post);
        $rst = $model->add();
        if ($rst) {
            $this->success('添加成功', U('showList'), 3);
        } else {
            $this->error('添加失败', U('add'), 3);
        }
    }
    public function download()
    {
        $id = I('get.id');
        $model = D('Doc');
        $rst = $model->find($id);
        $file = WORKING_PATH . $rst['filepath'];
        $filename = $rst['filename'];
        header("Content-Type:application/octet-stream");
        header('Content-Disposition:attachment; filename="' . $filename . '"');
        header("Content-Length:" . filesize($file));
        readfile($file);
    }
    public function content()
    {
        $id = I('get.id');
        $model = D('Doc');
        $data = $model->find($id);
        $content = $data['content'];
        echo html_entity_decode($content);
    }
    public function edit()
    {
        $model = D('Doc');
        if ($_POST['confirm']) {
            $post = I('post.');
            $cfg = array(
                'rootPath' => WORKING_PATH . UPLOAD_ROOT_PATH,
            );
            $upload = new Upload($cfg);
            $info = $upload->uploadOne($_FILES['file']);
            if ($info) {
                $post['filepath'] = UPLOAD_ROOT_PATH . $info['savepath'] . $info['savename'];
                $post['filename'] = $info['name'];
                $post['hasfile'] = 1;
            }
            $model->create($post);
            $rst = $model->save();
            if ($rst) {
                $this->success('修改成功', U('showList'), 3);
                die;
            } else {
                $this->error('修改失败', U('edit' ,array('id' => $post['id'])), 3);
                die;
            }
        }
        $id = I('get.id');
        $data = $model->find($id);
        $this->assign('data', $data);
        $this->display();
    }
    public function del()
    {
        $id = I('get.ids');
        $model = D('Doc');
        $rst = $model->delete($id);
        if ($rst) {
            $this->success('删除成功', U('showList'), 3);
        } else {
            $this->error('删除失败', U('showList'), 3);
        }
    }
}