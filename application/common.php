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
        returnJson(4002, $validate->getError());
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
    return strval(date('Y-m-d H:i:s',$time));
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
        return strval($formattedNum);
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
        return Db::name('sp_base_info')->where("recomm_code",$recommCode)->value('id');
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
        'push_type'=> $type,
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
        "req_time" => time(),
        "req_action" => 'sendText',
        'text' => $content,
    ];
    //进行签名校验
    $sendData['sign'] = createSign($sendData);
    HttpService::post(getenv('APP_API_MSG').'SendSms/sendText',$sendData);//sendSms($data)
}


/*
 * 推送信息 推送给货主为$rt_key='wztx_shipper' 推送给司机为 $rt_key='wztx_driver'
 */
function pushInfo($token,$title,$content,$rt_key='wztx_driver',$type='private'){
    $sendData = [
        "platform" => "all",
        "rt_appkey" => $rt_key,
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
            "extras" => ['type'=>$type]
        ]
    ];
    $desClass = new DesUtils();
    $arrOrder = $desClass->naturalOrdering([$sendData['rt_appkey'],$sendData['req_time'],$sendData['req_action']]);
    $skArr = explode('_',config('app_access_key'));
    $sendData['sign'] = $desClass->strEnc($arrOrder,$skArr[0],$skArr[1],$skArr[2]);//签名
    $result = HttpService::post(getenv('APP_API_HOME').'push',http_build_query($sendData));
}
/*
 * 得到司机推送token
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

/*
 * 获得司机报价价格
 */
function getDrPrice($id){
    return Db::name('quote')->where("id",$id)->value('dr_price');
}

/*
 * 获得司机手机
 */
function getDrPhone($id){
    return Db::name('dr_base_info')->where("id",$id)->value('phone');
}

/*
 * 得到用户基本信息
 */
function getBaseSpUserInfo($sp_id){
    return Db::name('sp_base_info')->where("id",$sp_id)->find();
}

/*
 * 判断用户是否通过认证并缴纳了保证金 通过返回true不通过返回false;
 */

function ispassAuth($loginUser){
    //验证是否缴纳保证金
    $baseUserInfo = model('SpBaseInfo', 'logic')->getBaseUserInfo($loginUser);
    //保证金状态(init=未缴纳，checked=已缴纳,frozen=冻结) bond_status
    //认证状态（init=未认证，check=认证中，pass=认证通过，refuse=认证失败，delete=后台删除） auth_status
    if ($baseUserInfo['bond_status'] != 'checked' || $baseUserInfo['auth_status'] != 'pass') {
        return false;
    }
    return true;
}

/*
 * 判断用户是否缴纳了保证金
 */
function isPaymentbond(){

}

/*
 * 添加推荐列表根据订单情况
 */
function saveOrderShare($order_id = ''){
    if(empty($order_id)){
        return false;
    }
    //获取订单详情
    $orderInfo = model('TransportOrder', 'logic')->getTransportOrderInfo([ 'id' => $order_id]);
    if (empty($orderInfo)) {
        return false;
    }
    if(in_array($orderInfo['status'],['pay_success','comment'])){
        $spBaseInfo = model('SpBaseInfo', 'logic')->findInfoByUserId($orderInfo['sp_id']);
        if(!empty($spBaseInfo['recomm_id'])){
            $spInviteBaseInfo = model('SpBaseInfo', 'logic')->findInfoByUserId($spBaseInfo['recomm_id']);
            $share_money = wztxMoney($orderInfo['final_price']*getSysconf('share_percent')/100);
            $whereSp = [
                'share_name'=>$spBaseInfo['real_name'],
                'share_id'=>$spBaseInfo['recomm_id'],
                'status'=>0,
                'type'=>0,
                'code'=>$spInviteBaseInfo['recomm_code'],
                'invite_name'=>$spInviteBaseInfo['real_name'],
                'invite_id'=>$orderInfo['sp_id'],
                'pay_orderid'=>$order_id,
                'amount'=>$share_money,
                'create_at'=>time(),
            ];
            if(saveRecomm($whereSp)){
                $isUpdate =  Db::name('SpBaseInfo')->where(['id'=>$spBaseInfo['recomm_id']])->update(['bonus'=>['exp','bonus+'.$share_money]]);
            }
        }

        $drBaseInfo = model('DrBaseInfo', 'logic')->findInfoByUserId($orderInfo['dr_id']);
        if(!empty($drBaseInfo['recomm_id'])){
            $drInviteBaseInfo = model('DrBaseInfo', 'logic')->findInfoByUserId($drBaseInfo['recomm_id']);

            $whereSp = [
                'share_name'=>$drBaseInfo['real_name'],
                'share_id'=>$drBaseInfo['recomm_id'],
                'status'=>0,
                'type'=>1,
                'code'=>$drInviteBaseInfo['recomm_code'],
                'invite_name'=>$drInviteBaseInfo['real_name'],
                'invite_id'=>$orderInfo['dr_id'],
                'pay_orderid'=>$order_id,
                'amount'=>$share_money,
                'create_at'=>time(),
            ];
            if(saveRecomm($whereSp)){
                $isUpdate =  Db::name('DrBaseInfo')->where(['id'=>$drBaseInfo['recomm_id']])->update(['cash'=>['exp','cash+'.$share_money]]);
            }
        }
        return true;
    }
    return false;
}


// 保存推荐信息
 function saveRecomm($where) {
     if (empty($where['share_id']) || empty($where['share_id']) || !in_array($where['type'], ['0', '1'])) {
         return false;
     }
     $whereExist = ['share_id' => $where['share_id'], 'invite_id' => $where['invite_id'], 'type' => $where['type']];
     $isExist = Db::name('ShareList')->where($whereExist)->find();
     if (!empty($isExist)) {
         return false;
     }
     return Db::name('ShareList')->insert($where);
 }

function bondStatus($sp_id){
    return Db::name('sp_base_info')->where('id',$sp_id)->value('bond_status');
}


//通过goods_id去查找未报价订单
function findOrderByGoodsId($goods_id){
    $where = [
        'status'  => 'quote',
        'goods_id' => $goods_id
    ];
    return Db::name('transport_order')->where($where)->find();
}