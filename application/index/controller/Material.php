<?php
namespace app\index\controller;
use app\common\controller\HomeBase;
use app\common\model\Category as CategoryModel;
use think\Db;
use think\Request;
class Material extends HomeBase
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
       $this->assign('nav_id', 29);

    }
    public function index()
    {
        $search=$this->request->param();
        $category_model = new CategoryModel();
        $current = $category_model->get(18);
        if (empty($current)) {
            return false;
        }
        $path = explode(',', $current['path']);
        $pid = !empty($path[1]) ? $path[1] : null;
       
        // 当前分类顶级父类
        $parent = $category_model->get($pid);


        //获取年份
        $year=db('material')->field('year')->group('year')->select();
       //获取院校
       $school=db('school')->field('id,name')->select();
      //获取资料
      $data=db('material')->field('id,name,clicks,receive');
        if(!empty($search)){
            if($search['year']!=null)
            {
                         
            
                $data=$data->where('year',$search['year']);
            }
            if($search['school']!=null)
            {
               
                $data=$data->where('school',$search['school']);
            }
            if($search['course']!=null)
            {
            
                $data=$data->where('course',$search['course']);
            }
        }
      
        $data=$data->paginate(20,false,[
            'query' => Request::instance()->param(),//不丢失已存在的url参数
        ]);
        $this->assign('year',$year);
        $this->assign('data',$data);
        $this->assign('school',$school);
        $this->assign('parent', $parent);
        $this->assign('current',$current);
        return $this->fetch();
    
    }
    public function file()
    {
        $id=$this->request->param('id/d');
        //获取文件地址
        $url=db('material')->where('id',$id)->field('url,receive,name')->find();
        $files='/static'.$url['url'];
        //会员下载
        if($url['receive']==1)
        {
            if(!session('?user'))
            {
                $this->redirect('User/login');
            }
        }
        db('material')->where('id',$id)->setInc('Clicks');
        $this->redirect($files);

    }



}