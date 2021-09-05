<?php

/**
 * SettingDetailModel
 * Model processing for page setting detail
 *
 * 処理概要/setting overview  : SettingDetailModel
 * 作成日/create date         : 2021/06/01
 * 作成者/creater             : ThanhND
 *
 * 更新日/update date         :
 * 更新者/updater             :
 * 更新内容 /update content   :
 *
 * @package Modules/Admin
 * @copyright Copyright (c) toploop.co
 * @version 1.0.0
 */

namespace App\Modules\Admin\Models\SettingManagement;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Helper, DataResponse, ResponseCode;

class SettingDetailModel
{
    protected $lang;

    public function __construct()
    {
        $this->lang = Helper::GetCookies('lang', 'en');
    }

    /**
     * Get data setting follow id
     * Created: 2021/06/01
     * @author ThanhND <thanhnguyenduyy@gmail.com>
     * @param  int $id Id of setting
     * @return Array Data of setting
     */
    public function LoadSetting()
    {
        try {
            $vi = DB::table("settings")
                ->where('deleted_at', null)
                ->where('lang', 'vi')->first();
            $trans = [];
            if (isset($vi) && !empty($vi)) {
                $trans = DB::table("settings")
                    ->where('deleted_at', null)
                    ->where('lang', 'en')->first();
                $vi->created_by = Helper::GetUsername($vi->created_by);
                $vi->updated_by = Helper::GetUsername($vi->updated_by);
            }
            return [
                'vi'    => $vi,
                'trans' => $trans
            ];
        } catch (\Exception $e) {
            throw $e;
        }
    }

    /**
     * Update setting
     * Created: 2021/06/01
     * @author ThanhND <thanhnguyenduyy@gmail.com>
     * @param  Array $data Data of setting from client
     * @return Array updated result
     */
    public function UpdateSetting($data)
    {
        $viImgPath = '';
        $transImgPath = '';
        $folder = 'upload_file/setting/';
        try {
            $response = new DataResponse();
            // upload image
            if (isset($data['vi']['about_us_img'])) {
                $viImg = Helper::SaveFileImg($data['vi']['about_us_img'], $folder, 'setting_vi');
                if ($viImg['status']) {
                    $viImgPath = $viImg['path'];
                } else {
                    $response->msgNo = $viImg['error'];
                    $response->code = ResponseCode::HAVE_ERROR;
                    return $response;
                }
            }
            if (isset($data['trans']['about_us_img'])) {
                $transImg = Helper::SaveFileImg($data['trans']['about_us_img'], $folder, 'setting_' . $data['trans']['lang']);
                if ($transImg['status']) {
                    $transImgPath = $transImg['path'];
                } else {
                    $response->msgNo = $transImg['error'];
                    $response->code = ResponseCode::HAVE_ERROR;
                    Helper::DeleteFile($viImgPath);
                    return $response;
                }
            }
            if ($response->code == ResponseCode::OK) {
                $userId = Helper::GetCurrentUserId();
                // Update data
                DB::table('settings')
                    ->where('deleted_at', null)
                    ->where('id', 1)
                    ->update([
                        'facebook'       => $data['vi']['facebook'],
                        'linkedin'       => $data['vi']['linkedin'],
                        'email'          => $data['vi']['email'],
                        'updated_at'     => Carbon::now('Asia/Ho_Chi_Minh'),
                        'updated_by'     => $userId

                    ]);
                DB::table('settings')
                    ->where('deleted_at', null)
                    ->where('lang', $data['vi']['lang'])
                    ->where('id', 1)
                    ->update([
                        'about_us_img'   => $viImgPath == '' ? $data['vi']['image'] : $viImgPath,
                        'about_us'       => $data['vi']['about_us'],
                        'stories'        => $data['vi']['stories'],
                        'process'        => $data['vi']['process'],
                        'description'    => $data['vi']['description'],
                        'keyword'        => $data['vi']['keyword'],
                        'author'         => $data['vi']['author'],
                        'phone'          => $data['vi']['phone'],
                        'address'        => $data['vi']['address'],
                        'updated_at'     => Carbon::now('Asia/Ho_Chi_Minh'),
                        'updated_by'     => $userId

                    ]);
                DB::table('settings')
                    ->where('deleted_at', null)
                    ->where('lang', $data['trans']['lang'])
                    ->where('id', 1)
                    ->update([
                        'about_us_img' => $transImgPath == '' ? $data['trans']['image'] : $transImgPath,
                        'about_us'     => $data['trans']['about_us'],
                        'stories'      => $data['trans']['stories'],
                        'process'      => $data['trans']['process'],
                        'description'  => $data['trans']['description'],
                        'keyword'      => $data['trans']['keyword'],
                        'author'       => $data['trans']['author'],
                        'phone'        => $data['trans']['phone'],
                        'address'      => $data['trans']['address'],
                        'updated_at'   => Carbon::now('Asia/Ho_Chi_Minh'),
                        'updated_by'   => $userId
                    ]);
            }
            return $response;
        } catch (\Exception $e) {
            Helper::DeleteFile($viImgPath);
            Helper::DeleteFile($transImgPath);
            throw $e;
        }
    }

    /**
     * Update emailsetting
     * Created: 2021/06/01
     * @author ThanhND <thanhnguyenduyy@gmail.com>
     * @param  Array $data Data of setting from client
     * @return Array updated result
     */
    public function UpdateEmailSetting($data)
    {
        try {
            $response = new DataResponse();
            if ($response->code == ResponseCode::OK) {
                $userId = Helper::GetCurrentUserId();
                // Update data with main and translate language
                DB::table('settings')
                    ->where('deleted_at', null)
                    ->where('id', 1)
                    ->update([
                        'mailer'          => $data['vi']['mailer'],
                        'mail_port'       => $data['vi']['mail_port'],
                        'mail_host'       => $data['vi']['mail_host'],
                        'mail_smtp_auth'  => $data['vi']['mail_smtp_auth'],
                        'mail_user'       => $data['vi']['mail_user'],
                        'mail_password'   => base64_encode($data['vi']['mail_password']),
                        'mail_from'       => $data['vi']['mail_from'],
                        'mail_received'   => $data['vi']['mail_received'],
                        'updated_at'        => Carbon::now('Asia/Ho_Chi_Minh'),
                        'updated_by'        => $userId
                    ]);
            }
            return $response;
        } catch (\Exception $e) {
            throw $e;
        }
    }
}
