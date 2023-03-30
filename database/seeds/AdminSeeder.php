<?php

use Illuminate\Database\Seeder;
use App\Modules\Admin\Models\Admin;
use App\Common\Constants\DeleteConst;
use App\Common\Constants\StatusConst;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $username = '10086';
        if (!Admin::where('username', $username)->exists()) {
            $model = new Admin();
            $model->fill([
                'username' => $username,
                'password' => 'Aa123456',
                'login_count' => 0,
                'login_at' => 0
            ]);
            $model->loadDefaultValue();
            $model->encryptPassword();
            return $model->save();
        }
    }
}
