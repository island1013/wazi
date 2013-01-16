<?php

class topicAction extends frontendAction {

    public function _initialize(){
        parent::_initialize();
        //访问者控制
        if (!$this->visitor->is_login) {
            IS_AJAX && $this->ajaxReturn(0, L('login_please'));
            $this->redirect('user/login');
        }
    }

    /**
     * 转发微博
     */
    public function forward() {
        if (IS_POST) {
            foreach ($_POST as $key=>$val) {
                $_POST[$key] = Input::deleteHtmlTags($val);
            }
            $tid = $this->_post('tid', 'intval');
            $content = $this->_post('content', 'trim');
            $topic_mod = M('topic');
            //微薄是否有效
            $topic_info = $topic_mod->field('id,uid')->find($tid);
            !$topic_info && $this->ajaxReturn(0, '您要转发的微薄不存在或者已经被删除');
            $data = array(
                'uid' => $this->visitor->info['id'],
                'uname' => $this->visitor->info['username'],
                'content' => $content,
                'type' => 1,
            );
            if (false !== $topic_mod->create($data)) {
                $forward_tid = $topic_mod->add();
                if ($forward_tid) {
                    //添加微博关系
                    M('topic_relation')->add(array(
                        'tid' => $forward_tid,
                        'src_tid' => $topic_info['id'],
                        'author_uid' => $topic_info['uid'],
                        'type' => 1,
                    ));
                    //添加at记录
                    M('topic_at')->add(array(
                        'uid' => $topic_info['uid'],
                        'tid' => $forward_tid,
                    ));
                    //转发分享钩子
                    $tag_arg = array('uid'=>$this->visitor->info['id'], 'uname'=>$this->visitor->info['username'], 'action'=>'fwitem');
                    tag('fwitem_end', $tag_arg);
                    $this->ajaxReturn(1, '转发成功');
                } else {
                    $this->ajaxReturn(0, '转发失败');
                }
            } else {
                $this->ajaxReturn(0, '转发失败');
            }
        } else {
            $tid = $this->_get('tid', 'intval');
            !$tid && $this->ajaxReturn(0, '请选择要转发的动态');
            $topic = M('topic')->field('id,content')->find($tid);
            $this->assign('topic', $topic);
            $resp = $this->fetch('dialog:topic_forward');
            $this->ajaxReturn(1, '', $resp);
        }
    }

    /**
     * 评论微博
     */
    public function comment() {
        if (IS_POST) {
            foreach ($_POST as $key=>$val) {
                $_POST[$key] = Input::deleteHtmlTags($val);
            }
            $tid = $this->_post('tid', 'intval');
            $content = $this->_post('content', 'trim');
            if ($content == '') {
                $this->ajaxReturn(0, '请输入评论内容！');
            }
            $topic_mod = M('topic');
            //微薄是否有效
            $topic_info = $topic_mod->field('id,uid')->find($tid);
            !$topic_info && $this->ajaxReturn(0, '您要评论的微薄不存在或者已经被删除');
            $data = array(
                'uid' => $this->visitor->info['id'],
                'uname' => $this->visitor->info['username'],
                'tid' => $tid,
                'content' => $content,
                'author_uid' => $topic_info['uid'],
            );
            if (D('topic_comment')->publish($data)) {
                $this->ajaxReturn(1, '评论成功！');
            } else {
                $this->ajaxReturn(0, '评论失败！');
            }
        } else {
            $tid = $this->_get('tid', 'intval');
            !$tid && $this->ajaxReturn(0, '请选择要评论的动态');
            $topic_comment_mod = M('topic_comment');
            $map = array('tid'=>$tid);
            $pagesize = 8;
            $count = $topic_comment_mod->where($map)->count('id');
            $pager = $this->_pager($count, $pagesize);
            $comment_list = M('topic_comment')->where($map)->order('id DESC')->limit($pager->firstRow.','.$pager->listRows)->select();
            $this->assign('comment_list', $comment_list);
            $this->assign('page_bar', $pager->fshow());
            $resp = $this->fetch('space:cmt_list');
            $this->ajaxReturn(1, '', $resp);
        }
    }

    /**
     * 删除微薄评论
     */
    public function comment_del() {
        $cid = $this->_get('cid', 'intval');
        !$cid && $this->ajaxReturn(0, '请选择要删除的评！');
        $topic_comment_mod = M('topic_comment');
        $tid = $topic_comment_mod->where(array('id'=>$cid))->getField('tid');
        if ($topic_comment_mod->where(array('id'=>$cid, 'uid'=>$this->visitor->info['id']))->delete()) {
            M('topic')->where(array('id'=>$tid))->setDec('comments');
            $this->ajaxReturn(1, '删除成功！');
        } else {
            $this->ajaxReturn(0, '删除失败！');
        }
    }

    /**
     * 删除微博
     */
    public function delete() {
        $tid = $this->_get('tid', 'intval');
        !$tid && $this->ajaxReturn(0, '请选择要删除的动态');
        if (M('topic')->where(array('id'=>$tid, 'uid'=>$this->visitor->info['id']))->delete()) {
            $this->ajaxReturn(1, '删除成功');
        } else {
            $this->ajaxReturn(0, '删除失败');
        }
    }
}