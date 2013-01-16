<?php

class captchaAction extends frontendAction {

    /**
     * 普通验证码
     */
	public function index() {
		import("ORG.Util.Image");
        Image::buildImageVerify(4,1,'gif','50','24', 'captcha');
	}

	/**
	 * 中文验证码
	 */
	public function cn() {

	}
}