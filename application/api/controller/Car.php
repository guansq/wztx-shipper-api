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
     * @apiSuccess  {Array}  length                 车型数组
     * @apiSuccess  {Array}  type                   车长数组
     * @apiSuccess  (String) length.id              车长id
     * @apiSuccess  (String) length.name            车长名
     * @apiSuccess  (String) type.id                车型id
     * @apiSuccess  (String) type.name              车姓名
     *
     */
    public function getAllCarStyle(){

        //dump($paramAll);die;
        $result = model('Car','logic')->getCarInfo();
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