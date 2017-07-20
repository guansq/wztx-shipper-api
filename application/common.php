<?php

// +----------------------------------------------------------------------
// | Think.Admin
// +----------------------------------------------------------------------
// | 版权所有 2014~2017 广州楚才信息科技有限公司 [ http://www.cuci.cc ]
// +----------------------------------------------------------------------
// | 官方网站: http://think.ctolog.com
// +----------------------------------------------------------------------
// | 开源协议 ( https://mit-license.org )
// +----------------------------------------------------------------------
// | github开源项目：https://github.com/zoujingli/Think.Admin
// +----------------------------------------------------------------------


use think\Validate;
use service\HttpService;
use DesUtils\DesUtils;
use think\Db;
//use DesUtils;
/**
 * 打印输出数据到文件
 * @param mixed       $data
 * @param bool        $replace
 * @param string|null $pathname
 */
function p($data, $replace = false, $pathname = NULL){
    is_null($pathname) && $pathname = RUNTIME_PATH.date('Ymd').'.txt';
    $str = (is_string($data) ? $data : (is_array($data) || is_object($data)) ? print_r($data, true) : var_export($data, true))."\n";
    $replace ? file_put_contents($pathname, $str) : file_put_contents($pathname, $str, FILE_APPEND);
}


/**
 * 安全URL编码
 * @param array|string $data
 * @return string
 */
function encode($data){
    return str_replace(['+', '/', '='], ['-', '_', ''], base64_encode(serialize($data)));
}


/**
 * 安全URL解码
 * @param string $string
 * @return string
 */
function decode($string){
    $data = str_replace(['-', '_'], ['+', '/'], $string);
    $mod4 = strlen($data)%4;
    !!$mod4 && $data .= substr('====', $mod4);
    return unserialize(base64_decode($data));
}


/**
 * 获取设备或配置系统参数
 * @param string $name  参数名称
 * @param bool   $value 默认值
 * @return string|bool
 */
function getSysconf($name, $defaultValue = ''){
    $logic = model('SystemConfig', 'logic');
    $data = $logic->where(['name' => $name])->find();
    if(empty($data)){
        return $defaultValue;
    }
    return $data['value'];

}

/**
 * 设置设备或配置系统参数
 * @param string $name 参数名称
 */
function setSysconf($name, $value = '', $group = 'app', $remark = ''){
    $data = ['name' => $name, 'value' => $value, 'group' => $group, 'remark' => $remark];
    $oldData = getSysconf($name);
    $logic = model('SystemConfig', 'logic');
    if(empty($oldData)){
        return $logic->create($data);
    }else{
        return $logic->update($data, ['name' => $name]);
    }

}


/**
 * array_column 函数兼容
 */
if(!function_exists("array_column")){

    function array_column(array &$rows, $column_key, $index_key = null){
        $data = [];
        foreach($rows as $row){
            if(empty($index_key)){
                $data[] = $row[$column_key];
            }else{
                $data[$row[$index_key]] = $row[$column_key];
            }
        }
        return $data;
    }
}


// 接口返回json 数据
if(!function_exists('getCodeMsg')){
    function getCodeMsg($code = 'all'){
        $CODE_MSG = [
            0 => '未知错误',
            2000 => 'SUCCESS',
            // 客户端异常
            4000 => '非法请求',
            4001 => '请求缺少参数',
            4002 => '请求参数格式错误',
            4003 => '请求参数格式错误',
            4004 => '请求的数据为空',
            // 客户端异常-用户鉴权
            4010 => '无权访问',
            4011 => 'token丢失',
            4012 => 'token无效',
            4013 => 'token过期',
            4014 => '账号或密码错误',
            4015 => '签名校验失败',
            4020 => '数据更新失败',
            4021 => '数据插入失败',
            4022 => '数据不合法',
            // 服务端端异常
            5000 => '服务端异常',
            5010 => '代码异常',
            5020 => '数据库操作异常',
            5030 => '文件操作异常',

            // 调用第三方接口异常
            6000 => '调用第三方接口异常',
        ];
        if(key_exists($code, $CODE_MSG)){
            return $CODE_MSG[$code];
        }
        if($code == 'all'){
            return $CODE_MSG;
        }
        return '';
    }
}

