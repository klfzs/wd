<?php
namespace app\index\controller;
use app\common\controller\HomeBase;
use think\Request;
use app\common\model\Category as CategoryModel;
use think\Db;
class Question extends HomeBase
{
    public function _initialize()
    {
        parent::_initialize();
           $this->assign('nav_id', 30);

    }
    public function index()
    {
        $category_model = new CategoryModel();
        $current = $category_model->get(19);
        if (empty($current)) {
            return false;
        }
        $path = explode(',', $current['path']);
        $pid = !empty($path[1]) ? $path[1] :'';
        // 当前分类顶级父类
        $parent = $category_model->get($pid);
       //获取问题
        $question=db('question')->alias('a')->join('user u','a.user_id=u.id')->join('comment c','c.qid=a.id','LEFT')->field('u.image,a.id,u.username,a.title,a.create_time,a.status,a.click,a.num')->paginate(10);
        dump($question);

        //获取文章列表
        $this->assign('question',$question);
        $this->assign('current',$current);
         $this->assign('parent', $parent);
         return  $this->fetch();
    }




}