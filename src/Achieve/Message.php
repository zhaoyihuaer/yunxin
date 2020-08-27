<?php

namespace Yihuaer\Yunxin\Achieve;

use Yihuaer\Yunxin\Exceptions\InvalidArgumentException;
use Yihuaer\Yunxin\Traits\HasHttpRequest;
use Yihuaer\Yunxin\Yunxin;

/**
 * 消息
 * Class Message
 * @package Yihuaer\Yunxin\Achieve
 */
class Message extends Yunxin
{
    use HasHttpRequest;

    /**
     * 消息功能-发送普通消息
     * @param  $from       [发送者accid，用户帐号，最大32字节，APP内唯一]
     * @param  $ope        [0：点对点个人消息，1：群消息，其他返回414]
     * @param  $to        [ope==0是表示accid，ope==1表示tid]
     * @param  $type        [0 表示文本消息,1 表示图片，2 表示语音，3 表示视频，4 表示地理位置信息，6 表示文件，100 自定义消息类型]
     * @param  $body       [请参考下方消息示例说明中对应消息的body字段。最大长度5000字节，为一个json字段。]
     * @param  $option       [发消息时特殊指定的行为选项,Json格式，可用于指定消息的漫游，存云端历史，发送方多端同步，推送，消息抄送等特殊行为;option中字段不填时表示默认值]
     * @param  $pushcontent      [推送内容，发送消息（文本消息除外，type=0），option选项中允许推送（push=true），此字段可以指定推送内容。 最长200字节]
     * @param array $params
     * @return mixed
     * @throws InvalidArgumentException
     */
    public function sendMsg(array $params){

        $url = 'https://api.netease.im/nimserver/msg/sendMsg.action';

        if (!isset($params['option']) || empty($params['option'])) {
            $params['option'] = $this->defaultOptions();
        }

        $params = $this->checkParams($params);
        return $this->post($url,$params,$this->getHeaders());
    }

    /**
     * 历史记录-单聊

     * @return $result      [返回array数组对象]
     */
    /**
     * 历史记录-单聊
     * @param  $from       [发送者accid]
     * @param  $to          [接收者accid]
     * @param  $begintime     [开始时间，ms]
     * @param  $endtime     [截止时间，ms]
     * @param  $limit       [本次查询的消息条数上限(最多100条),小于等于0，或者大于100，会提示参数错误]
     * @param  $reverse    [1按时间正序排列，2按时间降序排列。其它返回参数414.默认是按降序排列。]
     * @param array $params
     * @return mixed
     * @throws InvalidArgumentException
     */
    public function querySessionMsg(array $params){
        $url = 'https://api.netease.im/nimserver/history/querySessionMsg.action';

        $params = $this->checkParams($params);

        return $this->post($url,$params,$this->getHeaders());
    }

    /**
     * @param $params
     * @return array
     * @throws InvalidArgumentException
     */
    protected function checkParams($params)
    {
        if (!isset($params['from']) || empty($params['from'])) {
            throw new InvalidArgumentException('Invalid from value');
        }
        if (!isset($params['to']) || empty($params['to'])) {
            throw new InvalidArgumentException('Invalid from value');
        }

        $this->checkSumBuilder();
        return $params;
    }

    /**
     * 默认行为选项
     * @return array
     */
    protected function defaultOptions()
    {
        return [
            "push" => false,
            "roam" => true,
            "history" => true,
            "sendersync" => true,
            "route" => false
        ];
    }
}