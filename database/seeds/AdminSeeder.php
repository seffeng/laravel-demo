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
        $phone = '10086';
        if (!Admin::where('phone', $phone)->where('delete_id', DeleteConst::NOT)->exists()) {
            $model = new Admin();
            $model->fill([
                'phone' => $phone,
                'password' => '123456',
                'status_id' => StatusConst::NORMAL,
                'delete_id' => DeleteConst::NOT,
                'login_count' => 0,
                'login_at' => 0,
                'login_ip' => 0,
            ]);
            $model->encryptPassword();
            return $model->save();
        }
    }
}
