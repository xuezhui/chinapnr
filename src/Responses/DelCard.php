<?php
/**
 * DelCard.php
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

class DelCard extends Responses{

    protected function sortAttribute(){

        return [
            'CmdId', 'RespCode', 'RespDesc', 'MerCustId', 'UsrCustId', 'CardId', 'ChkValue'
        ];

    }

    public function getDesc(){

        return Arr::get($this->value, 'ChkValue');
    }

    public function getUserId(){

        return Arr::get($this->value, 'UsrCustId');
    }

    public function getCardId(){

        return Arr::get($this->value, 'UsrCustId');
    }

}