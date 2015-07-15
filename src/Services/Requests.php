<?php
/**
 * Requests.php
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
use Fakeronline\Chinapnr\Utils\Arr;
use Fakeronline\Chinapnr\Tools\Encrypt;

abstract class Requests{

    use ServicesTrait;

    const VERSION_10 = '10';

    /**
     * 存放配置
     * @var array
     */
    protected $config = [];

    /**
     * 属性数组
     * @var array
     */
    protected $attribute = [];

    /**
     * 存放属性值
     * @var array
     */
    protected $value = [];

    /**
     * 不可手动设置的属性
     * @var array
     */

    /**
     * 排序顺序属性
     * @var array
     */
    protected $sortAttribute = [];

    protected $requiredAttr = [];

    /**
     * 受保护的参数KEY将不能设置指
     * @var array
     */
    protected $guarded = ['CmdId']; //目前只有消息类型不能手动设置


    public function __construct($url, array $key, $merCustId){

        if(empty($url) || empty($key) || empty($merCustId)){

            throw new Exception('URL、KEY、MERCUST_ID为必要参数。其中KEY参数为数组，传入私有KEY和公有KEY!');

        }

        $this->config = [
            'url' => $url,
            'privateKey' => Arr::get($key, 'privateKey', ''),
            'publicKey' => Arr::get($key, 'publicKey', ''),
            'merCustId' => $merCustId
        ];

        $this->attribute = (array)($this->attribute()); //获得属性参数
        $this->sortAttribute = (array)($this->sortAttribute()); //获取排序顺序参数
        $this->requiredAttr = (array)($this->requiredAttr());   //获取必要参数

        $this->value['Version'] = self::VERSION_10; //设置版本号，默认为10版本

        $className = explode('\\', get_class($this));   //静态获取类名
        $this->value['CmdId'] = end($className);    //设置操作

        $this->value['MerCustId'] = $this->config['merCustId']; //设置商户号

    }

    /**
     * 设置版本号
     * @param string $version   版本号
     * @return $this    当前对象
     * @throws Exception
     */
    public function setVersion($version = '10'){

        if($version != self::VERSION_10){
            throw new Exception('暂不支持此版本!');
        }

        $this->value['Version'] = $version;

        return $this;

    }


    /**
     * 设置接口应答地址
     * @param string $bgUrl    后台应答地址
     * @param string $recUrl    前台应答地址
     * @return $this    当前对象
     * @throws Exception
     */
    public function setUrl($bgUrl, $recUrl = ''){

        if(empty($bgUrl)){
            throw new Exception('商户后台应答地址不能为空!');
        }

        $this->value['BgRetUrl'] = $bgUrl;

        $this->value['RetUrl'] = $recUrl;

        return $this;

    }

    abstract public function request();



}