<?php
// +----------------------------------------------------------------------
// | AdminFramework [ 编码如风 极速开发 智慧管控 ]
// +----------------------------------------------------------------------
// | Copyright (c) 2024~2025 http://www.adminframework.com All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 小码农 <phpxmn@gmail.com>
// +----------------------------------------------------------------------
require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/AttrTest.php';

// 创建属性测试实例
$attr = new AttrTest();

// 查看属性值
$attr->getAttribute();

// 设置属性(单个属性)
$attr->setAttribute('name', '小码农');

// 设置属性(数组形式)
$attr->setAttribute([
    'age' => 18,
    'gender' => '男',
    'email' => 'phpxmn@gmail.com',
    'hobby' => [],
]);

// 拼接(字符串)属性
$attr->concatAttribute('gender', '人');

// 追加(数组)属性
$attr->appendAttribute('hobby', '足球');
$attr->appendAttribute('hobby', '篮球');
$attr->setHobby('top', '游泳');
$attr->setHobby([
    'low' => 'test'
]);
$attr->setHobby('a.b.c.e', '游泳');
$attr->setHobby('a.b.c.d', '游泳');

// 删除属性值
$attr->unsetAttribute('age');
$attr->unsetAttribute('hobby.0');

// 调用不存在的方法
$attr->getHobby();
$attr->setName('小码农 ' . date('Y-m-d H:i:s'));
$attr->appendHobby('跑步');
$attr->concatEmail('@adminFramework.com');
$attr->unsetGender();

// 查看属性值
$attr->getAttribute();