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
use AdminFramework\Traits\AttributeTrait;

/**
 * 测试属性类
 * @method array getHobby() 获取爱好属性
 * @method self setName(string $name) 设置姓名属性
 * @method self appendHobby(mixed $hobby) 追加爱好属性
 * @method self concatEmail(string $email) 拼接邮箱属性
 * @method self unsetGender() 删除性别属性
 */
class AttrTest
{
    use AttributeTrait;
}