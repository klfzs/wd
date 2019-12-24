<?php
namespace app\index\controller;
use app\common\controller\HomeBase;
use app\common\model\Category as CategoryModel;
use think\Db;
class News extends HomeBase
{
    public function _initialize()
    {
        parent::_initialize();
        //获取最热新闻
       $hot=db('article')->field('id,title')->where('cid',6)->where('is_recommend',1)->limit(6)->select();
       //获取最新资讯
       $new=db('article')->field('id,title')->where('cid',6)->order('create_time DESC')->limit(6)->select();
       $this->assign('hot',$hot);
       $this->assign('new',$new);
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
       


        //获取文章列表
        $news=db('article')->field('id,author,introduction,thumb,create_time,title')->order('is_top DESC')->where('cid',6)->paginate(10);
         $this->assign('news',$news);
         $this->assign('parent', $parent);
         return  $this->fetch();
    }




}