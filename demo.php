<?php

namespace {
    require_once("tpns.php");
    //$tagItem = new tpns\TagItem;
    //$tagItem->tags = array("tag1", "tag2");
    //$tagItem->tags_operator = tpns\TAG_OPERATOR_AND;
    //$tagItem->items_operator = tpns\TAG_OPERATOR_OR;
    //$tagItem->tag_type = "xg_auto_active";

    //$tagRule = new tpns\TagRule;
    //$tagRule->operator = tpns\TAG_OPERATOR_OR;
    //$tagRule->tag_items = array($tagItem);

    $android = new tpns\AndroidMessage;
    $android->n_ch_id = "chid";
    
    $ios = new tpns\iOSMessage;
    $ios->custom = "{\"key\":\"value\"}";
    
    $req = tpns\NewRequest(
        tpns\WithAudienceType(tpns\AUDIENCE_TOKEN),
        tpns\WithPlatform(tpns\PLATFORM_IOS),
        tpns\WithMessageType(tpns\MESSAGE_NOTIFY),
        tpns\WithTitle("this-title"),
        tpns\WithContent("this-content"),
        tpns\WithThreadId("tid"),
        tpns\WithThreadSumText("st"),
        tpns\WithXGMediaResources("xgmr"),
        tpns\WithXGMediaAudioResources("xgmar"),
        tpns\WithAndroidMessage($android),
        tpns\WithIOSMessage($ios),
        //WithTagRules(array($tagRule)),
        tpns\WithTokenList(array("abc")),
        //WithAccountList(array("abc", "def")),
        tpns\WithEnvironment(tpns\ENVIRONMENT_PROD)
    );
    
    
    //@parameter: accessId=123456, secretKey="abcdef", host="api.tpns.tencent.com"
    $stub = new tpns\Stub(123456, "abcdef", tpns\GUANGZHOU);
    $result = $stub->Push($req);
    var_dump($result);
}
