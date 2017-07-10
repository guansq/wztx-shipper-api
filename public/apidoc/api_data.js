define({ "api": [
  {
    "type": "GET",
    "url": "/car/getAllCarStyle",
    "title": "获取车辆车长信息以及车型",
    "name": "getAllCarStyle",
    "group": "Car",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "authorization-token",
            "description": "<p>token.</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "Array",
            "optional": false,
            "field": "list",
            "description": "<p>车辆信息数组</p>"
          },
          {
            "group": "Success 200",
            "type": "Array",
            "optional": false,
            "field": "list.length",
            "description": "<p>车辆长度信息数组</p>"
          },
          {
            "group": "Success 200",
            "type": "Array",
            "optional": false,
            "field": "list.type",
            "description": "<p>车辆类型信息数组</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "application/api/controller/Car.php",
    "groupTitle": "Car",
    "sampleRequest": [
      {
        "url": "http://wztx.shp.api.ruitukeji.com/car/getAllCarStyle"
      }
    ]
  },
  {
    "type": "GET",
    "url": "/car/getOneCarStyle",
    "title": "获取单个车辆信息",
    "name": "getOneCarStyle",
    "group": "Car",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "authorization-token",
            "description": "<p>token.</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "card_number",
            "description": "<p>车牌号</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "length",
            "description": "<p>车型</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "type",
            "description": "<p>车长</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "application/api/controller/Car.php",
    "groupTitle": "Car",
    "sampleRequest": [
      {
        "url": "http://wztx.shp.api.ruitukeji.com/car/getOneCarStyle"
      }
    ]
  },
  {
    "type": "GET",
    "url": "/apiCode",
    "title": "返回码说明(ok)",
    "description": "<p>技术支持：<a href=\"http://www.ruitukeji.com\" target=\"_blank\">睿途科技</a></p>",
    "name": "apiCode",
    "group": "Index",
    "version": "0.0.0",
    "filename": "application/api/controller/Index.php",
    "groupTitle": "Index",
    "sampleRequest": [
      {
        "url": "http://wztx.shp.api.ruitukeji.com/apiCode"
      }
    ]
  },
  {
    "type": "GET",
    "url": "/appConfig",
    "title": "应用配置参数(OK)",
    "name": "appConfig",
    "group": "Index",
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "Array",
            "optional": false,
            "field": "payWays",
            "description": "<p>付款方式 一维数组</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "xxx",
            "description": "<p>其他参数</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "application/api/controller/Index.php",
    "groupTitle": "Index",
    "sampleRequest": [
      {
        "url": "http://wztx.shp.api.ruitukeji.com/appConfig"
      }
    ]
  },
  {
    "type": "GET",
    "url": "/index/home",
    "title": "首页(ok)",
    "name": "home",
    "group": "Index",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "authorization-token",
            "description": "<p>token.</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "Array",
            "optional": false,
            "field": "banners",
            "description": "<p>轮播图.</p>"
          },
          {
            "group": "Success 200",
            "type": "Number",
            "optional": false,
            "field": "banners.id",
            "description": "<p>id.</p>"
          },
          {
            "group": "Success 200",
            "type": "Number",
            "optional": false,
            "field": "banners.seqNo",
            "description": "<p>序号.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "banners.link",
            "description": "<p>跳转链接.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "banners.img",
            "description": "<p>图片.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": true,
            "field": "banners.title",
            "description": "<p>标题.</p>"
          },
          {
            "group": "Success 200",
            "type": "Object",
            "optional": false,
            "field": "unreadMsg",
            "description": "<p>未读消息.</p>"
          },
          {
            "group": "Success 200",
            "type": "Number",
            "optional": false,
            "field": "unreadMsg.io",
            "description": "<p>询价单未读数量.</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "application/api/controller/Index.php",
    "groupTitle": "Index",
    "sampleRequest": [
      {
        "url": "http://wztx.shp.api.ruitukeji.com/index/home"
      }
    ]
  },
  {
    "type": "GET",
    "url": "/lastApk",
    "title": "获取最新apk下载地址(ok)",
    "name": "lastApk",
    "group": "Index",
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "url",
            "description": "<p>下载链接.</p>"
          },
          {
            "group": "Success 200",
            "type": "Number",
            "optional": false,
            "field": "versionNum",
            "description": "<p>真实版本号.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "version",
            "description": "<p>显示版本号.</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "application/api/controller/Index.php",
    "groupTitle": "Index",
    "sampleRequest": [
      {
        "url": "http://wztx.shp.api.ruitukeji.com/lastApk"
      }
    ]
  },
  {
    "type": "POST",
    "url": "/index/sendCaptcha",
    "title": "发送验证码(ok)",
    "name": "sendCaptcha",
    "group": "Index",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "mobile",
            "description": "<p>手机号.</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "opt",
            "description": "<p>验证码类型 reg=注册 restpwd=找回密码 login=登陆 bind=绑定手机号.</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "application/api/controller/Index.php",
    "groupTitle": "Index",
    "sampleRequest": [
      {
        "url": "http://wztx.shp.api.ruitukeji.com/index/sendCaptcha"
      }
    ]
  },
  {
    "type": "GET",
    "url": "/message",
    "title": "我的消息-列表(ok)",
    "name": "index",
    "group": "Message",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "authorization-token",
            "description": "<p>token.</p>"
          }
        ]
      }
    },
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": true,
            "field": "type",
            "defaultValue": "private",
            "description": "<p>消息类型. all=全部  system=系统消息 private=私人消息</p>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": true,
            "field": "page",
            "defaultValue": "1",
            "description": "<p>页码.</p>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": true,
            "field": "pageSize",
            "defaultValue": "20",
            "description": "<p>每页数据量.</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "Array",
            "optional": false,
            "field": "list",
            "description": "<p>列表.</p>"
          },
          {
            "group": "Success 200",
            "type": "Number",
            "optional": false,
            "field": "list.id",
            "description": "<p>消息ID.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "list.type",
            "description": "<p>类型.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "list.title",
            "description": "<p>标题.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "list.summary",
            "description": "<p>摘要.</p>"
          },
          {
            "group": "Success 200",
            "type": "Number",
            "optional": false,
            "field": "list.isRead",
            "description": "<p>是否阅读</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "list.pushTime",
            "description": "<p>推送时间.</p>"
          },
          {
            "group": "Success 200",
            "type": "Number",
            "optional": false,
            "field": "page",
            "description": "<p>页码.</p>"
          },
          {
            "group": "Success 200",
            "type": "Number",
            "optional": false,
            "field": "pageSize",
            "description": "<p>每页数据量.</p>"
          },
          {
            "group": "Success 200",
            "type": "Number",
            "optional": false,
            "field": "dataTotal",
            "description": "<p>数据总数.</p>"
          },
          {
            "group": "Success 200",
            "type": "Number",
            "optional": false,
            "field": "pageTotal",
            "description": "<p>总页码数.</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "application/api/controller/Message.php",
    "groupTitle": "Message",
    "sampleRequest": [
      {
        "url": "http://wztx.shp.api.ruitukeji.com/message"
      }
    ]
  },
  {
    "type": "GET",
    "url": "/message/onlineService",
    "title": "在线客服",
    "name": "onlineService",
    "group": "Message",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "authorization-token",
            "description": "<p>token.</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "custom_phone",
            "description": "<p>客服电话.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "complain_phone",
            "description": "<p>投诉电话.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "custom_email",
            "description": "<p>我们的邮件地址.</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "application/api/controller/Message.php",
    "groupTitle": "Message",
    "sampleRequest": [
      {
        "url": "http://wztx.shp.api.ruitukeji.com/message/onlineService"
      }
    ]
  },
  {
    "type": "GET",
    "url": "/message/:id",
    "title": "我的消息-详情(ok)",
    "name": "read",
    "group": "Message",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "authorization-token",
            "description": "<p>token.</p>"
          }
        ]
      }
    },
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "id",
            "description": "<p>id.</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "Number",
            "optional": false,
            "field": "id",
            "description": "<p>消息ID.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "type",
            "description": "<p>类型.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "title",
            "description": "<p>标题.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "content",
            "description": "<p>内容.</p>"
          },
          {
            "group": "Success 200",
            "type": "Number",
            "optional": false,
            "field": "isRead",
            "description": "<p>是否阅读</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "pushTime",
            "description": "<p>推送时间.</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "application/api/controller/Message.php",
    "groupTitle": "Message",
    "sampleRequest": [
      {
        "url": "http://wztx.shp.api.ruitukeji.com/message/:id"
      }
    ]
  },
  {
    "type": "POST",
    "url": "/order/add",
    "title": "提交订单",
    "name": "addOrder",
    "group": "Order",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "authorization-token",
            "description": "<p>token</p>"
          }
        ]
      }
    },
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "type",
            "defaultValue": "often",
            "description": "<p>often-实时 urgent-加急 appoint-预约</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": true,
            "field": "appoint_at",
            "description": "<p>预约时间</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "org_address_maps",
            "description": "<p>出发地地址的坐标 如116.480881,39.989410</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "org_city",
            "description": "<p>出发地省市区</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "org_address_name",
            "description": "<p>出发地名称+出发地详细名称</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "start_address_name",
            "description": "<p>出发地-地点名称</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "start_address_detail",
            "description": "<p>出发地-详细名称</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "start_name",
            "description": "<p>出发地-发货人</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "start_phone",
            "description": "<p>出发地-手机号</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "start_telephone",
            "description": "<p>出发地-电话号码</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "dest_address_maps",
            "description": "<p>目的地地址的坐标 如116.480881,39.989410</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "dest_city",
            "description": "<p>目的地省市区</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "dest_address_name",
            "description": "<p>目的地名称+目的地详细名称</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "arr_address_name",
            "description": "<p>目的地-地点名称</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "arr_address_detail",
            "description": "<p>目的地-详细名称</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "arr_name",
            "description": "<p>目的地-发货人</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "arr_phone",
            "description": "<p>目的地-手机号</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "arr_telephone",
            "description": "<p>目的地-电话号码</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "goods_name",
            "description": "<p>货物名称</p>"
          },
          {
            "group": "Parameter",
            "type": "Float",
            "optional": false,
            "field": "weight",
            "description": "<p>总重量（吨）保留3位小数点</p>"
          },
          {
            "group": "Parameter",
            "type": "Float",
            "optional": false,
            "field": "volume",
            "description": "<p>总体积（立方米）保留3位小数点</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "car_style_length",
            "description": "<p>车辆要求-车长</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "car_style_type",
            "description": "<p>车辆要求-车型</p>"
          },
          {
            "group": "Parameter",
            "type": "Float",
            "optional": false,
            "field": "insured_amount",
            "description": "<p>货物保险-投保金额 保留2位小数点</p>"
          },
          {
            "group": "Parameter",
            "type": "Float",
            "optional": false,
            "field": "premium_amount",
            "description": "<p>货物保险-保费金额 保留2位小数点</p>"
          },
          {
            "group": "Parameter",
            "type": "Int",
            "optional": false,
            "field": "effective_time",
            "description": "<p>在途时效,统一换算成分钟</p>"
          },
          {
            "group": "Parameter",
            "type": "Float",
            "optional": false,
            "field": "system_price",
            "description": "<p>系统价 保留2位小数点</p>"
          },
          {
            "group": "Parameter",
            "type": "Float",
            "optional": true,
            "field": "mind_price",
            "description": "<p>心理价位 保留2位小数点</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": true,
            "field": "remark",
            "description": "<p>备注</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "is_receipt",
            "description": "<p>货物回单1-是-默认，2-否</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "application/api/controller/Order.php",
    "groupTitle": "Order",
    "sampleRequest": [
      {
        "url": "http://wztx.shp.api.ruitukeji.com/order/add"
      }
    ]
  },
  {
    "type": "POST",
    "url": "/order/showCerPic",
    "title": "查看凭证",
    "name": "showCerPic",
    "group": "Order",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Int",
            "optional": false,
            "field": "order_id",
            "description": "<p>订单ID</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "Array",
            "optional": false,
            "field": "list",
            "description": "<p>凭证列表</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "application/api/controller/Order.php",
    "groupTitle": "Order",
    "sampleRequest": [
      {
        "url": "http://wztx.shp.api.ruitukeji.com/order/showCerPic"
      }
    ]
  },
  {
    "type": "POST",
    "url": "/order/showOrderList",
    "title": "显示司机报价列表",
    "name": "showDriverQuoteList",
    "group": "Order",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Int",
            "optional": false,
            "field": "order_id",
            "description": "<p>订单ID</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "Array",
            "optional": false,
            "field": "list",
            "description": "<p>报价列表</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "avatar",
            "description": "<p>司机头像</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "score",
            "description": "<p>司机评分</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "car_type",
            "description": "<p>司机车型</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "car_length",
            "description": "<p>司机车长</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "card_number",
            "description": "<p>车牌号码</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "quote_price",
            "description": "<p>报价</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "application/api/controller/Order.php",
    "groupTitle": "Order",
    "sampleRequest": [
      {
        "url": "http://wztx.shp.api.ruitukeji.com/order/showOrderList"
      }
    ]
  },
  {
    "type": "POST",
    "url": "/order/showOrderInfo",
    "title": "显示订单详情",
    "name": "showOrderInfo",
    "group": "Order",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Int",
            "optional": false,
            "field": "order_id",
            "description": "<p>订单ID</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "is_receipt",
            "description": "<p>货物回单1-是-默认，2-否</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "status",
            "description": "<p>init 初始状态（未分发订单前）quote报价中（分发订单后）quoted已报价-未配送（装货中）distribute配送中（在配送-未拍照）发货中 photo 拍照完毕（订单已完成）pay_failed（支付失败）/pay_success（支付成功）comment（已评论）</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "order_code",
            "description": "<p>订单号</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "goods_name",
            "description": "<p>货品名称</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "weight",
            "description": "<p>重量</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "org_address_name",
            "description": "<p>起始地</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "dest_address_name",
            "description": "<p>目的地</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "dest_receive_name",
            "description": "<p>收货人姓名</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "dest_phone",
            "description": "<p>收货人电话</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "dest_address",
            "description": "<p>收货人地址</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "org_send_name",
            "description": "<p>寄件人姓名</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "org_phone",
            "description": "<p>寄件人电话</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "org_address",
            "description": "<p>寄件人地址</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "usecar_time",
            "description": "<p>用车时间</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "send_time",
            "description": "<p>发货时间</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "arr_time",
            "description": "<p>到达时间</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "real_name",
            "description": "<p>车主姓名</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "phone",
            "description": "<p>联系电话</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "final_price",
            "description": "<p>总运费</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "application/api/controller/Order.php",
    "groupTitle": "Order",
    "sampleRequest": [
      {
        "url": "http://wztx.shp.api.ruitukeji.com/order/showOrderInfo"
      }
    ]
  },
  {
    "type": "POST",
    "url": "/order/showOrderList",
    "title": "显示订单列表",
    "name": "showOrderList",
    "group": "Order",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "type",
            "description": "<p>订单状态（quote报价中，quoted已报价，待发货 distribute配送中（在配送-未拍照）发货中 photo 拍照完毕（订单已完成））</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "Array",
            "optional": false,
            "field": "list",
            "description": "<p>订单列表</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "list.org_address_name",
            "description": "<p>出发地名称</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "list.dest_address_name",
            "description": "<p>目的地名称</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "list.weight",
            "description": "<p>货物重量</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "list.goods_name",
            "description": "<p>货物名称</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "list.status",
            "description": "<p>init 初始状态（未分发订单前）quote报价中（分发订单后）quoted已报价-未配送（装货中）distribute配送中（在配送-未拍照）发货中 photo 拍照完毕（订单已完成）pay_failed（支付失败）/pay_success（支付成功）comment（已评论）</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "application/api/controller/Order.php",
    "groupTitle": "Order",
    "sampleRequest": [
      {
        "url": "http://wztx.shp.api.ruitukeji.com/order/showOrderList"
      }
    ]
  },
  {
    "type": "GET",
    "url": "/pay",
    "title": "我的钱包",
    "name": "index",
    "group": "Pay",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "authorization-token",
            "description": "<p>token.</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "Float",
            "optional": false,
            "field": "balance",
            "description": "<p>账户余额</p>"
          },
          {
            "group": "Success 200",
            "type": "Float",
            "optional": false,
            "field": "bonus",
            "description": "<p>我的推荐奖励</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "application/api/controller/Pay.php",
    "groupTitle": "Pay",
    "sampleRequest": [
      {
        "url": "http://wztx.shp.api.ruitukeji.com/pay"
      }
    ]
  },
  {
    "type": "POST",
    "url": "/pay/payBond",
    "title": "缴纳保证金",
    "name": "payBond",
    "group": "Pay",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "authorization-token",
            "description": "<p>token.</p>"
          }
        ]
      }
    },
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Float",
            "optional": false,
            "field": "bond",
            "description": "<p>保证金金额</p>"
          },
          {
            "group": "Parameter",
            "type": "Int",
            "optional": false,
            "field": "pay_way",
            "description": "<p>支付方式 1=支付宝，2=微信</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "Int",
            "optional": false,
            "field": "pay_status",
            "description": "<p>支付状态 0=未支付，1=支付成功，2=支付失败</p>"
          },
          {
            "group": "Success 200",
            "type": "Array",
            "optional": false,
            "field": "pay_info",
            "description": "<p>支付返回信息</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "application/api/controller/Pay.php",
    "groupTitle": "Pay",
    "sampleRequest": [
      {
        "url": "http://wztx.shp.api.ruitukeji.com/pay/payBond"
      }
    ]
  },
  {
    "type": "POST",
    "url": "/pay/recharge",
    "title": "充值",
    "name": "recharge",
    "group": "Pay",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "authorization-token",
            "description": "<p>token.</p>"
          }
        ]
      }
    },
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Float",
            "optional": false,
            "field": "real_amount",
            "description": "<p>充值金额</p>"
          },
          {
            "group": "Parameter",
            "type": "Int",
            "optional": false,
            "field": "pay_way",
            "description": "<p>支付方式 1=支付宝，2=微信</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "Int",
            "optional": false,
            "field": "pay_status",
            "description": "<p>支付状态 0=未支付，1=支付成功，2=支付失败</p>"
          },
          {
            "group": "Success 200",
            "type": "Int",
            "optional": false,
            "field": "balance",
            "description": "<p>充值之前的金额</p>"
          },
          {
            "group": "Success 200",
            "type": "Array",
            "optional": false,
            "field": "pay_info",
            "description": "<p>支付返回信息</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "application/api/controller/Pay.php",
    "groupTitle": "Pay",
    "sampleRequest": [
      {
        "url": "http://wztx.shp.api.ruitukeji.com/pay/recharge"
      }
    ]
  },
  {
    "type": "POST",
    "url": "/pay/showPayRecord",
    "title": "查看账单",
    "name": "showPayRecord",
    "group": "Pay",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "authorization-token",
            "description": "<p>token.</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "Array",
            "optional": false,
            "field": "list",
            "description": "<p>账单列表</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "list.send_name",
            "description": "<p>发货人姓名</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "list.org_address_name",
            "description": "<p>发货地址</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "list.final_price",
            "description": "<p>运价</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "list.pay_time",
            "description": "<p>订单完成时间</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "application/api/controller/Pay.php",
    "groupTitle": "Pay",
    "sampleRequest": [
      {
        "url": "http://wztx.shp.api.ruitukeji.com/pay/showPayRecord"
      }
    ]
  },
  {
    "type": "get",
    "url": "/test/test",
    "title": "测试",
    "name": "test",
    "group": "Test",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "id",
            "description": "<p>Users unique ID.</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "firstname",
            "description": "<p>Firstname of the User.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "lastname",
            "description": "<p>Lastname of the User.</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "application/api/controller/Car.php",
    "groupTitle": "Test",
    "sampleRequest": [
      {
        "url": "http://wztx.shp.api.ruitukeji.com/test/test"
      }
    ]
  },
  {
    "type": "POST",
    "url": "/User/businessAuth",
    "title": "企业个人认证",
    "name": "businessAuth",
    "group": "User",
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "accessToken",
            "description": "<p>接口调用凭证.</p>"
          }
        ]
      }
    },
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "int",
            "optional": false,
            "field": "id",
            "description": "<p>ID.</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "com_name",
            "description": "<p>企业全称.</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "com_short_name",
            "description": "<p>企业简称.</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "com_buss_num",
            "description": "<p>营业执照注册号.</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "law_person",
            "description": "<p>企业法人姓名.</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "identity",
            "description": "<p>企业法人身份证号码.</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "phone",
            "description": "<p>企业联系电话.</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "address",
            "description": "<p>地址.</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "deposit_name",
            "description": "<p>开户名称.</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "bank",
            "description": "<p>开户行.</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "account",
            "description": "<p>结算账号.</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "front_pic",
            "description": "<p>法人身份证正面照片.</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "back_pic",
            "description": "<p>法人身份证背面照片.</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "sp_identity",
            "description": "<p>操作人身份证号.</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "sp_hold_pic",
            "description": "<p>操作人手持身份证照.</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "sp_front_pic",
            "description": "<p>操作人身份证正.</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "sp_back_pic",
            "description": "<p>操作人身份证反.</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "application/api/controller/User.php",
    "groupTitle": "User",
    "sampleRequest": [
      {
        "url": "http://wztx.shp.api.ruitukeji.com/User/businessAuth"
      }
    ]
  },
  {
    "type": "GET",
    "url": "/user/getCompanyAuthInfo",
    "title": "获取企业公司认证信息",
    "name": "getCompanyAuthInfo",
    "group": "User",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "authorization-token",
            "description": "<p>token.</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "auth_status",
            "description": "<p>认证状态（init=未认证，pass=认证通过，refuse=认证失败，delete=后台删除）</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "auth_info",
            "description": "<p>认证失败原因</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "com_name",
            "description": "<p>企业全称</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "com_short_name",
            "description": "<p>企业简称</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "com_buss_num",
            "description": "<p>营业执照注册号</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "law_person",
            "description": "<p>企业法人姓名</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "law_identity",
            "description": "<p>法人身份证号</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "com_phone",
            "description": "<p>企业联系电话</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "address",
            "description": "<p>地址</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "identity",
            "description": "<p>操作人身份证号</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "front_pic",
            "description": "<p>操作人身份证正</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "law_front_pic",
            "description": "<p>法人身份证正</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "law_back_pic",
            "description": "<p>法人身份证反</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "buss_pic",
            "description": "<p>营业执照</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "application/api/controller/User.php",
    "groupTitle": "User",
    "sampleRequest": [
      {
        "url": "http://wztx.shp.api.ruitukeji.com/user/getCompanyAuthInfo"
      }
    ]
  },
  {
    "type": "GET",
    "url": "/user/getPersonAuthInfo",
    "title": "获取个人认证信息",
    "name": "getPersonAuthInfo",
    "group": "User",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "authorization-token",
            "description": "<p>token.</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "auth_status",
            "description": "<p>认证状态（init=未认证，pass=认证通过，refuse=认证失败，delete=后台删除）</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "auth_info",
            "description": "<p>认证失败原因</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "real_name",
            "description": "<p>真实姓名</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "phone",
            "description": "<p>绑定手机号</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "identity",
            "description": "<p>身份证号</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "sex",
            "description": "<p>性别 1=男 2=女 0=未知</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "front_pic",
            "description": "<p>身份证正</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "back_pic",
            "description": "<p>身份证反</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "application/api/controller/User.php",
    "groupTitle": "User",
    "sampleRequest": [
      {
        "url": "http://wztx.shp.api.ruitukeji.com/user/getPersonAuthInfo"
      }
    ]
  },
  {
    "type": "GET",
    "url": "/user/info",
    "title": "获取用户信息(ok)",
    "name": "info",
    "group": "User",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "authorization-token",
            "description": "<p>token.</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "Number",
            "optional": false,
            "field": "id",
            "description": "<p>id.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "phone",
            "description": "<p>绑定手机号.</p>"
          },
          {
            "group": "Success 200",
            "type": "Number",
            "optional": false,
            "field": "sex",
            "description": "<p>性别 1=男 2=女 0=未知.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "avatar",
            "description": "<p>头像.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "real_name",
            "description": "<p>真实姓名.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "auth_status",
            "description": "<p>认证状态（init=未认证，pass=认证通过，refuse=认证失败，delete=后台删除）</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "bond_status",
            "description": "<p>保证金状态(init=未缴纳，checked=已缴纳,frozen=冻结)</p>"
          },
          {
            "group": "Success 200",
            "type": "Float",
            "optional": false,
            "field": "bond",
            "description": "<p>保证金 保留两位小数点</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "application/api/controller/User.php",
    "groupTitle": "User",
    "sampleRequest": [
      {
        "url": "http://wztx.shp.api.ruitukeji.com/user/info"
      }
    ]
  },
  {
    "type": "POST",
    "url": "/User/login",
    "title": "用户登录(ok)",
    "name": "login",
    "group": "User",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "account",
            "description": "<p>账号/手机号/邮箱.</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "password",
            "description": "<p>加密的密码. 加密方式：MD5(&quot;RUITU&quot;+明文密码+&quot;KEJI&quot;).</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": true,
            "field": "wxOpenid",
            "description": "<p>微信openid.</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "pushToken",
            "description": "<p>消息推送token.</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "accessToken",
            "description": "<p>接口调用凭证.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "refreshToken",
            "description": "<p>刷新凭证.</p>"
          },
          {
            "group": "Success 200",
            "type": "Number",
            "optional": false,
            "field": "expireTime",
            "description": "<p>有效期.</p>"
          },
          {
            "group": "Success 200",
            "type": "Number",
            "optional": false,
            "field": "userId",
            "description": "<p>用户id.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "type",
            "description": "<p>用户类型.</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "application/api/controller/User.php",
    "groupTitle": "User",
    "sampleRequest": [
      {
        "url": "http://wztx.shp.api.ruitukeji.com/User/login"
      }
    ]
  },
  {
    "type": "POST",
    "url": "/User/personAuth",
    "title": "货主个人认证",
    "name": "personAuth",
    "group": "User",
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "accessToken",
            "description": "<p>接口调用凭证.</p>"
          }
        ]
      }
    },
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "id",
            "description": "<p>个人ID.</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "real_name",
            "description": "<p>真实姓名.</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "sex",
            "description": "<p>性别 1=男 2=女 0=未知.</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "pushToken",
            "description": "<p>消息推送token.</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "identity",
            "description": "<p>身份证号.</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "hold_pic",
            "description": "<p>手持身份证照.</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "front_pic",
            "description": "<p>身份证正面照.</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "back_pic",
            "description": "<p>身份证反面照.</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "application/api/controller/User.php",
    "groupTitle": "User",
    "sampleRequest": [
      {
        "url": "http://wztx.shp.api.ruitukeji.com/User/personAuth"
      }
    ]
  },
  {
    "type": "POST",
    "url": "/User/reg",
    "title": "用户注册",
    "name": "reg",
    "group": "User",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "type",
            "description": "<p>注册类型 person-个人 company-公司.</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "phone",
            "description": "<p>手机号.</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "password",
            "description": "<p>加密的密码. 加密方式：MD5(&quot;RUITU&quot;+明文密码+&quot;KEJI&quot;)</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": true,
            "field": "recommendcode",
            "description": "<p>推荐码</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "Number",
            "optional": false,
            "field": "userId",
            "description": "<p>用户id.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "accessToken",
            "description": "<p>接口调用凭证.</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "application/api/controller/User.php",
    "groupTitle": "User",
    "sampleRequest": [
      {
        "url": "http://wztx.shp.api.ruitukeji.com/User/reg"
      }
    ]
  },
  {
    "type": "POST",
    "url": "/User/resetPwd",
    "title": "重置密码",
    "name": "resetPwd",
    "group": "User",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "account",
            "description": "<p>账号/手机号/邮箱.</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "password",
            "description": "<p>加密的密码. 加密方式：MD5(&quot;RUITU&quot;+明文密码+&quot;KEJI&quot;).</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "captcha",
            "description": "<p>验证码.</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "application/api/controller/User.php",
    "groupTitle": "User",
    "sampleRequest": [
      {
        "url": "http://wztx.shp.api.ruitukeji.com/User/resetPwd"
      }
    ]
  },
  {
    "type": "PUT",
    "url": "/user/updateInfo",
    "title": "更新用户信息(ok)",
    "name": "updateInfo",
    "group": "User",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "authorization-token",
            "description": "<p>token.</p>"
          }
        ]
      }
    },
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Number",
            "optional": true,
            "field": "sex",
            "description": "<p>性别 1=男 2=女 0=未知.</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": true,
            "field": "avatar",
            "description": "<p>头像.</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": true,
            "field": "nickName",
            "description": "<p>昵称.</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": true,
            "field": "payWay",
            "description": "<p>付款方式.</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "application/api/controller/User.php",
    "groupTitle": "User",
    "sampleRequest": [
      {
        "url": "http://wztx.shp.api.ruitukeji.com/user/updateInfo"
      }
    ]
  },
  {
    "type": "POST",
    "url": "/user/uploadAvatar",
    "title": "上传并修改头像(ok)",
    "name": "uploadAvatar",
    "group": "User",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "authorization-token",
            "description": "<p>token.</p>"
          }
        ]
      }
    },
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Image",
            "optional": false,
            "field": "file",
            "description": "<p>上传的文件 最大5M 支持'jpg', 'gif', 'png', 'jpeg'</p>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": true,
            "field": "retType",
            "defaultValue": "json",
            "description": "<p>返回数据格式 默认=json  jsonp</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "url",
            "description": "<p>下载链接(绝对路径)</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "application/api/controller/User.php",
    "groupTitle": "User",
    "sampleRequest": [
      {
        "url": "http://wztx.shp.api.ruitukeji.com/user/uploadAvatar"
      }
    ]
  }
] });
