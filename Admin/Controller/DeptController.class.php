<?php
/**
 * Created by 张世彪.
 * Date: 2016/7/7 23:35
 */
namespace Admin\Controller;

use Think\Controller;
use Think\Model;

class DeptController extends CommonController{
    public function deptList() {
        $model = D('Dept');
//        循环获取对应的上级分类
//        $data = $model->select();
//        foreach ($data as $key => $value) {
//            $info = $model->field('name')->where('id=' . $value['pid'])->find();
//            //dump($info);die;
//            if ($info['name'] == '') {
//                $data[$key][pid_name] = '顶级分类';
//            } else {
//                $data[$key][pid_name] = $info['name'];
//            }
//        }
//        链表查询获取上级分类
        $data = $model->alias('t1')
                     ->field('t1.*, t2.name as pid_name')
                     ->join('left join tp_dept as t2 on t1.pid = t2.id')
                     ->select();
        load('@/tree');
        $data = getTree($data);
        $this->assign('data', $data);
        $this->display();
    }
    public function add() {
        $model = D('Dept');
        $data = $model->select();
        //dump($data);die;
        $this->assign('data', $data);
        $this->display();
    }
    public function addOk() {
        //$post = I('post.');
        $model = D('Dept');
        $model->create();
        $rst = $model->add();
        if ($rst) {
            $this->success('添加成功', U('add'), 3);
        } else {
            $this->error('添加失败', U('add'), 3);
        }
    }
    public function edit() {
        $id = I('get.id');
        $model = D('Dept');
        $data = $model->find($id);
        $info = $model->where('id !=' . $id)->select();
        $this->assign('data', $data);
        $this->assign('info', $info);
        $this->display();
    }
    public function editOk() {
        $data = I('post.');
        $model = D('Dept');
        $rst = $model->save($data);
        if ($rst !== false) {
            $this->success('修改成功', U('deptList'), 3);
        } else {
            $this->error('修改失败', U('edit', array('id' => $data[id])), 3);
        }
    }
    public function del() {
        $ids = I('get.ids');
        $model = D('Dept');
        $rst = $model->delete($ids);
        if ($rst) {
            $this->success('删除成功', U('deptList'), 3);
        } else {
            $this->error('删除失败', U('deptList'), 3);
        }
    }
}