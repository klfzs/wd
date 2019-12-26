<?php
namespace app\index\controller;
use app\common\controller\HomeBase;
use app\common\model\Category as CategoryModel;
use think\Db;
class Teacher extends HomeBase
{
    public function index()
    {
        $cid = $this->request->param('id/d');
        $teacher=null;
        if(empty($cid))
        {
            $category_model = new CategoryModel();
            $current = $category_model->get(5);
            if (empty($current)) {
                return false;
            }
            $path = explode(',', $current['path']);
            $pid = !empty($path[1]) ? $path[1] : $cid;
           
            // 当前分类顶级父类
            $parent = $category_model->get($pid);

          $teacher=db('teacher')->field('id,username,major,image')->paginate(10);
         
        }else{
            $category_model = new CategoryModel();
            $id=5+$cid;
            $current = $category_model->get($id);
            if (empty($current)) {
                return false;
            }
            $path = explode(',', $current['path']);
            $pid = !empty($path[1]) ? $path[1] : $cid;
           
            // 当前分类顶级父类
            $parent = $category_model->get($pid);
            $teacher=db('teacher')->where('position',$cid)->field('id,username,major,image')->paginate(10);


        }
        $this->assign('parent', $parent);
        $this->assign('current',$current);
        $this->assign('teacher',$teacher);
        dump($teacher);
        return $this->fetch();



    }
   
}

