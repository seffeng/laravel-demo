<?php

namespace App\Grpc\Servers;

use App\Grpc\Demo\Data;
use App\Grpc\Demo\DataList;
use App\Grpc\Demo\DataType;
use App\Grpc\Demo\Page;

class DemoServer
{
    public function getList(\App\Grpc\Demo\DemoRequest $request, \Grpc\ServerContext $context ): ?\App\Grpc\Demo\DemoListReply
    {
        $response = new \App\Grpc\Demo\DemoListReply();
        $name = $request->getName();
        $age = $request->getAge();
        $response->setMessage('success!');
        $response->setCode(200);
        $response->setStatus('success');
        $id = random_int(1, 100);
        $response->setData(new DataList([
            'items' => [
                new Data(['id' => ++$id, 'name' => $name . $id, 'age' => new DataType(['id' => ++$age, 'name' => $age . ' 岁'])]),
                new Data(['id' => ++$id, 'name' => $name . $id, 'age' => new DataType(['id' => ++$age, 'name' => $age . ' 岁'])]),
                new Data(['id' => ++$id, 'name' => $name . $id, 'age' => new DataType(['id' => ++$age, 'name' => $age . ' 岁'])])
            ],
            'page' => new Page([
                'totalCount' => 3,
                'currentPage' => 1,
                'pageCount' => 1,
                'perPage' => 10,
            ])
        ]));
        $context->setStatus(\Grpc\Status::ok());
        return $response;
    }

    public function view(\App\Grpc\Demo\DemoRequest $request, \Grpc\ServerContext $context ): ?\App\Grpc\Demo\DemoInfoReply
    {
        $response = new \App\Grpc\Demo\DemoInfoReply();
        $name = $request->getName();
        $age = $request->getAge();
        $response->setMessage('success!');
        $response->setCode(200);
        $response->setStatus('success');
        $id = random_int(1, 100);
        $response->setData(new Data(['id' => ++$id, 'name' => $name . $id, 'age' => new DataType(['id' => ++$age, 'name' => $age . ' 岁'])]));
        $context->setStatus(\Grpc\Status::ok());
        return $response;
    }

    public final function getMethodDescriptors(): array
    {
        return [
            '/demo/list' => new \Grpc\MethodDescriptor(
                $this,
                'getList',
                'App\Grpc\Demo\DemoRequest',
                \Grpc\MethodDescriptor::UNARY_CALL
            ),
            '/demo/view' => new \Grpc\MethodDescriptor(
                $this,
                'view',
                'App\Grpc\Demo\DemoRequest',
                \Grpc\MethodDescriptor::UNARY_CALL
            ),
        ];
    }
}