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
 * 单例Trait
 * 实现了线程安全的单例模式，防止克隆和反序列化
 */
trait SingletonTrait
{
    /**
     * 单例实例
     *
     * @var self|null
     */
    private static $instance;

    /**
     * 获取单例实例
     * @param mixed ...$args 构造函数参数
     * @return static
     */
    public static function getInstance(...$args)
    {
        if (null === self::$instance) {
            self::$instance = new self(...$args);
        }
        return self::$instance;
    }

    /**
     * 构造函数
     * @param mixed ...$args 构造函数参数
     */
    private function __construct(...$args)
    {
        $this->_initialize(...$args);
    }

    /**
     * 初始化单例实例
     * 子类可以重写此方法来进行初始化操作
     * @param mixed ...$args
     * @return void
     */
    protected function _initialize(...$args)
    {
    }

    /**
     * 防止克隆
     * 确保单例实例不能被克隆
     */
    private function __clone()
    {
        // 抛出异常或直接返回，防止克隆
        throw new Exception('Singleton instance cannot be cloned');
    }

    /**
     * 防止反序列化
     * 确保单例实例不能通过反序列化创建新实例
     */
    public function __wakeup()
    {
        // 抛出异常，防止反序列化
        throw new Exception('Singleton instance cannot be unserialized');
    }
}