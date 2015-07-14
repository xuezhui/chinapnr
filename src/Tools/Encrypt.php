<?php

namespace Fakeronline\Chinapnr\Tools;

class Encrypt
{

    public function buildKeyStr($key){
        return $this->buildKey(substr($key, 48));
    }

    private function buildKey($key){
        $bin = $this->secureToolHex2Bin($key);
        $privateKey["modulus"] = substr($bin, 0, 128);
        $desKey = "SCUBEPGW";
        $cipher = MCRYPT_DES;
        $iv = str_repeat("\x00", 8);
        $prime1 = substr($bin, 384, 64);
        $enc = $this->likeMCryptCbc($cipher, $desKey, $prime1, MCRYPT_DECRYPT, $iv);
        $privateKey["prime1"] = $enc;
        $prime2 = substr($bin, 448, 64);
        $enc = $this->likeMCryptCbc($cipher, $desKey, $prime2, MCRYPT_DECRYPT, $iv);
        $privateKey["prime2"] = $enc;
        $primeExponent1 = substr($bin, 512, 64);
        $enc = $this->likeMCryptCbc($cipher, $desKey, $primeExponent1, MCRYPT_DECRYPT, $iv);
        $privateKey["prime_exponent1"] = $enc;
        $primeExponent2 = substr ($bin, 576, 64);
        $enc = $this->likeMCryptCbc($cipher, $desKey, $primeExponent2, MCRYPT_DECRYPT, $iv);
        $privateKey["prime_exponent2"] = $enc;
        $coefficient = substr ($bin, 640, 64);
        $enc = $this->likeMCryptCbc($cipher, $desKey, $coefficient, MCRYPT_DECRYPT, $iv);
        $privateKey["coefficient"] = $enc;
        return $privateKey;
    }
    private function likeMCryptCbc($cipher, $key, $data, $md, $iv){
        if(!$data)return "";
        $td = mcrypt_module_open(MCRYPT_DES, '', MCRYPT_MODE_CBC, '');
        mcrypt_generic_init($td, $key, $iv);
        $data = mdecrypt_generic($td, $data);
        mcrypt_generic_deinit($td);
        mcrypt_module_close($td);
        return $data;
    }
    private function secureToolHex2Bin($hexData) {
        $binData = '';
        if (strlen($binData) % 2 == 1) {
            $hexData = '0' . $hexData;
        }
        for($i = 0; $i < strlen ($hexData); $i += 2) {
            $binData .= chr(hexdec(substr($hexData, $i, 2)));
        }
        return $binData;
    }
    private function secureToolPadstr($src, $len = 256, $chr = '0', $d = 'L') {
        $ret = trim ($src);
        $padLen = $len - strlen ($ret);
        if ($padLen > 0) {
            $pad = str_repeat ($chr, $padLen);
            if (strtoupper ($d) == 'L') {
                $ret = $pad . $ret;
            } else {
                $ret = $ret . $pad;
            }
        }
        return $ret;
    }
    private function secureToolBin2Int($binData) {
        $hexData = bin2hex ($binData);
        return $this->secureToolBchexdec($hexData);
    }
    private function secureToolBchexdec($hexData) {
        $ret = '0';
        $len = strlen ($hexData);
        for($i = 0; $i < $len; $i ++) {
            $hex = substr ($hexData, $i, 1 );
            $dec = hexdec ( $hex );
            $exp = $len - $i - 1;
            $pow = bcpow('16', $exp);
            $tmp = bcmul($dec, $pow);
            $ret = bcadd($ret, $tmp);
        }
        return $ret;
    }
    private function secureToolBcdechex($decData) {
        $s = $decData;
        $ret = '';
        while ( $s != '0' ) {
            $m = bcmod ( $s, '16' );
            $s = bcdiv ( $s, '16' );
            $hex = dechex ( $m );
            $ret = $hex . $ret;
        }
        return $ret;
    }
    public function secureToolSha1_128($string) {
        $hashPad = "0001ffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffff003021300906052b0e03021a05000414";
        $hash = sha1($string);
        $shaBin = $this->secureToolHex2Bin($hash);
        $shaPad = $this->secureToolHex2Bin($hashPad);
        return $shaPad . $shaBin;
    }
    public function secureToolRsaEncrypt($input, $privateKey) {
        $p = $this->secureToolBin2Int($privateKey['prime1']);
        $q = $this->secureToolBin2Int($privateKey["prime2"]);
        $u = $this->secureToolBin2Int($privateKey["coefficient"]);
        $dP = $this->secureToolBin2Int($privateKey["prime_exponent1"]);
        $dQ = $this->secureToolBin2Int($privateKey["prime_exponent2"]);
        $c = $this->secureToolBin2Int($input);
        $cp = bcmod ( $c, $p );
        $cq = bcmod ( $c, $q );
        $a = bcpowmod ( $cp, $dP, $p );
        $b = bcpowmod ( $cq, $dQ, $q );
        if (bccomp ( $a, $b ) >= 0) {
            $result = bcsub ( $a, $b );
        } else {
            $result = bcsub ( $b, $a );
            $result = bcsub ( $p, $result );
        }
        $result = bcmod ( $result, $p );
        $result = bcmul ( $result, $u );
        $result = bcmod ( $result, $p );
        $result = bcmul ( $result, $q );
        $result = bcadd ( $result, $b );
        $ret = $this->secureToolBcdechex($result);
        return strtoupper($this->secureToolPadstr($ret));
    }

    public function secureToolRsaDecrypt($input, $privateKey) {
        $check = $this->secureToolBchexdec($input);
        $modulus = $this->secureToolBin2Int($privateKey['modulus']);
        $exponent = $this->secureToolBchexdec("010001");
        $result = bcpowmod($check, $exponent, $modulus );
        $rb = $this->secureToolBcdechex($result);
        return strtoupper($this->secureToolPadstr($rb));
    }

}