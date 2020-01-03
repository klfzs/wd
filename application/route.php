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
    'Material'=>'Material/index',
    'File/:id'=>'Material/File',
    'Question'=>'Question/index',
    'About'=>'About/index',
    'Contact'=>'About/Contact',
    'videolist'=>'Index/VideoList',
    'Branchlist'=>'Index/Branchlist',
    'Studentlist'=>'Index/Studentlist',
    'Article/:id'=>'News/article',
    'Teacherin/:id'=>'Teacher/teacherIn',
    'Message'=>'index/message',
    'Course/:id'=>'Courses/course',
    'teacher/details'=>'About/teacherDetails',
    'branch/:id'=>'Index/branch',
    'login'=>'Login/index',
    'login/login'=>'Login/login',
    'logon'=>'Login/logon',
    'login/logon'=>'Login/zc',
    'user'=>'user/index',
    'user/sex'=>'user/sex',
    'user/addr'=>'user/addr',
    'user/zili'=>'user/zili',
    'user/account'=>'user/account',
    'user/email'=>'user/email',
    'user/emailedit'=>'user/emailedit',
    'user/phone'=>'user/phone',
    'user/phoneedit'=>'user/phoneedit',
    'user/password'=>'user/password',
    'user/passwordedit'=>'user/passwordedit'
];
