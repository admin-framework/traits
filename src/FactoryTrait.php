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

use Exception;

/**
 * 工厂Trait
 * 实现了对象的实例化和管理，支持依赖注入和配置绑定
 */
trait FactoryTrait
{
    /**
     * 实例对象容器
     * @var array
     */
    protected $_instances = [];

    /**
     * 实例化方法
     * @return static
     */
    public static function factory()
    {
        return static::_instance(static::class);
    }

    /**
     * 获取属性对象
     * @param mixed $name
     * @return mixed
     * @throws Exception
     */
    public function __get($name)
    {
        // 前置方法
        if (!isset($this->_instances[$name]) and method_exists($this, '_beforeInstance')) {
            $this->_beforeInstance($name);
        }

        // 如果有方法，则调用方法
        if (method_exists($this, $name)) {
            return $this->$name();
        }

        // 抛出异常
        if (!isset($this->_instances[$name])) {
            $debugInfo = debug_backtrace()[0];
            throw new Exception(self::class . ':' . $name . ' bind Not Found , 异常位置：' . $debugInfo['file'] . ':' . $debugInfo['line']);
        }

        if (is_object($this->_instances[$name])) {
            return $this->_instances[$name];
        }

        // 实例化对象
        return static::_instance($this->_instances[$name]);
    }

    /**
     * 实例化对象
     * @param string $namespace 类名空间
     * @return mixed
     */
    private static function _instance($namespace = '')
    {
        if (empty($namespace)) {
            $namespace = __CLASS__;
        }

        if (!method_exists($namespace, 'getInstance')) {
            $class = new $namespace();
        } else {
            $class = $namespace::getInstance();
        }

        return $class;
    }
}