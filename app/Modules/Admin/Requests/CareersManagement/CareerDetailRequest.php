<?php
/**
 * CareerDetailRequest
 * Request for validate and set default values for data of slide
 *
 * 処理概要/process overview  : CareerDetailRequest
 * 作成日/create date         : 2021/05/28
 * 作成者/creater             : tritd@toploop.co
 *
 * 更新日/update date         :
 * 更新者/updater             :
 * 更新内容 /update content   :
 *
 * @package Customer
 * @copyright Copyright (c) ANS-ASIA
 * @version 1.0.0
 */
namespace App\Modules\Admin\Requests\CareersManagement;

use App\Http\Requests\CommonRequest;

class CareerDetailRequest extends CommonRequest
{
    /**
     * Get the validation rules that apply to the request.
     * @return array
     */
    public function rules()
    {
        return [
            'name'     => 'required|max:255',
            'short_desc'      => 'required',
            'detail'      => 'required|max:1000',
            'location_id' => 'required'
        ];
    }

    /**
     * Get default value if not have in request of client
     */
    protected function getDeffaultValues()
    {
        $data = $this->all();
        $defaults = [];
        $data = $this->setDeffaultValues($defaults, $data);
        $this->getInputSource()->replace($data);
    }

    /**
     * Get the validator instance for the request.
     *
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function getValidatorInstance()
    {
        $this->getDeffaultValues();
        return parent::getValidatorInstance();
    }

}
