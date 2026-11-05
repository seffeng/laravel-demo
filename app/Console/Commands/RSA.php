<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Seffeng\LaravelRSA\Facades\RSA as RSAFacades;

class RSA extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:rsa
                {value : 加密或解密的值}
                {--c|client= : rsa客户端}
                {--d|decrypt : 是否解密，无此选项时为加密}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '测试rsa加密解密';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        try {
            $value = $this->argument('value');
            $client = $this->option('client');
            $decrypt = $this->option('decrypt');
            is_null($client) && $client = config('rsa.client');
            if ($decrypt) {
                $this->info(RSAFacades::loadClient($client)->decrypt(base64_decode($value)));
            } else {
                $this->info(base64_encode(RSAFacades::loadClient($client)->encrypt($value)));
            }
        } catch (\Exception $e) {
            $this->error($e->getMessage());
        }

    }
}
