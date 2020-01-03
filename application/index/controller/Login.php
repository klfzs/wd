<?php
namespace app\index\controller;
use app\common\controller\HomeBase;
use think\Request;
use think\Db;
use think\Validate;
class Login extends HomeBase
{
    public function _initialize()
    {
        parent::_initialize();
           $this->assign('nav_id', 31);

    }
    public function index()
    {
        if(session('?user'))
        {
          $this->redirect('/');

        }
       
        return $this->fetch();
    }
    public function login()
    {
        $data= $this->request->param();
       //获取密码
       $password=db('user')->where('username',$data['username'])->whereOr('mobile',$data['username'])->find();
       if(empty($password))
       {
            return json(['status'=>0,'message'=>'密码或者账号有误']);
       }
       if($password['password']==md5($data['password']))
       {
        session('user',$password);
        return json(['status'=>1,'message'=>'登录成功']);
       }else{
        return json(['status'=>0,'message'=>'密码或者账号有误']);
       }
    }
    public function logon()
    {
        return $this->fetch();
    }
    public function zc()
    {
        $data= $this->request->param();
        $validate = new Validate([
            'courses'  => 'require|max:25',
            'major' =>  'require|max:25',
            'mobile'=>'require|min:11',
            'password'=>'require'
        ],[
            'courses.require'=>"所属院校不能为空",
            'courses.max'=>"所属院校不能过长",
            'major.require'=>"院校专业不能为空",
            'major.max'=>"院校专业不能过长",
            'mobile.require'=>"手机号不能为空",
            'mobile.min'=>"手机号格式错误",
            'password.require'=>"密码不能为空"

        ]);
       
        if (!$validate->check([
            'courses'=>$data['courses'],
            'major'=>$data['major'],
            'mobile'=>$data['mobile'],
            'password'=>$data['password']


        ])) {
           return json(['status'=>0,'message'=>$validate->getError()]) ;
        }
        
     $phone= db('user')->find(['mobile'=>$data['mobile']]);
        if(!$phone)
        {
            return json(['status'=>0,'message'=>'手机号码已经被注册']) ;
        }   
     
        
       $res= db('user')->insert([
                'username'=>uniqid('文登'),
                'password'=>md5($data['password']),
                'create_time'=>date('Y-m-d H:i:s',time()),
                'mobile'=>$data['mobile'],
                'courses'=>$data['courses'],
                'major'=>$data['major']
       ]);
       if($res)
       {
           return json(['status'=>1,'message'=>'注册成功']);
       }else
       {
        return json(['status'=>0,'message'=>'注册失败']);
       }
    }





}