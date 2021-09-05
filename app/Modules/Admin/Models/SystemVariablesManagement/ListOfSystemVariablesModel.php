<?php

/**
 * ListOfSystemVariableModel
 * Model processing for page list of system_variables
 *
 * 処理概要/process overview  : ListOfSystemVariableModel
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

namespace App\Modules\Admin\Models\SystemVariablesManagement;

use Illuminate\Support\Facades\DB;
use Helper, DataResponse, ResponseCode;

class ListOfSystemVariablesModel
{
    protected $lang;

    public function __construct() {
        $this->lang = Helper::GetCookies('lang', 'en');
    }

    /**
     * Get list of system_variables follow page
     * Created: 2021/05/28
     * @param Array $condition Search condition
     * @return Array List of system_variables
     * @throws \Exception
     * @author TriTD <tritd@toploop.co>
     */
    public function ListOfSystemVariables($condition)
    {
        try {
            $query = DB::table("system_variables")
                ->select('id', 'name', 'key', 'value', 'language_id')
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
     * Delete list system_variables follow list id
     * Created: 2021/05/28
     * @param Array $ids id of system_variables need to delete
     * @return DataResponse Delete result
     * @throws \Exception
     * @author TriTD <tritd@toploop.co>
     */
    public function DeleteSystemVariables($ids)
    {
        try {
            $response = new DataResponse();

            $userId = Helper::GetCurrentUserId();
            DB::beginTransaction();
            DB::table('system_variables')
                ->whereIn('id', $ids)
                ->where('deleted_at', null)
                ->update([
                    'deleted_at' => date('Y-m-d H:i:s')
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
