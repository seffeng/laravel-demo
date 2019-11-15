<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Modules\Admin\Models\Admin;
use Illuminate\Support\Facades\DB;

class CreateTableAdmin extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $model = new Admin();
        $tableName = $model->getTable();
        if (!Schema::hasTable($tableName)) {
            Schema::create($tableName, function (Blueprint $table) {
                $table->bigIncrements('id')->comment('管理员ID[自增]');
                $table->bigInteger('phone')->index()->nullable(false)->default(0)->comment('手机号');
                $table->string('password', 100)->nullable(false)->default('')->comment('密码');
                $table->tinyInteger('status_id')->unsigned()->nullable(false)->default(0)->comment('状态');
                $table->tinyInteger('delete_id')->unsigned()->nullable(false)->default(0)->comment('删除类型');
                $table->integer('login_count')->unsigned()->nullable(false)->default(0)->comment('登录次数');
                $table->integer('login_at')->unsigned()->nullable(false)->default(0)->comment('登录时间');
                $table->integer('login_ip')->unsigned()->nullable(false)->default(0)->comment('登录IP');
                $table->integer('created_at')->unsigned()->nullable(false)->default(0)->comment('添加时间');
                $table->integer('updated_at')->unsigned()->nullable(false)->default(0)->comment('修改时间');
                $table->charset = 'utf8mb4';
                $table->engine = 'InnoDB';
                $table->collation = 'utf8mb4_general_ci';
            });
            DB::statement('ALTER TABLE `'. DB::connection()->getTablePrefix() . $tableName .'` COMMENT \'管理员表\'');
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //$model = new Admin();
        //Schema::dropIfExists($model->getTable());
    }
}
