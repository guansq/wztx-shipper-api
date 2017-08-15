<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/7/12
 * Time: 9:42
 */
namespace app\api\logic;

use app\common\model\SpCompanyAuth;
use jwt\JwtHelper;
use think\Db;

class SpBaseInfo extends BaseLogic{
    protected $table = 'rt_sp_base_info';

    /**
     * Auther: guanshaoqiu <94600115@qq.com>
     * Describe:通过用户ID获取相关信息
     */
    public function findInfoByUserId($user_id){
        return $this->where("user_id",$user_id)->find();
    }

    /**
     * Auther: guanshaoqiu <94600115@qq.com>
     * Describe:得到认证状态
     */
    public function getAuthStatus($user_id){
        return $this->where("user_id",$user_id)->value('auth_status');
    }

    /**
     * Auther: guanshaoqiu <94600115@qq.com>
     * Describe:保存个人验证信息
     */
    public function savePersonAuth($where,$data){
        $ret = $this->where($where)->update($data);
        if($ret){
            return resultArray('2000','更新成功');
        }
        return resultArray('4020', '抱歉，修改失败');
    }

    /**
     * Auther: guanshaoqiu <94600115@qq.com>
     * Describe:保存企业验证信息
     */
    public function saveBusinessAuth($param,$userInfo){
        $now = time();
        //Db::startTrans();
        $param['sp_id'] = $userInfo['id'];
        //dump($userInfo);die;
        //存入公司信息到数据库
        if(empty($userInfo['company_id'])){
            //$this->loginUser['company_name'] = getCompanyName($this->loginUser);
            $ret = model('sp_company_auth')->allowField(true)->save($param);
            if(empty($ret)){
                return resultArray(6000,'保存公司信息失败');
            }
            $company_id = $this->getLastInsID();
        }else{
            $company_id = $userInfo['company_id'];
            $model = new SpCompanyAuth();//model('sp_company_auth')
            $allowData = [
                'com_name' => $param['com_name'],
                'com_short_name' => $param['com_short_name'],
                'com_buss_num' => $param['com_buss_num'],
                'address' => $param['address'],
                'deposit_name' => $param['deposit_name'],
                'bank' => $param['bank'],
                'account' => $param['account'],
                'phone' => $param['phone'],
                'identity' => $param['identity'],
                'law_person' => $param['law_person'],
                'buss_pic' => $param['buss_pic'],
                'back_pic' => $param['back_pic'],
                'front_pic' => $param['front_pic'],
                'hold_pic' => $param['hold_pic'],
            ];
            $where = [
                'id' => $company_id
            ];
            $ret = model('sp_company_auth')->where($where)->update($allowData);

            if(!$ret){
                return resultArray(6000,'抱歉，修改失败');
            }
        }

        //更新法人信息 //'real_name' =>操作人名
        $updateArr = [
            'company_id' => $company_id,
            'real_name' => $param['com_name'],
            'identity' => $param['sp_identity'],//操作人的省份证
            'hold_pic' => $param['sp_hold_pic'],
            'front_pic' => $param['sp_front_pic'],
            'back_pic' => $param['sp_back_pic'],
            'auth_status' => 'check'
        ];
        $result = $this->where("id",$userInfo['id'])->update($updateArr);
        if($result){
            return resultArray(2000,'保存企业验证信息成功');
        }
        return resultArray(4020,'保存企业验证信息失败');
    }

    /**
     * Auther: guanshaoqiu <94600115@qq.com>
     * Describe:得到个人认证信息
     */
    public function getPersonAuthInfo($userInfo){
        $info = $this->field('auth_status,auth_info,real_name,phone,identity,sex,front_pic,back_pic,hold_pic')->where("id",$userInfo['id'])->find();
        if($info){
            return resultArray('2000','',$info);
        }
        return resultArray('4004');
    }

    /**
     * Auther: guanshaoqiu <94600115@qq.com>
     * Describe:得到公司认证信息
     */
    public function getBusinessAuthInfo($userInfo){
        $info = $this->alias('b')->field('b.auth_status,b.auth_info,c.com_name,
        c.com_short_name,c.com_buss_num,c.law_person,c.identity as law_identity,c.phone as com_phone,
        c.address,b.identity,b.front_pic,b.back_pic,b.hold_pic,c.front_pic as law_front_pic,c.back_pic as law_back_pic,
        c.hold_pic as law_hold_pic,c.buss_pic,deposit_name,bank,account')->join('sp_company_auth c','b.company_id = c.id','LEFT')->where("b.id",$userInfo['id'])->find();
        if($info){
            return resultArray('2000','',$info);
        }
        return resultArray('4004');
    }

    /**
     * Auther: guanshaoqiu <94600115@qq.com>
     * Describe:得到用户基本信息
     */
    public function getPersonBaseInfo($userInfo){
        $info = $this->field('id,phone,sex,avatar,real_name,auth_status,bond_status,bond,type,recomm_code')->where("id",$userInfo['id'])->find();
        if($info){
            $info['bond'] = wztxMoney($info['bond']);
            return resultArray('2000','',$info);
        }
        return resultArray('4004');
    }

    /**
     * Auther: guanshaoqiu <94600115@qq.com>
     * Describe:得到推荐码
     */
    public function getRecommCode($userInfo){
        $ret = $this->where("id",$userInfo['id'])->value('recomm_code');
        if(empty($ret)){
           return resultArray('4000','推荐码为空');
        }
        return resultArray('2000','成功',$ret);
    }

    /**
     * Auther: guanshaoqiu <94600115@qq.com>
     * Describe:得到推荐信息
     */
    public function getRecommList($userInfo){

    }
    // 获得被推荐人的id列表
    public function getRecommIDs($userInfo,$pageParam){
        $dataTotal =  $this->where("recomm_id",$userInfo['id'])->order('create_at desc')->count();
        if (empty($dataTotal)) {
            return false;
        }
        $list =  $this->where("recomm_id",$userInfo['id'])->order('create_at desc')->page($pageParam['page'], $pageParam['pageSize'])
            ->select();

        if(empty($list)){
            return false;
        }
        $ret = [
            'list' => $list,
            'page' => $pageParam['page'],
            'pageSize' => $pageParam['pageSize'],
            'dataTotal' => $dataTotal,
            'pageTotal' => intval(($dataTotal + $pageParam['pageSize'] - 1) / $pageParam['pageSize']),
        ];
        return $ret;
    }
    // 获得被推荐人的bonus
    public function getRecommBonus($where){
        return Db::name('ShareList')->where($where)->value("amount");
    }

    public function getBaseUserInfo($userInfo){
        $ret = $this->where("id",$userInfo['id'])->find();
        if(empty($ret)){
            return returnJson('4000','推荐码为空');
        }
        return $ret;
    }

    /**
     * 更新信息，并下单
     */
    public function updateUserBalance($where,$data){
        $ret = $this->where($where)->update($data);
       if($ret !== false){
           return resultArray(2000,'成功');
       }else{
           return resultArray(4000,'失败');
       }
    }

    // 获得被推荐人的总bonus
    public function getRecommBonusAll($where){
        $ret =Db::name('ShareList')->where($where)->field("sum(amount) amount")->select();
        // echo $this->getLastSql();
        return $ret;
    }
}