// 返回数组
if(!function_exists('resultArray')){
    function resultArray($result = 0, $msg = '', $data = []){
        $code = $result;
        if(is_array($result)){
            $code = $result['code'];
            $msg = $result['msg'];
            $data = $result['result'];
        }
        if(empty($data)){
            $data = new stdClass();
        }
        $info = [
            'code' => $code,
            'msg' => empty($msg) ? getCodeMsg($code) : $msg,
            'result' => $data
        ];
        return $info;
    }
}

// 接口返回json 数据
if(!function_exists('returnJson')){
    function returnJson($result = 0, $msg = '', $data = []){
        $ret = resultArray($result, $msg, $data);
        header('Content-type:application/json; charset=utf-8');
        header("Access-Control-Allow-Origin: *");
        exit(json_encode($ret));
    }
}


if(!function_exists('assureNotEmpty')){
    /**
     * Auther: WILL<314112362@qq.com>
     * Time: 2017-3-20 17:51:09
     * Describe: 校验参数是否有空值
     * @return bool
     */
    function assureNotEmpty($params = []){
        if(empty($params)){
            returnJson(4001, '缺少必要参数.');
        }
        foreach($params as $param){
            if(empty($param)){
                returnJson(4002, '缺少必要参数或者参数不合法.');
            }
        }
        return true;
    }
}

if(!function_exists('validateData')){
    /**
     * Auther: WILL<314112362@qq.com>
     * Time: 2017-3-20 17:51:09
     * Describe: 校验参数是否有空值
     * @return bool
     */
    function validateData($params = [], $rule = []){
        if(empty($params)){
            returnJson(4001, '缺少必要参数.');
        }
        if(empty($rule)){
            foreach($params as $k => $v){
                $rule[$k] = 'require';
            }
        }
        $validate = new Validate($rule);
        if($validate->check($params)){
            return true;
        }
        returnJson(4002, '', $validate->getError());
    }
}


/**
 * Auther: WILL<314112362@qq.com>
 * Time: 2017-3-20 17:51:09
 * Describe: 校验文件
 * @return bool
 */
if(!function_exists('validateFile')){
    function validateFile($files = [], $rule = ['size' => 1024*1024]){
        if(empty($files)){
            returnJson(4001, '缺少文件');
        }
        if(is_array($files)){
            foreach($files as $file){
                $validate = $file->check($rule);
                if(!$validate){
                    returnJson(4002, '', $file->getError());
                }
            }
            return true;
        }
        if(!$files->check($rule)){
            returnJson(4002, '', $files->getError());
        }
        return true;
    }
}


if(!function_exists("dd")){
    function dd($obj){
        var_dump($obj);
        die();
    }

}

/**
 * 生成訂單號
 */
if(!function_exists("generatOrderCode")){
    function generatOrderCode($prefix = ''){
        /* 选择一个随机的方案 */
        $randStr = date('YmdHis').str_pad(mt_rand(1, 99999), 5, '0', STR_PAD_LEFT);
        return $prefix.$randStr;
    }

}


/**
 * 随机生成 $len 位字符
 */
function randomStr($len = 4){
    $chars_array = [
        "0", "1", "2", "3", "4", "5", "6", "7", "8", "9",
        "a", "b", "c", "d", "e", "f", "g", "h", "i", "j",
        "k", "l", "m", "n", "o", "p", "q", "r", "s", "t",
        "u", "v", "w", "x", "y", "z", "A", "B", "C", "D",
        "E", "F", "G", "H", "I", "J", "K", "L", "M", "N",
        "O", "P", "Q", "R", "S", "T", "U", "V", "W", "X",
        "Y", "Z"
    ];
    $charsLen = count($chars_array) - 1;

    $outputstr = "";
    for($i = 0; $i < $len; $i++){
        $outputstr .= $chars_array[mt_rand(0, $charsLen)];
    }
    return $outputstr;
}

/**
 * 随机生成四位字符
 */
function randomNum($len = 4){
    $chars_array = [
        "0", "1", "2", "3", "4", "5", "6", "7", "8", "9"
    ];
    $charsLen = count($chars_array) - 1;

    $outputstr = "";
    for($i = 0; $i < $len; $i++){
        $outputstr .= $chars_array[mt_rand(0, $charsLen)];
    }
    return $outputstr;
}

/*
 * 时间的处理
 */
function wztxDate($time){
    if(empty($time)){
        return $time;
    }
    return date('Y-m-d H:i:s',$time);
}

/*
 * 金钱的处理-->统一后两位小数点
 */
