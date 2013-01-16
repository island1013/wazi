/**
 * @name 前台UI&TOOLS
 * @author andery@foxmail.com
 * @url http://www.pinphp.com
 */
;(function($){
    $.pinphp.init = function(){
        $.pinphp.ui.init();
        $.pinphp.tool.sendmail();
    }
    $.pinphp.ui = {
        init: function() {
            $.pinphp.ui.input_init();
            $.pinphp.ui.fixed_nav();
            $.pinphp.ui.return_top();
            $.pinphp.ui.drop_down();
            //$.pinphp.ui.img_lazyload();
            $.pinphp.ui.captcha();
        },
        img_lazyload: function() {
            $('img[data-original]').lazyload();
        },
        //导航浮动
        fixed_nav: function() {
            if(!$("#J_m_nav")[0]) return !1;
            $(window).bind("scroll", function() {
                var st = $(document).scrollTop();
                if (80 < st) {
                    $("#J_m_nav").addClass("nav_fixed");
                    $('#J_m_head').css('margin-bottom', '50px');
                } else {
                    $("#J_m_nav").removeClass("nav_fixed");
                    $('#J_m_head').css('margin-bottom', '10px');
                }
                //$.guang.util.isIE6() && (83 < a ? $(".m-nav").css("top", a) : $(".m-nav").css("top", "83px"))
            });
        },
        //返回顶部
        return_top: function() {
            $('#J_returntop')[0] && $('#J_returntop').returntop();
        },
        //下拉菜单
        drop_down: function() {
            var h = null,
                onshow = false;
            $('.J_down_menu_box').hover(
                function(){
                    var self = $(this);
                    if (onshow) clearTimeout(h);
                    if (!self.find('.J_down_menu').is(":animated") && !onshow) {
                        h = setTimeout(function(){
                            self.addClass('down_hover').find('.J_down_menu').slideDown(200);
                            onshow = true;
                        }, 200);
                    }
                },
                function(){
                    var self = $(this);
                    if (!onshow) clearTimeout(h);
                    h = setTimeout(function(){
                        self.removeClass('down_hover').find('.J_down_menu').slideUp(200);
                        onshow = false;
                    }, 200);
                    
                }
            );
        },
        //刷新验证码
        captcha: function() {
            $('#J_captcha_img').click(function(){
                var timenow = new Date().getTime(),
                    url = $(this).attr('data-url');
                $(this).attr("src", url+"&"+timenow)
            });
            $('#J_captcha_change').click(function(){
                $('#J_captcha_img').trigger('click');
            });
        },
        input_init: function() {
            $('input[def-val],textarea[def-val]').live('focus', function(){
                var self = $(this);
                $.trim(self.val()) == $.trim(self.attr('def-val')) && self.val("");
                self.css("color", "#484848")
            });
            $('input[def-val],textarea[def-val]').live('blur', function(){
                var self = $(this);
                $.trim(self.val()) == "" && (self.val(self.attr('def-val')), self.css("color", "#999999"));
            });
        }
    },
    $.pinphp.tool = {
        //发送邮件
        sendmail: function() {
            return PINER.async_sendmail ? ($.get('?a=send_mail'), !0) : !1;
        }
    }
    $.pinphp.init();
})(jQuery);