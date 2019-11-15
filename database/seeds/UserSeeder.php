<?php

use Illuminate\Database\Seeder;
use App\Modules\User\Models\User;
use App\Common\Constants\DeleteConst;
use App\Common\Constants\StatusConst;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $username = 'admin';
        if (!User::where('username', $username)->where('delete_id', DeleteConst::NOT)->exists()) {
            $model = new User();
            $model->fill([
                'username' => $username,
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
