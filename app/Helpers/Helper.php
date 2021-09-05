<?php
/**
 * Select
 * Helper to get common data
 *
 * 処理概要/process overview  : Helper
 * 作成日/create date         : 2021/05/26
 * 作成者/creater             : QuyPN - quy.pham@toploop.co
 *
 * 更新日/update date         :
 * 更新者/updater             :
 * 更新内容 /update content   :
 *
 * @package System
 * @copyright Copyright (c) toploop.co
 * @version 1.0.0
 */

namespace App\Helpers;
use DB, Exception, Cookie;

class Helper {

    public function __construct() {
    }

    /**
     * Get value of cookies by key
     * Created: 2021/05/28
     * @author QuyPN <quy.pham@toploop.co>
     * @param String $key
     * @param String $default
     * @return String Value of key in cookies of empty string if key not exists
     */
    public static function GetCookies($key, $default = '') {
        try {
            return $_COOKIE[$key];
        }
        catch(Exception $e) {
            return $default;
        }
    }

    /**
     * Rollback transaction if exists
     * Created: 2021/05/28
     * @author QuyPN <quy.pham@toploop.co>
     */
    public static function RollBackTrans() {
        try {
            if(DB::transactionLevel() > 0) {
                DB::rollBack();
            }
        }
        catch(Exception $e) {
        }
    }

    /**
     * Get id of current user loginning
     * Created: 2021/05/26
     * @author QuyPN <quy.pham@toploop.co>
     * @return Integer Id of user is loginning
     */
    public static function GetCurrentUserId() {
        try {
            $token = Helper::GetCookies('token');
            $now = new \DateTime(date('Y-m-d H:i:s'));
            if(!isset($token) || $token == '' || $token == null) {
                return 0;
            }
            else {
                $userDB = DB::table('users')
                    ->where('token', $token)
                    ->where('timeout', '>=', $now)
                    ->where('deleted_at', null)
                    ->select('id')
                    ->get()->toArray();
                if (isset($userDB) && !empty($userDB)) {
                    return $userDB[0]->id;
                }
            }
            return 0;
        }
        catch(Exception $e) {
            throw $e;
        }
    }

    /**
     * Get data of current user loginning
     * Created: 2021/05/26
     * @author QuyPN <quy.pham@toploop.co>
     * @return Array Data of user is loginning
     */
    public static function GetCurrentUser() {
        try {
            $token = Helper::GetCookies('token');
            $now = new \DateTime(date('Y-m-d H:i:s'));
            if(!isset($token) || $token == '' || $token == null) {
                return [];
            }
            else {
                $userDB = DB::table('users')
                    ->where('token', $token)
                    ->where('timeout', '>=', $now)
                    ->where('deleted_at', null)
                    ->select('id',  'name', 'email')
                    ->get()->toArray();
                if (isset($userDB) && !empty($userDB)) {
                    return $userDB[0];
                }
            }
            return [];
        }
        catch(Exception $e) {
            throw $e;
        }
    }

    /**
     * Get name of user by id
     * Created: 2021/05/28
     * @author QuyPN <quy.pham@toploop.co>
     * @return String Name of user
     */
    public static function GetUsername($id) {
        try {
            $userDB = DB::table('users')
                ->where('id', $id)
                ->select('username', 'name')
                ->get()->toArray();
            if (isset($userDB) && !empty($userDB)) {
                return $userDB[0]->name;
            }
            return __('System');
        }
        catch(Exception $e) {
            return __('System');
        }
    }

    /**
     * Check value of key in array is null or empty
     * Created: 2021/05/28
     * @author QuyPN <quy.pham@toploop.co>
     * @param Array $arr Array need to check
     * @param String $key key have value need to check
     * @return Boolean
     */
    public static function IsNullOrEmpty($arr, $key) {
        try {
            if(!isset($arr) || empty($arr) || !isset($arr[$key]) || empty($arr[$key]) || $arr[$key] == null || $arr[$key] == '') {
                return true;
            }
            return false;
        }
        catch(Exception $e) {
            return true;
        }
    }

