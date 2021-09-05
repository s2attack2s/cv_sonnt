<?php

/**
 * ContactDetailModel
 * Model processing for page contact detail
 *
 * 処理概要/process overview  : ContactDetailModel
 * 作成日/create date         : 2021/05/28
 * 作成者/creater             : TriTD
 *
 * 更新日/update date         :
 * 更新者/updater             :
 * 更新内容 /update content   :
 *
 * @package Modules/Admin
 * @copyright Copyright (c) toploop.co
 * @version 1.0.0
 */

namespace App\Modules\Admin\Models\ContactsManagement;

use Illuminate\Support\Facades\DB;
use Helper, DataResponse, ResponseCode;
use Illuminate\Support\Str;

class ContactDetailModel
{
    protected $lang;

    public function __construct() {
        $this->lang = Helper::GetCookies('lang', 'en');
    }

    /**
     * Get data contact follow id
     * Created: 2021/08/15
     * @param int $id Id of contact
     * @return Array Data of contact
     * @throws \Exception
     * @author TriTD <tritd@toploop.co>
     */
    public function LoadContact($id)
    {
        try {
            $contact = DB::table("contacts")
                ->select('*')
                ->where('id', $id)
                ->where('deleted_at', null)->first();
            if ($contact->status === 0) {
                DB::table("contacts")
                    ->where('id', $id)
                    ->update(['status' => 1]);
            }
            return  $contact;
        }
        catch(\Exception $e) {
            throw $e;
        }
    }

    public function LoadListJobTypes() {
        try {
            $types = DB::table("job_types")
                ->pluck('name', 'id');

            return  $types;
        }
        catch(\Exception $e) {
            throw $e;
        }
    }

    /**
     * Update contact
     * Created: 2021/08/15
     * @param Array $data Data of contact from contact
     * @return Array updated result
     * @throws \Exception
     * @author TriTD <tritd@toploop.co>
     */
    public function UpdateContact($data)
    {
        $folder = 'upload/contact/';
        $contact = DB::table('contacts')->where('id', $data['id'])->first();

        try {
            $response = new DataResponse();
            $image = $contact->logo;
            // upload image
            if (isset($data['image'])) {
                $img = Helper::SaveFileImg($data['image'], $folder, 'images');

                if ($img['status']) {
                    $image = $img['path'];
                }
                else {
                    $response->msgNo = $img['error'];
                    $response->code = ResponseCode::HAVE_ERROR;
                    return $response;
                }
            }

            if ($response->code == ResponseCode::OK) {
                $userId = Helper::GetCurrentUserId();
                // Update data
                DB::table('contacts')
                    ->where('id', $data['id'])
                    ->update([
                        'name' => $data['name'],
                        'logo' => $image,
                        'updated_at' => date('Y-m-d H:i:s')
                    ]);

                $response->data['id'] = $data['id'];
            }
            return $response;
        }
        catch(\Exception $e) {
            throw $e;
        }
    }

    public function UpdateContactStatus($id, $status)
    {

        $contact = DB::table('contacts')->where('id', $id)->first();

        try {
            $response = new DataResponse();

            if (isset($contact)) {
                // Update data
                DB::table('contacts')
                    ->where('id', $id)
                    ->update([
                        'status' => $status,
                        'updated_at' => date('Y-m-d H:i:s')
                    ]);

                $response->data['id'] = $id;
            }
            return $response;
        }
        catch(\Exception $e) {
            throw $e;
        }
    }


}
