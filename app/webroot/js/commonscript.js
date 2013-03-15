    
var Auth =
{
    requestCount : 0 ,
    
    status : false ,
    
    queue : [] ,
    
    loginBox   : 'loginForm' ,
    
    loginUrl   : '/users/login/' ,
    
    checkUrl   : '/users/is_authenticated/',

    check : function () { // get AuthUser
        var status = false ;
        v =$.ajax({
            url            : this.checkUrl,
            async          : false,
            type           : "GET",
            dataTypeString : 'json' ,
            success : function(login) {
                status = login.status
            }
        });
        return status ;
    },

    onComplete  : function(){} ,

    onError     : function(){} ,

    onCheck     : function(){} ,

    
    exec : function ( handler ) {
        if( this.check() ) {
            handler();
        } else { // user is not logued
            this.showLogin( this._create(handler) ); // shows or create a login form with the current handler.
        }
        return false ;
    },


    _createForm : function ( handler ) {
        var currentAuth = this ;

        var form = $('<div>').attr('id', this.loginBox ).addClass('ajax login form');
        $('body').append(form);
        var url = this.loginUrl + '/f:' + handler;
        $.get( url , function (data){
            form
            .html('')
            .append($(data))
            .dialog({
                autoOpen: true,
                resize: false,
                resizable : false,
                width: 480,
                modal: true,
                buttons:false,
                close: function() {
                    currentAuth._removeHandler(handler);
                }
            });
        });

    },

    showError : function() {
        console.log('error')
    },

    showLogin : function(handlerName){
        if (  $( "#" + this.loginBox ).length == 0 ) {
            this._createForm(handlerName) ;
        } else {
            $( "#" + this.loginBox ).dialog('open');
        }
    },

    hideLogin : function(){
        $( "#" + this.loginBox ).remove();
    },

    process : function (handler) {
        handler = handler ? handler : false ;
        if ( !handler ) {
            for ( a=0 ; a<= this.requestCount ; a++ ) {
                this._exec(a);
            }
        } else {
            this._exec(handler);
        }

        this.hideLogin();
    },


    _exec : function (handler) {
        if ( typeof this['queue'][handler] == 'function' ){
            this['queue'][handler]();
            this['queue'][handler] = null ;
        }
    },


    _removeHandler : function(handler) {
        this['queue'][handler] = null ;
    },
    
    /**
    * @param cntr element | responce cntr {required}
    * @param element element | action parent element {required}
    * @param hide boolean | hide or not ajax call response after x seconds {optional}
    * @param onComplete string |  function name to call after login or if user logued  {optional}
    *
    **/
    checkOnComplete : function( cntr , element , hide , onComplete )
    {


        hide = String(hide)!='undefined' ? hide : true ;
        onComplete = String(onComplete)!='undefined' ? onComplete : false;

        element.click(function(){
            $(checkLogin.loginBox).remove();
            cntr.show();
            cntr.html(l);
            url =  $(this).children('a').attr('href') ;
            if (!uID){
                if (onComplete){
                    handlerName = checkLogin._create(onComplete);
                    url = checkLogin.loginUrl + '?f=' + handlerName ;
                } else {
                    url = checkLogin.loginUrl + '?r=' + urlEncode(url);
                }
                cntr.load(url);
            } else {
                if (onComplete){
                    onComplete();
                } else {
                    $.get( url ,function(responce){
                        cntr.html(responce);
                        if (hide){
                            setTimeout(function(){
                                cntr.hide()
                            }, 5000 );
                        }

                    });
                }
            }
            return false;
        });

    },

    handlerCheck : function ( cntr , hide , onComplete) {
        hide = String(hide)!='undefined' ? hide : true ;
        onComplete = String(onComplete)!='undefined' ? onComplete : function(){};
        $(this.loginBox).remove();
        cntr.show();
        cntr.html(l);
        if (!uID){
            handlerName = checkLogin._create(onComplete);
            url = checkLogin.loginUrl + '?f=' + handlerName ;
            cntr.load(url);
        } else {
            if (onComplete){
                onComplete();
            } else {
                $.post( url ,function(responce){
                    cntr.html(responce);
                    if (hide){
                        setTimeout(function(){
                            cntr.hide()
                        }, 5000 );
                    }

                });
            }
        }
        return false;
    },

    _showLoginError : function (error) {
        $( checkLogin.loginBox + ' .error').text(error.error).show();
    },

    _create : function( handler ) {
        this.requestCount++;
        this['queue'][this.requestCount] = handler ;
        return this.requestCount ;
    },

    _bindLogin : function(handler){
        $( checkLogin.loginBox + ' .error').text('').hide();
        $(checkLogin.loginBox).unbind().submit(function(){
            $(this).attr('action',checkLogin.loginUrl);
            v =$.ajax({
                url :  $(this).attr('action') ,
                async : false,
                data : $(this).serialize() ,
                type: "POST",
                dataTypeString : 'json' ,
                success : function(login) {
                    if( checkLogin.check() ) {
                        handler();
                        $('.login .ui-icon.site-icon').click();
                    } else {
                        checkLogin._showLoginError(login);
                    }
                }
            });
            return false ;
        });
        $( checkLogin.loginBox + ' input[type=submit]').unbind().click(function(){
            $(  checkLogin.loginBox ).trigger('submit');
            return false ;
        });
    }

};


