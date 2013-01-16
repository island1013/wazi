<?php
/**
 * 404错误 
 */
class EmptyAction extends Action {
    public function _empty($method) {
        $this->display(TMPL_PATH . '404.html');
    }
}