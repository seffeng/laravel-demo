<?php

namespace App\Grpc\Clients;

class DemoClient extends \Grpc\BaseStub {

    /**
     * @param string $hostname hostname
     * @param array $opts channel options
     * @param \Grpc\Channel $channel (optional) re-use channel object
     */
    public function __construct($hostname, $opts, $channel = null)
    {
        parent::__construct($hostname, $opts, $channel);
    }

    /**
     *
     * @date   2023-06-01
     * @param \App\Grpc\Demo\DemoRequest $request
     * @param array $metadata
     * @param array $options
     * @return mixed
     */
    public function sayHello(\App\Grpc\Demo\DemoRequest $request, $metadata = [], $options = []) {
        return $this->_simpleRequest('/Demo/sayHello',
            $request,
            ['\App\Grpc\Demo\DemoReply', 'decode'],
            $metadata, $options
        );
    }
}