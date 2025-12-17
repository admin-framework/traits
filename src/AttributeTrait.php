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
namespace AdminFramework\Traits;

use PHPUnit\Util\Exception;

/**
 * 属性Trait
 * 实现了对象属性的获取和设置，支持链式调用
 */
trait AttributeTrait
{
    /**
     * 属性容器
     * @var array
     */
    public $_attributes = [];

    /**
     * 获取属性值
     * @param mixed $name 属性名
     * @param mixed $default 默认值
     * @return mixed
     */
    public function getAttribute($name = '', $default = false)
    {
        // 如果属性名为空，则返回所有属性值
        if (in_array($name, [null, false, ''])) {
            return $this->_attributes;
        }

        // 判断当前类是否有当前属性
        if (property_exists(static::class, $name)) {
            return $this->$name;
        }

        // 判断是否有符号
        if (strpos($name, '.') === false) {
            return array_key_exists($name, $this->_attributes) ? $this->_attributes[$name] : $default;
        }

        // 如果属性名包含点号，则说明是多级属性，需要递归获取
        $attribute = $this->_attributes;
        $nameList = explode('.', $name);
        // 遍历属性名数组，获取属性值
        foreach ($nameList as $i) {
            if (array_key_exists($i, $attribute)) {
                // 如果当前属性值是数组，则继续递归获取
                $attribute = $attribute[$i];
            } elseif (is_object($attribute) && property_exists($attribute, $i)) {
                // 如果当前属性值是对象，则继续递归获取
                $attribute = $attribute->$i;
            } else {
                // 如果当前属性值不存在，则返回默认值
                return $default;
            }
        }
        // 返回最终获取到的属性值
        return $attribute;
    }

    /**
     * 设置属性值
     * @param string|int|array $name 属性名
     * @param mixed $value 属性值
     * @return $this
     */
    public function setAttribute($name, $value = false)
    {
        // 如果属性名是数组，则合并数组属性
        if (is_array($name)) {
            $this->_attributes = array_merge($this->_attributes, $name);
            return $this;
        }

        // 判断当前类是否有当前属性
        if (property_exists(static::class, $name)) {
            $this->$name = $value;
            return $this;
        }

        // 如果没有符号，则直接设置数组属性
        if (strpos($name, '.') === false) {
            $this->_attributes[$name] = $value;
            return $this;
        }

        // 如果属性名包含点号，则说明是多级属性，需要递归设置
        $currentArray = &$this->_attributes;

        // 遍历属性名数组，递归设置数组属性
        foreach (explode('.', $name) as $key) {
            // 如果当前数组属性不存在，则创建空数组
            if (!isset($currentArray[$key]) or empty($currentArray[$key])) {
                $currentArray[$key] = [];
            }
            // 如果当前数组属性不是数组类型，则抛出异常
            if (!is_array($currentArray[$key])) {
                throw new Exception("属性 {$name} 不是数组类型");
            }
            // 如果当前数组属性是数组类型，则继续递归设置数组属性
            $currentArray = &$currentArray[$key];
        }

        // 最后将属性值设置到当前数组属性中
        $currentArray = $value;

        // 返回当前对象
        return $this;
    }

    /**
     * 追加属性值
     * @param int|string $name 属性名
     * @param mixed $value 属性值
     * @return $this
     */
    public function appendAttribute($name, $value)
    {
        // 获取当前属性值
        $data = $this->getAttribute($name);

        // 如果当前属性值为空，则直接设置属性值
        if (empty($data)) {
            $this->setAttribute($name, [$value]);
            return $this;
        }

        // 如果当前属性值是数组类型，则在数组后面追加属性值
        if (!is_array($data)) {
            throw new Exception("属性 {$name} 不是数组类型");
        }

        $data[] = $value;
        $this->setAttribute($name, $data);

        // 返回当前对象
        return $this;
    }

    /**
     * 拼接属性值
     * @param int|string $name
     * @param string|int $value 属性值
     * @return $this
     */
    public function concatAttribute($name, $value)
    {
        // 获取当前属性值
        $data = $this->getAttribute($name);

        // 如果当前属性值为空，则直接设置属性值
        if (empty($data)) {
            $this->setAttribute($name, $value);
            return $this;
        }

        // 如果当前属性值是数组类型，则在数组后面追加属性值
        if (!is_string($data) and !is_numeric($data)) {
            throw new Exception("属性 {$name} 不是字符串类型");
        }

        $data .= $value;
        $this->setAttribute($name, $data);

        // 返回当前对象
        return $this;
    }

    /**
     * 删除属性值
     * @param string $name 属性名
     * @return $this
     */
    public function unsetAttribute($name = false)
    {
        // 判断当前类是否有当前属性
        if (property_exists(static::class, $name)) {
            // 如果当前类有当前属性，则直接删除
            unset($this->$name);
            return $this;
        }

        // 如果当前类没有当前属性，则判断是否有符号
        if (strpos($name, '.') === false) {
            unset($this->_attributes[$name]);
            return $this;
        }
        // 如果有符号，则判断是否有数组属性
        $indexList = explode('.', $name);
        // 遍历属性名数组，删除数组属性
        $currentArray = &$this->_attributes;
        // 遍历属性名数组，删除数组属性
        foreach ($indexList as $key) {
            // 如果当前数组属性不存在，则返回当前对象
            if (!isset($currentArray[$key])) {
                return $this;
            }
            // 如果当前属性是数组的最后一个元素，则删除当前数组属性
            if ($key === end($indexList)) {
                unset($currentArray[$key]);
                return $this;
            }
            // 如果当前属性不是数组的最后一个元素，则继续递归删除数组属性
            $currentArray = &$currentArray[$key];
        }

        // 返回当前对象
        return $this;
    }

    /**
     * 调用不存在的方法
     * @param string $name 方法名
     * @param array $arguments 参数
     * @return mixed
     */
    public function __call($name, $arguments)
    {
        // 自定义call方法
        if (method_exists($this, '_call')) {
            return call_user_func_array([$this, '_call'], [$name, $arguments]);
        }

        // 解析方法名
        $names = preg_split('/(?=[A-Z])/', $name);
        // 前缀 取第一个
        $prefix = lcfirst(array_shift($names));

        // 判断方法名是否符合规范
        if (in_array($prefix, ['get', 'set', 'append', 'concat', 'unset'])) {
            // 除去前缀以外，其他的当做属性名称
            $attr = lcfirst(implode('', $names));
            // 合并参数
            $arguments = array_merge([$attr], $arguments);
            // 方法名
            $method = $prefix . 'Attribute';
            // 调用方法
            return call_user_func_array([$this, $method], $arguments);
        }

        throw new Exception("方法 {$name} 不存在");
    }
}