/*
checkLogin._bindLogin(function(){
    window.location = window.location ;
});
*/




        
Array.prototype.in_array=function(){
    for(var j in this){
        if(this[j]==arguments[0]){
            return true;
        }
    }
    return false;
}

var urlChecker = function(){

    el= $(this);
    row = el.parent('.row');
    id = row.attr('id').replace(/[^\d]/g,'');
    input = $( 'div.input.url div.row#row_' + id ).children('input[type=text]');
    filled =  (el.val() != '') ;

    if( !filled && row.nextAll('.row:visible').length > 0 ) {
        row.children('.error-message').remove();
        row.hide().insertAfter(row.nextAll('.row').last());
        e = row.prevAll('.row:visible').first().children('input') ;
        if ( e ){
            e.focus();
        }

    } else if( filled && row.nextAll('.row:visible').length == 0 ) {
        row.nextAll('.row').first().show();
    }
};

$(document).ready(function(){
    
    

    $('.action.ajax.follow a , .action.ajax.unfollow a').click(function(){
        var e = $(this) ;
        Auth.exec(function(){
            $.getJSON( e.attr('href'), function(r){
                e = e.parent('div').hide();
                if ( e.hasClass('follow')){
                    $('.action.ajax.unfollow').show();
                } else {
                    $('.action.ajax.follow').show();
                }
            });
        });
        return false ;
    });
    
    $('div.input.url div.row').css({
        'display':'none'
    }).first().css({
        'display':''
    });
    $('div.input.url .row input[type=text]').bind('blur focus keyup keydown',urlChecker).blur();

    $('textarea.simple-editor').tinymce({
        script_url : '/js/tinymce/tiny_mce.js',
        theme : "advanced",
        theme_advanced_buttons1 : "bold,italic,underline,strikethrough,blockquote,pagebreak,pagebreak,|,bullist,numlist,|,link,unlink,anchor,image,|,forecolor,backcolor",
        theme_advanced_buttons2 : false,
        theme_advanced_buttons3 : false,
        theme_advanced_toolbar_location : "bottom",
        theme_advanced_toolbar_align : "center",
        theme_advanced_statusbar_location : "bottom",
        theme_advanced_resizing : false ,
        content_css : "/css/user.input.css"
    });

    $('textarea.custom-html').tinymce({
        script_url : '/js/tinymce/tiny_mce.js',
        // General options
        theme : "advanced",
        plugins : "autolink,lists,media",
        // Theme options
        theme_advanced_background_colors : "111111,666666,999999,CCCCCC,EAEAEA,FFFFFF,4B9A38,7DB773,CDEAC6,E6F4E2,338ABD,70AECF,B8D7E7,D5E7F0,D55500,FF6600,D5E7F0,D5E7F0,FFCC00" ,
        theme_advanced_text_colors : "111111,666666,999999,CCCCCC,EAEAEA,FFFFFF,4B9A38,7DB773,CDEAC6,E6F4E2,338ABD,70AECF,B8D7E7,D5E7F0,D55500,FF6600,D5E7F0,D5E7F0,FFCC00" ,
        theme_advanced_more_colors : false ,
        theme_advanced_resizing_max_width : 600 ,
        theme_advanced_resizing_max_height : 480 ,


        theme_advanced_buttons1 : "formatselect,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,|,forecolor,backcolor,|,bullist,numlist,|,outdent,indent,blockquote,|,link,unlink,anchor,image,media,code",
        theme_advanced_buttons2 : false,
        theme_advanced_buttons3 : false,
        theme_advanced_buttons4 : false ,
        theme_advanced_toolbar_location : "top",
        theme_advanced_toolbar_align : "center",
        theme_advanced_statusbar_location : false,
        theme_advanced_resizing : false,

        theme_advanced_blockformats : "h3,h4,p,blockquote,code" ,

        //  theme_advanced_format : "Header=subtitle;Header 2=secondary-subtitle",
        // Skin options
        skin : "o2k7",
        skin_variant : "silver",
        // Example content CSS (should be your site CSS)
        content_css : "css/example.css"
    });
});

