<?php

/**
 * OurStoriesManagementController
 * Process for page list of our stories
 *
 * 処理概要/process overview  : OurStoriesManagementController
 * 作成日/create date         : 2021/06/01
 * 作成者/creater             : Trung
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

use App\Modules\Admin\Models\OurStoriesManagement\ListOfOurStoriesModel;
use App\Modules\Admin\Models\OurStoriesManagement\OurStoriesDetailModel;
use App\Modules\Admin\Requests\OurStoriesManagement\SearchOurStoriesConditionRequest;
use App\Modules\Admin\Requests\OurStoriesManagement\OurStoriesDetailRequest;


use Helper, DataResponse, ResponseCode;

class OurStoriesManagementController extends Controller
{
    protected $modelOfList;
    protected $modelOfDetail;

    public function __construct() {
        $this->modelOfList = new ListOfOurStoriesModel();
        $this->modelOfDetail = new OurStoriesDetailModel();
    }
    
    /**
     * ListOfOurStories
     * Created: 2021/06/01
     * @author Trung
     * @return \Illuminate\Http\Response
     */
    public function ListOfOurStories(SearchOurStoriesConditionRequest $request){
        try {
            $condition = $request->all();
            $data = $this->modelOfList->ListOfOurStories($request->all());
            if ($request->ajax()) {
                return view('Admin::OurStoriesManagement.TableOurStories', ["data" => $data]);
            }
            return view('Admin::OurStoriesManagement.ListOfOurStories', ["data" => $data, 'condition' => $condition]);
        }
        catch(\Exception $e) {
            return redirect()->route('ServerError', ["error" => $e->getMessage()]);
        }
    }

    /**
     * InsertOurStories
     * Created: 2021/06/02
     * @author Trung
     * @param  Request  $request Data from client
     * @return DataResponse Update result
     */
    public function CreateOurStories(Request $request) {
        try {
            $data = $this->modelOfDetail->LoadOurStories(0);
            return view('Admin::OurStoriesManagement.OurStoriesDetail', ["data" => $data]);
        }
        catch(\Exception $e) {
            return redirect()->route('ServerError', ["error" => $e->getMessage()]);
        }
    }

    /**
     * InsertSlide
     * Created: 2021/06/03
     * @author Trung
     * @param  Request  $request Data from client
     * @return DataResponse Update result
     */
    public function InsertOurStories(OurStoriesDetailRequest $request) {
        $response = new DataResponse();
        try {
            $response = $this->modelOfDetail->InsertOurStories($request->all());
        }
        catch(\Exception $e) {
            $response->SetException($e);
        }
        return response()->json($response->GetData());
    }

    /**
     * DeleteOurStories
     * Created: 2021/06/03
     * @author Trung
     * @param  Request  $request Data from client
     * @return DataResponse Delete result
     */
    public function DeleteOurStories(Request $request) {
        $response = new DataResponse();
        try {
            $response = $this->modelOfList->DeleteOurStories($request->get('ids'));
        }
        catch(\Exception $e) {
            $response->SetException($e);
        }
        return response()->json($response->GetData());
    }

    /**
     * EditSlide
     * Created: 2021/06/03
     * @author Trung
     * @param  Request  $request Data from client
     * @return \Illuminate\Http\Response
     */
    public function EditOurStories($id) {
        try {
            $data = $this->modelOfDetail->LoadOurStories($id);
            if($data['mode'] == 'I') {
                return redirect()->route('CreateOurStories');
            }
            return view('Admin::OurStoriesManagement.OurStoriesDetail', ["data" => $data]);
        }
        catch(\Exception $e) {
            return redirect()->route('ServerError', ["error" => $e->getMessage()]);
        }
    }

    /**
     * UpdateOurStories
     * Created: 2021/06/03
     * @author Trung
     * @param  Request  $request Data from client
     * @return DataResponse Update result
     */
    public function UpdateOurStories(OurStoriesDetailRequest $request) {
        $response = new DataResponse();
        try {
            $response = $this->modelOfDetail->UpdateOurStories($request->all());
        }
        catch(\Exception $e) {
            $response->SetException($e);
        }
        return response()->json($response->GetData());
    }
    
    /**
     * UpdateStatus
     * Created: 2021/05/28
     * @author QuyPN <quy.pham@toploop.co>
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

}
