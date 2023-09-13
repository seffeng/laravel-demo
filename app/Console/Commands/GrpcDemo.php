<?php

namespace App\Console\Commands;

use App\Grpc\Servers\DemoServer;
use App\Grpc\Demo\DemoRequest;
use App\Grpc\Demo\DemoReply;
use Illuminate\Console\Command;
use Seffeng\LaravelHelpers\Helpers\Json;

class GrpcDemo extends Command
{
    const TYPE_CLIENT = 'client';

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:grpc-demo
                            {type=server : 类型[client-客服端，server-服务端]}
                            {--host=0.0.0.0 : The host of the server.}
                            {--p|port=80 : The port of the server.}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Grpc Demo';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        try {
            $type = $this->argument('type');
            $host = $this->option('host');
            $port = $this->option('port');
            if ($type === self::TYPE_CLIENT) {
                /**
                 * @var \App\Grpc\Clients\DemoClient
                 */
                $client = new \App\Grpc\Clients\DemoClient($host . ':' . $port, [
                    'credentials' => \Grpc\ChannelCredentials::createInsecure(),
                ]);
                $form = new DemoRequest();
                $form->setName('张三');
                $form->setAge(random_int(1, 100));
                /**
                 * @var DemoReply $reply
                 * @var mixed $status
                 */
                list($reply, $status) = $client->sayHello($form)->wait();
                var_dump($reply->getStatus(), $reply->getCode(), $reply->getMessage(), $status);
                $items = [];
                $count = $reply->getDataList()->count();
                if ($count > 0) for ($i = 0; $i < $count; $i++) {
                    $items[] = [
                        'id' => $reply->getDataList()->offsetGet($i)->getId(),
                        'name' => $reply->getDataList()->offsetGet($i)->getName(),
                        'age' => $reply->getDataList()->offsetGet($i)->getAge(),
                    ];
                }
                print_r([
                    'data' => [
                        'id' => $reply->getData()->getId(),
                        'name' => $reply->getData()->getName(),
                        'age' => $reply->getData()->getAge()
                    ],
                    'list' => $items
                ]);
                exit;
            } else {
                $server = new \Grpc\RpcServer();
                $server->addHttp2Port($host . ':' . $port);
                $server->handle(new DemoServer());
                echo '[' . date('Y-m-d H:i:s'). ']Listening on port :' . $port . PHP_EOL;
                $server->run();
            }
        } catch (\Exception $e) {
            throw $e;
        }
    }
}
