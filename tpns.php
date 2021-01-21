<?php
namespace tpns {
    const GUANGZHOU = "api.tpns.tencent.com";
    const SINGAPORE = "api.tpns.sgp.tencent.com";
    const HONGKONG  = "api.tpns.hk.tencent.com";
    const SHANGHAI  = "api.tpns.sh.tencent.com";

    //audience type
    const AUDIENCE_ALL            = "all";
    const AUDIENCE_TAG            = "tag";
    const AUDIENCE_TOKEN          = "token";
    const AUDIENCE_TOKEN_LIST     = "token_list";
    const AUDIENCE_ACCOUNT        = "account";
    const AUDIENCE_ACCOUNT_LIST   = "account_list";

    // tag operation type
    const TAG_OPERATOR_AND = "AND";
    const TAG_OPERATOR_OR  = "OR";

    // platform type
    const PLATFORM_ALL      = "all";
    const PLATFORM_ANDROID  = "android";
    const PLATFORM_IOS      = "ios";

    // message type
    const MESSAGE_NOTIFY  = "notify";
    const MESSAGE_MESSAGE = "message";

    // environment type
    const ENVIRONMENT_PROD = "product";
    const ENVIRONMENT_DEV  = "dev";

    class AndroidActionActivityAttr {
        public $if = 0;
        public $pf = 0;
    }
    class AndroidActionBrowserAttr {
        public $url = "";
        public $confirm = 0;
    }

    class AndroidAction {
        public $action_type  = 1;
        public $activity     = "";
        public $aty_attr;                 //AndroidActionActivityAttr
        public $browser;                  //AndroidActionBrowserAttr
        public $intent       = "";
        public function __construct() {
            $this->aty_attr = new AndroidActionActivityAttr;
            $this->browser = new AndroidActionBrowserAttr;
        }
    }

    class AndroidMessage {
        public $n_ch_id         = "";
        public $n_ch_name       = "";
        public $xm_ch_id        = "";
        public $hw_ch_id        = "";
        public $oppo_ch_id      = "";
        public $vivo_ch_id      = "";
        public $builder_id      = 0;
        public $badge_type      = -1;
        public $ring            = 1;
        public $ring_raw        = "";
        public $vibrate         = 1;
        public $lights          = 1;
        public $clearable       = 1;
        public $icon_type       = 0;
        public $icon_res        = "";
        public $style_id        = 0;
        public $small_icon      = "";
        public $action;                     //AndroidAction
        public $custom_content  = "";     
        public $show_type       = 2;
        public $icon_color      = 0;

        public function __construct() {
            $this->action = new AndroidAction;
        }
    }

    class Aps {
        public $alert               = "";
        public $badge_type          = 0;
        public $category            = "";
        public $content_available   = 0;    //json to content-available
        public $sound               = "";
        public $mutable_content     = 1;    //json to mutable-content
    }

    class iOSMessage {
        public $aps;                 //Aps
        public $custom = "";
        function __construct() {
            $this->aps = new Aps;
        }
    }

    class TagItem {
        public $tags;          //array of string
        public $is_not         = false;
        public $tags_operator  = "";
        public $items_operator = "";
        public $tag_type       = "";
        public function __construct() {
            $this->tags = array();
        }
    }

    class TagRule {
        public $tag_items;   //array of TagItem
        public $is_not       = false;
        public $operator     = "";
        public function __construct() {
            $this->tag_items = array();
        }
    }

    class AcceptTime {
        public $hour = "";
        public $min  = "";
    }

    class AcceptTimeRange {
        public $start;      //AcceptTime
        public $end;        //AcceptTime
        public function __construct() {
            $this->start = new AcceptTime;
            $this->end = new AcceptTime;
        }
    }

    class Message {
        public $title                    = ""; 
        public $content                  = "";
        public $accept_time;             //array of AcceptTimeRange
        public $thread_id                = "";
        public $thread_sumtext           = "";
        public $xg_media_resources       = "";
        public $xg_media_audio_resources = "";
        public $android;                 //AndroidMessage
        public $ios;                     //iOSMessage

        public function __construct() {
            $this->accept_time = array();
            $this->android = new AndroidMessage;
            $this->ios = new iOSMessage;
        }
    }

    class ChannelRule {
        public $channel = "";
        public $disable = false;
    }

    class LoopParam {
        public $startDate  = "";
        public $endDate    = "";
        public $loopType   = 0;
        public $loopDayIndexs;  //array of uint32
        public $DayTimes;       //array of string
        public function __construct() {
            $this->loopDayIndexs = array();
            $this->DayTimes = array();
        }
    };


    class Request {
        public $audience_type = "";
        public $platform      = "";
        public $message;                // Message
        public $message_type  = "";

        public $tag_rules;              // array of TagRule
        public $token_list;             // array of string
        public $account_list;           // array of string

