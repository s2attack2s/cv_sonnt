<?php

/**
 * SystemVariableDetailModel
 * Model processing for page system_variable detail
 *
 * 処理概要/process overview  : SystemVariableDetailModel
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

namespace App\Modules\Admin\Models\SystemVariablesManagement;

use Illuminate\Support\Facades\DB;
use Helper, DataResponse, ResponseCode;
use Illuminate\Support\Str;

class SystemVariableDetailModel
{
    protected $lang;

    public function __construct() {
        $this->lang = Helper::GetCookies('lang', 'en');
    }

    /**
     * Get data system_variable follow id
     * Created: 2021/05/28
     * @param int $id Id of system_variable
     * @return Array Data of system_variable
     * @throws \Exception
     * @author TriTD <tritd@toploop.co>
     */
    public function LoadSystemVariable($id)
    {
        try {

            $system_variable = DB::table("system_variables")
                ->where('id', $id)
                ->where('deleted_at', null)->first();
                //->where('language_id', '=', 1)->first();
            return  $system_variable;
        }
        catch(\Exception $e) {
            throw $e;
        }
    }



    /**
     * Update system_variable
     * Created: 2021/08/15
     * @param Array $data Data of system_variable from system_variable
     * @return Array updated result
     * @throws \Exception
     * @author TriTD <tritd@toploop.co>
     */
    public function UpdateSystemVariable($data)
    {
        $system_variable = DB::table('system_variables')->where('id', $data['id'])->first();

        try {
            $response = new DataResponse();

            if ($response->code == ResponseCode::OK) {
                // Update data
                DB::table('system_variables')
                    ->where('id', $data['id'])
                    ->update([
                        'name' => $data['name'],
                        'value' => $data['value'],
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


}
