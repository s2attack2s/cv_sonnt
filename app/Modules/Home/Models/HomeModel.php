<?php

/**
 * HomeModel
 * Model processing for get data of home
 *
 * 処理概要/process overview  : HomeModel
 * 作成日/create date         : 2021/08/13
 * 作成者/creater             : AnhHT
 *
 * 更新日/update date         :
 * 更新者/updater             :
 * 更新内容 /update content   :
 *
 * @package Modules/Home
 * @copyright Copyright (c) toploop.co
 * @version 1.0.0
 */

namespace App\Modules\Home\Models;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request;

class HomeModel
{

    public function GetHomeData($code)
    {
        try {

            $languages = [ 1 => 'vi', 2 => 'en'];
            foreach($languages as $key => $language) {
                if($language == $code){
                    $lang = $key;
                }
            }

            return [
                'Profile' => $this->GetProfile($lang),
                'Objective' => $this->GetObjective($lang),
                'Education' => $this->GetEducation($lang),
                'Work' => $this->GetWork($lang),
                'Skill' => $this->GetSkill($lang),
                'Certification' => $this->GetCertification($lang),
                'Awards' => $this->GetAwards($lang),
            ];
        } catch (\Exception $e) {
            throw $e;
        }
    }

    /**
     * GetDeliveryModels
     * Created: 2021/08/13
     * @author ThanhND
     * @return Array
     */
    public function GetProfile($lang)
    {
        try {
            $lang = $this->GetCode($lang , 'profile');
            return DB::table('profile')
                ->where('language_id', $lang)
                ->where('deleted_at', null)
                ->select('*')
                ->get()->toArray();
        } catch (\Exception $e) {
            throw $e;
        }
    }

      /**
     * GetContractTypes
     * Created: 2021/08/13
     * @author ThanhND
     * @return Array
     */
    public function GetObjective($lang)
    {
        try {
            $lang = $this->GetCode($lang , 'objective');
            return DB::table('objective')
                ->where('language_id', $lang)
                ->where('deleted_at', null)
                ->select('*')
                ->get()->toArray();
        } catch (\Exception $e) {
            throw $e;
        }
    }

      /**
     * GetContractTypeDetails
     * Created: 2021/08/13
     * @author ThanhND
     * @return Array
     */
    public function GetEducation($lang)
    {
        try {
            $lang = $this->GetCode($lang , 'education');
            return DB::table('education')
                ->where('language_id', $lang)
                ->where('deleted_at', null)            
                ->select('*')
                ->get()->toArray();
        } catch (\Exception $e) {
            throw $e;
        }
    }

    /**
     * GetClients
     * Created: 2021/08/13
     * @author ThanhND
     * @return Array
     */
    public function GetWork($lang)
    {
        try {
            $lang = $this->GetCode($lang , 'work-ep');
            return DB::table('work-ep')
                ->where('language_id', $lang)
                ->where('deleted_at', null)
                ->select('*')
                ->get()->toArray();
        } catch (\Exception $e) {
            throw $e;
        }
    }

    /**
     * GetNews
     * Created: 2021/08/12
     * @author ThanhND
     * @return Array
     */
    public function GetSkill($lang)
    {
        try {
            $lang = $this->GetCode($lang , 'skill');
            return DB::table('skill')
                ->where('language_id', $lang)
                ->where('deleted_at', null)
                ->select('*')
                ->get()->toArray();
        } catch (\Exception $e) {
            throw $e;
        }
    }

    public function GetCertification($lang)
    {
        try {
            $lang = $this->GetCode($lang , 'certification');
            return DB::table('certification')
                ->where('language_id', $lang)
                ->where('deleted_at', null)
                ->select('*')
                ->get()->toArray();
        } catch (\Exception $e) {
            throw $e;
        }
    }

    public function GetAwards($lang)
    {
        try {
            $lang = $this->GetCode($lang , 'awards');
            return DB::table('awards')
                ->where('language_id', $lang)
                ->where('deleted_at', null)
                ->select('*')
                ->get()->toArray();
        } catch (\Exception $e) {
            throw $e;
        }
    }

    public function GetCode($lang , $table)
    {
        try {
            $langTb = DB::table($table)
                ->where('language_id', $lang)
                ->where('deleted_at', null)
                ->get()->toArray();
            if($langTb){
                return $lang =  $lang;
            }else{
                return $lang = 1;
            }
        }
        catch(\Exception $e) {
            throw $e;
        }
    }
}
