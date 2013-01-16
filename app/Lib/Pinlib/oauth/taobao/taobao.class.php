<?php
class TaobaoTOAuthV2 {
    public $api_key = '';
    public $secret_key = '';
    private $_authorize_url = 'http://container.api.taobao.com/container';
    function __construct($api_key, $secret_key)
    {
        $this->api_key = $api_key;
        $this->secret_key = $secret_key;
    }
    function getAuthorizeURL($callback)
    {
        $state = md5(uniqid(rand(), TRUE));
        $url = $this->_authorize_url . '?appkey=' . $this->api_key . '&redirect_uri=' . urlencode($callback);
      	return $url;
    }
}