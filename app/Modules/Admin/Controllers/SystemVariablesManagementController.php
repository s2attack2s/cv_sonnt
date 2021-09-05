<?php

/**
 * NewsManagementController
 * Process for page list of system_variables
 *
 * 処理概要/process overview  : SystemVariablesManagementController
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

namespace App\Modules\Admin\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Modules\Admin\Requests\SystemVariablesManagement\SystemVariableDetailRequest;
use App\Modules\Admin\Models\SystemVariablesManagement\ListOfSystemVariablesModel;
use App\Modules\Admin\Models\SystemVariablesManagement\SystemVariableDetailModel;

use Helper, DataResponse, ResponseCode;

class SystemVariablesManagementController extends Controller
{
    protected $modelOfList;
    protected $modelOfDetail;

    public function __construct() {
        $this->modelOfList = new ListOfSystemVariablesModel();
        $this->modelOfDetail = new SystemVariableDetailModel();
    }

    /**
     * ListOfSystemVariable
     * Created: 2021/05/28
     * @param SearchSystemVariablesConditionRequest $request
     * @return \Illuminate\Http\Response
     * @author TriTD <tritd@toploop.co>
     */
    public function ListOfSystemVariables(Request $request){

        try {
            $condition = $request->all();

            $data = $this->modelOfList->ListOfSystemVariables($request->all());
            if ($request->ajax()) {
                return view('Admin::SystemVariablesManagement.TableSystemVariable',
                    [
                        "data" => $data
                    ]);
            }

            return view('Admin::SystemVariablesManagement.ListOfSystemVariables',
                [
                    "data" => $data,
                    'condition' => $condition
                ]);
        }
        catch(\Exception $e) {
            return redirect()->route('ServerError', ["error" => $e->getMessage()]);
        }
    }

    /**
     * EditSystemVariable
     * Created: 2021/08/14
     * @author TriTD <tritd@toploop.co>
     * @param  Request  $request Data from system_variable
     * @return \Illuminate\Http\Response
     */
    public function EditSystemVariable($id) {
        try {
            $data = $this->modelOfDetail->LoadSystemVariable($id);
            return view('Admin::SystemVariablesManagement.SystemVariableDetail',
                [
                    "data" => $data
                ]);
        }
        catch(\Exception $e) {
            return redirect()->route('ServerError', ["error" => $e->getMessage()]);
        }
    }

    /**
     * UpdateSystemVariable
     * Created: 2021/05/31
     * @author TriTD <tritd@toploop.co>
     * @param  Request  $request Data from system_variable
     * @return DataResponse Update result
     */
    public function UpdateSystemVariable(SystemVariableDetailRequest $request) {
        $response = new DataResponse();
        try {
            $response = $this->modelOfDetail->UpdateSystemVariable($request->all());
        }
        catch(\Exception $e) {
            $response->SetException($e);
        }
        return response()->json($response->GetData());
    }


}
