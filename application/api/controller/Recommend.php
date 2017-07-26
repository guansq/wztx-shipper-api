<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/7/7
 * Time: 9:57
 */
namespace app\api\controller;

class Recommend extends BaseController{
    /**
     * @api {GET}   recommend/showMyRecommInfo      显示我的推荐信息done
     * @apiName     showMyRecommInfo
     * @apiGroup    Recommend
     * @apiHeader   {String}    authorization-token         token.
     * @apiSuccess  {String}    code            推荐码
     *
     */
    public function showMyRecommInfo(){
        $ret = model('sp_base_info','logic')->getRecommCode($this->loginUser);
        returnJson($ret);
    }


    /**
     * @api {GET}   recommend/showMyRecommList      显示我的推荐列表done
     * @apiName     showMyRecommList
     * @apiGroup    Recommend
     * @apiHeader   {String}    authorization-token         token.
     * @apiSuccess  {Array}     list                        列表
     * @apiSuccess  {String}    list.avatar                 被推荐人头像
     * @apiSuccess  {String}    list.name                   被推荐人名称
     * @apiSuccess  {String}    list.bonus                 奖励金
     */
    public function showMyRecommList(){
        $ret = model('sp_base_info','logic')->getRecommIDs($this->loginUser);
        if(empty($ret)){
            returnJson(4004, '暂时没有推荐列表');
        }
        $list = [];
        foreach ($ret as $k =>$v){
            $bonus = model('sp_base_info','logic')->getRecommBonus(['type'=>0,'status'=>0,'invite_id'=>$v['id'],'share_id'=>$this->loginUser['id']]);
            $v['bonus'] = empty($bonus)?0:$bonus;
            $v['bonus'] = wztxMoney( $v['bonus']);
            $list[$k]['avatar'] = $v['avatar'];
            $list[$k]['name'] = $v['real_name'];
            $list[$k]['bonus'] = $v['bonus'];
        }
        returnJson(2000, '成功', ['list',$list]);
    }
}