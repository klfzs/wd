<?php
namespace app\index\controller;
use app\common\controller\HomeBase;
use think\Db;
use think\Request;
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
      $time= $this->request->param('year');
      $category_model = new CategoryModel();
      $current = $category_model->get(25);
      if (empty($current)) {
          return false;
      }
      $path = explode(',', $current['path']);
      $pid = !empty($path[1]) ? $path[1] : '';
     
      // 当前分类顶级父类
      $parent = $category_model->get($pid);
      //获取视频
      if(!empty($time))
      {
        $student=db('student')->where('time',$time)->paginate(20,false,[
          'query' => Request::instance()->param(),//不丢失已存在的url参数
      ]);
      }else{
        $student=db('student')->paginate(20);
      }
    
    $year=db('student')->field('time')->group('time')->select();
    $this->assign('year',$year);
    $this->assign('time',$time);
      $this->assign('student',$student);
      $this->assign('parent', $parent);
      $this->assign('current',$current);
      return $this->fetch();
    }
    public function message()
    {
      $data= $this->request->param();
      $rec=db('message')->insert($data);
      if($rec==1)
      {
          return json(['type'=>'1','message'=>'报名成功']);
      } else
      {
        return json(['type'=>'0','message'=>'报名失败']);

      }
    }
    public function branch()
    {
      $data= $this->request->param('id');
      $branch=db('branch')->where('id',$data)->find();


   
      //获取所有地区
      $add=db('branch_add')->select();
      //获取每个校区的地址
      //

    
      foreach ($add as $v) {
      
        $addarr[$v['addr']]=db('branch')->where('area',$v['id'])->field('title,address,phone')->select();
      }
      $this->assign('branch',$branch);
      $this->assign('branchlist',$addarr);
     return $this->fetch();
    }
}
