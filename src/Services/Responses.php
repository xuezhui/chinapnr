<?php
/**
 * Responses.php
 *
 * Part of Allinpay.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author    Fackeronline <1077341744@qq.com>
 * @link      https://github.com/Fakeronline
 */

namespace Fakeronline\Chinapnr\Services;
use Exception;

abstract class Responses{

    use ServicesTrait;

    protected $config;
    protected $errorMsg;

    protected $sortAttr = [];
    protected $value = [];

    public function __construct($key){

        if(empty($key)){

            throw new Exception('没有KEY将无法解密!');

        }

        $this->config['key'] = $key;


    }

    public function chkValue(){

        if(empty($this->value)){
            throw new Exception('未得到任何参数值，无法进行校验!');
        }

        $sign = $this->sign();

        if($sign == $this->value['ChkValue']){
            return true;
        }

        return false;

    }


}