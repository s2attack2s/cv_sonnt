<?php

/**
 * CompanyProfilesManagementController
 * Process for page list of company Infos
 *
 * 処理概要/process overview  : CompanyProfilesManagementController
 * 作成日/create date         : 2021/08/17
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

namespace App\Modules\Admin\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Modules\Admin\Requests\CompanyProfilesManagement\SearchCompanyProfilesConditionRequest;
use App\Modules\Admin\Requests\CompanyProfilesManagement\CompanyProfileDetailRequest;
use App\Modules\Admin\Models\CompanyProfilesManagement\ListOfCompanyProfilesModel;
use App\Modules\Admin\Models\CompanyProfilesManagement\CompanyProfileDetailModel;

use Helper, DataResponse, ResponseCode;

class CompanyProfilesManagementController extends Controller
{
    protected $modelOfList;
    protected $modelOfDetail;

    public function __construct() {
        $this->modelOfList = new ListOfCompanyProfilesModel();
        $this->modelOfDetail = new CompanyProfileDetailModel();
    }

    /**
     * ListOfCompanyProfile
     * Created: 2021/08/17
     * @param SearchCompanyProfilesConditionRequest $request
     * @return \Illuminate\Http\Response
     * @author TriTD <tritd@toploop.co>
     */
    public function ListOfCompanyProfile(Request $request){

        try {
            $condition = $request->all();

            $data = $this->modelOfList->ListOfCompanyProfiles($request->all());
            if ($request->ajax()) {
                return view('Admin::CompanyProfilesManagement.TableCompanyProfile',
                    [
                        "data" => $data,
                        'languages' => [ 1 => 'English', 2 => 'Japanese', 3 => 'Vietnamese']
                    ]);
            }

            return view('Admin::CompanyProfilesManagement.ListOfCompanyProfiles',
                [
                    "data" => $data,
                    'languages' => [ 1 => 'English', 2 => 'Japanese', 3 => 'Vietnamese'],
                    'condition' => $condition
                ]);
        }
        catch(\Exception $e) {
            return redirect()->route('ServerError', ["error" => $e->getMessage()]);
        }
    }

    /**
     * EditCompanyProfile
     * Created: 2021/08/17
     * @author TriTD <tritd@toploop.co>
     * @param  Request  $request Data from companyInfo
     * @return \Illuminate\Http\Response
     */
    public function EditCompanyProfile($id) {
        try {
            $data = $this->modelOfDetail->LoadCompanyProfile($id);
            return view('Admin::CompanyProfilesManagement.CompanyProfileDetail',
                [
                    "data" => $data,
                    'languages' => [ 1 => 'English', 2 => 'Japanese', 3 => 'Vietnamese']
                ]);
        }
        catch(\Exception $e) {
            return redirect()->route('ServerError', ["error" => $e->getMessage()]);
        }
    }

    /**
     * UpdateCompanyProfile
     * Created: 2021/08/15
     * @author TriTD <tritd@toploop.co>
     * @param  Request  $request Data from company Information
     * @return DataResponse Update result
     */
    public function UpdateCompanyProfile(CompanyProfileDetailRequest $request) {
        $response = new DataResponse();
        try {
            $response = $this->modelOfDetail->UpdateCompanyProfile($request->all());
        }
        catch(\Exception $e) {
            $response->SetException($e);
        }
        return response()->json($response->GetData());
    }


}
