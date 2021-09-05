<?php

/**
 * ProfileModel
 * Model processing for page  profile
 *
 * 処理概要/process overview  : ProfileModel
 * 作成日/create date         : 2021/06/1
 * 作成者/creater             : HungNo1
 *
 * 更新日/update date         :
 * 更新者/updater             :
 * 更新内容 /update content   :
 *
 * @package Modules/Admin
 * @copyright Copyright (c) toploop.co
 * @version 1.0.0
 */

namespace App\Modules\Admin\Models\Profile;

use Illuminate\Support\Facades\DB;
use Helper, DataResponse, ResponseCode;

class GetProfileModel
{
  
    /**
     * Get  profile follow page
     * Created: 2021/06/1
     * @author HungNo1
     * @param  Array $condition Search condition
     * @return Array  profile
     */
    public function GetProfile()
    {
        try {
            $userId = Helper::GetCurrentUserId();
            $query = DB::table("users")
                ->where('id', $userId)
                ->where('deleted_at', null)
                ->first();
//                $query->created_by = Helper::GetUsername($query->created_by);
//                $query->updated_by = Helper::GetUsername($query->updated_by);
            return [
                'query'    => $query,
            ];
        }
        catch(\Exception $e) {
            throw $e;
        }
    }
          /**
     * Update profile
     * Created: 2021/06/2
     * @author HungNo1
     * @param  Array $data Data of profile from client
     * @return Array updated result
     */
    public function UpdateProfile($data)
    {
        try {
            $response = new DataResponse();
            if ($response->code == ResponseCode::OK) {
                $userId = Helper::GetCurrentUserId();
                // Update data
                DB::table('users')
                    ->where('deleted_at', null)
                    ->where('id', $userId)
                    ->update([
                        'username' => $data['username'],
                        'name' => $data['name'],                
                        'address' => $data['address'],
                        'email' => $data['email'],
                        'phone' => $data['phone'],
                        'updated_at' => date('Y-m-d H:i:s'),
                        'is_admin' => 1,  
                    ]);
                $response->userId = $userId;
            }
            return $response;
        }
        catch(\Exception $e) {
          
            throw $e;
        }
    }
              /**
     * Update profile
     * Created: 2021/06/2
     * @author HungNo1
     * @param  Array $data Data of profile from client
     * @return Array updated result
     */
    public function UpdatePassword($data)
    {
           
        try {
            $response = new DataResponse();
            $userId = Helper::GetCurrentUserId();    
            $userDB = DB::table('users')
                ->where('id', $userId)
                ->where('deleted_at', null)
                ->select('users.password')
                ->get()->toArray();
            
             if (md5(md5($data['old_password'])) != $userDB[0]->password) {
                $response->msgNo = 'E018';
                $response->code = ResponseCode::HAVE_ERROR;
            
            } else if ($response->code == ResponseCode::OK) {   
                DB::table('users')
                ->where('deleted_at', null)
                ->where('id', $userId)
                ->update([
                    'password' =>md5(md5($data['new_password'])),
                ]);
                $response->userId = $userId;
            }
            return $response;
        }
        catch(\Exception $e) {
          
            throw $e;
        }
    }


}
