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
    public function list(\App\Grpc\Demo\DemoRequest $request, $metadata = [], $options = []) {
        return $this->_simpleRequest('/demo/list',
            $request,
            ['\App\Grpc\Demo\DemoListReply', 'decode'],
            $metadata, $options
        );
    }

    /**
     *
     * @date   2023-06-01
     * @param \App\Grpc\Demo\DemoRequest $request
     * @param array $metadata
     * @param array $options
     * @return mixed
     */
    public function view(\App\Grpc\Demo\DemoRequest $request, $metadata = [], $options = []) {
        return $this->_simpleRequest('/demo/view',
            $request,
            ['\App\Grpc\Demo\DemoInfoReply', 'decode'],
            $metadata, $options
        );
    }
}