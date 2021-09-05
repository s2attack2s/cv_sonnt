<?php

/**
 * CompanyProfileDetailModel
 * Model processing for page company_profile detail
 *
 * 処理概要/process overview  : CompanyProfileDetailModel
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

namespace App\Modules\Admin\Models\CompanyProfilesManagement;

use Illuminate\Support\Facades\DB;
use Helper, DataResponse, ResponseCode;
use Illuminate\Support\Str;

class CompanyProfileDetailModel
{
    protected $lang;

    public function __construct() {
        $this->lang = Helper::GetCookies('lang', 'en');
    }

    /**
     * Get data company_profile follow id
     * Created: 2021/08/17
     * @param int $id Id of company_profile
     * @return Array Data of company_profile
     * @throws \Exception
     * @author TriTD <tritd@toploop.co>
     */
    public function LoadCompanyProfile($id)
    {
        try {
            $company_profile = DB::table("company_profile")
                ->where('id', $id)
                ->where('deleted_at', null)->first();
            return  $company_profile;
        }
        catch(\Exception $e) {
            throw $e;
        }
    }



    /**
     * Update company_profile
     * Created: 2021/08/17
     * @param Array $data Data of company_profile from company_profile
     * @return Array updated result
     * @throws \Exception
     * @author TriTD <tritd@toploop.co>
     */
    public function UpdateCompanyProfile($data)
    {

        $company_profile = DB::table('company_profile')->where('id', $data['id'])->first();

        try {
            $response = new DataResponse();

            if ($response->code == ResponseCode::OK) {

                // Update data
                DB::table('company_profile')
                    ->where('id', $data['id'])
                    ->update([
                        'company_name' => $data['company_name'],
                        'founded' => $data['founded'],
                        'tel' => $data['tel'],
                        'capital' => $data['capital'],
                        'main_bank' => $data['main_bank'],
                        'ceo_name' => $data['ceo_name'],
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

    /**
     * Insert new company_profile
     * Created: 2021/08/15
     * @param Array $data Data of company_profile from company_profile
     * @return Array inserted result
     * @throws \Exception
     * @author TriTD <tritd@toploop.co>
     */
    public function InsertCompanyProfile($data)
    {
        
        try {
            $response = new DataResponse();
            $logo = null;

            // Insert data with main and translate language
            $company_profile = DB::table('company_profile')->insert([
                [
                    'company_name' => $data['company_name'],
                    'founded' => $data['founded'],
                    'tel' => $data['tel'],
                    'capital' => $data['capital'],
                    'main_bank' => $data['main_bank'],
                    'ceo_name' => $data['ceo_name'],
                    'created_at' => date('Y-m-d H:i:s'),
                ]

            ]);
            $response->data['id'] = DB::getPdo()->lastInsertId();;
            return $response;
        }
        catch(\Exception $e) {
            throw $e;
        }
    }
}
