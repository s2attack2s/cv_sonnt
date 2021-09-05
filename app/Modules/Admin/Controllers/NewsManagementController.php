<?php

/**
 * NewsManagementController
 * Process for page list of news
 *
 * 処理概要/process overview  : NewsManagementController
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

use App\Modules\Admin\Requests\NewsManagement\SearchNewsConditionRequest;
use App\Modules\Admin\Requests\NewsManagement\NewsDetailRequest;
use App\Modules\Admin\Models\NewsManagement\ListOfNewsModel;
use App\Modules\Admin\Models\NewsManagement\NewsDetailModel;

use Helper, DataResponse, ResponseCode;

class NewsManagementController extends Controller
{
    protected $modelOfList;
    protected $modelOfDetail;
    protected  $languages;
    public function __construct() {
        $this->modelOfList = new ListOfNewsModel();
        $this->modelOfDetail = new NewsDetailModel();
        $this->languages = [1=> 'English', 2 => 'Japanese', 'Vietnamese'];
    }
    /**
     * ListOfNews
     * Created: 2021/05/28
     * @author TriTD <tritd@toploop.co>
     * @return \Illuminate\Http\Response
     */
    public function ListOfNews(SearchNewsConditionRequest $request){
        try {
            $condition = $request->all();
            $data = $this->modelOfList->ListOfNews($request->all());
            if ($request->ajax()) {
                return view('Admin::NewsManagement.TableNews', ["data" => $data, 'languages' => $this->languages]);
            }
            return view('Admin::NewsManagement.ListOfNews', ["data" => $data, 'languages' => $this->languages, 'condition' => $condition]);
        }
        catch(\Exception $e) {
            return redirect()->route('ServerError', ["error" => $e->getMessage()]);
        }
    }

    /**
     * DeleteNews
     * Created: 2021/05/28
     * @author TriTD <tritd@toploop.co>
     * @param  Request  $request Data from client
     * @return DataResponse Delete result
     */
    public function DeleteNews(Request $request) {
        $response = new DataResponse();
        try {
            $response = $this->modelOfList->DeleteNews($request->get('ids'));
        }
        catch(\Exception $e) {
            $response->SetException($e);
        }
        return response()->json($response->GetData());
    }

    /**
     * UpdateStatus
     * Created: 2021/05/28
     * @author TriTD <tritd@toploop.co>
     * @param  Request  $request Data from client
     * @return DataResponse Update result
     */
    public function UpdateStatus(Request $request) {
        $response = new DataResponse();
        try {
            $response = $this->modelOfList->UpdateStatus($request->get('id'), $request->get('is_published'));
        }
        catch(\Exception $e) {
            $response->SetException($e);
        }
        return response()->json($response->GetData());
    }

    /**
     * CreateNews
     * Created: 2021/05/28
     * @author TriTD <tritd@toploop.co>
     * @param  Request  $request Data from client
     * @return \Illuminate\Http\Response
     */
    public function CreateNews(Request $request) {
        try {
            $data = $this->modelOfDetail->LoadNews(0);

            return view('Admin::NewsManagement.NewsDetail', ["data" => $data, 'languages' => $this->languages]);
        }
        catch(\Exception $e) {
            return redirect()->route('ServerError', ["error" => $e->getMessage()]);
        }
    }

    /**
     * EditNews
     * Created: 2021/05/28
     * @author TriTD <tritd@toploop.co>
     * @param  Request  $request Data from client
     * @return \Illuminate\Http\Response
     */
    public function EditNews($id) {
        try {
            $data = $this->modelOfDetail->LoadNews($id);
            return view('Admin::NewsManagement.NewsDetail', ["data" => $data, 'languages' => $this->languages]);
        }
        catch(\Exception $e) {
            return redirect()->route('ServerError', ["error" => $e->getMessage()]);
        }
    }

    /**
     * UpdateNews
     * Created: 2021/05/31
     * @author TriTD <tritd@toploop.co>
     * @param  Request  $request Data from client
     * @return DataResponse Update result
     */
    public function UpdateNews(NewsDetailRequest $request) {
        $response = new DataResponse();
        try {
            $response = $this->modelOfDetail->UpdateNews($request->all());
        }
        catch(\Exception $e) {
            $response->SetException($e);
        }
        return response()->json($response->GetData());
    }

    /**
     * InsertNews
     * Created: 2021/05/31
     * @author TriTD <tritd@toploop.co>
     * @param  Request  $request Data from client
     * @return DataResponse Update result
     */
    public function InsertNews(Request $request) {

        $response = new DataResponse();
        try {
            $response = $this->modelOfDetail->InsertNews($request->all());
        }
        catch(\Exception $e) {
            $response->SetException($e);
        }
        return response()->json($response->GetData());
    }
}
