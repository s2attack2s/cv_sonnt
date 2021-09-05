<?php
/**
 * CompanyProfileDetailRequest
 * Request for validate and set default values for data of slide
 *
 * 処理概要/process overview  : CompanyProfileDetailRequest
 * 作成日/create date         : 2021/08/17
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
namespace App\Modules\Admin\Requests\CompanyProfilesManagement;

use App\Http\Requests\CommonRequest;

class CompanyProfileDetailRequest extends CommonRequest
{
    /**
     * Get the validation rules that apply to the request.
     * @return array
     */
    public function rules()
    {
        return [
            'company_name'     => 'required|max:255',
            'founded'     => 'required|max:255',
            'tel'     => 'required|max:255',
            'capital'     => 'required|max:255',
            'main_bank'     => 'required|max:255',
            'ceo_name'     => 'required|max:255',
        ];
    }

    /**
     * Get default value if not have in request of company_info
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
