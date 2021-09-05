<?php

/**
 * ChallengesManagement
 * Process for page list of challenges
 *
 * 処理概要/process overview  : ChallengesManagement
 * 作成日/create date         : 2021/06/02
 * 作成者/creater             : AnhHT
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

use App\Modules\Admin\Requests\ChallengesManagement\SearchChallengesConditionRequest;
use App\Modules\Admin\Models\ChallengesManagement\ListOfChallengesModel;

use Helper, DataResponse, ResponseCode;

class ChallengesManagementController extends Controller
{
    protected $modelOfList;

    public function __construct() {
        $this->modelOfList = new ListOfChallengesModel();
    }
    /**
     * ListOfChallenges
     * Created: 2021/06/02
     * @author AnhHT <tienanhbk96@gmail.com>
     * @return \Illuminate\Http\Response
     */
    public function ListOfChallenges(SearchChallengesConditionRequest $request){
        try {
            $condition = $request->all();
            $data = $this->modelOfList->ListOfChallenges($request->all());
            $combobox = $this->modelOfList->GetCombobox();
            if ($request->ajax()) {
                return view('Admin::ChallengesManagement.TableChallenge', ["data" => $data, 'combobox' => $combobox]);
            }
            return view('Admin::ChallengesManagement.Index', ["data" => $data, 'condition' => $condition, 'combobox' => $combobox ]);
        }
        catch(\Exception $e) {
            return redirect()->route('ServerError', ["error" => $e->getMessage()]);
        }
    }

    /**
     * DeleteChallenges
     * Created: 2021/06/02
     * @author AnhHT <tienanhbk96@gmail.com>
     * @param  Request  $request Data from client
     * @return DataResponse Delete result
     */
    public function DeleteChallenges(Request $request) {
        
        $response = new DataResponse();
        try {
            $response = $this->modelOfList->DeleteChallenges($request->get('ids'));
        }
        catch(\Exception $e) {
            $response->SetException($e);
        }
        return response()->json($response->GetData());
    }

    /**
     * Update status of challenges form
     * Created: 2021/06/02
     * @author AnhHT <tienanhbk96@gmail.com>
     * @param  Request  $request Data from client
     * @return DataResponse Update result
     */
    public function UpdateChallenges(Request $request) {
        $response = new DataResponse();
        try {
            $response = $this->modelOfList->UpdateChallenges($request->get('id'), $request->get('status'));
        }
        catch(\Exception $e) {
            $response->SetException($e);
        }
        return response()->json($response->GetData());
    }

}