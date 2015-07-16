<?php
/**
 * ServicesTrait.php
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
use Fakeronline\Chinapnr\Utils\Arr;
use Fakeronline\Chinapnr\Tools\Encrypt;

trait ServicesTrait{


    final protected function sign(){

        $result = $this->sortArgs($this->sortAttribute, $this->value);
        $resultStr = implode('', $result);

        $encrypt = new Encrypt();
        $resultStr = $encrypt->secureToolSha1_128($resultStr);
        return $encrypt->secureToolRsaEncrypt($resultStr, $encrypt->buildKeyStr($this->config['privateKey']));
    }

    protected function sortArgs(array $exampleArr, array $args){

        $result = [];

        foreach($exampleArr as $key){

            $value = Arr::get($args, $key);

            if(!is_null($value)){
                $result[$key] = $value;
            }

        }
        return $result;

    }

    abstract public function params($args);

    abstract protected function sortAttribute();

    public function __get($key){

        return Arr::get($this->value, $key);

    }

    public function __set($key, $value){

        if(in_array($key, $this->attribute) && (!in_array($key, $this->guarded))){
            $this->value[$key] = $value;
        }

    }

    public function __call($method, $args){

        $this->__set($method, reset($args));

        return $this;

    }

}