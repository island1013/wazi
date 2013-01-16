<?php if (!defined('THINK_PATH')) exit();?><!doctype html><html><head><meta charset="utf-8" /><title><?php echo ($page_seo["title"]); ?> - Powered by PinPHP</title><meta name="keywords" content="<?php echo ($page_seo["keyword"]); ?>" /><meta name="description" content="<?php echo ($page_seo["description"]); ?>" /><link rel="stylesheet" type="text/css" href="__STATIC__/css/default/base.css" /><link rel="stylesheet" type="text/css" href="__STATIC__/css/default/style.css" /><script src="__STATIC__/js/jquery/jquery.js"></script><link rel="stylesheet" type="text/css" href="__STATIC__/css/default/space.css" /></head><body><!--头部开始--><div class="header_wrap pt10"><div id="J_m_head" class="m_head clearfix"><div class="head_logo fl"><a href="__APP__" class="logo_b fl" title="<?php echo C('pin_site_name');?>"><?php echo C('pin_site_name');?></a></div><div class="head_user fr"><?php if(!empty($visitor)): ?><ul class="head_user_op"><li class="mr10"><a class="J_shareitem_btn share_btn" href="javascript:;" title="<?php echo L('share');?>"><?php echo L('share');?></a></li><li class="J_down_menu_box mb_info pos_r"><a href="<?php echo U('space/index', array('uid'=>$visitor['id']));?>" class="mb_name"><img class="mb_avt r3" src="<?php echo avatar($visitor['id'], 24);?>"><?php echo ($visitor["username"]); ?></a><ul class="J_down_menu s_m pos_a"><li><a href="<?php echo U('space/index');?>"><?php echo L('cover');?></a></li><li><a href="<?php echo U('user/index');?>"><?php echo L('personal_settings');?></a></li><li><a href="<?php echo U('user/bind');?>"><?php echo L('user_bind');?></a></li><li><a href="<?php echo U('user/logout');?>"><?php echo L('logout');?></a></li></ul></li><li><a class="libg feed" href="<?php echo U('space/me');?>"><?php echo L('feed');?></a></li><li><a class="libg album" href="<?php echo U('space/album');?>"><?php echo L('album');?></a></li><li><a class="libg like" href="<?php echo U('space/like');?>"><?php echo L('like');?></a></li><li class="J_down_menu_box my_shotcuts pos_r"><a class="libg msg" href="javascript:;"><?php echo L('message');?></a><ul class="J_down_menu s_m n_m pos_a"><li><a href="<?php echo U('space/atme');?>"><?php echo L('talk');?></a></li><li><a href="<?php echo U('message/index');?>"><?php echo L('my_msg');?></a></li><li><a href="<?php echo U('message/system');?>"><?php echo L('system_msg');?></a></li><li><a href="<?php echo U('space/fans');?>"><?php echo L('my_fans');?></a></li></ul></li></ul><?php else: ?><ul class="login_mod"><li class="local fl"><a href="<?php echo U('user/register');?>"><?php echo L('register');?></a><a href="<?php echo U('user/login');?>"><?php echo L('login');?></a></li><li class="other_login fl"><?php if(is_array($oauth_list)): $i = 0; $__LIST__ = $oauth_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$val): $mod = ($i % 2 );++$i;?><a href="<?php echo U('oauth/index', array('mod'=>$val['code']));?>" class="login_bg weibo_login"><img src="__STATIC__/images/oauth/<?php echo ($val["code"]); ?>/icon.png" /><?php echo ($val["name"]); ?></a><?php endforeach; endif; else: echo "" ;endif; ?></li></ul><?php endif; ?></div></div><div id="J_m_nav" class="clearfix"><ul class="nav_list fl"><li <?php if($nav_curr == 'index'): ?>class="current"<?php endif; ?>><a href="__ROOT__/"><?php echo L('index_page');?></a></li><?php $tag_nav_class = new navTag;$data = $tag_nav_class->lists(array('type'=>'lists','style'=>'main','cache'=>'0','return'=>'data',)); if(is_array($data)): $i = 0; $__LIST__ = $data;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$val): $mod = ($i % 2 );++$i;?><li class="split <?php if($nav_curr == $val['alias']): ?>current<?php endif; ?>"><a href="<?php echo ($val["link"]); ?>" <?php if($val["target"] == 1): ?>target="_blank"<?php endif; ?>><?php echo ($val["name"]); ?></a></li><?php endforeach; endif; else: echo "" ;endif; ?><li class="top_search"><form action="<?php echo U('book/search');?>" method="get" target="_blank"><input type="hidden" name="m" value="search"><input type="text" autocomplete="off" def-val="<?php echo C('pin_default_keyword');?>" value="<?php echo C('pin_default_keyword');?>" class="ts_txt fl" name="q"><input type="submit" class="ts_btn" value="搜索"></form></li></ul></div></div><div class="main_wrap"><div class="pt25"><div class="space_top mb25"><div class="space_info clearfix"><?php if($user['cover'] != '' AND ACTION_NAME == 'index'): ?><div class="space_cover" style="height:190px;background-image:url(<?php echo attach($user['cover'], 'cover');?>);"><div class="iwc_ct"><h1><?php echo ($user["username"]); ?></h1></div></div><?php else: ?><div class="left fl"><a href="<?php echo U('space/index', array('uid'=>$user['id']));?>" target="_blank"><img src="<?php echo avatar($user['id'], 100);?>" alt="" class="avatar fl r5"></a><div class="user_profile fl"><span class="uname"><?php echo ($user["username"]); ?></span><br><div class="home_follow"><?php if($visitor['id'] == $user['id']): ?><div class="see_more_info fl"><a target="_blank" href="<?php echo U('space/info');?>"><?php echo L('user_info');?></a>(<a target="_blank" href="<?php echo U('user/index');?>"><?php echo L('setting');?></a>)</div><?php else: ?><div class="J_follow_bar fl" data-uid="<?php echo ($user["id"]); ?>"><?php switch($user["ship"]): case "0": ?><a href="javascript:;" class="J_fo_u fo_u_btn"><?php echo L('follow');?></a><?php break; case "1": ?><span class="fo_u_ok"><?php echo L('followed');?></span><a href="javascript:;" class="J_unfo_u green"><?php echo L('cancel');?></a><?php break; case "2": ?><span class="fo_u_all"><?php echo L('follow_mutually');?></span><a href="javascript:;" class="J_unfo_u green"><?php echo L('cancel');?></a><?php break; endswitch;?></div><div class="see_more_info fl ml10"><a href="<?php echo U('space/info', array('uid'=>$user['id']));?>"><?php echo L('see_user_info');?></a></div><?php endif; ?></div></div></div><div class="right fr"><div class="collect_list"><a href="<?php echo U('space/follow', array('uid'=>$user['id']));?>" class="ft18"><?php echo ($user["follows"]); ?></a><br><span><?php echo L('follow');?></span></div><div class="collect_list"><a href="<?php echo U('space/fans', array('uid'=>$user['id']));?>" class="ft18"><?php echo ($user["fans"]); ?></a><br><span><?php echo L('fans');?></span></div><div class="collect_list bd_none"><a class="ft18"><?php echo ($user["likes"]); ?></a><br><span><?php echo L('belike');?></span></div></div><?php endif; ?></div><div class="space_nav"><?php if(is_array($space_nav_list)): $i = 0; $__LIST__ = $space_nav_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$nav): $mod = ($i % 2 );++$i;?><a <?php if($key == $space_nav_curr): ?>class="current"<?php endif; ?> href="<?php echo ($nav["url"]); ?>"><?php echo ($nav["text"]); ?></a><?php endforeach; endif; else: echo "" ;endif; if($visitor['id'] == $user['id']): ?><a class="cus_cover fr" href="<?php echo U('user/custom');?>"><?php echo L('custom_cover');?></a><?php endif; ?></div></div></div><div class="clearfix"><?php if($visitor['id'] == $user['id']): ?><ul class="space_tab clearfix"><li <?php if($tab_current == 'me'): ?>class="current"<?php endif; ?>><a href="<?php echo U('space/me');?>">全部</a></li><li <?php if($tab_current == 'talk'): ?>class="current"<?php endif; ?>><a href="<?php echo U('space/talk');?>">我发表的</a></li><li <?php if($tab_current == 'atme'): ?>class="current"<?php endif; ?>><a href="<?php echo U('space/atme');?>">@我的</a></li><li <?php if($tab_current == 'cmtme'): ?>class="current"<?php endif; ?>><a href="<?php echo U('space/cmtme');?>">评论我的</a></li></ul><div class="talk_tab ml20 mt10"><a class="current" href="<?php echo U('space/talk');?>">全部</a><i>|</i><a href="<?php echo U('space/talk', array('type'=>1));?>">原创</a></div><?php endif; ?><!--微博列表--><ul class="talk_l"><?php if(is_array($topic_list)): $i = 0; $__LIST__ = $topic_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$val): $mod = ($i % 2 );++$i;?><li class="J_feed talk_f" data-tid="<?php echo ($val["id"]); ?>"><div class="talk_tag fr"><a class="t" href="javascript:;" target="_blank"><?php echo (fdate($val["add_time"])); ?></a></div><div class="hd"><a target="_blank" href="<?php echo U('space/index', array('uid'=>$val['uid']));?>"><img class="J_card r5" src="<?php echo avatar($visitor['id'], '48');?>" data-uid="<?php echo ($val["uid"]); ?>"></a></div><div class="J_feed_info tk"><div class="inf"><a target="_blank" href="<?php echo U('space/index', array('uid'=>$val['uid']));?>" alt="<?php echo ($val["uname"]); ?>" class="J_card n" data-uid="<?php echo ($val["uid"]); ?>"><?php echo ($val["uname"]); ?></a></div><p class="sms"><?php echo ($val["content"]); ?></p><!--原创--><?php if($val['type'] == 0): ?><div class="J_pic pic fl" data-sid="<?php echo ($val["src_id"]); ?>" data-stype="<?php echo ($val["src_type"]); ?>"><?php if($val['src_type'] == 0): ?><div class="bigcursor r3 fl"><img src="<?php echo attach(get_thumb($val['extra'], '_m'), 'item');?>"></div><?php endif; ?></div><div class="J_src src_info r5 mt10"></div><?php else: ?><!--转播--><div class="q r5 clearfix"><p class="sms"><a href="<?php echo U('space/index', array('uid'=>$val['qt']['uid']));?>" class="J_card n" target="_blank" data-uid="<?php echo ($val["qt"]["uid"]); ?>">@<?php echo ($val["qt"]["uname"]); ?></a>：<?php echo ($val["qt"]["content"]); ?><a href="<?php echo U('item/index', array('id'=>$val['qt']['src_id']));?>" target="_blank">原文转发<?php if($val['qt']['forwards'] > 0): ?>(<?php echo ($val["qt"]["forwards"]); ?>)<?php endif; ?></a><a href="<?php echo U('item/index', array('id'=>$val['qt']['src_id']));?>" target="_blank">原文评论<?php if($val['qt']['comments'] > 0): ?>(<?php echo ($val["qt"]["comments"]); ?>)<?php endif; ?></a></p><div class="J_pic pic fl" data-sid="<?php echo ($val["qt"]["src_id"]); ?>" data-stype="<?php echo ($val["qt"]["src_type"]); ?>"><div class="bigcursor r3 fl"><img src="<?php echo attach(get_thumb($val['qt']['extra'], '_m'), 'item');?>"></div></div><div class="J_src src_info r5 mt10"></div></div><?php endif; ?><!--操作--><div class="tl"><?php if($visitor['id'] == $val['uid']): ?><a href="javascript:;" class="J_del del">删除</a><?php endif; ?><a href="javascript:;" class="J_fw fw">转发<?php if($val['forwards'] > 0): ?>(<?php echo ($val["forwards"]); ?>)<?php endif; ?></a><a href="javascript:;" class="J_cmt cmt">评论<?php if($val['comments'] > 0): ?>(<?php echo ($val["comments"]); ?>)<?php endif; ?></a></div></div></li><?php endforeach; endif; else: echo "" ;endif; ?></ul><div class="page_bar"><?php echo ($page_bar); ?></div></div></div><div class="footer_wrap rt10"><a href="__APP__" class="foot_logo"></a><div class="foot_links clearfix"><dl class="foot_nav fl"><dt>网站导航</dt><?php $tag_nav_class = new navTag;$data = $tag_nav_class->lists(array('type'=>'lists','style'=>'bottom','cache'=>'0','return'=>'data',)); if(is_array($data)): $i = 0; $__LIST__ = $data;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$val): $mod = ($i % 2 );++$i;?><dd><a href="<?php echo ($val["link"]); ?>" <?php if($val["target"] == 1): ?>target="_blank"<?php endif; ?>><?php echo ($val["name"]); ?></a></dd><?php endforeach; endif; else: echo "" ;endif; ?></dl><dl class="aboutus fl"><dt>关于我们</dt><?php $tag_article_class = new articleTag;$data = $tag_article_class->cate(array('type'=>'cate','cateid'=>'1','cache'=>'0','return'=>'data',)); if(is_array($data)): $i = 0; $__LIST__ = $data;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$val): $mod = ($i % 2 );++$i;?><dd><a href="<?php echo U('aboutus/index', array('id'=>$val['id']));?>" target="_blank"><?php echo ($val["name"]); ?></a></dd><?php endforeach; endif; else: echo "" ;endif; ?></dl><dl class="flinks fr"><dt>友情链接</dt><?php $data = S('36cd2015820ec8da2a165ad5dfc0c797');if (false === $data) { $tag_flink_class = new flinkTag;$data = $tag_flink_class->lists(array('cache'=>'3600','num'=>'5','return'=>'data','type'=>'lists',));S('36cd2015820ec8da2a165ad5dfc0c797', $data, 3600); } if(is_array($data)): $i = 0; $__LIST__ = $data;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$val): $mod = ($i % 2 );++$i;?><dd><a href="<?php echo ($val["url"]); ?>" target="_blank"><?php echo ($val["name"]); ?></a></dd><?php endforeach; endif; else: echo "" ;endif; ?><dd><a href="<?php echo U('aboutus/flink');?>" class="more" target="_blank">更多...</a></dd></dl><?php echo R('advert/index', array(8), 'Widget');?></div><p class="pt20">Powered by <a href="http://www.pinphp.com/" class="tdu clr6" target="_blank">PinPHP <?php echo (THINK_VERSION); echo (RELEASE); ?></a> &copy;Copyright 2010-2012 <a href="http://www.pinphp.com/" class="tdu clr6" target="_blank">pinphp.com</a> (<a href="http://www.miibeian.gov.cn" class="tdu clr6" target="_blank"><?php echo C('pin_site_icp');?></a>)<?php echo C('pin_statistics_code');?></p></div><div id="J_returntop" class="return_top"></div><script>var PINER = {
    uid: "<?php echo $visitor['id'];?>", 
    async_sendmail: "<?php echo $async_sendmail;?>",
    config: {
        wall_distance: "<?php echo C('pin_wall_distance');?>",
        wall_spage_max: "<?php echo C('pin_wall_spage_max');?>"
    },
    //URL
    url: {}
};
//语言项目
var lang = {};
<?php $_result=L('js_lang');if(is_array($_result)): $i = 0; $__LIST__ = $_result;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$val): $mod = ($i % 2 );++$i;?>lang.<?php echo ($key); ?> = "<?php echo ($val); ?>";<?php endforeach; endif; else: echo "" ;endif; ?></script><?php $tag_load_class = new loadTag;$data = $tag_load_class->js(array('type'=>'js','href'=>'__STATIC__/js/jquery/plugins/jquery.tools.min.js,__STATIC__/js/jquery/plugins/jquery.masonry.js,__STATIC__/js/jquery/plugins/formvalidator.js,__STATIC__/js/fileuploader.js,__STATIC__/js/pinphp.js,__STATIC__/js/front.js,__STATIC__/js/dialog.js,__STATIC__/js/wall.js,__STATIC__/js/item.js,__STATIC__/js/user.js,__STATIC__/js/album.js','cache'=>'0','return'=>'data',));?><script src="__STATIC__/js/topic.js"></script></body></html>