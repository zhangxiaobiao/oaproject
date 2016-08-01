<?php
/**
 * Created by 张世彪.
 * Date: 2016/7/9 20:24
 */
namespace Admin\Controller;

use Think\Controller;
use Think\Page;


class UserController extends CommonController
{
    public function add()
    {
        $model = D('Dept');
        $data = $model->select();
        load('@/tree');
        $data = getTree($data);
        $this->assign('data', $data);
        $this->display();
    }
    public function addOk()
    {
        $post = I('post.');
        $model = D('User');
        $post['addtime'] = time();
        $rst = $model->add($post);
        if ($rst) {
            $this->success('添加成功', U('showList'), 3);
        } else {
            $this->error('添加失败', U('add'), 3);
        }
    }
    public function edit()
    {
        $id = I('get.id');
        $model = D('User');
        $data = $model->where('id=' . $id)->find();
        $dept = D('Dept');
        $deptData = $dept->select();
        load('@/tree');
        $deptData = getTree($deptData);
        $this->assign('deptData', $deptData);
        $this->assign('data', $data);
        $this->display();
    }
    public function editOk()
    {
        $post = I('post.');
        if ($post['password'] == '') {
            $post['password'] = $post['oldpassword'];
        }
        unset($post['oldpassword']);
        $model = D('User');
        $rst = $model->save($post);
        if ($rst) {
            $this->success('修改成功', U('showList'), 3);
        } else {
            $this->error('修改失败', U('edit', array('id'=>$post[id])), 3);
        }

    }
    public function delUser()
    {
        $ids = I('get.ids');
        $model = D('User');
        $rst = $model->delete($ids);
        if ($rst) {
            $this->success('删除成功', U('showList'), 3);
        } else {
            $this->error('删除失败', U('showList'), 3);
        }

    }
    public function chart()
    {
        $model = D('User');
        $rst = $model->field('t1.name as dept_name, count(*) as count')
                     ->table('tp_dept as t1')
                     ->join('inner join tp_user as t2 on t1.pid=t2.dept_id')
                     ->group('dept_name')
                     ->select();
        $str = '[';
        foreach ($rst as $key => $value) {
            $str = $str . "['" . $value['dept_name'] . "'," . $value['count'] . "],";
        }
        $str = rtrim($str, ',');
        $str .= ']';
        $this->assign('data', $str);
        $this->display();
    }
    public function showList()
    {
        $model = D('User');
        $count = $model->count();
        $page = new Page($count, 1);
        $page->lastSuffix = false;
        $page->setConfig('prev', '上一页');
        $page->setConfig('next', '下一页');
        $page->setConfig('first', '首页');
        $page->setConfig('last', '末页');

        $show = $page->show();
        $data = $model->limit($page->fristRow, $page->listRows)->select();
        $dept = D('Dept');
        foreach($data as $key => $value) {
            $info = $dept->find($value['dept_id']);
            $data[$key]['dept_name'] = $info['name'];
        }
        $this->assign('count', $count);
        $this->assign('show', $show);
        $this->assign('data', $data);
        $this->display();
    }
}