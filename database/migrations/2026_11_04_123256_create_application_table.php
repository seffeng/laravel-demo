<?php

use App\Modules\Application\Models\Application;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * @author zxf
     * @date   2026-10-25
     * @var Application
     */
    protected $model;

    /**
     *
     * @author zxf
     * @date   2026-10-25
     */
    public function __construct()
    {
        $this->model = new Application();
    }

    /**
     *
     * @author zxf
     * @date   2026-10-25
     * @return Application
     */
    protected function getModel()
    {
        return $this->model;
    }

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $tableName = $this->getModel()->getTable();
        if (!Schema::hasTable($tableName)) {
            Schema::create($tableName, function (Blueprint $table) {
                $table->bigIncrements('id')->comment('应用ID[自增]');
                $table->string('name', 50)->nullable(false)->default('')->comment('名称');
                $table->string('app_key', 50)->unique()->collation('utf8mb4_bin')->nullable(false)->default('')->comment('APPKEY');
                $table->string('app_secret', 100)->nullable(false)->default('')->comment('APPSECRET');
                $table->string('domain')->nullable(false)->default('')->comment('域名限制');
                $table->string('allow_ip')->nullable(false)->default('')->comment('允许IP[多个,隔开]');
                $table->string('deny_ip')->nullable(false)->default('')->comment('禁止IP[多个,隔开]');
                $table->string('description')->nullable(false)->default('')->comment('描述');
                $table->tinyInteger('status_id')->unsigned()->nullable(false)->default(0)->comment('状态');
                $table->tinyInteger('delete_id')->unsigned()->nullable(false)->default(0)->comment('删除类型');
                $table->integer('created_at')->unsigned()->nullable(false)->default(0)->comment('添加时间');
                $table->integer('updated_at')->unsigned()->nullable(false)->default(0)->comment('修改时间');
                $table->charset = 'utf8mb4';
                $table->engine = 'InnoDB';
                $table->collation = 'utf8mb4_general_ci';
                $table->comment('应用表');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (config('app.env') === 'local' && config('app.debug')) {
            Schema::dropIfExists($this->getModel()->getTable());
        }
    }
};
