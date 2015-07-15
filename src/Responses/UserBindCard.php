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

namespace Fakeronline\Chinapnr\Responses;

use Fakeronline\Chinapnr\Services\Responses;

/**
 * @see as
 * Class UserBindCard
 * @package Fakeronline\Chinapnr\Responses
 */
class UserBindCard extends Responses{

    protected function sortAttribute(){

        return [
            'CmdId', 'RespCode', 'MerCustId', 'OpenAcctId', 'OpenBankId', 'UsrCustId', 'TrxId', 'BgRetUrl', 'MerPriv'
        ];

    }

}