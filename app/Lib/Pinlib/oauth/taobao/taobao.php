<?php
vendor('Taobaotop.TopClient');
vendor('Taobaotop.RequestCheckUtil');
vendor('Taobaotop.Logger');
require_once dirname(__FILE__) . '/taobao.class.php';
class taobao_oauth
{
    private $_need_request = array('top_appkey', 'top_parameters', 'top_session', 'ts', 'sign', 'top_sign');

    public function __construct($setting) {
        $this->redirect_uri = U('oauth/callback', array('mod'=>'taobao'), '', '', true);
        $this->setting = $setting;
    }
    function getAuthorizeURL() {
      $oauth = new TaobaoTOAuthV2($this->setting['app_key'], $this->setting['app_secret'] );
      return $oauth->getAuthorizeURL($this->redirect_uri);
    }
    public function getUserInfo($request_args) {
        if (!$this->CheckTaoBaoSign($request_args['top_parameters'], $request_args['top_session'], $request_args['top_sign'])) {
            exit('signature invalid.');
        }
        $parameters = array();
        parse_str(base64_decode($request_args['top_parameters']), $parameters);
        $now = time();
        $ts = intval($parameters['ts'] / 1000);
        if ($ts > ( $now + 60 * 10 ) || $now > ( $ts + 60 * 30 )) {
            exit('request out of date.');
        }
        $client = new TopClient();
        $client->appkey = $this->setting['app_key'];
        $client->secretKey = $this->setting['app_secret'];
        $req = $client->load_api('UserGetRequest');
        $req->setFields("user_id,uid,nick,sex,buyer_credit,seller_credit,location,created,last_visit,birthday,type,alipay_account,alipay_no,avatar,vip_info,email");
        $req->setNick($parameters['visitor_nick']);
        $resp = $client->execute($req, $request_args['top_session']);
        if (!$resp->user) {
            exit('param error.'); 
        }
        $user = (array)$resp->user;
        $result['keyid'] = $user['user_id'];
        $result['keyname'] = $user['nick'];
        $result['keyavatar_small'] = $user['avatar'];
        $result['keyavatar_big'] = $user['avatar'];
        $result['bind_info'] = $request_args;
        return $result;
    }
    public function getFriends($bind_user, $page, $count) {
        
    }
    public function send($bind_user, $data) {
        //淘宝不发送
    }
    public function follow($bind_user, $uid) {
        
    }
    public function NeedRequest() {
        return $this->_need_request;
    }
    public function CheckTaoBaoSign($top_parameters, $top_session, $top_sign) {
        $sign = base64_encode(md5($this->setting['app_key'].$top_parameters.$top_session.$this->setting['app_secret'], true));
        return $sign == $top_sign;
    }
}