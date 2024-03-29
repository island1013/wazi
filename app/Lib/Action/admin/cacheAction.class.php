<?php

class cacheAction extends backendAction
{
    public function _initialize() {
        parent::_initialize();
    }

    public function index() {
        $this->display();
    }

    public function clear() {
        $type = $this->_get('type','trim');
        $obj_dir = new Dir;
        switch ($type) {
            case 'field':
                is_dir(DATA_PATH . '_fields/') && $obj_dir->del(DATA_PATH . '_fields/');
                break;
            case 'tpl':
                is_dir(CACHE_PATH) && $obj_dir->delDir(CACHE_PATH);
                break;
            case 'data':
                is_dir(DATA_PATH) && $obj_dir->del(DATA_PATH);
                is_dir(TEMP_PATH) && $obj_dir->delDir(TEMP_PATH);
                break;
            case 'runtime':
                @unlink(RUNTIME_FILE);
                break;
            case 'logs':
                is_dir(LOG_PATH) && $obj_dir->delDir(LOG_PATH);
                break;
            case 'html':
                $this->ajaxReturn(1);
                is_dir(HTML_PATH) && $obj_dir->delDir(HTML_PATH);
                break;
        }
        $this->ajaxReturn(1);
    }

    public function qclear() {
        $obj_dir = new Dir;
        is_dir(DATA_PATH . '_fields/') && $obj_dir->del(DATA_PATH . '_fields/');
        is_dir(CACHE_PATH) && $obj_dir->delDir(CACHE_PATH);
        is_dir(DATA_PATH) && $obj_dir->del(DATA_PATH);
        is_dir(TEMP_PATH) && $obj_dir->delDir(TEMP_PATH);
        is_dir(LOG_PATH) && $obj_dir->delDir(LOG_PATH);
        is_dir(HTML_PATH) && $obj_dir->delDir(HTML_PATH);
        @unlink(RUNTIME_FILE);
        $this->ajaxReturn(1, L('clear_success'));
    }
}