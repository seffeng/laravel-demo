<?php

use App\Modules\User\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * @var User
     */
    protected $model;

    /**
     *
     * @author zxf
     * @date   2026-08-27
     */
    public function __construct()
    {
        $this->model = new User();
    }

    /**
     *
     * @author zxf
     * @date   2026-08-27
     * @return User
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
                $table->bigIncrements('id')->comment('用户ID[自增]');
                $table->string('username', 50)->index()->nullable(false)->default('')->comment('用户名');
                $table->string('password')->nullable(false)->default('')->comment('密码');
                $table->tinyInteger('status_id')->unsigned()->nullable(false)->default(0)->comment('状态');
                $table->tinyInteger('delete_id')->unsigned()->nullable(false)->default(0)->comment('删除类型');
                $table->integer('login_count')->unsigned()->nullable(false)->default(0)->comment('登录次数');
                $table->integer('login_at')->unsigned()->nullable(false)->default(0)->comment('登录时间');
                $table->string('login_ip', 39)->nullable(false)->default('')->comment('登录IP');
                $table->integer('created_at')->unsigned()->nullable(false)->default(0)->comment('添加时间');
                $table->integer('updated_at')->unsigned()->nullable(false)->default(0)->comment('修改时间');
                $table->charset = 'utf8mb4';
                $table->engine = 'InnoDB';
                $table->collation = 'utf8mb4_general_ci';
                $table->comment('用户表');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $tableName = $this->getModel()->getTable();
        if (config('app.env') === 'local' && config('app.debug')) {
            Schema::dropIfExists($tableName);
        }
    }
};
