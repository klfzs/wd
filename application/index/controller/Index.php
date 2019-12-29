<?php
namespace app\index\controller;
use app\common\controller\HomeBase;
use think\Db;
use app\common\model\Category as CategoryModel;
class Index extends HomeBase
{

    public function index()
    {
      $teaarr=[array(),array(),array(),array()];
      //获取语文老师
      $arr=[];
      $yuwen=db('teacher')->where('position',1)->select();
      for ($i=0; $i <count($yuwen) ; $i++) { 
        $arr[]=$yuwen[$i];
        if(count($arr)==5)
        {
          //dump($arryuwen);
          $teaarr[0][]=$arr;
          $arr=[];
        }
      
  
      }
      if(count($arr)>0)
      {
        $teaarr[0][]=$arr;

      }

      //数学老师
      $yuwen=db('teacher')->where('position',2)->select();
      $arr=[];
      for ($i=0; $i <count($yuwen) ; $i++) { 
        $arr[]=$yuwen[$i];
        if(count($arr)==5)
        {
          //dump($arryuwen);
          $teaarr[1][]=$arr;
          $arr=[];
        }
      
  
      }
      if(count($arr)>0)
      {
        $teaarr[1][]=$arr;

      }
      //英语老师
      $yuwen=db('teacher')->where('position',3)->select();
      $arr=[];
   
      for ($i=0; $i <count($yuwen) ; $i++) { 
        $arr[]=$yuwen[$i];
        if(count($arr)==5)
        {
          //dump($arryuwen);
          $teaarr[2][]=$arr;
          $arr=[];
        }
      
  
      }
      if(count($arr)>0)
      {
        $teaarr[2][]=$arr;

      }
      //计算机老师
      $yuwen=db('teacher')->where('position',4)->select();
      $arr=[];
    
      for ($i=0; $i <count($yuwen) ; $i++) { 
        $arr[]=$yuwen[$i];
        if(count($arr)==5)
        {
          //dump($arryuwen);
          $teaarr[3][]=$arr;
          $arr=[];
        }
      
  
      }
      if(count($arr)>0)
      {
        $teaarr[3][]=$arr;

      }
      //获取学员
      $arr=[];
      $studentArry=array();
      $student=db('student')->select();
      for ($i=0; $i <count($student) ; $i++) { 
        $arr[]=$student[$i];
        if(count($arr)==5)
        {
          //dump($arryuwen);
          $studentArry[]=$arr;
          $arr=[];
        }
      
  
      }
      if(count($arr)>0)
      {
        $studentArry[]=$arr;

      }
      //获取课程
      $course=db('course')->limit(5)->select();
      //获取视频

      $video=db('video')->order('order','ASC')->limit(7)->select();
      //获取教学点
      $branch=db('branch')->limit(8)->select();
      $this->assign('branch',$branch);
      $this->assign('video',$video);
      $this->assign('course',$course);
      $this->assign('student',$studentArry);
      $this->assign('teacher',$teaarr);
      return  $this->fetch();
    }
    public function videoList()
    {
      $category_model = new CategoryModel();
      $current = $category_model->get(23);
      if (empty($current)) {
          return false;
      }
      $path = explode(',', $current['path']);
      $pid = !empty($path[1]) ? $path[1] : '';
     
      // 当前分类顶级父类
      $parent = $category_model->get($pid);
      //获取视频
      $video=db('video')->order('order','ASC')->paginate(16);
      $this->assign('video',$video);
      $this->assign('parent', $parent);
      $this->assign('current',$current);
      return $this->fetch();
    }
    public function branchlist()
    {
      $category_model = new CategoryModel();
      $current = $category_model->get(24);
      if (empty($current)) {
          return false;
      }
      $path = explode(',', $current['path']);
      $pid = !empty($path[1]) ? $path[1] : '';
     
      // 当前分类顶级父类
      $parent = $category_model->get($pid);
      //获取视频
    $branch=db('branch')->paginate(16);
      $this->assign('branch',$branch);
      $this->assign('parent', $parent);
      $this->assign('current',$current);
      return $this->fetch();
    }
    public function studentlist()
    {
      $category_model = new CategoryModel();
      $current = $category_model->get(24);
      if (empty($current)) {
          return false;
      }
      $path = explode(',', $current['path']);
      $pid = !empty($path[1]) ? $path[1] : '';
     
      // 当前分类顶级父类
      $parent = $category_model->get($pid);
      //获取视频
    $student=db('student')->paginate(20);
      $this->assign('student',$student);
      $this->assign('parent', $parent);
      $this->assign('current',$current);
      return $this->fetch();
    }
}