        public $environment           = "";
        public $upload_id             = 0;
        public $expire_time           = 259200;
        public $send_time             = "";
        public $multi_pkg             = false;
        public $plan_id               = "";
        public $account_push_type     = 0;
        public $collapse_id           = 0;
        public $push_speed            = 0; 
        public $tpns_online_push_type = 0;
        public $force_collapse        = false;

        public $channel_rules;         //array of ChannelRule
        public $loop_param;            //LoopParam

        public function __construct() {
            $this->message = new Message;
            $this->tag_rules = array();
            $this->token_list = array();
            $this->account_list = array();
            $this->channel_rules = array();
            $this->loop_param = new LoopParam;
        }

        public function Validate() {
            if (empty($this->audience_type)) {
                throw new \Exception("audience_type is not set");
            }

            if ($this->audience_type != AUDIENCE_ALL && 
                $this->audience_type != AUDIENCE_TAG &&
                $this->audience_type != AUDIENCE_TOKEN &&
                $this->audience_type != AUDIENCE_TOKEN_LIST &&
                $this->audience_type != AUDIENCE_ACCOUNT &&
                $this->audience_type != AUDIENCE_ACCOUNT_LIST) {
                throw new \Exception ("invalid audience_type: ".$this->audience_type);
            }

            if ($this->audience_type == AUDIENCE_TOKEN || $this->audience_type == AUDIENCE_TOKEN_LIST) {
                if (empty($this->token_list)) {
                    throw new \Exception ("empty token_list");
                }
            }

            if ($this->audience_type == AUDIENCE_ACCOUNT || $this->audience_type == AUDIENCE_ACCOUNT_LIST) {
                if (empty($this->account_list)) {
                    throw new \Exception ("empty account_list");
                }
            }

            if ($this->audience_type == AUDIENCE_TAG) {
                if (empty($this->tag_rules)) {
                    throw new \Exception ("empty tag_rules");
                }
            }

            if (empty($this->platform)) {
                throw new \Exception("empty platform");
            }

            if ($this->platform != PLATFORM_ANDROID && $this->platform != PLATFORM_IOS) {
                throw new \Exception("invalid platform: " . $this->platform);
            }

            if (empty($this->message_type)) {
                throw new \Exception("empty message_type");
            }

            if ($this->message_type != MESSAGE_NOTIFY && $this->message_type != MESSAGE_MESSAGE) {
                throw new \Exception("invalid message_type: " . $this->message_type);
            }

            if ($this->platform == PLATFORM_IOS) {
                if (empty($this->environment)) {
                    throw new \Exception("empty environment");
                }
                if ($this->environment != ENVIRONMENT_PROD && $this->environment != ENVIRONMENT_DEV) {
                    throw new \Exception("invalid environment: " . $this->environment);
                }
            }
        }

        public function Marshal() {
            if ($this->platform == PLATFORM_ANDROID) {
                unset($this->message->ios);
            }

            if ($this->platform == PLATFORM_IOS) {
                unset($this->message->android);

                $aps = $this->message->ios->aps;
                $this->message->ios->aps = array(
                    "alert"      => $aps->alert,
                    "badge_type" => $aps->badge_type,
                    "category" => $aps->category,
                    "content-available" => $aps->content_available,
                    "sound" => $aps->sound,
                    "mutable-content" => $aps->mutable_content
                );
            }

            if ($this->audienceType == AUDIENCE_TOKEN || 
                $this->audienceType == AUDIENCE_TOKEN_LIST ||
                $this->audienceType == AUDIENCE_ACCOUNT || 
                $this->audienceType == AUDIENCE_TOKEN_LIST) {
                    unset($this->loop_param);
                }

            $data = json_encode($this);
            return $data;
        }

    }

    // set audience type: AUDIENCE_ALL, AUDIENCE_TAG, AUDIENCE_TOKEN, AUDIENCE_TOKEN_LIST, AUDIENCE_ACCOUNT, AUDIENCE_ACCOUNT_LIST
    function WithAudienceType($type) {
        return function($r) use ($type) {
            $r->audience_type = $type;
        };
    }

    // set platform: PLATFORM_ANDROID, PLATFORM_IOS
    function WithPlatform($platform) {
        return function($r) use ($platform) {
            $r->platform = $platform;
        };
    }

    //set message, type: Message
    function WithMessage($message) {
        return function($r) use ($message) {
            $r->message = $message;
        };
    }

    //set message title, type: string
    function WithTitle($title) {
        return function($r) use ($title) {
            $r->message->title = $title;
        };
    }

    //set message content, type: string
    function WithContent($content) {
        return function($r) use ($content) {
            $r->message->content = $content;
        };
    }

    //set message accept_time, type: array of AcceptTimeRange
    function WithAcceptTime($acceptTime) {
        return function($r) use ($acceptTime) {
            $r->message->accept_time = $acceptTime;
        };
    }

    //set message thread_id, type: string
    function WithThreadId($threadId) {
        return function($r) use ($threadId) {
            $r->message->thread_id = $threadId;
        };
    }

