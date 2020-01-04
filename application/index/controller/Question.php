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
        $hot=db('question')->order('click DESC')->field('id,title')->limit(10)->select();
        $this->assign('hot',$hot);
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
        $question=db('question')->alias('a')->join('user u','a.user_id=u.id','LEFT')->field('u.image,a.id,u.username,a.title,a.create_time,a.status,a.click,a.num')->paginate(10);
        //获取热门问题
       
       
        $this->assign('question',$question);
        $this->assign('current',$current);
         $this->assign('parent', $parent);
         return  $this->fetch();
    }
    public function quiz()
    {
       if(!session('?user'))
       {
           $this->redirect('/login.html');
       }
       return $this->fetch();
    }
    public function quizedit()
    {
        $data = $this->request->param();
        if(!session('?user'))
        {
            $this->reditect('/login.html');

        }
        $user=session('user');
       $res= db('question')->insert([
            'user_id'=>$user['id'],
            'title'=>$data['quesition'],
            'content'=>$data['content'],
            'status'=>0,
            'create_time'=>date('Y-m-d H:s:i',time()),
            'publish_time'=>date('Y-m-d H:s:i',time())
        ]);
        if($res)
        {
         return json(['status'=>1,'message'=>'提交成功']);
        }
        else{
         return json(['status'=>0,'message'=>'提交失败']);
        }
       
    }
    
    public function details()
    {
        $id = $this->request->param('id/d');
        db('question')->where('id',$id)->setInc('click');
        $question=db('question')->alias('a')->join('user u','a.user_id=u.id')->field('u.image,a.id,u.username,a.title,a.create_time,a.status,a.click,a.num,a.click,a.like,a.content,a.user_id')->where('a.id',$id)->find();
        //获取评论
        
        $user=session('user');
        $user=db('user')->where('id',$user['id'])->field('image,id')->find();
        //获取会员及回答
        $comment=db('comment')->alias('a')->join('user u','a.uid=u.id')->field('u.image,u.username,a.content,a.create_time,a.status,a.id')->order('create_time DESC')->where('a.qid',$id)->paginate(10);

        $this->assign('comment',$comment);
        $this->assign('user',$user);
        $this->assign('question',$question);
        return $this->fetch();
    
    }
    public function commone()
    {
        if(!session('user'))
        {
            $this->redirect('/login.html');

        }
        $user=session('user');
        $content= $this->request->param();
        $res=db('comment')->insert([
            'uid'=>$user['id'],
            'qid'=>$content['qid'],
            'content'=>$content['content'],
            'create_time'=>date('Y-m-d H:i:s',time()),
            'publish_time'=>date('Y-m-d H:i:s',time())
        ]);
        if($res)
        {
            db('question')->where('id',$content['qid'])->setInc('num');
         return json(['status'=>1,'message'=>'提交成功']);
        }
        else{
         return json(['status'=>0,'message'=>'提交失败']);
        }
    }
    public function caina()
    {
        $id = $this->request->param('id/d');
        db('comment')->where('id',$id)->update([
            'status'=>1
        ]);
        $qid=db('comment')->where('id',$id)->field('qid')->find();
        db('question')->where('id',$qid['qid'])->update([
            'status'=>1

        ]);
        $this->redirect();
    }



}