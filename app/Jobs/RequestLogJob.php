<?php

namespace App\Jobs;

use Illuminate\Support\Facades\Log;
use Seffeng\LaravelHelpers\Helpers\Arr;

class RequestLogJob extends Job
{
    /**
     * 请求参数
     *
     * @author zxf
     * @date   2026-09-29
     * @var array
     */
    private array $requestData;

    /**
     * @author zxf
     * @date   2026-09-29
     * @var string
     */
    private string $fromName;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(array $requestData, string $fromName)
    {
        $this->requestData = $requestData;
        $this->fromName = $fromName;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Log::channel('requestlog')->debug('请求日志：', Arr::merge([
            'fromName' => $this->fromName,
        ], $this->requestData));
    }
}
