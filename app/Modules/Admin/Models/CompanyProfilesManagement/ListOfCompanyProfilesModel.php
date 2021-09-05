<?php

/**
 * ListOfCompanyProfileModel
 * Model processing for page list of company_profiles
 *
 * 処理概要/process overview  : ListOfCompanyProfileModel
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

namespace App\Modules\Admin\Models\CompanyProfilesManagement;

use Illuminate\Support\Facades\DB;
use Helper, DataResponse, ResponseCode;

class ListOfCompanyProfilesModel
{
    protected $lang;

    public function __construct() {
        $this->lang = Helper::GetCookies('lang', 'en');
    }

    /**
     * Get list of company_profiles follow page
     * Created: 2021/07/18
     * @param Array $condition Search condition
     * @return Array List of company_profiles
     * @throws \Exception
     * @author TriTD <tritd@toploop.co>
     */
    public function ListOfCompanyProfiles($condition)
    {
        try {
            $query = DB::table("company_profile")
                ->select('id', 'company_name', 'founded', 'tel', 'capital', 'main_bank', 'ceo_name', 'language_id')
                ->whereNull('deleted_at');


            $result = $query
                ->orderBy('created_at', 'desc')
                ->get()->toArray();
            return  $result;
        }
        catch(\Exception $e) {
            throw $e;
        }
    }

    /**
     * Delete list company_profiles follow list id
     * Created: 2021/08/17
     * @param Array $ids id of company_profiles need to delete
     * @return DataResponse Delete result
     * @throws \Exception
     * @author TriTD <tritd@toploop.co>
     */
    public function DeleteCompanyProfiles($ids)
    {
        try {
            $response = new DataResponse();

            $userId = Helper::GetCurrentUserId();
            DB::beginTransaction();
            DB::table('company_profiles')
                ->whereIn('id', $ids)
                ->where('deleted_at', null)
                ->update([
                    'deleted_at' => date('Y-m-d H:i:s'),
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
     * Update company_profile show or hide
     * Created: 2021/08/17
     * @param Integer $id id of company_profile need to update
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
            DB::table('company_profile')
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
