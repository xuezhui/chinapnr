<?php
/**
 * UserRegister.php
 *
 * Part of Allinpay.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author    Fackeronline <1077341744@qq.com>
 * @link      https://github.com/Fakeronline
 */

namespace Fakeronline\Chinapnr;

use Fakeronline\Chinapnr\Services\Requests;
use Fakeronline\Chinapnr\Utils\Arr;
use Exception;
use Fakeronline\Chinapnr\Utils\Curl;
use Fakeronline\Chinapnr\Utils\Form;

class UserRegister extends  Requests{

    protected function attribute(){

        return [
            'Version', 'CmdId', 'MerCustId', 'BgRetUrl', 'RetUrl', 'UsrId', 'UsrName', 'IdType', 'IdNo', 'UsrMp', 'UsrEmail', 'MerPriv', 'CharSet', 'ChkValue'
        ];

    }

    protected function sortAttribute(){

        return [
            'Version', 'CmdId', 'MerCustId', 'BgRetUrl', 'RetUrl', 'UsrId', 'UsrName', 'IdType', 'IdNo', 'UsrMp', 'UsrEmail', 'MerPriv', 'ChkValue'
        ];

    }

    protected function requiredAttr(){

        return [
            'Version', 'CmdId', 'MerCustId', 'BgRetUrl', 'ChkValue'
        ];

    }


    /**
     * 排序算法
     * @return array 排序后的数组
     */
    final protected function sortArgs(array $exampleArr, array $args){

        $result = [];

        foreach($exampleArr as $key){

            $value = Arr::get($args, $key);

            if(!is_null($value)){
                $result[$key] = $value;
            }

        }
        return $result;

    }

    public function params($args){

        foreach($args as $key => $value){

            if(in_array($key, $this->attribute)){

                if(in_array($key, $this->guarded)){
                    throw new Exception("{$key}受保护，不允许设置!");
                }

                $this->value[$key] = $value;
            }

        }

        return $this;

    }


    public function request(){

        $this->value['ChkValue'] = $this->sign();
dump($this->value);
        $curl = new Curl($this->config['url']);
        $result =  $curl->setData($this->value)->get();
dump($result);
    }


}