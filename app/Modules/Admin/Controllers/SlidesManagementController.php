<?php

/**
 * SlidesManagementController
 * Process for page list of slide
 *
 * 処理概要/process overview  : SlidesManagementController
 * 作成日/create date         : 2021/05/28
 * 作成者/creater             : QuyPN
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

use App\Modules\Admin\Requests\SlidesManagement\SearchNewsConditionRequest;
use App\Modules\Admin\Requests\SlidesManagement\NewsDetailRequest;
use App\Modules\Admin\Models\SlidesManagement\ListOfNewsModel;
use App\Modules\Admin\Models\SlidesManagement\NewsDetailModel;

use Helper, DataResponse, ResponseCode;

class SlidesManagementController extends Controller
{
    protected $modelOfList;
    protected $modelOfDetail;

    public function __construct() {
        $this->modelOfList = new ListOfNewsModel();
        $this->modelOfDetail = new NewsDetailModel();
    }
    /**
     * ListOfSlides
     * Created: 2021/05/28
     * @author QuyPN <quy.pham@toploop.co>
     * @return \Illuminate\Http\Response
     */
    public function ListOfSlides(SearchNewsConditionRequest $request){
        try {
            $condition = $request->all();
            $data = $this->modelOfList->ListOfSlides($request->all());
            if ($request->ajax()) {
                return view('Admin::SlidesManagement.TableSlide', ["data" => $data]);
            }
            return view('Admin::SlidesManagement.ListOfSlides', ["data" => $data, 'condition' => $condition]);
        }
        catch(\Exception $e) {
            return redirect()->route('ServerError', ["error" => $e->getMessage()]);
        }
    }

    /**
     * DeleteSlides
     * Created: 2021/05/28
     * @author QuyPN <quy.pham@toploop.co>
     * @param  Request  $request Data from client
     * @return DataResponse Delete result
     */
    public function DeleteSlides(Request $request) {
        $response = new DataResponse();
        try {
            $response = $this->modelOfList->DeleteSlides($request->get('ids'));
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

    /**
     * CreateSlide
     * Created: 2021/05/28
     * @author QuyPN <quy.pham@toploop.co>
     * @param  Request  $request Data from client
     * @return \Illuminate\Http\Response
     */
    public function CreateSlide(Request $request) {
        try {
            $data = $this->modelOfDetail->LoadSlide(0);
            return view('Admin::SlidesManagement.SlideDetail', ["data" => $data]);
        }
        catch(\Exception $e) {
            return redirect()->route('ServerError', ["error" => $e->getMessage()]);
        }
    }

    /**
     * EditSlide
     * Created: 2021/05/28
     * @author QuyPN <quy.pham@toploop.co>
     * @param  Request  $request Data from client
     * @return \Illuminate\Http\Response
     */
    public function EditSlide($id) {
        try {
            $data = $this->modelOfDetail->LoadSlide($id);
            if($data['mode'] == 'I') {
                return redirect()->route('CreateSlide');
            }
            return view('Admin::SlidesManagement.SlideDetail', ["data" => $data]);
        }
        catch(\Exception $e) {
            return redirect()->route('ServerError', ["error" => $e->getMessage()]);
        }
    }

    /**
     * UpdateSlide
     * Created: 2021/05/31
     * @author QuyPN <quy.pham@toploop.co>
     * @param  Request  $request Data from client
     * @return DataResponse Update result
     */
    public function UpdateSlide(NewsDetailRequest $request) {
        $response = new DataResponse();
        try {
            $response = $this->modelOfDetail->UpdateSlide($request->all());
        }
        catch(\Exception $e) {
            $response->SetException($e);
        }
        return response()->json($response->GetData());
    }

    /**
     * InsertSlide
     * Created: 2021/05/31
     * @author QuyPN <quy.pham@toploop.co>
     * @param  Request  $request Data from client
     * @return DataResponse Update result
     */
    public function InsertSlide(NewsDetailRequest $request) {
        $response = new DataResponse();
        try {
            $response = $this->modelOfDetail->InsertSlide($request->all());
        }
        catch(\Exception $e) {
            $response->SetException($e);
        }
        return response()->json($response->GetData());
    }
}
