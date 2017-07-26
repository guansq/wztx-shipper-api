<?php
/**
 * Created by PhpStorm.
 * User: xun
 * Date: 2016/9/28
 * Time: 17:48
 */

namespace pay;

class alipay_mobile extends alipay_common
{
    private $transport='https';
    private $__https_verify_url = 'https://mapi.alipay.com/gateway.do?service=notify_verify&';
    private $__http_verify_url = 'http://notify.alipay.com/trade/notify_query.do?';
    //private $key='cudh56ifrikibb2fyhjk8cmgftml9h42';
    private $key='jgc2ke9ev5rogrcnnltjbaxnkj4iee0i';
    private $sign_type='RSA';
    private $private_key_path='../extend/pay/payment/rsa_private_key.pem';//私钥路径
    private $public_key_path='../extend/pay/payment/alipay_public_key.pem';//支付宝公钥路径
    private $config=[
        'timestamp'     =>      "",
        //'app_id'        =>      "2016082901818372",
        'app_id'        =>      "2017061607503256",
        'method'        =>      "alipay.trade.app.pay",
//        'method'        =>      "alipay.trade.create",
        'charset'       =>      "utf-8",
        'sign_type'     =>      "RSA",
        'format'        =>      "JSON",
        'version'       =>      "1.0",
        'notify_url'    =>      "http://wztx.shp.api.ruitukeji.com/callback/alipay_callback",
        'biz_content'   =>      "",//请求参数
    ];
    public function create_pay($biz_content){
        $this->config['timestamp']=date('Y-m-d H:i:s',time());
        $this->config['biz_content']=json_encode($biz_content,JSON_UNESCAPED_UNICODE);
        //生成完整数组
        $data_array=$this->buildRequestPara($this->config);
        //生成urldecode链接
        $last_url=$this->urlencode_array($data_array);
        return $last_url;
    }

    /**
     * 把数组所有元素，按照“参数=参数值”的模式用“&”字符拼接成字符串 并且进行url编码
     * @param array $para
     * @return string
     */
    private function urlencode_array($para=[]){
        $arg = '';
        while ((list ($key, $val) = each($para)) == true) {
            $arg .= $key . '=' . urlencode($val) . '&';
        }
        //去掉最后一个&字符
        $arg = substr($arg, 0, count($arg) - 2);
        //如果存在转义字符，那么去掉转义
        if (get_magic_quotes_gpc()) {
            $arg = stripslashes($arg);
        }
        return $arg;
    }
    /**
     * 生成签名结果
     * @param $para_sort    已排序要签名的数组
     * @return string   签名结果字符串
     */
    private function buildRequestMysign($para_sort)
    {
        //把数组所有元素，按照“参数=参数值”的模式用“&”字符拼接成字符串
        $prestr = $this->createLinkstring($para_sort);
        switch (strtoupper(trim($this->sign_type))) {
            case 'MD5':
                $mysign = $this->md5Sign($prestr, $this->key);
                break;
            case 'RSA':
                $mysign = $this->rsaSign($prestr, trim($this->private_key_path));
                break;
            default:
                $mysign = '';
        }

        return $mysign;
    }

    /**
     * 把数组所有元素，按照“参数=参数值”的模式用“&”字符拼接成字符串
     * @param $para     需要拼接的数组
     * @return string   拼接完成以后的字符串
     */
    private function createLinkstring($para)
    {
        $para=$this->argSort($para);
        $arg = '';
        while ((list ($key, $val) = each($para)) == true) {
            $arg .= $key . '=' . $val . '&';
        }
        //去掉最后一个&字符
        $arg = substr($arg, 0, count($arg) - 2);
        //如果存在转义字符，那么去掉转义
        if (get_magic_quotes_gpc()) {
            $arg = stripslashes($arg);
        }
        return $arg;
    }

    /**
     * 生成要请求给支付宝的参数数组
     * @param $para_temp 请求前的参数数组
     * @return 要请求的参数数组
     */
    private function buildRequestPara($para_temp)
    {
        //除去待签名参数数组中的空值和签名参数
        $para_filter = $this->paraFilter($para_temp);
        //对待签名参数数组排序
        $para_sort = $this->argSort($para_filter);
        //生成签名结果
        $mysign = $this->buildRequestMysign($para_sort);
        //签名结果与签名方式加入请求提交参数组中
        $para_sort['sign'] = $mysign;
        return $para_sort;
    }

    /**
     * 除去数组中的空值和签名参数
     * @param $para     签名参数组
     * @return array    去掉空值与签名参数后的新签名参数组
     */
    private function paraFilter($para)
    {
        $para_filter = array();
        while ((list ($key, $val) = each($para)) == true) {
            if ($key == 'sign'  || $val == '') {
                continue;
            } else {
                $para_filter[$key] = $para[$key];
            }
        }
        return $para_filter;
    }

    /**
     * 除去数组中的空值和签名参数
     * @param $para     签名参数组
     * @return array    去掉空值与签名参数后的新签名参数组
     */
    private function paraFilter2($para)
    {
        $para_filter = array();
        while ((list ($key, $val) = each($para)) == true) {
            if ($key == 'sign' || $key == 'sign_type'  || $val == '') {
                continue;
            } else {
                $para_filter[$key] = $para[$key];
            }
        }
        return $para_filter;
    }

