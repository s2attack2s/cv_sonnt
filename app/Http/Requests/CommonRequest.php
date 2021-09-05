<?php
/**
 * CommonRequest
 * Setting some config common for check validate data
 *
 * 処理概要/process overview  : CommonRequest
 * 作成日/create date         : 2021/05/26
 * 作成者/creater             : quy.pham@toploop.co
 *
 * 更新日/update date         :
 * 更新者/updater             :
 * 更新内容 /update content   :
 *
 * @package System
 * @copyright Copyright (c) toploop.co
 * @version 1.0.0
 */
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;
use Illuminate\Contracts\Validation\Validator;
use Helper, DataResponse, ResponseCode;

abstract class CommonRequest extends FormRequest
{
    /**
     * Get error validate and return follow format json
     * Created: 2021/05/26
     * @param  Validator $validator  Validation information
     * @return DataResponse List Item error
     */
    protected function failedValidation(Validator $validator)
    {
        $response = new DataResponse();
        $response->code = ResponseCode::INVALID_DATA;
        $response->msgError = 'Data invalid';
        $response->msgNo = 'E' . ResponseCode::INVALID_DATA;
        $response->dataError = (new ValidationException($validator))->errors();
        throw new HttpResponseException(response()->json($response->GetData(), JsonResponse::HTTP_UNPROCESSABLE_ENTITY));
    }

    /**
     * custom messages validation
     * @return array
     */
    public function messages(){
        return [
            'required'              => 'E001',
            'max'                   => 'E005',
            'mimes'                 => 'E021'
        ];
    }

    /**
     * Get default value if not have in request of client.
     * Created: 2020/04/01
     * @author QuyPN <quy.pham@toploop.co>
     * @param  Array $dataDeffautls Array have default values
     * @param  Array $data Dataa need to set default values
     * @return Array Data after have default values
     */
    public function setDeffaultValues($dataDeffautls, $data)
    {
        try {
            foreach($dataDeffautls as $key => $value) {
                if(!isset($data[$key]) || $data[$key] == null) {
                    $data[$key] = $value;
                }
            }
            foreach($data as $key => $value) {
                if(isset($data[$key]) && gettype($data[$key]) == 'string') {
                    $data[$key] = Helper::SqlEscString($data[$key]);
                }
            }
            return $data;
        }
        catch(\Exception $e) {
            throw $e;
        }
    }

    /**
     * Get the validator instance for the request.
     *
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function getValidatorInstance()
    {
        return parent::getValidatorInstance();
    }
}
