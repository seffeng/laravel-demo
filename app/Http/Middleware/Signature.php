<?php

namespace App\Http\Middleware;

use Closure;
use App\Common\Exceptions\BaseException;
use App\Modules\Application\Services\ApplicationService;
use Illuminate\Support\Facades\Log;
use Seffeng\LaravelSignature\Middleware\Signature as Middleware;
use Seffeng\LaravelSignature\Facades\Signature as SignatureFacade;
use Seffeng\Signature\Exceptions\SignatureAccessException;
use Seffeng\Signature\Exceptions\SignatureException;
use Seffeng\Signature\Exceptions\SignatureTimeoutException;

class Signature extends Middleware
{
/**
     *
     * {@inheritDoc}
     * @see \Seffeng\LaravelSignature\Middleware\Signature::handle()
     */
    public function handle($request, Closure $next, ?string $server = null)
    {
        $logContent = [];
        $message = '';
        try {
            !is_null($server) && SignatureFacade::setServer($server)->loadServer();
            if (SignatureFacade::getIsDebug()) {
                return $next($request);
            }
            $this->setAccessKeyId($request->header(SignatureFacade::getHeaderAccessKeyId()));
            $this->setTimestamp($request->header(SignatureFacade::getHeaderTimestamp()));
            $this->setSignature($request->header(SignatureFacade::getHeaderSignature()));
            $this->setVersion($request->header(SignatureFacade::getHeaderVersion(), ''));
            $this->setMethod($request->getMethod());
            $uri = $request->getPathInfo();
            $uri = substr($uri, 0, 2) === '//' ? substr($uri, 1) : $uri;
            $this->setUri($uri);
            $logContent = [
                'accessKeyId' => $this->getAccessKeyId(),
                'timestamp' => $this->getTimestamp(),
                'signature' => $this->getSignature(),
                'version' => $this->getVersion(),
                'method' => $this->getMethod(),
                'uri' => $this->getUri()
            ];

            if ($this->getAccessKeyId()) {
                $application = $this->getApplicationService()->notNullByAppKey($this->getAccessKeyId());
                if (!$application->getStatus()->getIsOn()) {
                    throw new BaseException(trans('application.notFound'));
                }
                $this->setAccessKeySecret($application->app_secret);
                if ($application->domain && strpos($request->server('HTTP_REFERER'), $application->domain) === false) {
                    throw new SignatureException(trans('common.signDomainDeny'));
                }
                $this->setAllowIp($application->allowIps);
                $this->setDenyIp($application->denyIps);
                $params = $request->all();
                $logContent['params'] = $params;
                $this->setParams($params);
                if (parent::handle($request, $next)) {
                    $request->merge(['signatureAppId' => $application->id]);
                    return $next($request);
                }
            }
            throw new BaseException(trans('common.signParamRequired'));
        } catch (\Error $e) {
            throw new BaseException(trans('common.signParamRequired'));
        } catch (SignatureTimeoutException $e) {
            $message = '本地时间不准确，请刷新或调整本地时间！';
        } catch (SignatureAccessException $e) {
            $message = $e->getMessage();
        } catch (SignatureException $e) {
            $message = $e->getMessage();
        } catch (\Exception $e) {
            throw $e;
        }

        $logContent['sign'] = SignatureFacade::getSignature();
        $logContent['signString'] = SignatureFacade::getSignString();
        Log::channel('signature')->info($message, $logContent);
        throw new BaseException($message ? $message : trans('common.signInvalid'));
    }

    /**
     *
     * @author zxf
     * @date   2026-10-15
     * @return ApplicationService
     */
    private function getApplicationService()
    {
        return new ApplicationService();
    }
}
