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

    protected $sortAttribute = [];
    protected $value = [];

    public function __construct($key){

        if(empty($key)){

            throw new Exception('没有KEY值无法进行解密!');

        }

        $this->config['privateKey'] = $key;


    }


    public function chkValue(){

        if(empty($this->value)){
            throw new Exception('没有值可以进行加密!');
        }

        $sign = $this->sign();

        if($sign == $this->value['ChkValue']){
            return true;
        }

        return false;

    }

    public function params($args){

        $this->value = $args;

        return $this;

    }


}