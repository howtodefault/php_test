# tpns-server-sdk/php
## 概述
[腾讯移动推送](https://cloud.tencent.com/product/tpns) 是腾讯云提供的一款支持**百亿级**消息的移动App推送平台，开发者可以调用php SDK访问腾讯移动推送服务。

## 使用说明
1. 接口和参数，可以参看[官网](https://cloud.tencent.com/document/product/548/39060) ，注意，本代码只支持推送接口。

2. 全量推送
   ```
   <?php
   namespace {
       require_once("tpns.php");

       //$android = new tpns\AndroidMessage;
       //$android->n_ch_id = "chid";
                       
       $ios = new tpns\iOSMessage;
       $ios->custom = "{\"key\":\"value\"}";
                                   
       $req = tpns\NewRequest(
           tpns\WithAudienceType(tpns\AUDIENCE_ALL),
           tpns\WithPlatform(tpns\PLATFORM_IOS),
           tpns\WithMessageType(tpns\MESSAGE_NOTIFY),
           tpns\WithTitle("this-title"),
           tpns\WithContent("this-content"),
           tpns\WithThreadId("tid"),
           //tpns\WithAndroidMessage($android),
           tpns\WithIOSMessage($ios),
           tpns\WithEnvironment(tpns\ENVIRONMENT_PROD)
       );

       //@parameter: accessId=123456, secretKey="abcdef", host="api.tpns.tencent.com"
       $stub = new tpns\Stub(123456, "abcdef", tpns\GUANGZHOU);
       $result = $stub->Push($req);
       var_dump($result);
   }

   ```

3. 单设备推送
   ```
   <?php
   namespace {
       require_once("tpns.php");

       //$android = new tpns\AndroidMessage;
       //$android->n_ch_id = "chid";
                       
       $ios = new tpns\iOSMessage;
       $ios->custom = "{\"key\":\"value\"}";
                                   
       $req = tpns\NewRequest(
           tpns\WithAudienceType(tpns\AUDIENCE_TOKEN),
           tpns\WithPlatform(tpns\PLATFORM_IOS),
           tpns\WithMessageType(tpns\MESSAGE_NOTIFY),
           tpns\WithTitle("this-title"),
           tpns\WithContent("this-content"),
           //tpns\WithAndroidMessage($android),
           tpns\WithIOSMessage($ios),
           tpns\WithTokenList(array("abc")),
           tpns\WithEnvironment(tpns\ENVIRONMENT_PROD)
       );
       
       //@parameter: accessId=123456, secretKey="abcdef", host="api.tpns.tencent.com"
       $stub = new tpns\Stub(123456, "abcdef", tpns\GUANGZHOU);
       $result = $stub->Push($req);
       var_dump($result);
   }

   ```
4. 设备列表推送
   ```
   <?php
   namespace {
       require_once("tpns.php");

       //$android = new tpns\AndroidMessage;
       //$android->n_ch_id = "chid";
                       
       $ios = new tpns\iOSMessage;
       $ios->custom = "{\"key\":\"value\"}";
                                   
       $req = tpns\NewRequest(
           tpns\WithAudienceType(tpns\AUDIENCE_TOKEN_LIST),
           tpns\WithPlatform(tpns\PLATFORM_IOS),
           tpns\WithMessageType(tpns\MESSAGE_NOTIFY),
           tpns\WithTitle("this-title"),
           tpns\WithContent("this-content"),
           //tpns\WithAndroidMessage($android),
           tpns\WithIOSMessage($ios),
           tpns\WithTokenList(array("abc", "def", "hijk")),
           tpns\WithEnvironment(tpns\ENVIRONMENT_PROD)
       );
       
       //@parameter: accessId=123456, secretKey="abcdef", host="api.tpns.tencent.com"
       $stub = new tpns\Stub(123456, "abcdef", tpns\GUANGZHOU);
       $result = $stub->Push($req);
       var_dump($result);

   ``` 

5. 单账号推送
   ```
   <?php
   namespace {
       require_once("tpns.php");

       //$android = new tpns\AndroidMessage;
       //$android->n_ch_id = "chid";
                       
       $ios = new tpns\iOSMessage;
       $ios->custom = "{\"key\":\"value\"}";
                                   
       $req = NewRequest(
           tpns\WithAudienceType(tpns\AUDIENCE_ACCOUNT),
           tpns\WithPlatform(tpns\PLATFORM_IOS),
           tpns\WithMessageType(tpns\MESSAGE_NOTIFY),
           tpns\WithTitle("this-title"),
           tpns\WithContent("this-content"),
           //tpns\WithAndroidMessage($android),
           tpns\WithIOSMessage($ios),
           tpns\WithAccountList(array("account1")),
           tpns\WithEnvironment(tpns\ENVIRONMENT_PROD)
       );
       
       //@parameter: accessId=123456, secretKey="abcdef", host="api.tpns.tencent.com"
       $stub = new tpns\Stub(123456, "abcdef", tpns\GUANGZHOU);
       $result = $stub->Push($req);
       var_dump($result);
 
   ```  
    
6. 账号列表推送
   ```
   <?php
   namespace {
       require_once("tpns.php");

       //$android = new tpns\AndroidMessage;
       //$android->n_ch_id = "chid";
                       
       $ios = new tpns\iOSMessage;
       $ios->custom = "{\"key\":\"value\"}";
                                   
       $req = tpns\NewRequest(
           tpns\WithAudienceType(tpns\AUDIENCE_ACCOUNT_LIST),
           tpns\WithPlatform(tpns\PLATFORM_IOS),
           tpns\WithMessageType(tpns\MESSAGE_NOTIFY),
           tpns\WithTitle("this-title"),
           tpns\WithContent("this-content"),
           //tpns\WithAndroidMessage($android),
           tpns\WithIOSMessage($ios),
           tpns\WithAccountList(array("account1", "account2", "account3")),
           tpns\WithEnvironment(tpns\ENVIRONMENT_PROD)
       );
       
       //@parameter: accessId=123456, secretKey="abcdef", host="api.tpns.tencent.com"
       $stub = new tpns\Stub(123456, "abcdef", tpns\GUANGZHOU);
       $result = $stub->Push($req);
       var_dump($result);
   
   ```    
   
7. 标签推送
   ```
   <?php
   namespace {
       require_once("tpns.php");

       //$android = new tpns\AndroidMessage;
       //$android->n_ch_id = "chid";
                       
       $ios = new tpns\iOSMessage;
       $ios->custom = "{\"key\":\"value\"}";

       $tagItem = new tpns\TagItem;
       $tagItem->tags = array("tag1", "tag2");
       $tagItem->tags_operator = tpns\TAG_OPERATOR_AND;
       $tagItem->items_operator = tpns\TAG_OPERATOR_OR;
       $tagItem->tag_type = "xg_auto_active";

       $tagRule = new tpns\TagRule;
       $tagRule->operator = tpns\TAG_OPERATOR_OR;
       $tagRule->tag_items = array($tagItem);

                                   
       $req = tpns\NewRequest(
           tpns\WithAudienceType(tpns\AUDIENCE_TAG),
           tpns\WithPlatform(tpns\PLATFORM_IOS),
           tpns\WithMessageType(tpns\MESSAGE_NOTIFY),
           tpns\WithTitle("this-title"),
           tpns\WithContent("this-content"),
           //tpns\WithAndroidMessage($android),
           tpns\WithIOSMessage($ios),
           tpns\WithTagRules(array($tagRule)),
           tpns\WithEnvironment(tpns\ENVIRONMENT_PROD)
       );
       
       //@parameter: accessId=123456, secretKey="abcdef", host="api.tpns.tencent.com"
       $stub = new tpns\Stub(123456, "abcdef", tpns\GUANGZHOU);
       $result = $stub->Push($req);
       var_dump($result);
   
   ```  
8. 其它
   可以具体参看官网文档，通过WithXXX方式来填充Request结构体，然后调用Stub->Push发起请求。     
