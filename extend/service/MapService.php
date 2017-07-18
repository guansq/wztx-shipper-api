<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/7/17
 * Time: 15:34
 */
namespace service;

class MapService{

    /**
     * Auther: guanshaoqiu <94600115@qq.com>
     * Describe:检索附近的司机
     */
    public static function aroundDriver($maps){

        $data = [
            'key' => getSysconf('map_key'),
            'tableid' => getSysconf('map_table_id'),
            'center' => $maps,//腾飞创新软件园
            'radius' => '50000',//50公里范围

        ];
        $httpRet = HttpService::post('http://yuntuapi.amap.com/datasearch/around?', http_build_query($data));
        if(empty($httpRet)){
            return resultArray(6000);
        }
        $ret = json_decode($httpRet, true);
        if(empty($ret)){
            return resultArray(6000,'',$httpRet);
        }
        if($ret['infocode'] == 10000){
            return $ret['datas'];//返回附近的司机列表
        }else{
            returnJson(6000,$ret['infocode'],$ret);
        }
    }
}