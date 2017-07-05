define({ "api": [
  {
    "type": "GET",
    "url": "/ask",
    "title": "01.咨询列表(ok)",
    "name": "index",
    "group": "Ask",
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
            "description": "<p>咨询列表.</p>"
          },
          {
            "group": "Success 200",
            "type": "Number",
            "optional": false,
            "field": "list.id",
            "description": "<p>咨询单id.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "list.content",
            "description": "<p>咨询内容.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "list.reply",
            "description": "<p>最后一条回复内容.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "list.replyTime",
            "description": "<p>最后一条回复时间.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "list.replierId",
            "description": "<p>最后一条回复人id.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "list.replierName",
            "description": "<p>最后一条回复人名称.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "list.isRead",
            "description": "<p>是否阅读.</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "application/api/controller/Ask.php",
    "groupTitle": "Ask",
    "sampleRequest": [
      {
        "url": "http://wztx.shp.api.ruitukeji.com/ask"
      }
    ]
  },
  {
    "type": "GET",
    "url": "/ask/:id",
    "title": "04.咨询的回复记录(ok)",
    "name": "read",
    "group": "Ask",
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
            "description": "<p>咨询id.</p>"
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
            "description": "<p>回复列表.</p>"
          },
          {
            "group": "Success 200",
            "type": "Number",
            "optional": false,
            "field": "list.id",
            "description": "<p>回复id.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "list.content",
            "description": "<p>回复内容.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "list.time",
            "description": "<p>回复时间.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "list.replierId",
            "description": "<p>回复人id.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "list.replierName",
            "description": "<p>回复人名称.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "list.replierAvatar",
            "description": "<p>回复人头像.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "list.isRead",
            "description": "<p>是否阅读.</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "application/api/controller/Ask.php",
    "groupTitle": "Ask",
    "sampleRequest": [
      {
        "url": "http://wztx.shp.api.ruitukeji.com/ask/:id"
      }
    ]
  },
  {
    "type": "POST",
    "url": "/ask/reply",
    "title": "05.咨询发送消息(ok)",
    "name": "reply",
    "group": "Ask",
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
            "description": "<p>咨询id.</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "content",
            "description": "<p>回复内容.</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "application/api/controller/Ask.php",
    "groupTitle": "Ask",
    "sampleRequest": [
      {
        "url": "http://wztx.shp.api.ruitukeji.com/ask/reply"
      }
    ]
  },
  {
    "type": "POST",
    "url": "/ask",
    "title": "03.新增咨询(ok)",
    "name": "save",
    "group": "Ask",
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
            "optional": false,
            "field": "content",
            "description": "<p>咨询内容.</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "application/api/controller/Ask.php",
    "groupTitle": "Ask",
    "sampleRequest": [
      {
        "url": "http://wztx.shp.api.ruitukeji.com/ask"
      }
    ]
  },
  {
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "list.DocNo",
            "description": "<p>采购订单号</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "list.DocLineNo",
            "description": "<p>采购单据行号</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "list.SupCode",
            "description": "<p>供应商代码</p>"
          },
          {
            "group": "Success 200",
            "type": "Number",
            "optional": false,
            "field": "list.SupName",
            "description": "<p>供应商名称</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "list.ItemCode",
            "description": "<p>料品编码</p>"
          },
          {
            "group": "Success 200",
            "type": "Number",
            "optional": false,
            "field": "list.ItemName",
            "description": "<p>料品名称</p>"
          },
          {
            "group": "Success 200",
            "type": "Number",
            "optional": false,
            "field": "list.ItemSPECS",
            "description": "<p>料品规格</p>"
          },
          {
            "group": "Success 200",
            "type": "Number",
            "optional": false,
            "field": "list.DocStatus",
            "description": "<p>单据状态（已审核、已关闭）</p>"
          },
          {
            "group": "Success 200",
            "type": "Number",
            "optional": false,
            "field": "list.ArrQTY",
            "description": "<p>到货数量</p>"
          }
        ]
      }
    },
    "type": "",
    "url": "",
    "version": "0.0.0",
    "filename": "application/api/logic/PO.php",
    "group": "D__work_wztx_shipper_api_application_api_logic_PO_php",
    "groupTitle": "D__work_wztx_shipper_api_application_api_logic_PO_php",
    "name": ""
  },
  {
    "type": "GET",
    "url": "/index/home",
    "title": "01.首页(ok)",
    "description": "<p>@apiName  home</p>",
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
          },
          {
            "group": "Success 200",
            "type": "Number",
            "optional": false,
            "field": "unreadMsg.po",
            "description": "<p>采购单未读数量.</p>"
          },
          {
            "group": "Success 200",
            "type": "Number",
            "optional": false,
            "field": "unreadMsg.msg",
            "description": "<p>推送消息未读数量.</p>"
          },
          {
            "group": "Success 200",
            "type": "Number",
            "optional": false,
            "field": "unreadMsg.ask",
            "description": "<p>咨询消息未读数量.</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "application/api/controller/Index.php",
    "groupTitle": "Index",
    "name": "GetIndexHome",
    "sampleRequest": [
      {
        "url": "http://wztx.shp.api.ruitukeji.com/index/home"
      }
    ]
  },
  {
    "type": "GET",
    "url": "/apiCode",
    "title": "00.返回码说明(ok)",
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
    "title": "01.应用配置参数(OK)",
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
    "title": "02.发送验证码(ok)",
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
    "title": "01.我的消息-列表(ok)",
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
    "url": "/message/:id",
    "title": "02.我的消息-详情(ok)",
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
    "type": "PUT",
    "url": "/po/agree",
    "title": "08.确定订单(ok)",
    "name": "agree",
    "group": "PO",
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
            "description": "<p>订单id.</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "application/api/controller/PO.php",
    "groupTitle": "PO",
    "sampleRequest": [
      {
        "url": "http://wztx.shp.api.ruitukeji.com/po/agree"
      }
    ]
  },
  {
    "type": "GET",
    "url": "/po",
    "title": "01.我的订单列表(ok)",
    "name": "index",
    "group": "PO",
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
            "optional": false,
            "field": "status",
            "defaultValue": "all",
            "description": "<p>状态. all=全部 unsign_contract=待签合同  upload_contract=合同待审核  executing_0=待交货 executing=部分交货 executing_all=全部交货 finish=结束</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "Object",
            "optional": false,
            "field": "orderCount",
            "description": "<p>.</p>"
          },
          {
            "group": "Success 200",
            "type": "Number",
            "optional": false,
            "field": "orderCount.unSign",
            "description": "<p>待签合同单数.</p>"
          },
          {
            "group": "Success 200",
            "type": "Number",
            "optional": false,
            "field": "orderCount.unCheck",
            "description": "<p>合同待审核单数.</p>"
          },
          {
            "group": "Success 200",
            "type": "Number",
            "optional": false,
            "field": "orderCount.unExecuting",
            "description": "<p>待交货单数.</p>"
          },
          {
            "group": "Success 200",
            "type": "Number",
            "optional": false,
            "field": "orderCount.executing",
            "description": "<p>部分交货单数.</p>"
          },
          {
            "group": "Success 200",
            "type": "Number",
            "optional": false,
            "field": "orderCount.exeAll",
            "description": "<p>全部交货单数.</p>"
          },
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
            "description": "<p>订单id.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "list.code",
            "description": "<p>订单号.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "list.docDate",
            "description": "<p>下单日期.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "list.contractTime",
            "description": "<p>合同签订日期.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "list.status",
            "description": "<p>状态 init=初始 sup_cancel=供应商取消 sup_edit=供应商修改 atw_sure=安特威确定 sup_sure = 供应商确定/待上传合同 upload_contract = 供应商已经上传合同contract_pass  = 合同审核通过 contract_refuse= 合同审核拒绝 executing  = 执行中 finish=结束</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "list.statusStr",
            "description": "<p>状态 .</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "list.orderArvInfo",
            "description": "<p>订单到货情况.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "list.orderPayInfo",
            "description": "<p>订单支付情况.</p>"
          },
          {
            "group": "Success 200",
            "type": "Array",
            "optional": false,
            "field": "list.contractArr",
            "description": "<p>合同映象 一位数组.</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "application/api/controller/PO.php",
    "groupTitle": "PO",
    "sampleRequest": [
      {
        "url": "http://wztx.shp.api.ruitukeji.com/po"
      }
    ]
  },
  {
    "type": "GET",
    "url": "/po/:id",
    "title": "04.我的订单详情(ok)",
    "name": "read",
    "group": "PO",
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
            "description": "<p>订单id.</p>"
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
            "field": "code",
            "description": "<p>订单号.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "docDate",
            "description": "<p>下单日期.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "contractTime",
            "description": "<p>合同签订日期.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "status",
            "description": "<p>状态 init=初始 sup_cancel=供应商取消 sup_edit=供应商修改 atw_sure=安特威确定 sup_sure = 供应商确定/待上传合同 upload_contract = 供应商已经上传合同contract_pass  = 合同审核通过 contract_refuse= 合同审核拒绝 executing  = 执行中 finish=结束</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "statusStr",
            "description": "<p>状态 .</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "orderArvInfo",
            "description": "<p>订单到货情况.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "orderPayInfo",
            "description": "<p>订单支付情况.</p>"
          },
          {
            "group": "Success 200",
            "type": "Array",
            "optional": false,
            "field": "contractArr",
            "description": "<p>合同映象 一位数组.</p>"
          },
          {
            "group": "Success 200",
            "type": "Array",
            "optional": false,
            "field": "itemArr",
            "description": "<p>物料.</p>"
          },
          {
            "group": "Success 200",
            "type": "Number",
            "optional": false,
            "field": "itemArr.id",
            "description": "<p>物料id.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "itemArr.itemCode",
            "description": "<p>物料编号.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "itemArr.itemName",
            "description": "<p>物料名称.</p>"
          },
          {
            "group": "Success 200",
            "type": "Number",
            "optional": false,
            "field": "itemArr.priceNum",
            "description": "<p>计价数量.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "itemArr.priceUom",
            "description": "<p>计价单位.</p>"
          },
          {
            "group": "Success 200",
            "type": "Number",
            "optional": false,
            "field": "itemArr.price",
            "description": "<p>单价(含税).</p>"
          },
          {
            "group": "Success 200",
            "type": "Number",
            "optional": false,
            "field": "itemArr.taxPrice",
            "description": "<p>含税单价(废弃).</p>"
          },
          {
            "group": "Success 200",
            "type": "Number",
            "optional": false,
            "field": "itemArr.subtotal",
            "description": "<p>小计金额.</p>"
          },
          {
            "group": "Success 200",
            "type": "Number",
            "optional": false,
            "field": "itemArr.confirmDate",
            "description": "<p>交期.</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "application/api/controller/PO.php",
    "groupTitle": "PO",
    "sampleRequest": [
      {
        "url": "http://wztx.shp.api.ruitukeji.com/po/:id"
      }
    ]
  },
  {
    "type": "PUT",
    "url": "/po/refuse",
    "title": "09.拒绝订单(ok)",
    "name": "refuse",
    "group": "PO",
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
            "description": "<p>订单id.</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "application/api/controller/PO.php",
    "groupTitle": "PO",
    "sampleRequest": [
      {
        "url": "http://wztx.shp.api.ruitukeji.com/po/refuse"
      }
    ]
  },
  {
    "type": "GET",
    "url": "/user/info",
    "title": "04.获取用户信息(ok)",
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
            "field": "bindMobile",
            "description": "<p>绑定手机号.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "bindEmail",
            "description": "<p>绑定邮箱.</p>"
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
            "field": "nickName",
            "description": "<p>昵称.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "code",
            "description": "<p>供应商编号.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "name",
            "description": "<p>供应商名称.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "typeCode",
            "description": "<p>主分类编码.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "typeName",
            "description": "<p>主分类名称.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "taxCode",
            "description": "<p>税号.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "foundDate",
            "description": "<p>成立日期.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "taxRate",
            "description": "<p>税率.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "mobile",
            "description": "<p>电话.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "phone",
            "description": "<p>手机.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "email",
            "description": "<p>邮箱.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "fax",
            "description": "<p>传真.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "ctcName",
            "description": "<p>联系人.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "address",
            "description": "<p>地址.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "payWay",
            "description": "<p>付款方式.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "comName",
            "description": "<p>企业名称.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "purchCode",
            "description": "<p>采购员工号.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "purchName",
            "description": "<p>采购员工姓名.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "purchType",
            "description": "<p>供应商采购属性.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "checkType",
            "description": "<p>检验类型.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "checkRate",
            "description": "<p>抽检比例.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "arvRate",
            "description": "<p>到货率.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "passRate",
            "description": "<p>合格率.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "creditLevel",
            "description": "<p>信用等级.</p>"
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
    "title": "02.用户登录(ok)",
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
    "type": "GET",
    "url": "/User/qualification",
    "title": "06.获取用户资质 (ok)",
    "name": "qualification",
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
            "type": "Array",
            "optional": false,
            "field": "list",
            "description": "<p>id.</p>"
          },
          {
            "group": "Success 200",
            "type": "Number",
            "optional": false,
            "field": "list.id",
            "description": "<p>id.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "list.code",
            "description": "<p>资质编码 <br/>biz_lic=营业执照 <br/>tax_reg_ctf=税务登记证 <br/>org_code_ctf=组织机构代码证 <br/>prd_ctf=生产许可证 <br/>iso90001=ISO90001 <br/>ts_lic=TS认证 <br/>ped_lic=PED <br/>api_lic=API <br/>ce_lic=CE <br/>sil_lic=SIL <br/>bam_lic=BAM <br/>other=其他</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "list.name",
            "description": "<p>资质名称.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "list.termStart",
            "description": "<p>资质有效期起.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "list.termEnd",
            "description": "<p>资质有效期止.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "list.status",
            "description": "<p>审核状态 ''=未审核 refuse=拒绝  agree=同意.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "list.img",
            "description": "<p>图片地址.</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "application/api/controller/User.php",
    "groupTitle": "User",
    "sampleRequest": [
      {
        "url": "http://wztx.shp.api.ruitukeji.com/User/qualification"
      }
    ]
  },
  {
    "type": "POST",
    "url": "/User/resetPwd",
    "title": "03.重置密码(toto)",
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
    "type": "POST",
    "url": "/user/qualification",
    "title": "07.保存资质证书信息(ok)",
    "name": "saveQualification",
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
            "type": "String",
            "optional": false,
            "field": "list",
            "description": "<p>资质名称.</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "list.code",
            "description": "<p>资质编码 <br/>biz_lic=营业执照 <br/>tax_reg_ctf=税务登记证 <br/>org_code_ctf=组织机构代码证 <br/>prd_ctf=生产许可证 <br/>iso90001=ISO90001 <br/>ts_lic=TS认证 <br/>ped_lic=PED <br/>api_lic=API <br/>ce_lic=CE <br/>sil_lic=SIL <br/>bam_lic=BAM <br/>other=其他</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "list.name",
            "description": "<p>资质名称.</p>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "list.termStart",
            "description": "<p>资质有效期起.</p>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "list.termEnd",
            "description": "<p>资质有效期止.</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "list.img",
            "description": "<p>图片地址.</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "application/api/controller/User.php",
    "groupTitle": "User",
    "sampleRequest": [
      {
        "url": "http://wztx.shp.api.ruitukeji.com/user/qualification"
      }
    ]
  },
  {
    "type": "PUT",
    "url": "/user/updateInfo",
    "title": "06.更新用户信息(ok)",
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
    "title": "05.上传并修改头像(ok)",
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
  },
  {
    "type": "POST",
    "url": "/user/uploadQfctImg",
    "title": "07.上传资质证书(ok)",
    "name": "uploadQfctImg",
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
        "url": "http://wztx.shp.api.ruitukeji.com/user/uploadQfctImg"
      }
    ]
  },
  {
    "type": "GET",
    "url": "/inquiry",
    "title": "01.询价单列表(ok)",
    "name": "index",
    "group": "inquiry",
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
            "optional": false,
            "field": "status",
            "description": "<p>状态值. init=未报价  quoted=已报价  winbid=中标 close=已关闭.</p>"
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
            "description": "<p>询价单号.</p>"
          },
          {
            "group": "Success 200",
            "type": "Number",
            "optional": false,
            "field": "list.id",
            "description": "<p>询价单id.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "list.itemCode",
            "description": "<p>料品编号.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "list.itemName",
            "description": "<p>料品名称.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "list.priceUom",
            "description": "<p>计价单位.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "list.priceNum",
            "description": "<p>计价数量.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "list.subtotal",
            "description": "<p>小计.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "list.tcUom",
            "description": "<p>交易单位.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "list.reqDate",
            "description": "<p>需求日期.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "list.inqDate",
            "description": "<p>询价日期.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "list.quoteEndDate",
            "description": "<p>报价截止日期.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "list.status",
            "description": "<p>状态值. init=未报价  quoted=已报价  winbid=中标 close=已关闭</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "list.statusStr",
            "description": "<p>状态显示值. init=未报价  quoted=已报价  winbid=中标 close=已关闭</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": true,
            "field": "list.promiseDate",
            "description": "<p>报价承诺交期.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": true,
            "field": "list.price",
            "description": "<p>报价单价.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": true,
            "field": "list.subTotal",
            "description": "<p>报价小计.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": true,
            "field": "list.remark",
            "description": "<p>报价备注.</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "application/api/controller/Inquiry.php",
    "groupTitle": "inquiry",
    "sampleRequest": [
      {
        "url": "http://wztx.shp.api.ruitukeji.com/inquiry"
      }
    ]
  },
  {
    "type": "POST",
    "url": "/inquiry/quote",
    "title": "08.报价(ok)",
    "name": "quote",
    "group": "inquiry",
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
            "description": "<p>询价单id.</p>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "promiseDate",
            "description": "<p>承诺交期(时间戳).</p>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "price",
            "description": "<p>询价单价.</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "remark",
            "description": "<p>备注.</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "application/api/controller/Inquiry.php",
    "groupTitle": "inquiry",
    "sampleRequest": [
      {
        "url": "http://wztx.shp.api.ruitukeji.com/inquiry/quote"
      }
    ]
  }
] });