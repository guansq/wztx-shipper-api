<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/7/17
 * Time: 18:22
 */

namespace app\api\logic;

class Quote extends BaseLogic{
    protected $table = 'rt_quote';

    /**
     * Auther: guanshaoqiu <94600115@qq.com>
     * Describe:保存报价信息
     */
    public function saveQuoteInfo($data){
        $ret = $this->data($data,true)->isUpdate(false)->save();
        //echo $this->getLastSql();
        if($ret === false){
            returnJson('4020', '更新失败');
        }
        return $this->getLastInsID();
    }

    /**
     * Auther: guanshaoqiu <94600115@qq.com>
     * Describe:显示当前个人的报价列表
     */
    public function showQuoteList($where,$pageParam){
        $list = [];
        $dataTotal = $this->where($where)->count();
        $dbRet = $this->field('id,dr_id,car_style_type,car_style_length,dr_price')->page($pageParam['page'], $pageParam['pageSize'])->where($where)->select();
        if(empty($dataTotal)){
            return resultArray(4004);
        }
        foreach($dbRet as $item){
            $drInfo = model('DrBaseInfo','logic')->findInfoByUserId($item['dr_id']);
            $list[] = [
                'id' => $item['id'],
                'dr_id' => $item['dr_id'],
                'avatar' => $drInfo['avatar'],
                'score' => 5,//司机评分
                'car_style_type' => $item['car_style_type'],
                'car_style_length' => $item['car_style_length'],
                'card_number' => getCardNumber($item['dr_id']),
                'dr_price' => wztxMoney($item['dr_price']),
            ];
        }

        $ret = [
            'list' => $list,
            'page' => $pageParam['page'],
            'pageSize' => $pageParam['pageSize'],
            'dataTotal' => $dataTotal,
            'pageTotal' => floor($dataTotal/$pageParam['pageSize']) + 1,
        ];

        return resultArray(2000, '', $ret);
    }
    /*
     * 取出所有货源的报价
     */
    public function getAllQuote($goods_id){
        return $this->field('id,dr_id')->where('goods_id',$goods_id)->select();
    }

    /**
     * Auther: guanshaoqiu <94600115@qq.com>
     * Describe:得到相关条件的报价数量
     */
    public function getQuoteCount($where){
       return $this->where($where)->count();
    }

    /**
     * Auther: guanshaoqiu <94600115@qq.com>
     * Describe:更改报价信息状态
     */
    public function changeQuote($where,$data){
        $ret =  $this->where($where)->update($data);
        if($ret === false){
            return resultArray(4000,'更改报价信息失败');
        }
    }

    public function delQuote($where){
        $this->where($where)->delete();
    }

    /**
     * Auther: guanshaoqiu <94600115@qq.com>
     * Describe:得到报价信息
     */
    public function getQuoteInfo($where){
        $ret = $this->where($where)->find();
        if(empty($ret)){
            return resultArray(4000,'获取信息失败');
        }
        return resultArray(2000,'',$ret);
    }

}