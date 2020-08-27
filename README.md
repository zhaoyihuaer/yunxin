<h1 align="center"> Yunxin </h1>

<p align="center"> 基于网易云信的IM 扩展</p>


## Installing 安装

```shell
$ composer require yihuaer/yunxin -vvv
```
## 安装 开发版
```shell
$ composer require yihuaer/yunxin:dev-master
```
## 用户示例
```php
    $conf = [
        'app_key' => '9cf2e9d011c20d0dbaa36392dba67360',
        'app_secret' => 'ff89b9722095'
    ];
    // 获取用户实例
    //$letter = Letter::user($conf);
    
    // 创建用户
    $data = [
        'accid' => 1111111,
        'name'  => 'zhaoyi',
        'props' => '',
        'token' => ''
    ];
    $result = $letter->createUserId($data);
    
    // 封禁用户
    $data = [
        'accid' => 1111111
    ];
    
    $result = $letter->blockUserId($data);
    // 解禁
    $result = $letter->unblockUserId($data);
    
     $data= [
        'accid' => 1111111,
        'name' => 'zhaozzz',
        'icon' => '',
        'sign' => '这是签名',
        'email' => 'zzz@163.com',
        'birth' => '19951011',
        'mobile' => '13936380118',
        'gender' => 1,
        'ex' => ''
     ];
     // 更新用户信息
     $result = $letter->updateUinfo($data);
    
     $data= [
            'accid' => [1111111]
     ];
     // 获取用户信息
     $result = $letter->getUinfos($data);
    
```

## 消息示例
```php
    // 实例化消息
    $letter = Letter::message($conf);
    
    // 发送点对点消息
    $data= [
        'from' => 1111111,
        'ope' => 0,
        'to' => 22222,
        'type' => 0,
        'body' => json_encode(['msg' => 'hello']), // 发送的消息内容
        'option' => '',
        'pushcontent' => ''
    ];

    $result = $letter->sendMsg($data);
    
    // 获取历史消息
    $data = [
        'from' => 1111111,
        'to' => 1111111,
        'begintime' => (string)(time()*1000-2000000),
        'endtime' => (string)(time()*1000),
        'limit' => 100, //本次查询的消息条数上限(最多100条),小于等于0，或者大于100，会提示参数错误
        'reverse' => 1 //1按时间正序排列，2按时间降序排列。其它返回参数414.默认是按降序排列。
    ];
    $result = $letter->querySessionMsg($data);
```
    
更多内容还在丰富中 ， 具体请查阅 
[网易云信](https://dev.yunxin.163.com/docs/product/IM%E5%8D%B3%E6%97%B6%E9%80%9A%E8%AE%AF/%E6%96%B0%E6%89%8B%E6%8E%A5%E5%85%A5%E6%8C%87%E5%8D%97)