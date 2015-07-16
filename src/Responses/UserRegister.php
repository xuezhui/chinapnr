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

namespace Fakeronline\Chinapnr\Responses;

use Fakeronline\Chinapnr\Services\Responses;
use Fakeronline\Chinapnr\Utils\Arr;


class UserRegister extends Responses{

    protected function sortAttribute(){

        return [
            'Version', 'CmdId', 'MerCustId', 'BgRetUrl', 'RetUrl', 'UsrId', 'UsrName', 'IdType', 'IdNo', 'UsrMp', 'UsrEmail', 'MerPriv'
        ];

    }

    public function getCardNo(){

        return Arr::get($this->value, 'OpenAcctId', '');
    }

//    public function getBank(){
//
//    }

    public function getUserId(){

        return Arr::get($this->value, 'UsrCustId', '');

    }

    public function getDesc(){

        return Arr::get($this->value, 'RespDesc', '');

    }


}