<?php
/**
 * 用户信息管理
 */
class userAction extends backendAction
{

    public function _initialize() {
        parent::_initialize();
        $this->_mod = D('user');
    }

    protected function _search() {
        $map = array();
        if( $keyword = $this->_request('keyword', 'trim') ){
            $map['_string'] = "username like '%".$keyword."%' OR email like '%".$keyword."%'";
        }
        $this->assign('search', array(
            'keyword' => $keyword,
        ));
        return $map;
    }

    public function _before_index() {
        $big_menu = array(
            'title' => L('添加会员'),
            'iframe' => U('user/add'),
            'id' => 'add',
            'width' => '500',
            'height' => '330'
        );
        $this->assign('big_menu', $big_menu);
        $this->assign('img_dir',$this->_get_imgdir());
    }

    public function _before_insert($data){

        if( ($data['password']!='')&&(trim($data['password'])!='') ){
            $data['password'] = md5($data['password']);
        }else{
            unset($data['password']);
        }
        return $data;
    }

    public function _after_insert($id){
        import("ORG.Util.Image");
        $img = $this->_post('img','trim');

        $a = explode('.',$img);
        $extend = $a[count($a)-1];
        $img_path = $this->_mod->get_avatar_dirs($id);
        $path = './data/upload/user/avatar/'.$img_path.'/';
        mkdir($path);

        Image::thumb('./data/upload/user/tmp/'.$img, './data/upload/user/avatar/'.$img_path.'/' . md5($id).'_middle.'.$extend, '', 80, 80, true);
        Image::thumb('./data/upload/user/tmp/'.$img, './data/upload/user/avatar/'.$img_path.'/' . md5($id).'_big.'.$extend, '', 106, 106, true);
        Image::thumb('./data/upload/user/tmp/'.$img, './data/upload/user/avatar/'.$img_path.'/' . md5($id).'_small.'.$extend, '', 48, 48, true);
        @unlink('./data/upload/user/tmp/'.$img);

    }

    public function _before_update($data)
    {
        if( ($data['password']!='')&&(trim($data['password'])!='') ){
            $data['password'] = md5($data['password']);
        }else{
            unset($data['password']);
        }
        return $data;
    }

    public function _after_update($id){
        $username = $this->_mod->where(array('id'=>$id))->getField('username');
        D('message')->setName($id,$username);

        $img = $this->_post('img','trim');

        $a = explode('.',$img);
        $extend = $a[count($a)-1];
        $id = abs(intval($id));
        $spri_id = sprintf("%09d", $id);
        $dir1 = substr($spri_id, 0, 3);
        $dir2 = substr($spri_id, 3, 2);
        $dir3 = substr($spri_id, 5, 2);
        $img_path = $dir1.'/'.$dir2.'/'.$dir3;
        //$img_path = avatar($id);
        $path = './data/upload/avatar/'.$img_path.'/';
        mkdir($path);
        if('./data/upload/avatar/'.$img_path.'/' . md5($id).'_middle.jpg'){
            @unlink('./data/upload/avatar/'.$img_path.'/' . md5($id).'_middle.jpg');
        }
        if('./data/upload/avatar/'.$img_path.'/' . md5($id).'_big.jpg'){
            @unlink('./data/upload/avatar/'.$img_path.'/' . md5($id).'_big.jpg');
        }
        if('./data/upload/avatar/'.$img_path.'/' . md5($id).'_middle.jpg'){
            @unlink('./data/upload/avatar/'.$img_path.'/' . md5($id).'_big.jpg');
        }

        Image::thumb('./data/upload/user/tmp/'.$img, './data/upload/avatar/'.$img_path.'/' . md5($id).'_middle.jpg', '', 80, 80, true);
        Image::thumb('./data/upload/user/tmp/'.$img, './data/upload/avatar/'.$img_path.'/' . md5($id).'_big.jpg', '', 106, 106, true);
        Image::thumb('./data/upload/user/tmp/'.$img, './data/upload/avatar/'.$img_path.'/' . md5($id).'_small.jpg', '', 48, 48, true);
        @unlink('./data/upload/user/tmp/'.$img);
    }

    public function add_users(){
        if (IS_POST) {
            $users = $this->_post('username', 'trim');
            $users = explode(',', $users);
            $password = $this->_post('password', 'trim');
            $gender = $this->_post('gender', 'intavl');
            $data=array();
            foreach($users as $key=>$val){
                $data['password']=md5($password);
                $data['gender']=$gender;
                if($gender==3){
                    $data['gender']=rand(0,1);
                }
                $data['username']=$val;
                D('user')->add($data);
            }
            //$this->redirect('user/index');
            $this->success(L('operation_success'));
        }

        $this->display();
    }

    public function ajax_upload_img() {
        //上传图片
        if (!empty($_FILES['img']['name'])) {
            $add_time_dir = date('Y/m/d/');
            $result = $this->_upload($_FILES['img'], 'user/'. $add_time_dir );
            if ($result['error']) {
                $this->ajaxReturn(0, $result['info']);
            } else {
                $data['img'] = $add_time_dir . $result['info'][0]['savename'];
                $this->ajaxReturn(1, L('operation_success'), $data['img']);
            }
        } else {
            $this->ajaxReturn(0, L('illegal_parameters'));
        }
    }

    public function ajax_upload_imgs() {
        //上传图片
        if (!empty($_FILES['img']['name'])) {

            //$img_dir = $this->_mod->get_avatar_dirs($id);
            //$result = $this->_upload($_FILES['img'], 'user/tmp/', array('width'=>'106,80,40', 'height'=>'106,80,40', 'remove_origin'=>true, 'suffix'=>'_big,_middle,_small') );
            $result = $this->_upload($_FILES['img'], 'user/tmp/' );
            if ($result['error']) {
                $this->error($result['info']);
            }else {
                $data['img'] =  $result['info'][0]['savename'];
                $this->ajaxReturn(1, L('operation_success'), $data['img']);
            }


        } else {
            $this->ajaxReturn(0, L('illegal_parameters'));
        }
    }


    private function _get_imgdir() {
        static $dir = null;
        if ($dir === null) {
            $dir = './data/upload/user/';
        }
        return $dir;
    }

    /**
     * ajax检测会员是否存在
     */
    public function ajax_check_name() {
        $name = $this->_get('username', 'trim');
        $id = $this->_get('id', 'intval');
        if ($this->_mod->name_exists($name,  $id)) {
            $this->ajaxReturn(0, '该会员已经存在');
        } else {
            $this->ajaxReturn();
        }
    }

}