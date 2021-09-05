<?php

/**
 * NewsManagementController
 * Process for page list of careers
 *
 * 処理概要/process overview  : CareersManagementController
 * 作成日/create date         : 2021/08/213
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

use App\Modules\Admin\Requests\CareersManagement\SearchCareersConditionRequest;
use App\Modules\Admin\Requests\CareersManagement\CareerDetailRequest;
use App\Modules\Admin\Models\CareersManagement\ListOfCareersModel;
use App\Modules\Admin\Models\CareersManagement\CareerDetailModel;

use Helper, DataResponse, ResponseCode;

class CareersManagementController extends Controller
{
    protected $modelOfList;
    protected $modelOfDetail;
    protected $languages;
    protected $locations;
    protected $job_types;
    protected $statuses;

    public function __construct() {
        $this->modelOfList = new ListOfCareersModel();
        $this->modelOfDetail = new CareerDetailModel();
        $this->languages = [ 1 => 'English', 2 => 'Japanese', 'Việt Nam'];
        $this->locations = [ 1 => 'Tokyo', 2 => 'Đà Nẵng' ];
        $this->statuses = ['0'=> 'New', '1' => 'Open', '2' => 'Ended', '3' => 'Closed'];
    }

    /**
     * ListOfCareer
     * Created: 2021/05/28
     * @param SearchCareersConditionRequest $request
     * @return \Illuminate\Http\Response
     * @author TriTD <tritd@toploop.co>
     */
    public function ListOfCareers(SearchCareersConditionRequest $request){

        try {
            $condition = $request->all();

            $data = $this->modelOfList->ListOfCareers($request->all());
            if ($request->ajax()) {
                return view('Admin::CareersManagement.TableCareer',
                    [
                        "data" => $data,
                        'languages' => $this->languages,
                        'locations' => $this->locations,
                        'statuses' => $this->statuses
                    ]);
            }
            return view('Admin::CareersManagement.ListOfCareers',
                [
                    "data" => $data,
                    'languages' => $this->languages,
                    'locations' => $this->locations,
                    'condition' => $condition,
                    'statuses' => $this->statuses
                ]);
        }
        catch(\Exception $e) {
            return redirect()->route('ServerError', ["error" => $e->getMessage()]);
        }
    }

    /**
     * DeleteCareers
     * Created: 2021/08/14
     * @author TriTD <tritd@toploop.co>
     * @param  Request  $request Data from client
     * @return DataResponse Delete result
     */
    public function DeleteCareers(Request $request) {
        $response = new DataResponse();
        try {
            $response = $this->modelOfList->DeleteCareers($request->get('ids'));
        }
        catch(\Exception $e) {
            $response->SetException($e);
        }
        return response()->json($response->GetData());
    }

    /**
     * UpdateStatus
     * Created: 2021/08/14
     * @author TriTD <tritd@toploop.co>
     * @param  Request  $request Data from client
     * @return DataResponse Update result
     */
    public function UpdateStatus(Request $request) {
        $response = new DataResponse();
        try {
            $response = $this->modelOfList->UpdateStatus($request->get('id'), $request->get('status'));
        }
        catch(\Exception $e) {
            $response->SetException($e);
        }
        return response()->json($response->GetData());
    }

    /**
     * CreateCareer
     * Created: 2021/08/14
     * @author TriTD <tritd@toploop.co>
     * @param  Request  $request Data from client
     * @return \Illuminate\Http\Response
     */
    public function CreateCareer(Request $request) {
        try {
            $data = $this->modelOfDetail->LoadCareer(0);
            $jobTypes = $this->modelOfDetail->LoadListJobTypes();
            return view('Admin::CareersManagement.CareerDetail',
                    [
                        "data" => $data,
                        'languages' => $this->languages,
                        'locations' => $this->locations,
                        'job_types' => $jobTypes,
                        'statuses' => $this->statuses
                    ]);
        }
        catch(\Exception $e) {
            return redirect()->route('ServerError', ["error" => $e->getMessage()]);
        }
    }

    /**
     * EditCareer
     * Created: 2021/08/14
     * @author TriTD <tritd@toploop.co>
     * @param  Request  $request Data from client
     * @return \Illuminate\Http\Response
     */
    public function EditCareer($id) {
        try {
            $data = $this->modelOfDetail->LoadCareer($id);
            $jobTypes = $this->modelOfDetail->LoadListJobTypes();
            return view('Admin::CareersManagement.CareerDetail',
                [
                    "data" => $data,
                    'languages' => $this->languages,
                    'locations' => $this->locations,
                    'job_types' => $jobTypes,
                    'statuses' => $this->statuses
                ]);
        }
        catch(\Exception $e) {
            return redirect()->route('ServerError', ["error" => $e->getMessage()]);
        }
    }

    /**
     * UpdateCareer
     * Created: 2021/05/31
     * @author TriTD <tritd@toploop.co>
     * @param  Request  $request Data from client
     * @return DataResponse Update result
     */
    public function UpdateCareer(CareerDetailRequest $request) {
        $response = new DataResponse();
        try {
            $response = $this->modelOfDetail->UpdateCareer($request->all());
        }
        catch(\Exception $e) {
            $response->SetException($e);
        }
        return response()->json($response->GetData());
    }

    /**
     * InsertCareer
     * Created: 2021/05/31
     * @author TriTD <tritd@toploop.co>
     * @param  Request  $request Data from client
     * @return DataResponse Update result
     */
    public function InsertCareer(Request $request) {

        $response = new DataResponse();
        try {
            $response = $this->modelOfDetail->InsertCareer($request->all());
        }
        catch(\Exception $e) {
            $response->SetException($e);
        }
        return response()->json($response->GetData());
    }
}
