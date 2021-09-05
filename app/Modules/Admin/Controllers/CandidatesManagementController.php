<?php

/**
 * NewsManagementController
 * Process for page list of candidates
 *
 * 処理概要/process overview  : CandidatesManagementController
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

use App\Modules\Admin\Requests\CandidatesManagement\SearchCandidatesConditionRequest;
use App\Modules\Admin\Requests\CandidatesManagement\CandidateDetailRequest;
use App\Modules\Admin\Models\CandidatesManagement\ListOfCandidatesModel;
use App\Modules\Admin\Models\CandidatesManagement\CandidateDetailModel;

use Helper, DataResponse, ResponseCode;

class CandidatesManagementController extends Controller
{
    protected $modelOfList;
    protected $modelOfDetail;
    protected $languages;
    protected $locations;
    protected $status;


    public function __construct() {
        $this->modelOfList = new ListOfCandidatesModel();
        $this->modelOfDetail = new CandidateDetailModel();
        $this->languages = [ 1 => 'English', 2 => 'Japanese', 'Việt Nam'];
        $this->status = [ 0 => 'New', 1 => 'Approved', 2 => 'Rejected'];
    }

    /**
     * ListOfCandidate
     * Created: 2021/05/28
     * @param SearchCandidatesConditionRequest $request
     * @return \Illuminate\Http\Response
     * @author TriTD <tritd@toploop.co>
     */
    public function ListOfCandidates(SearchCandidatesConditionRequest $request){
        $jobs = $this->modelOfDetail->LoadListJobs();
        try {
            $condition = $request->all();

            $data = $this->modelOfList->ListOfCandidates($request->all());
            if ($request->ajax()) {
                return view('Admin::CandidatesManagement.TableCandidate',
                    [
                        "data" => $data,
                        'languages' => $this->languages,
                        'status' => [ 0 => 'New', 1 => 'Approved', 2 => 'Rejected'],
                        'jobs' => $jobs
                    ]);
            }
            return view('Admin::CandidatesManagement.ListOfCandidates',
                [
                    "data" => $data,
                    'languages' => $this->languages,
                    'status' => [ 0 => 'New', 1 => 'Approved', 2 => 'Rejected'],
                    'jobs' => $jobs,
                    'condition' => $condition
                ]);
        }
        catch(\Exception $e) {
            return redirect()->route('ServerError', ["error" => $e->getMessage()]);
        }
    }

    /**
     * DeleteCandidates
     * Created: 2021/08/14
     * @author TriTD <tritd@toploop.co>
     * @param  Request  $request Data from candidate
     * @return DataResponse Delete result
     */
    public function DeleteCandidates(Request $request) {
        $response = new DataResponse();
        try {
            $response = $this->modelOfList->DeleteCandidates($request->get('ids'));
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
     * @param  Request  $request Data from candidate
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
     * CreateCandidate
     * Created: 2021/08/14
     * @author TriTD <tritd@toploop.co>
     * @param  Request  $request Data from candidate
     * @return \Illuminate\Http\Response
     */
    public function CreateCandidate(Request $request) {
        try {
            $data = $this->modelOfDetail->LoadCandidate(0);
            $jobTypes = $this->modelOfDetail->LoadListJobTypes();
            return view('Admin::CandidatesManagement.CandidateDetail',
                    [
                        "data" => $data,
                        'languages' => $this->languages,
                        'locations' => $this->locations,
                        'job_types' => $jobTypes
                    ]);
        }
        catch(\Exception $e) {
            return redirect()->route('ServerError', ["error" => $e->getMessage()]);
        }
    }

    /**
     * EditCandidate
     * Created: 2021/08/14
     * @author TriTD <tritd@toploop.co>
     * @param  Request  $request Data from candidate
     * @return \Illuminate\Http\Response
     */
    public function EditCandidate($id) {
        try {
            $data = $this->modelOfDetail->LoadCandidate($id);
            return view('Admin::CandidatesManagement.CandidateDetail',
                [
                    "data" => $data
                ]);
        }
        catch(\Exception $e) {
            return redirect()->route('ServerError', ["error" => $e->getMessage()]);
        }
    }

    /**
     * ViewCandidate
     * Created: 2021/08/15
     * @author TriTD <tritd@toploop.co>
     * @param  Request  $request Data from candidate
     * @return \Illuminate\Http\Response
     */
    public function ViewCandidate($id) {
        try {
            $data = $this->modelOfDetail->LoadCandidate($id);
            $jobTypes = $this->modelOfDetail->LoadListJobTypes();
            return view('Admin::CandidatesManagement.ViewCandidateDetail',
                [
                    "data" => $data,
                    'status' => [ 0 => 'New', 1 => 'Approved', 2 => 'Rejected'],
                ]);
        }
        catch(\Exception $e) {
            return redirect()->route('ServerError', ["error" => $e->getMessage()]);
        }
    }

    /**
     * UpdateCandidate
     * Created: 2021/08/15
     * @author TriTD <tritd@toploop.co>
     * @param  Request  $request Data from candidate
     * @return DataResponse Update result
     */
    public function UpdateCandidate(CandidateDetailRequest $request) {
        $response = new DataResponse();
        try {
            $response = $this->modelOfDetail->UpdateCandidate($request->all());
        }
        catch(\Exception $e) {
            $response->SetException($e);
        }
        return response()->json($response->GetData());
    }

    /**
     * Approve Candidate
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function ApproveCandidate(Request $request) {
        $response = new DataResponse();
        $ids = $request->get('ids');
        try {
            $response = $this->modelOfDetail->ApproveCandidate($ids);
        }
        catch(\Exception $e) {
            $response->SetException($e);
        }
        return response()->json($response->GetData());
    }

    /**
     * Reject Candidate
     * @param CandidateDetailRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function RejectCandidate(Request $request) {
        $response = new DataResponse();
        $ids = $request->get('ids');
        try {
            $response = $this->modelOfDetail->RejectCandidate($ids);
        }
        catch(\Exception $e) {
            $response->SetException($e);
        }
        return response()->json($response->GetData());
    }

    /**
     * InsertCandidate
     * Created: 2021/08/15
     * @author TriTD <tritd@toploop.co>
     * @param  Request  $request Data from candidate
     * @return DataResponse Update result
     */
    public function InsertCandidate(Request $request) {

        $response = new DataResponse();
        try {
            $response = $this->modelOfDetail->InsertCandidate($request->all());
        }
        catch(\Exception $e) {
            $response->SetException($e);
        }
        return response()->json($response->GetData());
    }
}
