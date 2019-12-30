<?php
namespace app\index\controller;
use app\common\controller\HomeBase;
use app\common\model\Category as CategoryModel;
use think\Db;
class Teacher extends HomeBase
{
    protected function _initialize()
    {
        parent::_initialize();
        $this->assign('nav_id', 7);
    }
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

          $teacher=db('teacher')->field('id,username,major,image')->paginate(15);
         
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
            $teacher=db('teacher')->where('position',$cid)->field('id,username,major,image')->paginate(15);


        }
        $this->assign('position',$cid);
        $this->assign('parent', $parent);
        $this->assign('current',$current);
        $this->assign('teacher',$teacher);
        return $this->fetch();



    }
    public function teacherIn()
    {
        $id = $this->request->param('id/d');
        $teacher=db('teacher')->where('id',$id)->find();
        $courses=db('courses_teacher')->where('tid',$id)->select();
        $coursesarr=[];
        foreach ($courses as $v) {
    
            $coursesarr[]=db('course')->where('id',$v['cid'])->find();
        }
        dump($coursesarr);
        $this->assign('teacher',$teacher);
        $this->assign('coursesarr',$coursesarr);
       return $this->fetch();
    }
   
}

