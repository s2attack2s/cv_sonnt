<?php
/**
 * DataResponse
 * Format of data will return to client
 *
 * 処理概要/process overview  : DataResponse
 * 作成日/create date         : 2020/03/25
 * 作成者/creater             : QuyPN - quy.pham@toploop.co
 *
 * 更新日/update date         :
 * 更新者/updater             :
 * 更新内容 /update content   :
 *
 * @package Common
 * @copyright Copyright (c) toploop.co
 * @version 1.0.0
 */

namespace App\Http\Models\Common\Schemas;

use ResponseCode;

class DataResponse
{
	public $code;
	public $data;
	public $msgError;
	public $msgNo;
	public $dataError;

    /**
     * Init the value default for properies
     * Created: 2021/05/26
     * @author QuyPN <quy.pham@toploop.co>
     */
	public function __construct() {
        $this->code 		= ResponseCode::OK;
        $this->data 		= [];
        $this->msgError 	= '';
        $this->msgNo 		= '';
        $this->dataError 	= [];
    }

    /**
     * Set data to return a exception
     * Created: 2021/05/26
     * @author QuyPN <quy.pham@toploop.co>
     * @param \Exception $e Exception had throewed
     */
    public function SetException($e) {
    	$this->code 		= ResponseCode::SERVICE_ERROR;
    	$this->data 		= [];
        $this->msgError 	= $e->getMessage();
        $this->msgNo 		= 'E500';
        $this->dataError 	= [
            'instance'      => get_class($e),
            'line'          => $e->getLine(),
            'file'          => basename($e->getFile()),
            'code'          => $e->getCode()
        ];
    }

    /**
     * Get data to return to client follow common format
     * Created: 2021/05/26
     * @author QuyPN <quy.pham@toploop.co>
     */
    public function GetData() {
    	return [
    		'code' 		=> $this->code,
    		'data' 		=> $this->data,
            'msgNo' 	=> $this->msgNo,
    		'errors' 	=> [
    			'message'		=> $this->msgError,
    			'message_no'	=> $this->msgNo,
    			'data'			=> $this->dataError,
    		]
    	];
    }
}
