# Laravel Demo

## 运行环境
```
php 版本 >= 8.1
```

## 安装部署
```shell
# composer 安装
1、laravel10
$ composer create-project seffeng/laravel-demo

2、laravel8
$ composer create-project seffeng/laravel-demo:~8.0

3、laravel6
$ composer create-project seffeng/laravel-demo:~6.0 --prefer-dist

# 源码 安装
1、安装
$ composer install -vvv
$ php ./artisan key:generate
$ php ./artisan jwt:secret

2、创建数据库；

3、修改 .env 对应配置，如关闭DEBUG(APP_DEBUG=false)、数据库信息（DB_DATABASE）等；

4、执行迁移脚本创建数据表，初始数据，初始用户：（账号：10086, 密码：Aa123456）；
$ php ./artisan migrate --seed

5、前台根目录为 /public/frontend，后台根目录为 /public/backend， API根目录为 /public/api；

6、增加网站应用；
# 1. /public 目录下增加应用入口，nginx配置root；
# 2. /config/packet.php 增加应用设置；
# 3. /app/Web 目录下增加对应应用；
# 4. /routes 目录下增加对应路由；
# 5. 其他：/storage/framework/views、/resources/views。

7、数据库账号密码加密配置；
# .env 文件配置参数 APP_CRYPT=false，若为 true 则 .env 文件中 数据库账号，数据库密码，redis密码需为加密后的字符；
# 可执行命令 php artisan crypt {原始字符}，如：
# 1、数据账号为 root
# 2、执行命令 php artisan crypt root
# 3、将生成的字符填入 .env 配置 DB_USERNAME=生成字符
# 其他需加密的字符配置参考配置文件 config/database.php
```

## 目录说明
```
├─app
│  ├─Common                 公共模块
│  │  ├─Actions                 公共控制器Action
│  │  ├─Base                    基础接口对象
│  │  ├─Constants               常量定义
│  │  ├─Exceptions              基础异常
│  │  ├─Illuminate              字段值声明
│  │  ├─Listeners               事件监听
│  │  └─Rules                   自定义验证规则
│  ├─Console                    控制台应用
│  │  └─Commands                    控制台脚本
│  ├─Grpc                   GRPC应用
│  ├─Http
│  │  └─Middleware              中间件
│  ├─Jobs
│  ├─Modules                模块管理
│  │  ├─Admin                   管理员模块
│  │  │  ├─Events                   事件
│  │  │  ├─Exceptions               异常
│  │  │  ├─Illuminate               字段值声明
│  │  │  ├─Listeners                事件监听
│  │  │  ├─Models                   数据表模块
│  │  │  ├─Requests                 表单规则验证
│  │  │  └─Services                 服务处理
│  │  ├─Log                     日志模块
│  │  └─User                    用户模块
│  ├─Providers
│  └─Web                    WEB应用
│      ├─Api                    API应用
│      │  ├─Common                  后台入口
│      │  ├─Controllers             控制器
│      │  │  ├─Auth
│      │  │  ├─Site
│      │  │  └─Test
│      │  └─Requests                表单规则验证
│      │      └─Auth
│      ├─Backend                后台应用
│      └─Frontend               前台应用
├─bootstrap
│  └─cache
├─config
├─database
│  ├─migrations
│  └─seeds
├─public
│  ├─api                    API入口
│  ├─backend                后台入口
│  └─frontend               前台入口
├─resources
│  ├─lang
│  │  └─zh-CN
│  └─views
│      ├─backend
│      └─frontend
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
│  │      ├─api
│  │      ├─backend
│  │      └─frontend
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

如需使用GRPC，必须先 composer 安装 google/protobuf 和 grpc/grpc 。

## 已有接口

### api/frontend

| 名称     | 地址         | 方式 | 参数              |
| -------- | ------------ | ---- | ----------------- |
| 数据获取 | /down-list   | GET  | type              |
| 登录     | /login       | POST | username,password |
| 登出     | /logout      | POST |                   |
| 是否登录 | /check-login | GET  |                   |
| 登录用户 | /auth        | GET  |                   |
| 修改资料 | /auth        | POST | username          |

### backend

| 名称             | 地址              | 方式 | 参数                 |
| ---------------- | ----------------- | ---- | -------------------- |
| 数据获取         | /down-list        | GET  | type                 |
| 登录             | /login            | POST | username,password    |
| 登出             | /logout           | POST |                      |
| 是否登录         | /check-login      | GET  |                      |
| 登录用户         | /auth             | GET  |                      |
| 修改登录用户资料 | /auth/self-update | POST | username             |
| 管理员列表       | /admin            | GET  |                      |
| 管理员添加       | /admin/create     | POST | username,password    |
| 管理员编辑       | /admin/update     | POST | id,username,password |
| 管理员删除       | /admin/delete     | POST | id                   |
| 管理员启用       | /admin/on         | POST | id                   |
| 管理员停用       | /admin/off        | POST | id                   |
| 用户列表         | /user             | GET  |                      |
| 操作日志         | /operate-log      | GET  |                      |
| 管理员登录日志   | /admin/login-log  | GET  |                      |
| 用户登录日志     | /user/login-log   | GET  |                      |

