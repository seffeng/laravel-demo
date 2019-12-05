# Laravel Demo

## 运行环境
```
php 版本 >= 7.1
```

## 安装部署
```
1、安装
composer install -vvv

2、创建数据库；

3、修改 .env 对应配置，如关闭DEBUG(APP_DEBUG=false)、数据库信息（DB_DATABASE）等；

4、执行迁移脚本创建数据表，初始数据，初始用户：（账号：10086, 密码：123456）；
$ php ./artisan migrate
$ php ./artisan db:seed

5、前台根目录为 /public/www，后台根目录为 /public/admin， API根目录为 /public/api；
```

## 目录说明
```
├─app
│  ├─Common                 公共模块
│  │  ├─Base                    基础接口对象
│  │  ├─Constants               常量定义
│  │  ├─Exceptions              基础异常
│  │  └─Rules                   自定义验证规则
│  ├─Console
│  │  └─Commands            控制台脚本
│  ├─Exceptions
│  ├─Http
│  │  ├─Controllers
│  │  ├─Middleware
│  │  └─Providers
│  ├─Modules                模块管理
│  │  ├─Admin                   管理员
│  │  │  ├─Events                   事件
│  │  │  ├─Exceptions               异常
│  │  │  ├─Illuminate               字段值声明
│  │  │  ├─Listeners                事件监听
│  │  │  ├─Models                   数据表模块
│  │  │  ├─Requests                 表单规则验证
│  │  │  └─Services                 服务处理
│  │  └─User                    用户
│  │      ├─Events                  事件
│  │      ├─Exceptions              异常
│  │      ├─Illuminate              字段值声明
│  │      ├─Listeners               事件监听
│  │      ├─Models                  数据表模块
│  │      ├─Requests                表单规则验证
│  │      └─Services                服务处理
│  └─Web                    WEB应用
│      ├─Admin                  后台应用
│      │  ├─Common                  公共模块
│      │  ├─Controllers             控制器
│      │  │  ├─Admin
│      │  │  ├─Auth
│      │  │  ├─Site
│      │  │  └─Test
│      │  └─Requests                表单验证
│      │      └─Admin
│      ├─Api                    API应用
│      │  └─Controllers
│      │      └─Test
│      └─Www                    前台应用
│          ├─Common
│          ├─Controllers
│          │  ├─Auth
│          │  ├─Site
│          │  └─Test
│          └─Requests
│              └─Auth
├─bootstrap
│  └─cache
├─config
├─database
│  ├─migrations
│  └─seeds
├─public
│  ├─admin                  后台入口
│  ├─api                    api入口
│  └─www                    前台入口
├─resources
│  └─views
│      ├─admin
│      └─www
├─routes
├─storage
│  ├─app
│  │  └─public
│  ├─debugbar
│  ├─framework
│  │  ├─cache
│  │  │  └─data
│  │  ├─sessions
│  │  ├─testing
│  │  └─views
│  │      ├─admin
│  │      ├─api
│  │      └─www
│  └─logs
└─vendor
```

## 项目依赖

| 依赖                   | 仓库地址                                  | 备注 |
| :--------------------- | :---------------------------------------- | :--- |
| seffeng/laravel-basics | https://github.com/seffeng/laravel-basics | 无   |

## 演示地址

无

## 备注

无
