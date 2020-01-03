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
}

