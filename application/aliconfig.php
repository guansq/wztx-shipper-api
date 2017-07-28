<?php
/**
 * @author: helei
 * @createTime: 2016-07-15 17:19
 * @description:
 */

// 一下配置均为本人的沙箱环境，贡献出来，大家测试

// 个人沙箱帐号：
/*
 * 商家账号   naacvg9185@sandbox.com
 * 商户UID   2088102169252684
 * appId     2016073100130857
 */

/*
 * 买家账号    aaqlmq0729@sandbox.com
 * 登录密码    111111
 * 支付密码    111111
 */

return [
    'use_sandbox'               => false,// 是否使用沙盒模式

    //'partner'                   => '2088621197716899',
    'partner'                   => '2088621197716899',
    //'app_id'                    => '2016073100130857',
    'app_id'                    => '2017061607503256',
    'sign_type'                 => 'RSA2',// RSA  RSA2

    // 可以填写文件路径，或者密钥字符串  当前字符串是 rsa2 的支付宝公钥(开放平台获取)
    'ali_public_key'            => 'MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAx57k5O9rmVm3WyYXuL5JVQ9PhyGe7ih3AJL/FySC9fas6InkoBtoo+kXsZWTn9rxhOFkMl0mmL7TSDZCWZLX6KNs5cmZh+6yTm++LhPaFsYZnwOsaZlmD6P57g9rJhvfY0LPKZ4I5qdMUQ9uYsaNp4vf7rg9VS1d1KS9I9Qpen0WYsp3zPM/B+ivQk6GpLaR3Q+60dusLc/P7STiIUl8GlfK9efE5h0Ajs5NVES+MmY2Ez1ouoTbnjiZ5ls110zBHLSubeEEB6IIAbsJJdG5L6EiimNsXrTm73QJO0ij31kkb7BsNisb8SuXcdlbdYklfVdY9qT7PshfS8FglxbC5wIDAQAB',

    // 可以填写文件路径，或者密钥字符串  我的沙箱模式，rsa与rsa2的私钥相同，为了方便测试
    'rsa_private_key'           => 'MIIEpAIBAAKCAQEA8vg4xtApZfufZ/rSXaRE6PdZehfcTH4/ks5dR+FberJ6/62BvlHSlubGruPA7jLc7GdAd2nnbAXU7sGqRXilvbkjAdYnTxbwXjY+sazKGTSgEzNgR5Vpek5fMpMudMjOjiTTuasIOH8r9pBXSh5Fg4ear1esKa/em82TmxnkP7Lf2nJZKS6OIfs5Ory5KKRJE5oh+HFvgLDq6JWXhejUFWlLJ/snBetJdMFolP7OJ47PlIBvvAPXhrXhuh/3PIjwZu5gCqeTbJ7wBbxEhRrCqLEGjLKc15e0YNSuljkjCNQ0ErQG2DjdNLCkaJq76fJXoF72fdg04TP0eTNyVZpGHQIDAQABAoIBAF8nOwURjMT10C3mmvA1Xw9ln1MjeREz+C3ER9/Yr/zTXTw4dTFV1gVnB7SCWZJvtPmYTjT18r3pYsTGb6qZXz93++/CMM7Wivg6gj8PDm7knzQl0LT4HMDbZIjn/y+ZXNtqLMjv5F5L36nGSYkrZcnnF3tH+JKy35lg30fE0hDndz7WlGxu1OXBZ7vVVmRQX2ia3bmG2LuiV9ryt98hdPmlhkDUVB8jMsxOoQwWhSR4CdATum+SLZOHSHVY21l1mmUuRnEmK+H77CqylkFeUPzxUCKANZvlT6pb4csF0WEa51OP4YjJZK7DF2B1v3ewkbYtJ/ZuazIvT+fHqGvPtDkCgYEA/9QknJdprf+yREjYBs+sKogajNi/rpilvoKuL2hCyzq1FYEAmlgxEeJcDYcmnux6yMM6LxTF1IWCv53JLNl3tFzhrrwGOsRa7byP2yE5CMQYuGpU7INC30xW1ohGQnvgRFULIULtHrzeG+7hY5yNyhQBAmO4OX3Ssv2lB75KPHcCgYEA8yHf08ylC1YwKnRdwyXQPrE352188nQxCnj9Lq91mTDvxuoKPVQa8sYwKMbKvzCS0SJ9WGtFTS0oZqrrFM/beX40Eyke7qYnLoaMNxSPfpz6AKfl9NTuPcDkQibjabpLDC7Q4fxcYuwqKnFBLOt3AuX3osu5JpxZE3NNTV8n+wsCgYEAq2TynmKmr6cmRK9U48NQgjIrL3+rdArayDb/Ac3lKgkL9vs1bzJ0tZmkuH96dXDTlhuNqKtPGuHTxhKtDDoqA5FSteFMfyS8EpiI/HNWpbPTKAI9ITOTosyfRR2JjNM3XjBnw4H2IOjCGY7CPB1PtToPrw0mCIZumfJrFTP8wmMCgYEA7E1wDZpIjswl5B1VQ+XskAIOI4/2cG8deuA8srM1yL4XTW0KprCnwG1/QSJ0y32aNEkhKl6X7HqHWcGk2YVr+pj+Y+EDf09dpYp/nMkO7jADi7+jcGHDa6GeN+0z+f5mEmEuA3YTFNIT6UxJ3C6+bMK1/DOksDIlIRJff2OMqCECgYBm6IYTNYBsjmJO2M41o/PbPkjIlepLN3JZrLn9Nx7x1JdUuHjfUm3lJYNBXbS8wrg2Oi8Mp4nxh+l+A9pFYKDnbQ862F18ZUYdGklBV8fkSKJ/pvlxIheKVEt1iYrvYo0m5R7TgDeefDzXjzhHtiS6fegbbcEX4avRMrT27fukEg==',

    'limit_pay'                 => [
        //'balance',// 余额
        //'moneyFund',// 余额宝
        //'debitCardExpress',// 	借记卡快捷
        //'creditCard',//信用卡
        //'creditCardExpress',// 信用卡快捷
        //'creditCardCartoon',//信用卡卡通
        //'credit_group',// 信用支付类型（包含信用卡卡通、信用卡快捷、花呗、花呗分期）
    ],// 用户不可用指定渠道支付当有多个渠道时用“,”分隔

    // 与业务相关参数
    'notify_url'                => 'http://wztx.shp.api.ruitukeji.com/callback/alipay_callback',
    'return_url'                => 'http://wztx.shp.api.ruitukeji.com/callback/alipay_callback',

    'return_raw'                => false,// 在处理回调时，是否直接返回原始数据，默认为 true
];
