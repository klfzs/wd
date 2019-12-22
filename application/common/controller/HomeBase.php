<?php

namespace app\common\controller;

use think\Cache;
use think\Controller;
use think\Db;
use app\common\model\Category as CategoryModel;

class HomeBase extends Controller
{
    protected function _initialize()
    {
        parent::_initialize();
        $this->getSystem();
        $this->getNav();
        $this->getRecommendList();
        $this->getSlide();
        $this->getLink();
        //$this->getPubCat();
    }

    /**
     * 获取站点信息
     */
    protected function getSystem()
    {
        $site_config = Db::name('system')->field('value')->where('name', 'site_config')->find();
        $site_config = unserialize($site_config['value']);
        $this->assign('site', $site_config);
    }

    /**
     * 获取前端导航列表
     */
    protected function getNav()
    {
        $nav = Db::name('nav')->where(['status' => 1])->order(['sort' => 'ASC', 'id' => 'ASC'])->select();
        $nav = !empty($nav) ? array2tree($nav) : [];

        $parts = parse_url($_SERVER['REQUEST_URI']);
        $this->assign('path', $parts['path']);
        $this->assign('nav', $nav);
    }

    /**
     * 获取推荐文章
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    protected function getRecommendList()
    {
        $recommend_list = Db::name('article')->field(['id', 'cid', 'title', 'introduction', 'thumb', 'reading', 'publish_time'])->where(['cid' => 6])->order(['sort' => 'ASC'])->limit(12)->select();
        foreach ($recommend_list as &$value) {
            $value['title'] = $value['title'] ? mb_substr($value['title'], 0, 22, 'utf-8') : '';
        }
    
        $this->assign('recommend_list', $recommend_list);
    }

    /**
     * 获取前端轮播图
     */
    protected function getSlide()
    {
        $slide = Db::name('slide')->where(['status' => 1, 'cid' => 1])->order(['sort' => 'DESC'])->select();
        $this->assign('slide', $slide);
    }

    protected function getLink()
    {
        $slide = Db::name('link')->where(['status' => 1])->order(['sort' => 'DESC'])->select();
        $this->assign('link', $slide);
    }

    /*protected function getPubCat()
    {
        $cid = $this->request->param('id/d');
        $category_model = new CategoryModel();

        // 当前分类
        $current = $category_model->get($cid);
        if (empty($current)) {
            return false;
        }

        $path = explode(',', $current['path']);
        $pid = !empty($path[1]) ? $path[1] : $cid;
        // 当前分类顶级父类
        $parent = $category_model->get($pid);

        //当前平级分类
        $cat_list = Db::name('category')->where(['pid' => $parent['id']])->order('sort', 'ASC')->select();

        $this->assign('parent', $parent);
        $this->assign('current', $current);
        $this->assign('cat_list', $cat_list);
    }*/

}