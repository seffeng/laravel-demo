<?php

namespace App\Grpc\Servers;

use App\Grpc\Demo\Data;

class DemoServer
{
    public function sayHello(\App\Grpc\Demo\DemoRequest $request, \Grpc\ServerContext $context ): ?\App\Grpc\Demo\DemoReply
    {
        $response = new \App\Grpc\Demo\DemoReply();
        $name = $request->getName();
        $age = $request->getAge();
        $response->setMessage('success!!!');
        $response->setCode(200);
        $response->setStatus('success');
        $response->setData(new Data(['id' => random_int(1, 100), 'name' => $name, 'age' => $age]));
        $context->setStatus(\Grpc\Status::ok());
        return $response;
    }

    public final function getMethodDescriptors(): array
    {
        return [
            '/Demo/sayHello' => new \Grpc\MethodDescriptor(
                $this,
                'sayHello',
                'App\Grpc\Demo\DemoRequest',
                \Grpc\MethodDescriptor::UNARY_CALL
            ),
        ];
    }
}