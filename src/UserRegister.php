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
use Exception;
use Fakeronline\Chinapnr\Utils\Curl;

/**
 * @method UsrId($UsrId)
 * @method UsrName($UsrName)
 * @method IdNo($IdNo)
 * @method UsrMp($phoneNo)
 * @method UsrEmail($email)
 * @method MerPriv($merPriv)
 * Class UserRegister
 * @package Fakeronline\Chinapnr
 */
final class UserRegister extends  Requests{

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
}