(function($){
    $.fn.range = function(settings){
        var defaultSettings = {
            text : {
                plural   : langTexts.range.text.plural ,
                singular : langTexts.range.text.singular,
                value : '::value::'
            },
            defaultText		: '',
            range:  'min',
            min: 0 ,
            max: 90 ,
            animate: true
        }
        /* Combining the default settings object with the supplied one */
        settings = $.extend(defaultSettings,settings);
        return this.each(function(k,el){
            var elem = $(this)
            .css({
                display : 'none'
            });
            
            elem.parent('div.input').attr('class' , 'input range');

            c = $('<div class="range-cntr">').insertAfter(elem).width( elem.outerWidth() - 16 ).css({
                'margin' : '8px' 

            });
            var d =  $('<div>') ;
            c.append(d);
            var label = elem.prev('label');
            if ( label.length <= 0 ) {
                label = $('<span>').insertBefore(elem).text(settings.defaultText);
            }


            d.slider({
                range:  settings.range,
                min: settings.min ,
                value : elem.val() ,
                max: settings.max ,
                animate: settings.animate ,

                slide: function( event, ui ) {
                    elem.val( ui.value );
                    LabelText = String(  ui.value == 1 ? settings.text.singular : settings.text.plural ).replace('::value::',  ui.value);
                    label.text( label.attr('title').replace('::value::' , LabelText));
                }
            });

            elem.val( d.slider( "value" ) );
            label.attr('title' , label.text() + settings.text.value );
            
            
            //
            
            LabelText = String( d.slider( "value" ) == 1 ? settings.text.singular : settings.text.plural ).replace('::value::', d.slider( "value" ));
            label.text( label.attr('title').replace('::value::' , LabelText));
            
        });

    }
})(jQuery);


(function($){
    $.fn.loader = function(url , data , complete , settings){
        var defaultSettings = {
            loader		: $('<div class="loader"><img src="/img/assets/loader.gif" alt="Loading..."/></div>')
        }
        settings = $.extend(defaultSettings,settings);
        return this.each(function(k,el){
            $(el).html(settings.loader).load(url,data,complete);
        });
    }
})(jQuery);
        
    /* Adding a colortip to any tag with a title attribute: */
    /*
$(document).ready(function(){
	$('.tip[title]').colorTip({color:'yellow'});

    $('a.process').live('click',function(event){
        var e = $(this);

        cont=true ;

        if ( e.hasClass('ajax') ) {

            h = function(){
               $.get(e.attr('href'),function(r){

                    if ( e.attr('parent') != '' && String(e.attr('parent')) != 'undefined' ) {
                        p = $('#'+e.attr('parent')) ;
                    } else {
                        p = e.parent(':first');
                    }

                    if ( e.hasClass('delete') ) {
                        p.remove();
                    }


                    if ( e.hasClass('reload') ) {
                        window.location =  window.location ;
                    }

                    if ( e.hasClass('update') ) {
                        p.html(r);
                    }


                    if ( e.hasClass('insert') ) {
                        d = $('<div>');
                        d.html(r);
                        if ( e.hasClass('before') ) {
                            d.insertBefore(e);
                        } else {
                            d.insertAfter(e);
                        }
                    }

                });

                return false;
            }


        } else {
            h = function(){  window.location = e.attr('href'); return false; }
        }

       if ( e.hasClass('confirm') ) {
            if ( e.attr('rel') != '' ) {
                t = e.attr('rel').split('|');
                d = t[1];
                t = t[0];
            } else {
                t =  langTexts.confirm.title;
                d =  langTexts.confirm.body;
            }

            confirm(t,d,h);

            //return cont ;


        } else {
            h();
        }

        if ( e.hasClass('delete') && !e.hasClass('confirm') ) {
            $('#'+e.attr('parent')).remove();
        }


        return false;
    });

});



     */
















