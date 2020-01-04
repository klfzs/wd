<?php
namespace app\index\controller;
use app\common\controller\HomeBase;
use app\common\model\Category as CategoryModel;
use think\Db;
class User extends HomeBase
{
    private $id;
    public function _initialize()
    {
        parent::_initialize();
        if(!session('?user'))
        {
            $this->redirect('/login');
        }
        $this->id=session('user')['id'];
        $user=session('user');
        $user=db('user')->where('id',$user['id'])->find();
        $user['mobile']= substr_replace($user['mobile'],'****','3','4'); 
        $this->assign('user',$user);

    }
   public function index()
   {
       //获取当前用户
       if(!session('?user'))
       {
           $this->redirect('/login');
       }
       $user=session('user');
       $user=db('user')->where('id',$user['id'])->find();
       $user['mobile']= substr_replace($user['mobile'],'****','3','4'); 
       $this->assign('user',$user);
       $this->assign('index',1);
       return $this->fetch();
   }
   public function sex()
   {
    $data=$this->request->param();

   $id= session('user')['id'];
    $res=db('user')->where('id',$id)->update($data);
    if($res)
    {
        return json(['status'=>1,'message'=>'修改成功']);

    }else{
        return json(['status'=>0,'message'=>'修改失败']);

    }
   }
   public function zili()
   {
        //获取当前用户
        if(!session('?user'))
        {
            $this->redirect('/login');
        }
        $user=session('user');
        $user=db('user')->where('id',$user['id'])->find();
        $user['mobile']= substr_replace($user['mobile'],'****','3','4'); 
        $this->assign('user',$user);
        $this->assign('index',6);
        return $this->fetch();
   }
   public function account()
   {
       $this->assign('index',2);
       return $this->fetch();
   }
   public function email()
   {

      return $this->fetch();
   }
   public function emailedit()
   {
    $data=$this->request->param();
    if(!captcha_check($data['captcha'])){
        return json(['status'=>0,'message'=>'验证码错误']);
       }
       unset($data['captcha']);
       $res=db('user')->where('id',$this->id)->update($data);
       if($res)
       {
        return json(['status'=>1,'message'=>'修改成功']);
       }
       else{
        return json(['status'=>0,'message'=>'修改失败']);
       }
   }
   public function phone()
   {
       return $this->fetch();
   }
   public function phoneedit()
   {
    $data=$this->request->param();
        $res=db('user')->where('id',$this->id)->where('mobile',$data['phone'])->find();
        if(empty($res))
        {
            return json(['status'=>0,'message'=>'原手机号码不正确']);
        }
        unset($data['phone']);
        unset($data['captcha']);
       $res=db('user')->where('id',$this->id)->update($data);
       if($res)
       {
        return json(['status'=>1,'message'=>'修改成功']);
       }
       else{
        return json(['status'=>0,'message'=>'修改失败']);
       }
   }
   public function password()
   {
    return $this->fetch();
   }
   public function passwordedit()
   {
    $data=$this->request->param();
    if($data['password']!=$data['password2'])
    {
        
        return json(['status'=>0,'message'=>'两次输入密码不一致']);
    }
    $user=db('user')->where('id',$this->id)->find();
    if($user['password']==md5($data['password1']))
    {
        unset($data['password2']);
        unset($data['password1']);
        $res=db('user')->where('id',$this->id)->update($data);
        if($res)
        {
         return json(['status'=>1,'message'=>'修改成功']);
        }
        else{
         return json(['status'=>0,'message'=>'修改失败']);
        }
    }else
    {
        return json(['status'=>0,'message'=>'原密码不正确']);
    }
   }
   public function question()
   {
     //获取我的提问
    $quiz=db('question')->where('user_id',$this->id)->count();
    //获取我的问答
    $common=db('comment')->where('uid',$this->id)->count();
    //获取我的提问
    $arr=db('question')->alias('a')->join('user u','a.user_id=u.id')->join('comment c','c.qid=a.id','LEFT')->field('u.image,a.id,u.username,a.title,a.create_time,a.status,a.click,a.num')->where('a.user_id',$this->id)->paginate(10);
       $this->assign('arr',$arr);
       $this->assign('num',1);
       $this->assign('common',$common);
       $this->assign('quiz',$quiz);
       $this->assign('index',3);
       return $this->fetch();
   }
   public function Answer()
   {
    //获取我的提问
    $quiz=db('question')->where('user_id',$this->id)->count();
    //获取我的问答
    $common=db('comment')->where('uid',$this->id)->count();
    //获取我的提问
    $comment=db('comment')->where('uid',$this->id)->select();
    
    $qid=[];
    foreach ($comment as $v) {
        $qid[]=$v['qid'];
    }

    $arr=db('question')->alias('a')->join('user u','a.user_id=u.id')->join('comment c','c.qid=a.id','LEFT')->field('u.image,a.id,u.username,a.title,a.create_time,a.status,a.click,a.num')->where('a.id','in',$qid)->paginate(10);
       $this->assign('arr',$arr);
       $this->assign('common',$common);
       $this->assign('quiz',$quiz);
    $this->assign('index',3);
    $this->assign('num',2);
    return $this->fetch('question');
   }
   public function feedback()
   {
       $this->assign('index',4);
       return $this->fetch();
   }
   public function message()
   {
    $data=$this->request->param();
    //获取用户信息
    $user=db('user')->where('id',$this->id)->find();
    $res=db('message')->insert([
        'msg_type'=>1,
        'username'=>$user['username'],
        'sex'=>$user['sex'],
        'phone'=>$user['mobile'],
        'e_mail'=>$user['email'],
        'content'=>$data['message']
    ]);
    if($res)
    {
     return json(['status'=>1,'message'=>'提交成功']);
    }
    else{
     return json(['status'=>0,'message'=>'提交失败']);
    }
   }
}