function wztxMoney($num,$ispre = false){
    $num = $num > 0 ? $num : 0;
    //number_format(10000, 2, '.', '')
    $formattedNum = number_format($num, 2,'.', '') ;
    if($ispre){
        return '¥'.$formattedNum;
    }else{
        return $formattedNum;
    }
}

/*
 * 计算系统价格
 */
function accountSystemPrice(){

}

/*
 * 得到公司名称
 */
function getCompanyName($userInfo){
    if(!empty($userInfo)){
        if(!empty($userInfo['company_id'])){
            return Db::name('sp_company_auth')->where("sp_id",$userInfo['id'])->value('com_name');
        }
        return '';
    }
    return '';
}

/*
 * 通过推荐码得到推荐人ID
 */
function getBaseIdByRecommCode($recommCode){
    if(!empty($recommCode)){
        return Db::name('dr_base_info')->where("recomm_code",$recommCode)->value('id');
    }
    return '';
}

/**
 * 生成唯一订单号
 * @return string
 */
function order_num(){
    return date('Ymd').substr(implode(NULL, array_map('ord', str_split(substr(uniqid(), 7, 13), 1))), 0, 8);
}


/*
 * 发送信息 $basetype =0 为发送信息给货主 $basetype =1 为发送信息给司机
 */
function sendMsg($sendeeId,$title,$content,$basetype=0,$type='single',$pri=3){
    $data = [
        'title' => $title,
        'content' => $content,
        'type' => $basetype,
        'publish_time' => time(),
        'pri' => $pri,
        'create_at' => time(),
        'update_at' => time()
    ];
    $msgId = model('Message')->saveMsg($data);
    $data = [
        'msg_id' => $msgId,
        'sendee_id' => $sendeeId,
        'type' => 0,
        'create_at' => time(),
        'update_at' => time()
    ];
    $res = model('MessageSendee')->saveSendee($data);
    return $res;
}

/*
 * 发送短信 推送给货主为$rt_key='wztx_shipper' 推送给司机为 $rt_key='wztx_driver'
 */
function sendSMS($phone,$content,$rt_key='wztx_shipper'){
    $sendData = [
        'mobile' => $phone,
        'rt_appkey' => 'wztx_shipper',
        'text' => $content,
    ];
    //进行签名校验
    HttpService::curl(getenv('APP_API_MSG').'SendSms/sendText',$sendData);//sendSms($data)
}


/*
 * 推送信息 推送给货主为$rt_key='wztx_shipper' 推送给司机为 $rt_key='wztx_driver'
 */
function pushInfo($token,$title,$content,$rt_key='wztx_shipper'){
    $sendData = [
        "platform" => "all",
        "rt_appkey" => "wztx_shipper",
        "req_time" => time(),
        "req_action" => 'push',
        "alert" => $title,
        "regIds" => $token,
        //"platform" => "all",
        "androidNotification" => [
            "alert" => $title,
            "title" => $content,
            "builder_id" => "builder_id",
            "priority" => 0,
            "style" => 0,
            "alert_type" => -1,
            "extras" => [
                "0" => "RuiTu",
                "key" => "value"
            ]
        ]
    ];
    $desClass = new DesUtils();
    $arrOrder = $desClass->naturalOrdering([$sendData['rt_appkey'],$sendData['req_time'],$sendData['req_action']]);
    $skArr = explode('_',config('app_access_key'));
    $sendData['sign'] = $desClass->strEnc($arrOrder,$skArr[0],$skArr[1],$skArr[2]);//签名
    $result = HttpService::post(getenv('APP_API_HOME').'push',http_build_query($sendData));
    //dump($result);
}
/*
 * 得到推送token
 */
function getPushToken($id){
    return Db::name('system_user_driver')->where("id",$id)->value('push_token');
}

/*
 * 生成签名
 */
function createSign($sendData){
    $desClass = new DesUtils();
    $arrOrder = $desClass->naturalOrdering([$sendData['rt_appkey'],$sendData['req_time'],$sendData['req_action']]);
    $skArr = explode('_',config('app_access_key'));
    return $desClass->strEnc($arrOrder,$skArr[0],$skArr[1],$skArr[2]);//签名
}

/*
 * 得到司机车牌号
 */
function getCardNumber($id){
    return Db::name('dr_carinfo_auth')->where("id",$id)->value('card_number');
}