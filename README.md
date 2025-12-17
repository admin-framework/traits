# AdminFramework Traits

> AdminFramework Traits 提供了一组实用的 PHP Trait，用于快速实现常见的设计模式和功能特性。

<p align="center"> 
    <a href="https://github.com/admin-framework/traits/blob/main/LICENSE" target="_blank"> 
        <img src="https://poser.pugx.org/admin-framework/traits/license" alt="License"> 
    </a> 
    <a href="https://github.com/admin-framework/traits" target="_blank"> 
        <img src="https://img.shields.io/badge/PHP-%3E%3D5.6-blue" alt="PHP Version Require"> 
    </a> 
    <a href="https://github.com/admin-framework/traits/releases" target="_blank"> 
        <img src="https://img.shields.io/github/v/release/admin-framework/traits" alt="Latest Stable Version"> 
    </a> 
</p>

## 目录结构

```
src/
├── AttributeTrait.php    # 属性管理Trait
├── FactoryTrait.php      # 工厂模式Trait
└── SingletonTrait.php    # 单例模式Trait
```

## composer 安装

```bash
composer require admin-framework/traits
```

## 使用示例

查看文件 `example/index.php` , `example/AttrTest.php` 中的示例代码。

## AttributeTrait

### 功能描述

实现了灵活的对象属性管理，支持：

- 普通属性的获取和设置
- 链式调用
- 多级属性访问（支持点号分隔）
- 属性追加、拼接和删除
- 魔术方法支持（如 getXXX, setXXX）

## FactoryTrait

### 功能描述

实现了工厂模式，支持：

- 静态工厂方法
- 对象依赖注入
- 实例管理

## SingletonTrait

### 功能描述

实现了线程安全的单例模式，确保：

- 类只有一个实例
- 提供全局访问点
- 防止克隆
- 防止反序列化

## 许可证

MIT License

## 作者

小码农 <phpxmn@gmail.com>
