<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Common\Exceptions\BaseException;
use Illuminate\Support\Facades\Validator;
use App\Modules\Application\Requests\ApplicationCreateRequest;
use App\Modules\Application\Services\ApplicationService;
use App\Modules\Application\Requests\ApplicationSearchRequest;

class Application extends Command
{
    /**
     *
     * @var string
     */
    const ACTION_LIST = 'list';
    /**
     *
     * @var string
     */
    const ACTION_CREATE = 'create';

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:application
            {action=list : 操作[list|create]}
            {name? : 应用名称}
            {--debug : 打印}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '应用管理';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        try {
            $action = $this->argument('action');
            $debug = $this->option('debug');
            $name = $this->argument('name');
            if ($action === self::ACTION_CREATE) {
                $form = $this->getCreateRequest();
                $form->setFillItem('name', $name);
                $validator = Validator::make($form->getFillItems(), $form->rules(), $form->messages(), $form->attributes());
                if ($errorItems = $form->getErrorItems($validator)) {
                    throw new BaseException($errorItems['message']);
                }
                if ($debug) {
                    print_r($form->getFillItems());
                    exit;
                }
                if ($this->getService()->create($form)) {
                    $this->info(trans('application.createSuccess'));
                } else {
                    $this->error(trans('application.createFailure'));
                }
            } else {
                $form = $this->getSearchRequest();
                $form->setFillItem('name', $name);
                $items = $this->getService()->getApplicationStore($form);
                print_r($items);exit;
            }
        } catch (\Exception $e) {
            throw $e;
        }
    }

    /**
     *
     * @author zxf
     * @date   2026-10-15
     * @return ApplicationService
     */
    private function getService()
    {
        return new ApplicationService();
    }

    /**
     *
     * @author zxf
     * @date   2026-10-15
     * @return ApplicationSearchRequest
     */
    private function getSearchRequest()
    {
        return new ApplicationSearchRequest();
    }

    /**
     *
     * @author zxf
     * @date   2026-10-15
     * @return ApplicationCreateRequest
     */
    private function getCreateRequest()
    {
        return new ApplicationCreateRequest();
    }
}
