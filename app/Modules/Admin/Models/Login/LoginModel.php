<?php

/**
 * LoginModel
 * Model processing for login page
 *
 * 処理概要/process overview  : LoginModel
 * 作成日/create date         : 2021/05/26
 * 作成者/creater             : QuyPN
 *
 * 更新日/update date         :
 * 更新者/updater             :
 * 更新内容 /update content   :
 *
 * @package Modules/Admin
 * @copyright Copyright (c) toploop.co
 * @version 1.0.0
 */

namespace App\Modules\Admin\Models\Login;

use Illuminate\Support\Facades\DB;
use Helper, DataResponse, ResponseCode;
use DateTime, DateInterval;

class LoginModel
{
    protected $expires = 2000;
    /**
     * CheckLogin
     * Created: 2021/08/12
     * @author QuyPN <quy.pham@toploop.co>
     *          TriTD <tritd@toploop.co>
     * @param  Array $user Data login from client
     * @return DataResponse Result of check login
     */
    public function CheckLogin($user)
    {
        try {
            $response = new DataResponse();
            $userDB = DB::table('users')
                ->where('email', $user['username'])
                //->where('deleted_at', null)
                ->select('id', 'email', 'password')
                ->get()->toArray();
            if (!isset($userDB) || empty($userDB)) {
                $response->msgNo = 'E014';
                $response->code = ResponseCode::HAVE_ERROR;
            }
            else if (md5($user['password']) != $userDB[0]->password) {
                $response->msgNo = 'E015';
                $response->code = ResponseCode::HAVE_ERROR;
            }
            else {
                $token = Helper::GenerateRandomString();
                $timeout = new DateTime(date('Y-m-d H:i:s'));
                $timeout->add(new DateInterval('PT' . $this->expires . 'M'));
                $updateUser = DB::table('users')->where('id', $userDB[0]->id);
                $updateUser->update([
                    'token' => $token,
                    'timeout' => $timeout,
                    'updated_at' => date('Y-m-d H:i:s'),
                ]);
                $response->data['token'] = $token;
                $response->data['expires'] = $this->expires;
            }
            return $response;
        }
        catch(\Exception $e) {
            throw $e;
        }
    }
    /**
     * Refresh token
     * Created: 2021/05/26
     * @author QuyPN <quy.pham@toploop.co>
     * @param  String $token old token
     * @return DataResponse New token and expires
     */
    public function RefreshToken()
    {
        try {
            $response = new DataResponse();
            $now = new DateTime(date('Y-m-d H:i:s'));
            $userId = Helper::GetCurrentUserId();
            if ($userId > 0) {
                $token = Helper::GenerateRandomString();
                $timeout = new DateTime(date('Y-m-d H:i:s'));
                $timeout->add(new DateInterval('PT' . $this->expires . 'M'));
                DB::table('users')
                    ->where('id', $userId)
                    ->update([
                        'token' => $token,
                        'timeout' => $timeout,
                        'updated_at' => date('Y-m-d H:i:s'),
                        'updated_by' => $userId
                    ]);
                $response->data['token'] = $token;
                $response->data['expires'] = $this->expires;
            }
            return $response;
        }
        catch(\Exception $e) {
            throw $e;
        }
    }
    /**
     * Logout
     * Created: 2021/05/26
     * @author QuyPN <quy.pham@toploop.co>
     * @return DataResponse Result of check login
     */
    public function Logout()
    {
        try {
            $response = new DataResponse();
            $userId = Helper::GetCurrentUserId();
            $userDB = DB::table('users')->where('id', $userId);
            if (isset($userDB) && !empty($userDB)) {
                $userDB->update([
                    'token' => '',
                    'timeout' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                    'updated_by' => $userDB->id
                ]);
            }
            return $response;
        }
        catch(\Exception $e) {
            throw $e;
        }
    }
}
