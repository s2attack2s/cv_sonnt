<?php

/**
 * CandidateDetailModel
 * Model processing for page candidate detail
 *
 * 処理概要/process overview  : CandidateDetailModel
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

namespace App\Modules\Admin\Models\CandidatesManagement;

use Illuminate\Support\Facades\DB;
use Helper, DataResponse, ResponseCode;
use Illuminate\Support\Str;

class CandidateDetailModel
{
    protected $lang;

    public function __construct() {
        $this->lang = Helper::GetCookies('lang', 'en');
    }

    /**
     * Get data candidate follow id
     * Created: 2021/05/28
     * @param int $id Id of candidate
     * @return Array Data of candidate
     * @throws \Exception
     * @author TriTD <tritd@toploop.co>
     */
    public function LoadCandidate($id)
    {
        try {
            $candidate = DB::table("candidates")
                ->select('candidates.id', 'candidates.name', 'candidates.email', 'candidates.phone',
                    'career_id', 'candidates.cv_file', 'candidates.message', 'candidates.created_at', 'candidates.status',
                    'careers.name as career_name'
                )
                ->join('careers', 'careers.id', '=', 'candidates.career_id')
                ->where('candidates.id', $id)
                ->where('candidates.deleted_at', null)->first();
            return  $candidate;
        }
        catch(\Exception $e) {
            throw $e;
        }
    }

    /**
     * List Of Job Types
     * @return \Illuminate\Support\Collection
     * @throws \Exception
     */
    public function LoadListJobTypes() {
        try {
            $types = DB::table("job_types")
                ->pluck('name', 'id');

            return  $types;
        }
        catch(\Exception $e) {
            throw $e;
        }
    }

    /**
     * List Of Job Types
     * @return \Illuminate\Support\Collection
     * @throws \Exception
     */
    public function LoadListJobs() {
        try {
            $jobs = DB::table("careers")
                ->whereNull('deleted_at')
                //->where('status', '>',0)
                ->orderBy('created_at', 'desc')
                ->pluck('name', 'id')
            ;

            return  $jobs;
        }
        catch(\Exception $e) {
            throw $e;
        }
    }

    /**
     * Update candidate
     * Created: 2021/05/31
     * @param Array $data Data of candidate from candidate
     * @return Array updated result
     * @throws \Exception
     * @author TriTD <tritd@toploop.co>
     */
    public function UpdateCandidate($data)
    {
        $folder = 'upload/candidate/';
        $candidate = DB::table('candidates')->where('id', $data['id'])->first();

        try {
            $response = new DataResponse();
            $image = $candidate->logo;
            // upload image
            if (isset($data['image'])) {
                $img = Helper::SaveFileImg($data['image'], $folder, 'images');

                if ($img['status']) {
                    $image = $img['path'];
                }
                else {
                    $response->msgNo = $img['error'];
                    $response->code = ResponseCode::HAVE_ERROR;
                    return $response;
                }
            }

            if ($response->code == ResponseCode::OK) {
                $userId = Helper::GetCurrentUserId();
                // Update data
                DB::table('candidates')
                    ->where('id', $data['id'])
                    ->update([
                        'name' => $data['name'],
                        'logo' => $image,
                        'updated_at' => date('Y-m-d H:i:s')
                    ]);

                $response->data['id'] = $data['id'];
            }
            return $response;
        }
        catch(\Exception $e) {
//            Helper::DeleteFile($viImgPath);
            throw $e;
        }
    }

    /**
     * Approve CV
     * @param $id
     * @return DataResponse
     * @throws \Exception
     */
    public function ApproveCandidate($ids)
    {
        $response = new DataResponse();
       try{
                // Update data
            DB::table('candidates')
                ->whereIn('id', $ids)
                ->update([
                    'status' => 1
                ]);

            return $response;
        }
        catch(\Exception $e) {
            throw $e;
        }
    }

    /**
     * Reject CV
     * @param $id
     * @return bool
     * @throws \Exception
     */
    public function RejectCandidate($ids)
    {
        $response = new DataResponse();
        try{
            // Update data
            DB::table('candidates')
                ->whereIn('id', $ids)
                ->update([
                    'status' => 2
                ]);

            return $response;
        }
        catch(\Exception $e) {
            throw $e;
        }
    }

    /**
     * Insert new candidate
     * Created: 2021/05/31
     * @param Array $data Data of candidate from candidate
     * @return Array inserted result
     * @throws \Exception
     * @author TriTD <tritd@toploop.co>
     */
    public function InsertCandidate($data)
    {
        $folder = 'upload/candidate/';
        try {
            $response = new DataResponse();
            $logo = null;
            // upload image
            if (isset($data['image'])) {
                $img = Helper::SaveFileImg($data['image'], $folder, 'images');

                if ($img['status']) {
                    $logo = $img['path'];
                }
                else {
                    $response->msgNo = $img['error'];
                    $response->code = ResponseCode::HAVE_ERROR;
                    return $response;
                }
            }

            // Insert data with main and translate language
            $candidate = DB::table('candidates')->insert([
                [
                    'name' => $data['name'],
                    'logo' => $logo,
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