    /**
     * RSA签名
     * @param $data     待签名数据
     * @param $private_key_path     商户私钥文件路径
     * @return string       签名结果
     */
    private function rsaSign($data, $private_key_path)
    {
        $priKey = file_get_contents($private_key_path);
        $res = openssl_get_privatekey($priKey);
        openssl_sign($data, $sign, $res);
        openssl_free_key($res);
        //base64编码
        $sign = base64_encode($sign);
        return $sign;
    }

    /**
     * 对数组排序
     * @param $para     排序前的数组
     * @return mixed    排序后的数组
     */
    private function argSort($para)
    {
        ksort($para);
        reset($para);
        return $para;
    }

    /**
     * 获取返回时的签名验证结果
     * @param $para_temp 通知返回来的参数数组
     * @param $sign 返回的签名结果
     * @return 签名验证结果
     */
    function getSignVeryfy($para_temp, $sign)
    {
        //除去待签名参数数组中的空值和签名参数sing和sing_type
        $para_filter = $this->paraFilter2($para_temp);
        //对待签名参数数组排序
        $para_sort = $this->argSort($para_filter);
        //把数组所有元素，按照“参数=参数值”的模式用“&”字符拼接成字符串
        $prestr = $this->createLinkstring($para_sort);

        switch (strtoupper(trim($this->sign_type))) {
            case 'MD5':
                $is_sgin = $this->md5Verify($prestr, $sign, $this->key);
                break;
            case 'RSA':
                $is_sgin = $this->rsaVerify($prestr, $this->public_key_path, $sign);
                break;
            default:
                $is_sgin = false;
        }
        return $is_sgin;
    }
    /**RSA验签
     * @param $data     待签名数据
     * @param $public_key_path      支付宝的公钥文件路径
     * @param $sign     要校对的的签名结果
     * @return bool     验证结果
     */
    private function rsaVerify($data, $public_key_path, $sign)
    {
//        $key_width = 64;
//        $pubKey ="MIGfMA0GCSqGSIb3DQEBAQUAA4GNADCBiQKBgQDDI6d306Q8fIfCOaTXyiUeJHkrIvYISRcc73s3vF1ZT7XN8RNPwJxo8pWaJMmvyTn9N4HQ632qJBVHf8sxHi/fEsraprwCtzvzQETrNRwVxLO5jVmRGi60j8Ue1efIlzPXV9je9mkjzOmdssymZkh2QhUrCmZYI/FCEa3/cNMW0QIDAQAB";
//        $p_key = array();
//        //如果私钥是 1行
//        if( ! stripos( $pubKey, "\n" )  ){
//            $i = 0;
//            while( $key_str = substr( $pubKey , $i * $key_width , $key_width) ){
//                $p_key[] = $key_str;
//                $i ++ ;
//            }
//        }else{
//            //echo '一行？';
//        }
//        $pubKey = "-----BEGIN PUBLIC KEY-----\n" . implode("\n", $p_key) ;
//        $pubKey = $pubKey ."\n-----END PUBLIC KEY-----";

        $pubKey = file_get_contents($public_key_path);

        $res = openssl_get_publickey($pubKey);
        $result = (bool)openssl_verify($data, base64_decode($sign), $res);
        openssl_free_key($res);

        return $result;
    }

    /**
     * 获取远程服务器ATN结果,验证返回URL
     * @param $notify_id 通知校验ID
     * @return 服务器ATN结果
     * 验证结果集：
     * invalid命令参数不对 出现这个错误，请检测返回处理中partner和key是否为空
     * true 返回正确信息
     * false 请检查防火墙或者是服务器阻止端口问题以及验证时间是否超过一分钟
     */
    public function getResponse($notify_id)
    {
        $transport = strtolower(trim($this->transport));
        $partner = trim($this->partner);
        if ($transport == 'https') {
            $veryfy_url = $this->__https_verify_url;
        } else {
            $veryfy_url = $this->__http_verify_url;
        }
        $veryfy_url = $veryfy_url . 'partner=' . $partner . '&notify_id=' . $notify_id;
        $response_txt = $this->getHttpResponseGET($veryfy_url, $this->cacert);

        return $response_txt;
    }

    /**
     * 远程获取数据，GET模式
     * 注意：
     * 1.使用Crul需要修改服务器中php.ini文件的设置，找到php_curl.dll去掉前面的";"就行了
     * 2.文件夹中cacert.pem是SSL证书请保证其路径有效，目前默认路径是：getcwd().'\\cacert.pem'
     * @param $url      指定URL完整路径地址
     * @param $cacert_url       指定当前工作目录绝对路径
     * @return mixed        远程输出的数据
     */
    private function getHttpResponseGET($url, $cacert_url)
    {
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_HEADER, 0); // 过滤HTTP头
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1); // 显示输出结果
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, true); //SSL证书认证
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 2); //严格认证
        curl_setopt($curl, CURLOPT_CAINFO, $cacert_url); //证书地址
        $responseText = curl_exec($curl);
        //var_dump( curl_error($curl) );//如果执行curl过程中出现异常，可打开此开关，以便查看异常内容
        curl_close($curl);

        return $responseText;
    }


}