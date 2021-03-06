/**
 * Created by Administrator on 2017/7/12.
 *
 */

//手机号验证
function test() {
    var account = $("#tel").val();
    var tval = /^1(3|4|5|7|8)\d{9}$/;
    if (!account) {
        alert("请输入手机号");
        return false;
    }
    if (account.length < 11) {
        alert("请输入11位的手机号码");
        return false;
    }
    if (!tval.test(account)) {
        alert("您输入的手机格式不正确");
        return false;
    }
    return true;
}

var flag = 0;
// 发送验证码的点击事件
$(".get_ident").click(function (e) {
    if (flag == 1) {
        return;
    }
    flag = 1;
    validate();
});


//发送验证码
function validate() {
    if (!test()) {
        return false;
    }

    var timestamp = (Date.parse(new Date())).toString();
    var timestr = timestamp.substring(2, timestamp.length);
    var timeSecret = $.md5(timestr);

    var m = $("#tel").val();
    var ms = m.substring(1, 11);
    var timestrS = $.md5(timestr.substring(3, timestr.length));
    var validationId = ms + timestrS;

    var Jsdata = {
        "mobile": m,
        "opt": "reg",
        "codeId": timeSecret,
        "validationId": validationId
    };
    // console.log(JSON.stringify(Jsdata));
    $.post("http://wztx.shp.api.zenmechi.cc/index/sendCaptcha", Jsdata, function (resData) {
        flag = 0;
        if (resData.code == 2000) {
            settime($(".get_ident").get(0));
        } else {
            alert(resData.msg)
        }
    });


}

//点击注册
var model;
$(".consignor").click(function (e) {
    console.log(IsPC());
    e.preventDefault();

    if (!test()) {
        return false;
    }
    if (!$("#identifying").val()) {
        alert("请填写短信验证码");
        return false;
    }
    if ($("#identifying").val().length < 6 || $("#identifying").val().length > 6) {
        alert("验证码长度应为6位");
        return false;
    }
    if (!$("#psw").val()) {
        alert("密码不能为空");
        return false;
    }
    if ($("#psw").val().length < 6 || $("#psw").val().length > 20) {
        alert("密码长度在6-20之间");
        return false;
    }
    $(".pop_box").css("display", "block");

    $(".select_b li img").click(function () {
        $(".pop_box").css("display", "none");
        model = $(this).attr("data-model"); //注册类型
        var psw = $.md5("RUITU" + $("#psw").val() + "KEJI"); //加密的密码
        var dataObj = {
            "type": model,
            "user_name": $("#tel").val(),
            "captcha": $("#identifying").val(),
            "password": psw,
            "recomm_code": $('#referral').val(),
            "pushToken": ""
        }
        $.post("http://wztx.shp.api.zenmechi.cc/User/reg", dataObj, function (resData) {
            console.log(resData);
            if (resData.code == 2000) {
                window.location = "http://wztx.shp.api.zenmechi.cc/static/share/reg_success_shp.html";
                //alert("注册成功");
            } else if (resData.code == 4002) {
                alert("用户名已存在");
            } else {
                alert(resData.msg);
            }
        })
    });


});


//倒计时
var countdown = 60;

function settime(val) {
    if (countdown == 0) {
        val.removeAttribute("disabled");
        val.value = "获取验证码";
        countdown = 60;
        return;
    } else {
        val.setAttribute("disabled", true);
        val.value = "重新发送(" + countdown + ")";
        countdown--;
    }
    setTimeout(function () {
        settime(val);
    }, 1000)

}


function IsPC() {
    var flag;
    var userAgentInfo = navigator.userAgent;
    var Agents = ["Android", "iPhone",
        "SymbianOS", "Windows Phone",
        "iPad", "iPod"];
    for (var v = 0; v < Agents.length; v++) {
        if (userAgentInfo.indexOf(Agents[v]) > 0) {
            flag = true;
            break;
        } else {
            flag = false;
            break;
        }
    }
    return flag;
}