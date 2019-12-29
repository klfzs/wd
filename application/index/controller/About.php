<?php
namespace app\index\controller;
use app\common\controller\HomeBase;
use think\Request;
use app\common\model\Category as CategoryModel;
use think\Db;
class About extends HomeBase
{
    public function _initialize()
    {
        parent::_initialize();
           $this->assign('nav_id', 31);

    }
    public function index()
    {
     
        $category_model = new CategoryModel();
        $current = $category_model->get(21);
        if (empty($current)) {
            return false;
        }
        $path = explode(',', $current['path']);
        $pid = !empty($path[1]) ? $path[1] : '';
       
        // 当前分类顶级父类
        $parent = $category_model->get($pid);
        //获取招聘信息
        $job=db('job')->select();
        $this->assign('job',$job);
        $this->assign('parent', $parent);
        $this->assign('current',$current);
        return $this->fetch();
    }
    public function Contact()
    {
        $category_model = new CategoryModel();
        $current = $category_model->get(22);
        if (empty($current)) {
            return false;
        }
        $path = explode(',', $current['path']);
        $pid = !empty($path[1]) ? $path[1] : '';
       
        // 当前分类顶级父类
        $parent = $category_model->get($pid);
        $this->assign('parent', $parent);
        $this->assign('current',$current);
        return $this->fetch();
    }




}