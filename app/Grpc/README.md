
#### 在项目根目录通过 protoc 生成类文件
```shell
$ cd ../..
$ protoc --php_out=. app/Grpc/Protos/Demo.proto
# 生成文件目录为 GPBMetadata 和 Demo

# composer 安装 grpc/grpc, google/protobuf
```

#### 服务端示例参考 `app/Grpc/Servers/DemoServer`
```shell
# 启动服务
$ php artisan command:grpc-demo

# 关闭服务，结束进程
$ kill -9 $(ps aux|grep grpc|grep -v grep|awk '{print $1}')
```

#### 客户端示例参考 `app/Grpc/Clients/DemoClient`
```shell
# 请求
$ php artisan command:grpc-demo client
```