    /**
     * Get uuid
     * Created: 2021/05/26
     * @author QuyPN <quy.pham@toploop.co>
     * @return String uuid v4
     */
    public static function GenerateUuid() {
        return sprintf( '%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
            // 32 bits for "time_low"
            mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ),

            // 16 bits for "time_mid"
            mt_rand( 0, 0xffff ),

            // 16 bits for "time_hi_and_version",
            // four most significant bits holds version number 4
            mt_rand( 0, 0x0fff ) | 0x4000,

            // 16 bits, 8 bits for "clk_seq_hi_res",
            // 8 bits for "clk_seq_low",
            // two most significant bits holds zero and one for variant DCE1.1
            mt_rand( 0, 0x3fff ) | 0x8000,

            // 48 bits for "node"
            mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff )
        );
    }

    /**
     * Create a random string
     * Created: 2021/05/26
     * @author QuyPN <quy.pham@toploop.co>
     * @param Integer length of string will be generate. Default is 100
     * @return String uuid v4
     */
    public static function GenerateRandomString($length = 100) {
        try{
            $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ_-';
            $charactersLength = strlen($characters);
            $randomString = '';
            for ($i = 0; $i < $length; $i++) {
                $randomString .= $characters[rand(0, $charactersLength - 1)];
            }
            return $randomString . Helper::GenerateUuid();
        }
        catch(Exception $e) {
            throw $e;
        }
    }

    /**
     * Check have error data from SPC or not
     * Created: 2021/05/26
     * @author QuyPN <quy.pham@toploop.co>
     * @param Array Data from SPC
     * @return Boolean true - if not error, false - if have error from DB, Exception if SPC have exception
     */
    public static function HasDatabaseError($data) {
        try {
            if ( empty($result) ) return false; // haven't error
            // Check SQL error
            if ( isset($result[0][0]['error_typ']) && $result[0][0]['error_typ'] != 0 ) {
                // SQL Exception
                if ( $result[0][0]['error_typ'] == 999 ) throw new \Exception($result[0][0]['remark']);
                // Logic error
                return true;
            }
            return false;
        }
        catch(Exception $e) {
            throw $e;
        }
    }

    /**
     * Get Id insert of table
     * Created: 2021/05/26
     * @author QuyPN <quy.pham@toploop.co>
     * @param String $table Name of table want to get new Id
     * @return Integer New id of table
     */
    public static function GetId($table) {
        try {
            $getLastID = DB::table($table)->select('id')->orderBy('id', 'DESC')->first();
            if ($getLastID == null) {
                return 1;
            } else {
                return ++$getLastID->id;
            }
        } catch (Exception $e) {
            return -1;
        }
    }

    /**
     * Get data of library use in combobox by type
     * Created: 2021/05/26
     * @author QuyPN <quy.pham@toploop.co>
     * @param Integer $id Type of library need to get data
     * @param String $lang Current language code
     * @return Array Data of library
     */
    public static function GetLibrary($id, $lang='en') {
        try {
            return DB::table('libraries')
                ->where('libraries.id', $id)
                ->where('libraries.lang', $lang)
                ->where('libraries.deleted_at', '=', null)
                ->select(
                    'libraries.number as id',
                    'libraries.name as name'
                )
                ->get()->toArray();
        } catch (Exception $e) {
            return;
        }
    }

    /**
     * Get list language for translate
     * Created: 2021/05/28
     * @author QuyPN <quy.pham@toploop.co>
     * @return Array Data of laguage
     */
    public static function GetLanguages() {
        try {
            $vi = 'vi';
            return DB::table('languages')
                ->where('deleted_at', null)
                ->where('language_code', '<>', $vi)
                ->select(
                    'language_code as code',
                    'language_name as name'
                )
                ->get()->toArray();
        } catch (Exception $e) {
            return [];
        }
    }

    /**
     * Escape string before render sql
     * Created: 2021/05/28
     * @author QuyPN <quy.pham@toploop.co>
     * @param String $str string need to escape
     * @return String string after  escape
     */
    public static function SqlEscString($str)
    {
        try {
            $ret = str_replace([ '%', '_' ], [ '\%', '\_' ], DB::getPdo()->quote($str));
            return $ret && strlen($ret) >= 2 ? substr($ret, 1, strlen($ret)-2) : $ret;
        } catch (Exception $e) {
            return $str;
        }
    }

    public static function SaveFileImg($file, $folder = 'upload_file/', $filename = '', $maxSize = 10, $typeFiles = ['png', 'jpg', 'jpeg'])
    {
        $status = false;
        $error = 'E023';
        $path = '';
        try {
            if(isset($file)){
                $extension = $file->getClientOriginalExtension();
                $size = $file->getSize();
                $filename = $filename . '_' . date('YmdHis') . time() . '.' . $extension;
                if (!file_exists($folder)) {
                    mkdir($folder, 0777, true);
                }
                if(in_array($extension, $typeFiles)){
                    if($size/1024/1024 > $maxSize){
                        $error = 'E020';
                    }
                    else {
                        $path = $folder . $filename;
                        if (file_exists($path)) {
                            unlink($path);
                        }
                        $status = true;
                        $error = '';
                        $file->move($folder, $filename);
                        $path = '/' . $path;
                    }
                }
                else {
                    $error = 'E021';
                }
            }
            else {
                $error = 'E024';
            }
        }
        catch (Exception $e) {
        }
        return [
            'status' => $status,
            'error' => $error,
            'path' => $path
        ];
    }
    public static function DeleteFile($path)
    {
        try {
            if (file_exists($path)) {
                unlink($path);
            }
        }
        catch (Exception $e) {
        }
    }
}
