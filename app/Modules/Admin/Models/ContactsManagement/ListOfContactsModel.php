<?php

/**
 * ListOfContactModel
 * Model processing for page list of contacts
 *
 * 処理概要/process overview  : ListOfContactModel
 * 作成日/create date         : 2021/08/15
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

class ListOfContactsModel
{
    protected $lang;

    public function __construct() {
        $this->lang = Helper::GetCookies('lang', 'en');
    }

    /**
     * Get list of contacts follow page
     * Created: 2021/08/15
     * @param Array $condition Search condition
     * @return Array List of contacts
     * @throws \Exception
     * @author TriTD <tritd@toploop.co>
     */
    public function ListOfContacts($condition)
    {
        try {

            $query = DB::table("contacts")
                ->select('id', 'fullname', 'email','reason', 'phone', 'company', 'position', 'service_interest', 'message', 'attachment', 'status')
                ->whereNull('deleted_at');

            if(!Helper::IsNullOrEmpty($condition, 'search')){
                $keyword = $condition['search'] ;

                $query->where(function($query) use ($keyword) {
                    return $query->where('fullname', 'LIKE', '%' . $keyword . '%')
                                ->orWhere('phone', 'LIKE', '%' . $keyword . '%')
                                ->orWhere('email', 'LIKE', '%' . $keyword . '%')
                                ->orWhere('company', 'LIKE', '%' . $keyword . '%')
                                ->orWhere('position', 'LIKE', '%' . $keyword . '%')
                                ->orWhere('service_interest', 'LIKE', '%' . $keyword . '%');

                });

            }
            if (isset($condition['status'])) {
                $query->where('status', $condition['status']);
            }
            $result = $query
                ->orderBy('created_at', 'desc')
                ->paginate(
                    !Helper::IsNullOrEmpty($condition, 'per_page') ? $condition['per_page'] : 10,
                    ['*'],
                    'page',
                    !Helper::IsNullOrEmpty($condition, 'current_page') ? $condition['current_page'] : 1
                )->toArray();
            return  $result;
        }
        catch(\Exception $e) {
            throw $e;
        }
    }

    /**
     * Delete list contacts follow list id
     * Created: 2021/08/15
     * @param Array $ids id of contacts need to delete
     * @return DataResponse Delete result
     * @throws \Exception
     * @author TriTD <tritd@toploop.co>
     */
    public function DeleteContacts($ids)
    {
        try {
            $response = new DataResponse();

            $userId = Helper::GetCurrentUserId();
            DB::beginTransaction();
            DB::table('contacts')
                ->whereIn('id', $ids)
                ->where('deleted_at', null)
                ->update([
                    'deleted_at' => date('Y-m-d H:i:s'),
//                    'deleted_by' => $userId
                ]);
            DB::commit();

            return $response;
        }
        catch(\Exception $e) {
            Helper::RollBackTrans();
            throw $e;
        }
    }

    /**
     * Update contact show or hide
     * Created: 2021/08/15
     * @param Integer $id id of contact need to update
     * @param Boolean $status status will update
     * @return DataResponse Updated result
     * @throws \Exception
     * @author TriTD <tritd@toploop.co>
     */
    public function UpdateStatus($id, $status)
    {
        try {
            $response = new DataResponse();

            DB::beginTransaction();
            DB::table('contacts')
                ->where('id', $id)
                ->where('deleted_at', null)
                ->update([
                    'status' => $status === 'true' ? 1 : 0,
                    'updated_at' => date('Y-m-d H:i:s')
                ]);
            DB::commit();

            return $response;
        }
        catch(\Exception $e) {
            Helper::RollBackTrans();
            throw $e;
        }
    }
}
