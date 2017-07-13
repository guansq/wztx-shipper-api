<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/7/7
 * Time: 10:34
 */
namespace app\api\controller;

class Car extends BaseController{
    /**
     * @api     {GET} /car/getAllCarStyle       获取车辆车长信息以及车型done
     * @apiName     getAllCarStyle
     * @apiGroup    Car
     * @apiHeader   {String} authorization-token           token.
     * @apiParam    {String}    type                        1=车型，2=车长
     * @apiSuccess  (type=1) {Number}  id                   id
     * @apiSuccess  (type=1) {String}  name                   车型
     * @apiSuccess  (type=2) {String}  id                   id
     * @apiSuccess  (type=2) {String}  name                   车长
     * @apiSuccess  (type=2) {String}  over_metres_price      超出起步公里费
     * @apiSuccess  (type=2) {String}  weight_price           计重费
     * @apiSuccess  (type=2) {String}  init_kilometres        起步公里数
     * @apiSuccess  (type=2) {String}  init_price             车长-起步价
     *
     */
    public function getAllCarStyle(){
        //校验参数
        $paramAll = $this->getReqParams(['type']);
        $rule = [
            'type' => 'require'
        ];
        validateData($paramAll,$rule);
        //dump($paramAll);die;
        $result = model('Car','logic')->getCarInfo($paramAll['type']);
        returnJson($result);
    }

    /**
      * @api     {GET} /car/getOneCarStyle       获取单个车辆信息
      * @apiName     getOneCarStyle
      * @apiGroup    Car
      * @apiHeader   {String} authorization-token           token.
      *
      * @apiSuccess  {String}  card_number                  车牌号
      * @apiSuccess  {String}  length                       车型
      * @apiSuccess  {String}  type                         车长
      */
    public function getOneCarStyle(){

    }

    /**
     * @api {get} /test/test 测试
     * @apiName test
     * @apiGroup Test
     *
     * @apiParam {Number} id Users unique ID.
     *
     * @apiSuccess {String} firstname Firstname of the User.
     * @apiSuccess {String} lastname  Lastname of the User.
     */
    public function test(){

    }
}