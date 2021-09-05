<?php
/**
 * DeliveryModelDetailRequest
 * Request for validate and set default values for data of slide
 *
 * 処理概要/process overview  : DeliveryModelDetailRequest
 * 作成日/create date         : 2021/08/15
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
namespace App\Modules\Admin\Requests\DeliveryModelsManagement;

use App\Http\Requests\CommonRequest;

class DeliveryModelDetailRequest extends CommonRequest
{
    /**
     * Get the validation rules that apply to the request.
     * @return array
     */
    public function rules()
    {
        return [
            'title'     => 'required|max:255'
        ];
    }

    /**
     * Get default value if not have in request of DeliveryModel
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
