<?php

/**
 * UserDetailModel
 * Model processing for page Users detail
 *
 * 処理概要/process overqueryew  : UserDetailModel
 * 作成日/create date         : 2021/05/28
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

namespace App\Modules\Admin\Models\UsersManagement;

use Illuminate\Support\Facades\DB;
use Helper, DataResponse, ResponseCode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;



class UserDetailModel
{
    /**
     * Get data User follow id
     * Created: 2021/05/28
     * @author Sonnt <ntson12a4@gmail.com>
     * @param  int $id Id of User
     * @return Array Data of User
     */
    public function LoadUser($id)
    {
        try {
            $userId = Helper::GetCurrentUserId();
            $query = DB::table("users")
                ->where('id', '!=', $userId)
                ->where('id', $id)
                ->where('deleted_at', null)
                ->first();
            $mode = 'I';
            if (isset($query) && !empty($query)) {
                $mode = 'U';
                $query->created_by = Helper::GetUsername($query->created_by);
                $query->updated_by = Helper::GetUsername($query->updated_by);
            }
            return [
                'query'    => $query,
                'mode'  => $mode
            ];
        } catch (\Exception $e) {
            throw $e;
        }
    }

    /**
     * Update User
     * Created: 2021/05/31
     * @author Sonnt <ntson12a4@gmail.com>
     * @param  Array $data Data of User from client
     * @return Array updated result
     */
    public function UpdateUser($data)
    {
        try {
            $listUser = DB::table('users')
                ->where('username', $data['username'])
                ->where('deleted_at', null)
                ->select('username')
                ->get()->toArray();
            $response = new DataResponse();
            $userId = Helper::GetCurrentUserId();
            if ($userId == $data['id']) {
                $response->code = ResponseCode::HAVE_ERROR;
                $response->msgNo = 'E048';
            } else {
                if (!isset($listUser) || empty($listUser)) {
                 DB::table('users')
                        ->where('deleted_at', null)
                        ->where('id', $data['id'])
                        ->update([
                            'username' => $data['username'],
                            'name' => $data['name'],
                            'address' => $data['address'],
                            'email' => $data['email'],
                            'phone' => $data['phone'],
                            'updated_at' => date('Y-m-d H:i:s'),
                            'updated_by' => $userId
                        ]);  Mail::send('Admin::UsersManagement.UpdateUser', [
                            'email' => $data['email'],
                            'username' => $data['username'],
                            'name' => $data['name'],
                            'updated_at' => date('Y-m-d H:i:s'),
                        ], function ($mail) use ($data) {
                            $mail->to($data['email']);
                            $mail->subject("Update User");
                        });
                    $response->data['id'] = $data['id'];
                } else {
                    $response->msgNo = 'E015';
                    $response->code = ResponseCode::HAVE_ERROR;
                }
            }
            return $response;
        } catch (\Exception $e) {
            throw $e;
        }
    }

    public function ResetPassword($data)
    {
        try {
            $response = new DataResponse();
            $temp = str_random(8);
            // Reset Password
          DB::table('users')
                ->where('deleted_at', null)
                ->where('id', $data['id'])
                ->select('username')
                ->update([
                    'password' => md5(md5($temp)),
                ]);
            $response->data['id'] = $data['id'];
            Mail::send('Admin::UsersManagement.ResetPassword', [
                'email' => $data['email'],
                'username' => $data['username'],
                'name' => $data['name'],
                'password' => $temp,
            ], function ($mail) use ($data) {
                $mail->to($data['email']);
                $mail->subject("Reset Password");
            });
            return $response;
        } catch (\Exception $e) {
            throw $e;
        }
    }
    /**
     * Insert new User
     * Created: 2021/05/31
     * @author Sonnt <ntson12a4@gmail.com>
     * @param  Array $data Data of User from client
     * @return Array inserted result
     */
    public function InsertUser($data)
    {
        try {
            $listUser = DB::table('users')
                ->where('username', $data['username'])
                ->where('deleted_at', null)
                ->select('username')
                ->get()->toArray();
            $response = new DataResponse();
            $newId = Helper::GetId('users');
            $userId = Helper::GetCurrentUserId();
            if (!isset($listUser) || empty($listUser)) {
                if ($data['password']) {
                    DB::table('users')->insert([
                        'id' =>  $newId,
                        'username' => $data['username'],
                        'password' => md5(md5($data['password'])),
                        'name' => $data['name'],
                        'address' => $data['address'],
                        'email' => $data['email'],
                        'phone' => $data['phone'],
                        'created_by' => $userId,
                        'created_at' => date('Y-m-d H:i:s')
                    ]);
                    Mail::send('Admin::UsersManagement.ResetPassword', [
                        'email' => $data['email'],
                        'username' => $data['username'],
                        'name' => $data['name'],
                        'password' => $data['password'],
                    ], function ($mail) use ($data) {
                        $mail->to($data['email']);
                        $mail->subject("Insert User");
                    });
                } else {
                    $temp = str_random(8);
                    DB::table('users')->insert([
                        'id' =>  $newId,
                        'username' => $data['username'],
                        'password' => md5(md5($temp)),
                        'name' => $data['name'],
                        'address' => $data['address'],
                        'email' => $data['email'],
                        'phone' => $data['phone'],
                        'created_by' => $userId,
                        'created_at' => date('Y-m-d H:i:s')
                    ]);
                    Mail::send('Admin::UsersManagement.ResetPassword', [
                        'email' => $data['email'],
                        'username' => $data['username'],
                        'name' => $data['name'],
                        'password' => $temp,
                    ], function ($mail) use ($data) {
                        $mail->to($data['email']);
                        $mail->subject("Insert User");
                    });
                }
            } else {
                $response->msgNo = 'E015';
                $response->code = ResponseCode::HAVE_ERROR;
            }
            return $response;
        } catch (\Exception $e) {
            throw $e;
        }
    }
}
