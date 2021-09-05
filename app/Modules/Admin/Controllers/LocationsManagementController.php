<?php

/**
 * NewsManagementController
 * Process for page list of locations
 *
 * 処理概要/process overview  : LocationsManagementController
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

use App\Modules\Admin\Requests\LocationsManagement\SearchLocationsConditionRequest;
use App\Modules\Admin\Requests\LocationsManagement\LocationDetailRequest;
use App\Modules\Admin\Models\LocationsManagement\ListOfLocationsModel;
use App\Modules\Admin\Models\LocationsManagement\LocationDetailModel;

use Helper, DataResponse, ResponseCode;

class LocationsManagementController extends Controller
{
    protected $modelOfList;
    protected $modelOfDetail;
    protected $languages;

    public function __construct() {
        $this->modelOfList = new ListOfLocationsModel();
        $this->modelOfDetail = new LocationDetailModel();
        $this->languages = [ 1 => 'English', 2 => 'Japanese', 'Việt Nam'];
    }

    /**
     * ListOfLocation
     * Created: 2021/05/28
     * @param SearchLocationsConditionRequest $request
     * @return \Illuminate\Http\Response
     * @author TriTD <tritd@toploop.co>
     */
    public function ListOfLocations(Request $request){

        try {
            $condition = $request->all();

            $data = $this->modelOfList->ListOfLocations($request->all());
            if ($request->ajax()) {
                return view('Admin::LocationsManagement.TableLocation',
                    [
                        "data" => $data,
                        "languages" => $this->languages
                    ]);
            }

            return view('Admin::LocationsManagement.ListOfLocations',
                [
                    "data" => $data,
                    "languages" => $this->languages,
                    'condition' => $condition
                ]);
        }
        catch(\Exception $e) {
            return redirect()->route('ServerError', ["error" => $e->getMessage()]);
        }
    }

    /**
     * EditLocation
     * Created: 2021/08/14
     * @author TriTD <tritd@toploop.co>
     * @param  Request  $request Data from location
     * @return \Illuminate\Http\Response
     */
    public function EditLocation($id) {
        try {
            $data = $this->modelOfDetail->LoadLocation($id);
            return view('Admin::LocationsManagement.LocationDetail',
                [
                    "data" => $data,
                    "languages" => $this->languages
                ]);
        }
        catch(\Exception $e) {
            return redirect()->route('ServerError', ["error" => $e->getMessage()]);
        }
    }

    /**
     * UpdateLocation
     * Created: 2021/05/31
     * @author TriTD <tritd@toploop.co>
     * @param  Request  $request Data from location
     * @return DataResponse Update result
     */
    public function UpdateLocation(LocationDetailRequest $request) {
        $response = new DataResponse();
        try {
            $response = $this->modelOfDetail->UpdateLocation($request->all());
        }
        catch(\Exception $e) {
            $response->SetException($e);
        }
        return response()->json($response->GetData());
    }


}
