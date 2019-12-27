<?php
namespace app\index\controller;
use app\common\controller\HomeBase;
use app\common\model\Category as CategoryModel;
use think\Db;
class School extends HomeBase
{
    protected function _initialize()
    {
        parent::_initialize();
        $this->assign('nav_id', 2);
    }
    public function index()
    {
        $cid = $this->request->param('id/d');
        $category_model = new CategoryModel();
        $current = $category_model->get($cid);
        if (empty($current)) {
            return false;
        }
        $path = explode(',', $current['path']);
        $pid = !empty($path[1]) ? $path[1] : $cid;
       
        // 当前分类顶级父类
        $parent = $category_model->get($pid);
        $this->assign('parent', $parent);
        $this->assign('current',$current);
        return $this->fetch();
    }
    public function grow()
    {
        $cid = $this->request->param('id/d');
        $category_model = new CategoryModel();
        $current = $category_model->get($cid);
        if (empty($current)) {
            return false;
        }
        $path = explode(',', $current['path']);
        $pid = !empty($path[1]) ? $path[1] : $cid;
       
        // 当前分类顶级父类
        $parent = $category_model->get($pid);
        $this->assign('parent', $parent);
        $this->assign('current',$current);
        return $this->fetch();
    }
    public function word()
    {
        $cid = $this->request->param('id/d');
        $category_model = new CategoryModel();
        $current = $category_model->get($cid);
        if (empty($current)) {
            return false;
        }
        $path = explode(',', $current['path']);
        $pid = !empty($path[1]) ? $path[1] : $cid;
       
        // 当前分类顶级父类
        $parent = $category_model->get($pid);
        $this->assign('parent', $parent);
        $this->assign('current',$current);
        return $this->fetch();
    }


}

