<?php
class item_commentAction extends backendAction
{
    public function _initialize() {
        parent::_initialize();
        $this->_mod = M('item_comment');
    }

    public function index() {
        $prefix = C(DB_PREFIX);

        if ($this->_request("sort", 'trim')) {
            $sort = $this->_request("sort", 'trim');
        } else if (!empty($sort_by)) {
            $sort = $sort_by;
        } else if ($this->sort) {
            $sort = $this->sort;
        } else {
            $sort = $prefix.'item_comment.id';
        }
        if ($this->_request("order", 'trim')) {
            $order = $this->_request("order", 'trim');
        } else if (!empty($order_by)) {
            $order = $order_by;
        } else if ($this->order) {
            $order = $this->order;
        } else {
            $order = 'DESC';
        }

        $p = $this->_get('p','intval',1);
        $this->assign('p',$p);


        $where = '1=1';
        $keyword = $this->_request('keyword','trim','');
        $keyword && $where .= " AND ((".$prefix."user.username LIKE '%".$keyword."%') OR (".$prefix."item.title LIKE '%".$keyword."%') OR (".$prefix."item_comment.info LIKE '%".$keyword."%') )";
        $keyword && $search['keyword'] = $keyword;
        $this->assign('search',$search);

        $count = $this->_mod->join($prefix.'user ON '.$prefix.'user.id='.$prefix.'item_comment.uid')->join($prefix.'item ON '.$prefix.'item.id='.$prefix.'item_comment.item_id')->where($where)->count($prefix.'item_comment.id');
        $pager = new Page($count,20);
        $list  = $this->_mod->field($prefix.'item_comment.*,'.$prefix.'user.username,'.$prefix.'item.title as item_name,'.$prefix.'item.img')->join($prefix.'user ON '.$prefix.'user.id='.$prefix.'item_comment.uid')->join($prefix.'item ON '.$prefix.'item.id='.$prefix.'item_comment.item_id')->where($where)->order($sort . ' ' . $order)->limit($pager->firstRow.','.$pager->listRows)->select();
        $this->assign('list',$list);
        $this->assign('page',$pager->show());

        $this->assign('list_table', true);

        $this->display();
    }

}