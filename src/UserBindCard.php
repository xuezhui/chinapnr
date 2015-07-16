<?php
/**
 * UserBindCard.php
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

class UserBindCard extends Requests{

    protected function attribute(){

        return [
            'Version', 'CmdId', 'MerCustId', 'UsrCustId', 'BgRetUrl', 'MerPriv', 'ChkValue'
        ];

    }

    protected function sortAttribute(){

        return [
            'Version', 'CmdId', 'MerCustId', 'UsrCustId', 'BgRetUrl', 'MerPriv'
        ];

    }

    protected function requiredAttr(){

        return [
            'Version', 'CmdId', 'MerCustId', 'UsrCustId', 'BgRetUrl', 'ChkValue'
        ];

    }

    public function setUrl($bgUrl){

        if(empty($bgUrl)){
            throw new Exception('无效的通知地址!');
        }

        $this->value['BgRetUrl'] = $bgUrl;

        return $this;

    }


}