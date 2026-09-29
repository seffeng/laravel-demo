<?php

namespace App\Http\Middleware;

use Closure;
use App\Common\Exceptions\BaseException;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use App\Jobs\RequestLogJob;

class RequestLog
{
    /**
     * 仅以下请求方法记录请求日志
     *
     * @author zxf
     * @date   2026-09-29
     * @var array
     */
    private $methods = ['POST', 'PUT', 'DELETE'];

    /**
     *
     * @author zxf
     * @date   2026-09-29
     * @param  Request $request
     * @param  Closure $next
     * @param  string $fromName
     * @return bool
     */
    public function handle($request, Closure $next, string $fromName)
    {
        $response = $next($request);
        try {
            if (config('app.request_debug') && in_array($request->method(), $this->methods)) {
                $headers = $request->headers->all();
                if (isset($headers['authorization'])) {
                    unset($headers['authorization']);
                }
                if (isset($headers['cookie'])) {
                    unset($headers['cookie']);
                }
                $params = $request->all();
                if (isset($params['operateLogParams'])) {
                    unset($params['operateLogParams']);
                }
                $requestData = [
                    'method' => $request->method(),
                    'uri' => $request->path(),
                    'ip' => $request->ip(),
                    'params' => $params,
                    'headers' => $headers,
                ];
                dispatch(new RequestLogJob($requestData, $fromName));
            }
        } catch (BaseException $e) {
            Log::error($e->getMessage());
        } catch (\Exception $e) {
            Log::error($e->getMessage());
        }
        return $response;
    }
}
