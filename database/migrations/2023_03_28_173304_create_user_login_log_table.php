<?php

use App\Modules\Log\Models\UserLoginLog;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * @author zxf
     * @date   2023-08-28
     * @var    UserLoginLog
     */
    protected $model;

    /**
     *
     * @author zxf
     * @date   2023-08-28
     */
    public function __construct()
    {
        $this->model = new UserLoginLog();
    }

    /**
     *
     * @author zxf
     * @date   2023-08-28
     * @return UserLoginLog
     */
    protected function getModel()
    {
        return $this->model;
    }

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $tableName = $this->getModel()->getTable();
        if (!Schema::hasTable($tableName)) {
            Schema::create($tableName, function (Blueprint $table) {
                $table->bigIncrements('id')->nullable(false)->comment('日志ID[自增]');
                $table->bigInteger('user_id')->index()->unsigned()->nullable(false)->default(0)->comment('用户ID[admin.id]');
                $table->tinyInteger('status_id')->unsigned()->nullable(false)->default(0)->comment('状态');
                $table->tinyInteger('type_id')->unsigned()->nullable(false)->default(0)->comment('类型');
                $table->tinyInteger('from_id')->unsigned()->nullable(false)->default(0)->comment('操作源[前台,api...]');
                $table->tinyInteger('delete_id')->unsigned()->nullable(false)->default(0)->comment('删除类型');
                $table->string('content')->nullable(false)->default('')->comment('内容');
                $table->string('login_ip', 39)->nullable(false)->default('')->comment('登录ip');
                $table->integer('created_at')->unsigned()->nullable(false)->default(0)->comment('添加时间');
                $table->integer('updated_at')->unsigned()->nullable(false)->default(0)->comment('修改时间');
                $table->charset = 'utf8mb4';
                $table->engine = 'InnoDB';
                $table->collation = 'utf8mb4_general_ci';
                $table->comment('用户登录日志表');
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (config('app.env') === 'local' && config('app.debug')) {
            Schema::dropIfExists($this->getModel()->getTable());
        }
    }
};
