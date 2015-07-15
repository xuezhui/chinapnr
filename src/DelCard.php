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

namespace Fakeronline\Chinapnr;

use Fakeronline\Chinapnr\Services\Requests;

class DelCard extends Requests{

    protected function attribute(){

        return [
            'Version', 'CmdId', 'MerCustId', 'UsrCustId', 'CardId', 'ChkValue'
        ];

    }

    protected function sortAttribute(){

        return [
            'Version', 'CmdId', 'MerCustId', 'UsrCustId', 'CardId'
        ];

    }

    protected function requiredAttr(){

        return [
            'Version', 'CmdId', 'MerCustId', 'UsrCustId', 'CardId'
        ];

    }

    //TODO：因为是实时返回的，所以这块还需要做点修改

}