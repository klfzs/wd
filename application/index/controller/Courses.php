<?php
namespace app\index\controller;
use app\common\controller\HomeBase;
use app\common\model\Category as CategoryModel;
use think\Db;
class Courses extends HomeBase
{
    protected function _initialize()
    {
        parent::_initialize();
        $this->assign('nav_id', 13);
    }
    public function index()
    {
        $cid = $this->request->param('id/d');
        $category_model = new CategoryModel();
        if(empty($cid))
        {
          
            $current = $category_model->get(10);
            if (empty($current)) {
                return false;
            }
            $path = explode(',', $current['path']);
            $pid = !empty($path[1]) ? $path[1] : '';
           
            // 当前分类顶级父类
            $parent = $category_model->get($pid);
            $course=db('course')->field('id,course_name,price,oldprice,image')->paginate(15);


        }else
        {

            $id=10+$cid;
            $current = $category_model->get($id);
            if (empty($current)) {
                return false;
            }
            $path = explode(',', $current['path']);
            $pid = !empty($path[1]) ? $path[1] : $cid;
           
            // 当前分类顶级父类
            $parent = $category_model->get($pid);
            $course=db('course')->field('id,course_name,price,oldprice,image')->where('id',$cid)->paginate(15);

        }
          
       
        $this->assign('parent', $parent);
        $this->assign('course',$course);
        $this->assign('current',$current);
        return $this->fetch();



    }
    public function course()
    {
        $id = $this->request->param('id/d');
        $course=db('course')->where('id',$id)->find();
        $this->assign('course',$course);
        return $this->fetch();
    }
   
}

