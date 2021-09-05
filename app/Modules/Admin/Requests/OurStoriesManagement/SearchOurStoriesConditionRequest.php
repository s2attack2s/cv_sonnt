<?php
/**
 * SearchStoriesConditionRequest
 * Request for validate and set default values for search stories
 *
 * 処理概要/process overview  : SearchOurStoriesConditionRequest
 * 作成日/create date         : 2021/06/03
 * 作成者/creater             : Trung
 *
 * 更新日/update date         :
 * 更新者/updater             :
 * 更新内容 /update content   :
 *
 * @package Customer
 * @copyright Copyright (c) ANS-ASIA
 * @version 1.0.0
 */
namespace App\Modules\Admin\Requests\OurStoriesManagement;

use App\Http\Requests\CommonRequest;

class SearchOurStoriesConditionRequest extends CommonRequest
{
    /**
     * Get the validation rules that apply to the request.
     * @return array
     */
    public function rules()
    {
        return [
            'search'  => 'max:100',
            'per_page'  => 'numeric',
            'page'  => 'numeric',
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
