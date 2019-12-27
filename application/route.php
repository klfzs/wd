<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2018 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

return [
    '__pattern__' => [
        'name' => '\w+',
    ],
    'News/:id'=>'News/Index',
    'Search'=>'News/Search',
    'School/:id'=>'School/index',
    'Grow/:id'=>'School/Grow',
    'Word/:id'=>'School/Word',
    'Teacher/[:id]'=>'Teacher/index',
    'Courses/[:id]'=>'Courses/Index',
    'Material'=>'Material/index'
];