    //set message thread_sumtext, type: string
    function WithThreadSumText($threadSumText) {
        return function($r) use ($threadSumText) {
            $r->message->thread_sumtext = $threadSumText;
        };
    }

    //set message xg_media_resources, type string
    function WithXGMediaResources($xgMediaResources) {
        return function($r) use ($xgMediaResources) {
            $r->message->xg_media_resources = $xgMediaResources;
        };
    }

    //set message xg_media_audio_resources, type string
    function WithXGMediaAudioResources($xgMediaAudioResources) {
        return function($r) use ($xgMediaAudioResources) {
            $r->message->xg_media_audio_resources = $xgMediaAudioResources;
        };
    }

    //set message android, type AndroidMessage
    function WithAndroidMessage($android) {
        return function($r) use ($android) {
            $r->message->android = $android;
        };
    }

    //set message ios, type iOSMessage
    function WithIOSMessage($ios) {
        return function($r) use ($ios) {
            $r->message->ios = $ios;
        };
    }

    //set message_type, 'MESSAGE_NOTIFY' or 'MESSAGE_MESSAGE'
    function WithMessageType($type) {
        return function($r) use ($type) {
            $r->message_type = $type;
        };
    }

    //set tag_rules, type: array of TagRule
    function WithTagRules($tagRules) {
        return function($r) use ($tagRules) {
            $r->tag_rules = $tagRules;
        };
    }

    //set token_list, type: array of string
    function WithTokenList($tokenList) {
        return function($r) use ($tokenList) {
            $r->token_list = $tokenList;
        };
    }

    //set account_list, type: array of string
    function WithAccountList($accountList) {
        return function($r) use ($accountList) {
            $r->account_list = $accountList;
        };
    }

    //set environment, only for iOS, 'ENVIRONMENT_PROD' or 'ENVIRONMENT_DEV'
    function WithEnvironment($env) {
        return function($r) use ($env) {
            $r->environment = $env;
        };
    }

    //set upload_id, type: int
    function WithUploadId($uploadId) {
        return function($r) use ($uploadId) {
            $r->upload_id = $uploadId;
        };
    }

    //set expire_time, type: int
    function WithExpireTime($expireTime) {
        return function($r) use ($expireTime) {
            $r->expire_time = $expireTime;
        };
    }

    //set send_time, type: string
    function WithSendTime($sendtime) {
        return function($r) use ($sendtime) {
            $r->send_time = $sendtime;
        };
    }

    //set multi_pkg, type: boolean
    function WithMultiPkg($multiPkg) {
        return function($r) use ($multiPkg) {
            $r->multi_pkg = $multiPkg;
        };
    }

    //set plan_id, type: string
    function WithPlanId($planId) {
        return function($r) use ($planId) {
            $r->plan_id = $planId;
        };
    }

    //set account_push_type, type: int
    function WithAccountPushType($type) {
        return function($r) use ($type) {
            $r->account_push_type = $type;
        };
    }

    //set collapse_id, type: int
    function WithCollapseId($collapseId) {
        return function($r) use ($collapseId) {
            $r->collapse_id = $collapseId;
        };
    }

    //set push_speed, type: int
    function WithPushSpeed($speed) {
        return function($r) use ($speed) {
            $r->push_speed = $speed;
        };
    }

    //set tpns_online_push_type, type int
    function WithTpnsOnlinePushType($type) {
        return function($r) use ($type) {
            $r->tpns_online_push_type = $type;
        };
    }

    //set force_collapse, type: bool
    function WithForceCollapse($force) {
        return function($r) use ($force) {
            $r->force_collapse = $force;
        };
    }

    //set channel_rules, type: array of ChannelRule
    function WithChannelRules($channelRules) {
        return function($r) use ($channelRules) {
            $r->channel_rules = $channelRules;
        };
    }

    //set loop_param, type: LoopParam
    function WithLoopParam($param) {
        return function($r) use ($param) {
            $r->loop_param = $param;
        };
    }

    //@param: WithXXX
    //php<5.6 not support ...$args
    function NewRequest() {
        $r= new Request;
        $num = func_num_args();
        $args = func_get_args();
        for ($i = 0; $i < $num; $i++) {
            $args[$i]($r);
        }

        return $r;
    }


    class Stub {
        public $host;
        public $sign;

        public function __construct($accessId, $secretKey, $host) {
            $this->host = $host;
            if (strpos($host, "http://") == false && strpos($host, "https://") == false) {
                $this->host = "https://" . $host;
            }

            $this->sign = base64_encode($accessId . ":" . $secretKey);
        }

        public function Push($request) {
            $request->Validate();

            $headers = array("Content-type: application/json;charset='utf-8'", "Authorization: Basic " . $this->sign);
            $url = $this->host . "/v3/push/app";

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_HEADER, 0); 
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $request->Marshal());
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_TIMEOUT, 10000);
            $ret = curl_exec($ch);
            curl_close($ch);
            return json_decode($ret, 1);
        }
    }
}
