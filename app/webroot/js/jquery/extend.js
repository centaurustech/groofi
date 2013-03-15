$.fn.reverse = [].reverse;
//$('#some_selector').parents('li').reverse();

(function($){
        $.fn.extend({
        ModelUrl: function(options) {
            var defaults = {
                selector: 'input',
                ClonesCount: 1,
                maxClones: 5 ,
                minClones: 1 ,
                aux : 1
            }

            var options = $.extend(defaults, options);
            return this.each(function() {
                var o = options;
                var obj = $(this);
                addBtn = obj.find('.btn.add');
                addBtn.bind('click',function(){
                    if(o.ClonesCount<o.maxClones){
                        e = $(this);


                        cloned = e.prevUntil('div.btn.remove').filter(o.selector).clone();
                        cloned = cloned.reverse();


                        //var clonedCopy = cloned ;
                        cloned.each(function(k,e){
                            e=$(e);
                            n =String(e.attr('name')).replace(/\[\d+\]/,"["+ o.aux +"]");
                            e.attr('name',n);
                        });



                        cloned.val('').insertBefore(e);

                        r = $('<div>').addClass('btn').addClass('remove').insertBefore(cloned.eq(0));
                        r.bind('click',function(){
                            if(o.ClonesCount>o.minClones){
                                e = $(this);
                                e.prevUntil('div.btn.remove').filter(o.selector).remove();
                                e.remove();
                                o.ClonesCount-- ;
                            }
                        });
                        o.ClonesCount++;
                        o.aux++;
                    }
                });

                $('div.btn.remove').bind('click',function(){
                    if(o.ClonesCount > o.minClones){
                        e = $(this);
                        e.prevUntil('div.btn.remove').filter(o.selector).remove();
                        e.remove();
                        o.ClonesCount-- ;
                    }
                });

            });
        }
    });
})(jQuery);



window.confirm = function (title, text , okTriger , cancelTriger ,okText,cancelText) {
    okTriger = okTriger ? okTriger : function(){return true ;};
    cancelTriger = cancelTriger ? cancelTriger : function(){return false;};
    okText = okText ? okText : langTexts.confirm.ok ;
    cancelText = cancelText ? cancelText : langTexts.confirm.cancel ;
    text = text ? text : false ;
    if (!text){
        text  = title ;
        title = langTexts.confirm.title ;
    }


    $("#dialog").dialog("destroy");
    msg = $('<div>').attr('title',title);
    icon = $('<span>').addClass('ui-icon ui-icon-alert').css('float','left').css('margin','0 7px 20px 0;').text(' ');
    txt =$('<p>').html(icon).append(text);
    msg.html(txt);

    var dialogOptions = {} ;
    dialogOptions.resizable  = false ;
    dialogOptions.minHeight     = '50' ;
    dialogOptions.modal      = true ;
    dialogOptions.position      = 'top'  ;
    dialogOptions.buttons    = {} ;
    dialogOptions.buttons[okText] = function() {
                                        $(this).dialog('close');
                                        okTriger();
                                        return true ;
                                    };
    dialogOptions.buttons[cancelText] = function() {
                                        $(this).dialog('close');
                                        cancelTriger();
                                        return false ;
                                    };
    $(msg).dialog(dialogOptions);

}

 window.alert = function(title, text , okTriger , okText) {
    okTriger = okTriger ? okTriger : function(){};
    okText = okText ? okText : langTexts.alert.ok;
    text = text ? text : false ;
    if (!text){
        text  = title ;
        title = langTexts.alert.title;
    }

    $("#dialog").dialog("destroy");
    msg = $('<div>').attr('title',title);
    icon = $('<span>').addClass('ui-icon ui-icon-alert').css('float','left').css('margin','0 7px 20px 0;').text(' ');
    txt =$('<p>').html(icon).append(text);
    msg.html(txt);

    var dialogOptions = {} ;
    dialogOptions.resizable  = false ;
    dialogOptions.minHeight     = '50' ;
    dialogOptions.modal      = true ;
    dialogOptions.buttons    = {} ;
    dialogOptions.buttons[okText] = function() {
                                        $(this).dialog('close');
                                        okTriger();
                                        return true ;
                                    };
    $(msg).dialog(dialogOptions);
}

/*
(function($){
    $.fn.equalizeHeights = function(){
        return this.height( Math.max.apply(this, $(this).map(function(i,e){return $(e).height()}).get() ) )
    }
    $.fn.equalizeWidths = function(){
        return this.width( Math.max.apply(this, $(this).map(function(i,e){return $(e).width()}).get() ) )
    }
    $.fn.extend({
        filterMenu: function(options) {
            var defaults = {
                maxHeight: 8 ,
                width : false ,
                height: 30
            }

            var options = $.extend(defaults, options);

            return this.each(function() {
                var obj = $(this);
                var o = options;
                obj.css('z-index',99);

                var menuCtnr = obj.children('ul') ;

                var menuTitle = obj.children('p') ;

                menuCtnr.width(9999).addClass('menuCtnr');

                menuCtnr.children('li').children().addClass('option').hover(function(){
                    $(this).addClass( 'hover' );
                },function(){
                    $(this).removeClass( 'hover' );
                });

                menuTitle.hover(function(){
                   $(this).addClass('ui-state-active').css('border','0px none').css('color','#999999');
                },function(){
                     mV  = menuCtnr.css('display') == 'none' ? false : true ;
                     if (!mV){
                        $(this).removeClass('ui-state-active');
                     }
                });

                liH = menuCtnr.children('li').children().outerHeight() ;
                o.maxHeight = liH * o.maxHeight ; // OK


                aHeight = liH * menuCtnr.children('li').length ;
               // console.log(aHeight);

                menuCtnr.children('li').children().css({'float':'left'});


                aWidth = Math.max.apply( menuCtnr.children('li').children() ,  menuCtnr.children('li').children().map(function(i,e){return $(e).outerWidth()}).get() );
                o.maxHeight = aHeight > o.maxHeight ? o.maxHeight : aHeight ;
                overFlow = aHeight > o.maxHeight ? 'auto' : 'hidden' ;
                menuCtnr.children('li').children().css({'float':'none','display':'block'});
                menuCtnr.css({'width':'auto'});
                obj.css({
                    'position' : 'relative' ,
                    'height' : o.height
                })

               if (!o.width){
                    o.width = menuTitle.outerWidth();
                }

                Ulwidth = aWidth <= o.width ? o.width : aWidth + 30 ;

                if (Ulwidth > o.width ) {
                    left = 0 //o.width - Ulwidth ;
                } else {
                    left = 0
                }

              $('body').click(function(event) {
                    if (!$(event.target).closest(menuCtnr).length) {
                        $(menuCtnr).hide();
                    }
                    if (!$(event.target).closest(menuTitle).length) {
                        $(menuTitle).removeClass('ui-state-active');
                    }

                });

                l =  menuTitle.children('b');
                menuTitle.children('b').remove();

                t = menuTitle.css({
                    'position' : 'absolute' ,
                    'height' : o.height ,
                    'width' : o.width  ,
                    'cursor' : 'pointer' ,
                    'background' : '#e5e5e5' ,
                    'z-index' : 40 ,
                    'top' : 0 ,
                    'left' : 0
                }).click(function(event){ //.addClass('ui-state-default')

                    mV  = menuCtnr.css('display') == 'none' ? false : true ;
                    $('body').click();
                    if (mV){
                        menuCtnr.hide();
                        $(this).removeClass('ui-state-active');
                    } else {
                        menuCtnr.show();
                        $(this).addClass('ui-state-active').css('border','0px none').css('color','#999999');
                    }

                    return false ;

                }).text(); //.width();
                l.css({'padding':'10px 3px 10px 10px','display':'inline-block','color':'#333333','float':'left'});
                titleTxt = $('<span>').addClass('dropText').text(t).css({'padding':'10px 5px 10px 3px','display':'inline-block','float':'left'});
                icon = $('<span>').addClass('ui-icon ui-icon-triangle-1-s').text('').css({'margin':'8px 10px 10px 0px','display':'inline-block','float':'right'});

                menuTitle.html('');

                menuTitle.append(l);
                menuTitle.append(titleTxt);
                menuTitle.append(icon);

                menuCtnr.css({
                    'height' : o.maxHeight ,
                    'z-index' : 999 ,
                    //'background' : '#ff0000' ,
                    'position' : 'absolute' ,
                    'top' : menuTitle.height() ,
                    'left' : left ,
                    'width' : Ulwidth  ,
                    'overflow' : overFlow,
                    'display' : 'none'
                }).children('li').css(
                    {
                        'float' : 'none' ,
                        'clear' : 'both'
                    }
                );

            });
        }
    });
})(jQuery);


*/

//this.width( Math.max.apply(this, $(this).map(function(i,e){ return $(e).width() }).get() ) )



                /*
                addBtn = obj.find('.btn.add');
                addBtn.bind('click',function(){
                    if(o.ClonesCount<o.maxClones){
                        e = $(this);
                        cloned = Array.reverse(e.prevUntil('div.btn.remove').filter(o.selector).clone());
                        cloned.each(function(k,e){
                            e=$(e);
                            n =String(e.attr('name')).replace(/\[\d+\]/,"["+ o.aux +"]");
                            e.attr('name',n);
                        });
                        cloned.val('').insertBefore(e);
                        r = $('<div>').addClass('btn').addClass('remove').insertBefore(cloned.eq(0));
                        r.bind('click',function(){
                            if(o.ClonesCount>o.minClones){
                                e = $(this);
                                e.prevUntil('div.btn.remove').filter(o.selector).remove();
                                e.remove();
                                o.ClonesCount-- ;
                            }
                        });
                        o.ClonesCount++;
                        o.aux++;
                    }
                });

                $('div.btn.remove').bind('click',function(){
                    if(o.ClonesCount > o.minClones){
                        e = $(this);
                        e.prevUntil('div.btn.remove').filter(o.selector).remove();
                        e.remove();
                        o.ClonesCount-- ;
                    }
                });
                */




urlEncodeCharacter=function(c){
    return '%' + c.charCodeAt(0).toString(16);
}

urlDecodeCharacter=function(str, c){
    return String.fromCharCode(parseInt(c, 16));
}

urlEncode=function(s){
    return encodeURIComponent( s ).replace( /\%20/g, '+' ).replace( /[!'()*~]/g, urlEncodeCharacter );
}

urlDecode=function(s){
    return decodeURIComponent(s.replace( /\+/g, '%20' )).replace( /\%([0-9a-f]{2})/g, urlDecodeCharacter);
}

function echo () {
    // !No description available for echo. @php.js developers: Please update the function summary text file.
    //
    // version: 1008.1718
    // discuss at: http://phpjs.org/functions/echo
    // +   original by: Philip Peterson
    // +   improved by: echo is bad
    // +   improved by: Nate
    // +    revised by: Der Simon (http://innerdom.sourceforge.net/)
    // +   improved by: Brett Zamir (http://brett-zamir.me)
    // +   bugfixed by: Eugene Bulkin (http://doubleaw.com/)
    // +   input by: JB
    // +   improved by: Brett Zamir (http://brett-zamir.me)
    // +   bugfixed by: Brett Zamir (http://brett-zamir.me)
    // +   bugfixed by: Brett Zamir (http://brett-zamir.me)
    // %        note 1: If browsers start to support DOM Level 3 Load and Save (parsing/serializing),
    // %        note 1: we wouldn't need any such long code (even most of the code below). See
    // %        note 1: link below for a cross-browser implementation in JavaScript. HTML5 might
    // %        note 1: possibly support DOMParser, but that is not presently a standard.
    // %        note 2: Although innerHTML is widely used and may become standard as of HTML5, it is also not ideal for
    // %        note 2: use with a temporary holder before appending to the DOM (as is our last resort below),
    // %        note 2: since it may not work in an XML context
    // %        note 3: Using innerHTML to directly add to the BODY is very dangerous because it will
    // %        note 3: break all pre-existing references to HTMLElements.
    // *     example 1: echo('<div><p>abc</p><p>abc</p></div>');
    // *     returns 1: undefined
    var arg = '', argc = arguments.length, argv = arguments, i = 0;
    var win = this.window;
    var d = win.document;
    var ns_xhtml = 'http://www.w3.org/1999/xhtml';
    var ns_xul = 'http://www.mozilla.org/keymaster/gatekeeper/there.is.only.xul'; // If we're in a XUL context

    var holder;

    var stringToDOM = function (str, parent, ns, container) {
        var extraNSs = '';
        if (ns === ns_xul) {
            extraNSs = ' xmlns:html="'+ns_xhtml+'"';
        }
        var stringContainer = '<'+container+' xmlns="'+ns+'"'+extraNSs+'>'+str+'</'+container+'>';
        if (win.DOMImplementationLS &&
            win.DOMImplementationLS.createLSInput &&
            win.DOMImplementationLS.createLSParser) { // Follows the DOM 3 Load and Save standard, but not
            // implemented in browsers at present; HTML5 is to standardize on innerHTML, but not for XML (though
            // possibly will also standardize with DOMParser); in the meantime, to ensure fullest browser support, could
            // attach http://svn2.assembla.com/svn/brettz9/DOMToString/DOM3.js (see http://svn2.assembla.com/svn/brettz9/DOMToString/DOM3.xhtml for a simple test file)
            var lsInput = DOMImplementationLS.createLSInput();
            // If we're in XHTML, we'll try to allow the XHTML namespace to be available by default
            lsInput.stringData = stringContainer;
            var lsParser = DOMImplementationLS.createLSParser(1, null); // synchronous, no schema type
            return lsParser.parse(lsInput).firstChild;
        }
        else if (win.DOMParser) {
            // If we're in XHTML, we'll try to allow the XHTML namespace to be available by default
            try {
                var fc = new DOMParser().parseFromString(stringContainer, 'text/xml');
                if (!fc || !fc.documentElement ||
                        fc.documentElement.localName !== 'parsererror' ||
                        fc.documentElement.namespaceURI !== 'http://www.mozilla.org/newlayout/xml/parsererror.xml') {
                    return fc.documentElement.firstChild;
                }
                // If there's a parsing error, we just continue on
            }
            catch(e) {
                // If there's a parsing error, we just continue on
            }
        }
        else if (win.ActiveXObject) { // We don't bother with a holder in Explorer as it doesn't support namespaces
            var axo = new ActiveXObject('MSXML2.DOMDocument');
            axo.loadXML(str);
            return axo.documentElement;
        }
        /*else if (win.XMLHttpRequest) { // Supposed to work in older Safari
            var req = new win.XMLHttpRequest;
            req.open('GET', 'data:application/xml;charset=utf-8,'+encodeURIComponent(str), false);
            if (req.overrideMimeType) {
                req.overrideMimeType('application/xml');
            }
            req.send(null);
            return req.responseXML;
        }*/
        // Document fragment did not work with innerHTML, so we create a temporary element holder
        // If we're in XHTML, we'll try to allow the XHTML namespace to be available by default
        //if (d.createElementNS && (d.contentType && d.contentType !== 'text/html')) { // Don't create namespaced elements if we're being served as HTML (currently only Mozilla supports this detection in true XHTML-supporting browsers, but Safari and Opera should work with the above DOMParser anyways, and IE doesn't support createElementNS anyways)
        if (d.createElementNS &&  // Browser supports the method
            (d.documentElement.namespaceURI || // We can use if the document is using a namespace
            d.documentElement.nodeName.toLowerCase() !== 'html' || // We know it's not HTML4 or less, if the tag is not HTML (even if the root namespace is null)
            (d.contentType && d.contentType !== 'text/html') // We know it's not regular HTML4 or less if this is Mozilla (only browser supporting the attribute) and the content type is something other than text/html; other HTML5 roots (like svg) still have a namespace
        )) { // Don't create namespaced elements if we're being served as HTML (currently only Mozilla supports this detection in true XHTML-supporting browsers, but Safari and Opera should work with the above DOMParser anyways, and IE doesn't support createElementNS anyways); last test is for the sake of being in a pure XML document
            holder = d.createElementNS(ns, container);
        }
        else {
            holder = d.createElement(container); // Document fragment did not work with innerHTML
        }
        holder.innerHTML = str;
        while (holder.firstChild) {
            parent.appendChild(holder.firstChild);
        }
        return false;
        // throw 'Your browser does not support DOM parsing as required by echo()';
    };


    var ieFix = function (node) {
        if (node.nodeType === 1) {
            var newNode = d.createElement(node.nodeName);
            var i, len;
            if (node.attributes && node.attributes.length > 0) {
                for (i = 0, len = node.attributes.length; i < len; i++) {
                    newNode.setAttribute(node.attributes[i].nodeName, node.getAttribute(node.attributes[i].nodeName));
                }
            }
            if (node.childNodes && node.childNodes.length > 0) {
                for (i = 0, len = node.childNodes.length; i < len; i++) {
                    newNode.appendChild(ieFix(node.childNodes[i]));
                }
            }
            return newNode;
        }
        else {
            return d.createTextNode(node.nodeValue);
        }
    };

    for (i = 0; i < argc; i++ ) {
        arg = argv[i];
        if (this.php_js && this.php_js.ini && this.php_js.ini['phpjs.echo_embedded_vars']) {
            arg = arg.replace(/(.?)\{\$(.*?)\}/g, function (s, m1, m2) {
                // We assume for now that embedded variables do not have dollar sign; to add a dollar sign, you currently must use {$$var} (We might change this, however.)
                // Doesn't cover all cases yet: see http://php.net/manual/en/language.types.string.php#language.types.string.syntax.double
                if (m1 !== '\\') {
                    return m1+eval(m2);
                }
                else {
                    return s;
                }
            });
        }
        if (d.appendChild) {
            if (d.body) {
                if (win.navigator.appName == 'Microsoft Internet Explorer') { // We unfortunately cannot use feature detection, since this is an IE bug with cloneNode nodes being appended
                    d.body.appendChild(stringToDOM(ieFix(arg)));
                }
                else {
                    var unappendedLeft = stringToDOM(arg, d.body, ns_xhtml, 'div').cloneNode(true); // We will not actually append the div tag (just using for providing XHTML namespace by default)
                    if (unappendedLeft) {
                        d.body.appendChild(unappendedLeft);
                    }
                }
            } else {
                d.documentElement.appendChild(stringToDOM(arg, d.documentElement, ns_xul, 'description')); // We will not actually append the description tag (just using for providing XUL namespace by default)
            }
        } else if (d.write) {
            d.write(arg);
        }/* else { // This could recurse if we ever add print!
            print(arg);
        }*/
    }
}

function print_r (array, return_val) {
    // Prints out or returns information about the specified variable
    //
    // version: 1008.1718
    // discuss at: http://phpjs.org/functions/print_r
    // +   original by: Michael White (http://getsprink.com)
    // +   improved by: Ben Bryan
    // +      input by: Brett Zamir (http://brett-zamir.me)
    // +      improved by: Brett Zamir (http://brett-zamir.me)
    // +   improved by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
    // -    depends on: echo
    // *     example 1: print_r(1, true);
    // *     returns 1: 1

    var output = "", pad_char = " ", pad_val = 4, d = this.window.document;
    var getFuncName = function (fn) {
        var name = (/\W*function\s+([\w\$]+)\s*\(/).exec(fn);
        if (!name) {
            return '(Anonymous)';
        }
        return name[1];
    };

    var repeat_char = function (len, pad_char) {
        var str = "";
        for (var i=0; i < len; i++) {
            str += pad_char;
        }
        return str;
    };

    var formatArray = function (obj, cur_depth, pad_val, pad_char) {
        if (cur_depth > 0) {
            cur_depth++;
        }

        var base_pad = repeat_char(pad_val*cur_depth, pad_char);
        var thick_pad = repeat_char(pad_val*(cur_depth+1), pad_char);
        var str = "";

        if (typeof obj === 'object' && obj !== null && obj.constructor && getFuncName(obj.constructor) !== 'PHPJS_Resource') {
            str += "Array\n" + base_pad + "(\n";
            for (var key in obj) {
                if (obj[key] instanceof Array) {
                    str += thick_pad + "["+key+"] => "+formatArray(obj[key], cur_depth+1, pad_val, pad_char);
                } else {
                    str += thick_pad + "["+key+"] => " + obj[key] + "\n";
                }
            }
            str += base_pad + ")\n";
        } else if (obj === null || obj === undefined) {
            str = '';
        } else { // for our "resource" class
            str = obj.toString();
        }

        return str;
    };

    output = formatArray(array, 0, pad_val, pad_char);

    if (return_val !== true) {
        if (d.body) {
            this.echo(output);
        }
        else {
            try {
                d = XULDocument; // We're in XUL, so appending as plain text won't work; trigger an error out of XUL
                this.echo('<pre xmlns="http://www.w3.org/1999/xhtml" style="white-space:pre;">'+output+'</pre>');
            }
            catch (e) {
                this.echo(output); // Outputting as plain text may work in some plain XML
            }
        }
        return true;
    } else {
        return output;
    }
}

function serialize (mixed_value) {
    // Returns a string representation of variable (which can later be unserialized)
    //
    // version: 1009.820
    // discuss at: http://phpjs.org/functions/serialize
    // +   original by: Arpad Ray (mailto:arpad@php.net)
    // +   improved by: Dino
    // +   bugfixed by: Andrej Pavlovic
    // +   bugfixed by: Garagoth
    // +      input by: DtTvB (http://dt.in.th/2008-09-16.string-length-in-bytes.html)
    // +   bugfixed by: Russell Walker (http://www.nbill.co.uk/)
    // +   bugfixed by: Jamie Beck (http://www.terabit.ca/)
    // +      input by: Martin (http://www.erlenwiese.de/)
    // +   bugfixed by: Kevin van Zonneveld (http://kevin.vanzonneveld.net/)
    // +   improved by: Le Torbi (http://www.letorbi.de/)
    // +   improved by: Kevin van Zonneveld (http://kevin.vanzonneveld.net/)
    // -    depends on: utf8_encode
    // %          note: We feel the main purpose of this function should be to ease the transport of data between php & js
    // %          note: Aiming for PHP-compatibility, we have to translate objects to arrays
    // *     example 1: serialize(['Kevin', 'van', 'Zonneveld']);
    // *     returns 1: 'a:3:{i:0;s:5:"Kevin";i:1;s:3:"van";i:2;s:9:"Zonneveld";}'
    // *     example 2: serialize({firstName: 'Kevin', midName: 'van', surName: 'Zonneveld'});
    // *     returns 2: 'a:3:{s:9:"firstName";s:5:"Kevin";s:7:"midName";s:3:"van";s:7:"surName";s:9:"Zonneveld";}'
	var _utf8Size = function (str) {
	    var size = 0, i = 0, l = str.length, code = '';
	    for (i = 0; i < l; i++) {
	        code = str[i].charCodeAt(0);
	        if (code < 0x0080) {
	            size += 1;
	        } else if (code < 0x0800) {
	            size += 2;
	        } else {
	        	size += 3;
			}
	    }
	    return size;
	};
    var _getType = function (inp) {
        var type = typeof inp, match;
        var key;

        if (type === 'object' && !inp) {
            return 'null';
        }
        if (type === "object") {
            if (!inp.constructor) {
                return 'object';
            }
            var cons = inp.constructor.toString();
            match = cons.match(/(\w+)\(/);
            if (match) {
                cons = match[1].toLowerCase();
            }
            var types = ["boolean", "number", "string", "array"];
            for (key in types) {
                if (cons == types[key]) {
                    type = types[key];
                    break;
                }
            }
        }
        return type;
    };
    var type = _getType(mixed_value);
    var val, ktype = '';

    switch (type) {
        case "function":
            val = "";
            break;
        case "boolean":
            val = "b:" + (mixed_value ? "1" : "0");
            break;
        case "number":
            val = (Math.round(mixed_value) == mixed_value ? "i" : "d") + ":" + mixed_value;
            break;
        case "string":
			val = "s:" + _utf8Size(mixed_value) + ":\"" + mixed_value + "\"";
            break;
        case "array":
        case "object":
            val = "a";
            /*
            if (type == "object") {
                var objname = mixed_value.constructor.toString().match(/(\w+)\(\)/);
                if (objname == undefined) {
                    return;
                }
                objname[1] = this.serialize(objname[1]);
                val = "O" + objname[1].substring(1, objname[1].length - 1);
            }
            */
            var count = 0;
            var vals = "";
            var okey;
            var key;
            for (key in mixed_value) {
			    if (mixed_value.hasOwnProperty(key)) {
               	   ktype = _getType(mixed_value[key]);
	               if (ktype === "function") {
	                   continue;
	               }

	               okey = (key.match(/^[0-9]+$/) ? parseInt(key, 10) : key);
	               vals += this.serialize(okey) +
	                       this.serialize(mixed_value[key]);
	               count++;
		        }
            }
            val += ":" + count + ":{" + vals + "}";
            break;
        case "undefined": // Fall-through
        default: // if the JS object has a property which contains a null value, the string cannot be unserialized by PHP
            val = "N";
            break;
    }
    if (type !== "object" && type !== "array") {
        val += ";";
    }
    return val;
}

function unserialize (data) {
    // Takes a string representation of variable and recreates it
    //
    // version: 1008.1718
    // discuss at: http://phpjs.org/functions/unserialize
    // +     original by: Arpad Ray (mailto:arpad@php.net)
    // +     improved by: Pedro Tainha (http://www.pedrotainha.com)
    // +     bugfixed by: dptr1988
    // +      revised by: d3x
    // +     improved by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
    // +        input by: Brett Zamir (http://brett-zamir.me)
    // +     improved by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
    // +     improved by: Chris
    // +     improved by: James
    // +        input by: Martin (http://www.erlenwiese.de/)
    // +     bugfixed by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
    // +     improved by: Le Torbi
    // +     input by: kilops
    // +     bugfixed by: Brett Zamir (http://brett-zamir.me)
    // -      depends on: utf8_decode
    // %            note: We feel the main purpose of this function should be to ease the transport of data between php & js
    // %            note: Aiming for PHP-compatibility, we have to translate objects to arrays
    // *       example 1: unserialize('a:3:{i:0;s:5:"Kevin";i:1;s:3:"van";i:2;s:9:"Zonneveld";}');
    // *       returns 1: ['Kevin', 'van', 'Zonneveld']
    // *       example 2: unserialize('a:3:{s:9:"firstName";s:5:"Kevin";s:7:"midName";s:3:"van";s:7:"surName";s:9:"Zonneveld";}');
    // *       returns 2: {firstName: 'Kevin', midName: 'van', surName: 'Zonneveld'}
    var that = this;
    var utf8Overhead = function(chr) {
        // http://phpjs.org/functions/unserialize:571#comment_95906
        var code = chr.charCodeAt(0);
        if (code < 0x0080) {
            return 0;
        }
        if (code < 0x0800) {
             return 1;
        }
        return 2;
    };


    var error = function (type, msg, filename, line){throw new that.window[type](msg, filename, line);};
    var read_until = function (data, offset, stopchr){
        var buf = [];
        var chr = data.slice(offset, offset + 1);
        var i = 2;
        while (chr != stopchr) {
            if ((i+offset) > data.length) {
                error('Error', 'Invalid');
            }
            buf.push(chr);
            chr = data.slice(offset + (i - 1),offset + i);
            i += 1;
        }
        return [buf.length, buf.join('')];
    };
    var read_chrs = function (data, offset, length){
        var buf;

        buf = [];
        for (var i = 0;i < length;i++){
            var chr = data.slice(offset + (i - 1),offset + i);
            buf.push(chr);
            length -= utf8Overhead(chr);
        }
        return [buf.length, buf.join('')];
    };
    var _unserialize = function (data, offset){
        var readdata;
        var readData;
        var chrs = 0;
        var ccount;
        var stringlength;
        var keyandchrs;
        var keys;

        if (!offset) {offset = 0;}
        var dtype = (data.slice(offset, offset + 1)).toLowerCase();

        var dataoffset = offset + 2;
        var typeconvert = function(x) {return x;};

        switch (dtype){
            case 'i':
                typeconvert = function (x) {return parseInt(x, 10);};
                readData = read_until(data, dataoffset, ';');
                chrs = readData[0];
                readdata = readData[1];
                dataoffset += chrs + 1;
            break;
            case 'b':
                typeconvert = function (x) {return parseInt(x, 10) !== 0;};
                readData = read_until(data, dataoffset, ';');
                chrs = readData[0];
                readdata = readData[1];
                dataoffset += chrs + 1;
            break;
            case 'd':
                typeconvert = function (x) {return parseFloat(x);};
                readData = read_until(data, dataoffset, ';');
                chrs = readData[0];
                readdata = readData[1];
                dataoffset += chrs + 1;
            break;
            case 'n':
                readdata = null;
            break;
            case 's':
                ccount = read_until(data, dataoffset, ':');
                chrs = ccount[0];
                stringlength = ccount[1];
                dataoffset += chrs + 2;

                readData = read_chrs(data, dataoffset+1, parseInt(stringlength, 10));
                chrs = readData[0];
                readdata = readData[1];
                dataoffset += chrs + 2;
                if (chrs != parseInt(stringlength, 10) && chrs != readdata.length){
                    error('SyntaxError', 'String length mismatch');
                }

                // Length was calculated on an utf-8 encoded string
                // so wait with decoding
                readdata = that.utf8_decode(readdata);
            break;
            case 'a':
                readdata = {};

                keyandchrs = read_until(data, dataoffset, ':');
                chrs = keyandchrs[0];
                keys = keyandchrs[1];
                dataoffset += chrs + 2;

                for (var i = 0; i < parseInt(keys, 10); i++){
                    var kprops = _unserialize(data, dataoffset);
                    var kchrs = kprops[1];
                    var key = kprops[2];
                    dataoffset += kchrs;

                    var vprops = _unserialize(data, dataoffset);
                    var vchrs = vprops[1];
                    var value = vprops[2];
                    dataoffset += vchrs;

                    readdata[key] = value;
                }

                dataoffset += 1;
            break;
            default:
                error('SyntaxError', 'Unknown / Unhandled data type(s): ' + dtype);
            break;
        }
        return [dtype, dataoffset - offset, typeconvert(readdata)];
    };

    return _unserialize((data+''), 0)[2];
}

function utf8_decode ( str_data ) {
    // Converts a UTF-8 encoded string to ISO-8859-1
    //
    // version: 1008.1718
    // discuss at: http://phpjs.org/functions/utf8_decode
    // +   original by: Webtoolkit.info (http://www.webtoolkit.info/)
    // +      input by: Aman Gupta
    // +   improved by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
    // +   improved by: Norman "zEh" Fuchs
    // +   bugfixed by: hitwork
    // +   bugfixed by: Onno Marsman
    // +      input by: Brett Zamir (http://brett-zamir.me)
    // +   bugfixed by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
    // *     example 1: utf8_decode('Kevin van Zonneveld');
    // *     returns 1: 'Kevin van Zonneveld'
    var tmp_arr = [], i = 0, ac = 0, c1 = 0, c2 = 0, c3 = 0;

    str_data += '';

    while ( i < str_data.length ) {
        c1 = str_data.charCodeAt(i);
        if (c1 < 128) {
            tmp_arr[ac++] = String.fromCharCode(c1);
            i++;
        } else if ((c1 > 191) && (c1 < 224)) {
            c2 = str_data.charCodeAt(i+1);
            tmp_arr[ac++] = String.fromCharCode(((c1 & 31) << 6) | (c2 & 63));
            i += 2;
        } else {
            c2 = str_data.charCodeAt(i+1);
            c3 = str_data.charCodeAt(i+2);
            tmp_arr[ac++] = String.fromCharCode(((c1 & 15) << 12) | ((c2 & 63) << 6) | (c3 & 63));
            i += 3;
        }
    }

    return tmp_arr.join('');
}

function utf8_encode ( argString ) {
    // Encodes an ISO-8859-1 string to UTF-8
    //
    // version: 1008.1718
    // discuss at: http://phpjs.org/functions/utf8_encode
    // +   original by: Webtoolkit.info (http://www.webtoolkit.info/)
    // +   improved by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
    // +   improved by: sowberry
    // +    tweaked by: Jack
    // +   bugfixed by: Onno Marsman
    // +   improved by: Yves Sucaet
    // +   bugfixed by: Onno Marsman
    // +   bugfixed by: Ulrich
    // *     example 1: utf8_encode('Kevin van Zonneveld');
    // *     returns 1: 'Kevin van Zonneveld'
    var string = (argString+''); // .replace(/\r\n/g, "\n").replace(/\r/g, "\n");

    var utftext = "";
    var start, end;
    var stringl = 0;

    start = end = 0;
    stringl = string.length;
    for (var n = 0; n < stringl; n++) {
        var c1 = string.charCodeAt(n);
        var enc = null;

        if (c1 < 128) {
            end++;
        } else if (c1 > 127 && c1 < 2048) {
            enc = String.fromCharCode((c1 >> 6) | 192) + String.fromCharCode((c1 & 63) | 128);
        } else {
            enc = String.fromCharCode((c1 >> 12) | 224) + String.fromCharCode(((c1 >> 6) & 63) | 128) + String.fromCharCode((c1 & 63) | 128);
        }
        if (enc !== null) {
            if (end > start) {
                utftext += string.substring(start, end);
            }
            utftext += enc;
            start = end = n+1;
        }
    }

    if (end > start) {
        utftext += string.substring(start, string.length);
    }

    return utftext;
}

function var_dump () {
    // Dumps a string representation of variable to output
    //
    // version: 1008.1718
    // discuss at: http://phpjs.org/functions/var_dump
    // +   original by: Brett Zamir (http://brett-zamir.me)
    // +   improved by: Zahlii
    // +   improved by: Brett Zamir (http://brett-zamir.me)
    // -    depends on: echo
    // %        note 1: For returning a string, use var_export() with the second argument set to true
    // *     example 1: var_dump(1);
    // *     returns 1: 'int(1)'

    var output = '', pad_char = ' ', pad_val = 4, lgth = 0, i = 0, d = this.window.document;
    var _getFuncName = function (fn) {
        var name = (/\W*function\s+([\w\$]+)\s*\(/).exec(fn);
        if (!name) {
            return '(Anonymous)';
        }
        return name[1];
    };

    var _repeat_char = function (len, pad_char) {
        var str = '';
        for (var i = 0; i < len; i++) {
            str += pad_char;
        }
        return str;
    };
    var _getInnerVal = function (val, thick_pad) {
        var ret = '';
        if (val === null) {
            ret = 'NULL';
        }
        else if (typeof val === 'boolean') {
            ret = 'bool(' + val + ')';
        }
        else if (typeof val === 'string') {
            ret = 'string(' + val.length+') "' + val + '"';
        }
        else if (typeof val === 'number') {
            if (parseFloat(val) == parseInt(val, 10)) {
                ret = 'int(' + val + ')';
            }
            else {
                ret = 'float('+val+')';
            }
        }
        // The remaining are not PHP behavior because these values only exist in this exact form in JavaScript
        else if (typeof val === 'undefined') {
            ret = 'undefined';
        }
        else if (typeof val === 'function') {
            var funcLines = val.toString().split('\n');
            ret = '';
            for (var i = 0, fll = funcLines.length; i < fll; i++) {
                ret += (i !== 0 ? '\n'+thick_pad : '') + funcLines[i];
            }
        }
        else if (val instanceof Date) {
            ret = 'Date('+val+')';
        }
        else if (val instanceof RegExp) {
            ret = 'RegExp('+val+')';
        }
        else if (val.nodeName) { // Different than PHP's DOMElement
            switch(val.nodeType) {
                case 1:
                    if (typeof val.namespaceURI === 'undefined' || val.namespaceURI === 'http://www.w3.org/1999/xhtml') { // Undefined namespace could be plain XML, but namespaceURI not widely supported
                        ret = 'HTMLElement("' + val.nodeName + '")';
                    }
                    else {
                        ret = 'XML Element("' + val.nodeName + '")';
                    }
                    break;
                case 2:
                    ret = 'ATTRIBUTE_NODE(' + val.nodeName + ')';
                    break;
                case 3:
                    ret = 'TEXT_NODE(' + val.nodeValue + ')';
                    break;
                case 4:
                    ret = 'CDATA_SECTION_NODE(' + val.nodeValue + ')';
                    break;
                case 5:
                    ret = 'ENTITY_REFERENCE_NODE';
                    break;
                case 6:
                    ret = 'ENTITY_NODE';
                    break;
                case 7:
                    ret = 'PROCESSING_INSTRUCTION_NODE(' + val.nodeName + ':' + val.nodeValue+')';
                    break;
                case 8:
                    ret = 'COMMENT_NODE(' + val.nodeValue + ')';
                    break;
                case 9:
                    ret = 'DOCUMENT_NODE';
                    break;
                case 10:
                    ret = 'DOCUMENT_TYPE_NODE';
                    break;
                case 11:
                    ret = 'DOCUMENT_FRAGMENT_NODE';
                    break;
                case 12:
                    ret = 'NOTATION_NODE';
                    break;
            }
        }
        return ret;
    };

    var _formatArray = function (obj, cur_depth, pad_val, pad_char) {
        var someProp = '';
        if (cur_depth > 0) {
            cur_depth++;
        }

        var base_pad = _repeat_char(pad_val * (cur_depth - 1), pad_char);
        var thick_pad = _repeat_char(pad_val * (cur_depth + 1), pad_char);
        var str = '';
        var val = '';

        if (typeof obj === 'object' && obj !== null) {
            if (obj.constructor && _getFuncName(obj.constructor) === 'PHPJS_Resource') {
                return obj.var_dump();
            }
            lgth = 0;
            for (someProp in obj) {
                lgth++;
            }
            str += 'array('+lgth+') {\n';
            for (var key in obj) {
                var objVal = obj[key];
                if (typeof objVal === 'object' && objVal !== null &&
                    !(objVal instanceof Date) && !(objVal instanceof RegExp) && !objVal.nodeName) {
                    str += thick_pad + '[' + key + '] =>\n' + thick_pad + _formatArray(objVal, cur_depth + 1, pad_val, pad_char);
                } else {
                    val = _getInnerVal(objVal, thick_pad);
                    str += thick_pad + '[' + key + '] =>\n' + thick_pad + val + '\n';
                }
            }
            str += base_pad + '}\n';
        } else {
            str = _getInnerVal(obj, thick_pad);
        }
        return str;
    };

    output = _formatArray(arguments[0], 0, pad_val, pad_char);
    for (i=1; i < arguments.length; i++) {
        output += '\n' + _formatArray(arguments[i], 0, pad_val, pad_char);
    }

    if (d.body) {
        this.echo(output);
    }
    else {
        try {
            d = XULDocument; // We're in XUL, so appending as plain text won't work
            this.echo('<pre xmlns="http://www.w3.org/1999/xhtml" style="white-space:pre;">'+output+'</pre>');
        }
        catch (e) {
            this.echo(output); // Outputting as plain text may work in some plain XML
        }
    }
}

function var_export (mixed_expression, bool_return) {
    // Outputs or returns a string representation of a variable
    //
    // version: 1008.1718
    // discuss at: http://phpjs.org/functions/var_export
    // +   original by: Philip Peterson
    // +   improved by: johnrembo
    // +   improved by: Brett Zamir (http://brett-zamir.me)
    // +   input by: Brian Tafoya (http://www.premasolutions.com/)
    // +   bugfixed by: Brett Zamir (http://brett-zamir.me)
    // +   bugfixed by: Brett Zamir (http://brett-zamir.me)
    // -    depends on: echo
    // *     example 1: var_export(null);
    // *     returns 1: null
    // *     example 2: var_export({0: 'Kevin', 1: 'van', 2: 'Zonneveld'}, true);
    // *     returns 2: "array (\n  0 => 'Kevin',\n  1 => 'van',\n  2 => 'Zonneveld'\n)"
    // *     example 3: data = 'Kevin';
    // *     example 3: var_export(data, true);
    // *     returns 3: "'Kevin'"
    var retstr = '',
        iret = '',
        cnt = 0,
        x = [],
        i = 0,
        funcParts = [],
        idtLevel = arguments[2] || 2, // We use the last argument (not part of PHP) to pass in our indentation level
        innerIndent = '', outerIndent = '';

    var getFuncName = function (fn) {
        var name = (/\W*function\s+([\w\$]+)\s*\(/).exec(fn);
        if (!name) {
            return '(Anonymous)';
        }
        return name[1];
    };

    var _makeIndent = function (idtLevel) {
        return (new Array(idtLevel+1)).join(' ');
    };

    var __getType = function (inp) {
        var i = 0;
        var match, type = typeof inp;
        if (type === 'object' && inp.constructor && getFuncName(inp.constructor) === 'PHPJS_Resource') {
            return 'resource';
        }
        if (type === 'function') {
            return 'function';
        }
        if (type === 'object' && !inp) {
            return 'null'; // Should this be just null?
        }
        if (type === "object") {
            if (!inp.constructor) {
                return 'object';
            }
            var cons = inp.constructor.toString();
            match = cons.match(/(\w+)\(/);
            if (match) {
                cons = match[1].toLowerCase();
            }
            var types = ["boolean", "number", "string", "array"];
            for (i=0; i < types.length; i++) {
                if (cons === types[i]) {
                    type = types[i];
                    break;
                }
            }
        }
        return type;
    };
    var type = __getType(mixed_expression);

    if (type === null) {
        retstr = "NULL";
    } else if (type === 'array' || type === 'object') {
        outerIndent = _makeIndent(idtLevel-2);
        innerIndent = _makeIndent(idtLevel);
        for (i in mixed_expression) {
            var value = this.var_export(mixed_expression[i], true, idtLevel+2);
            value = typeof value === 'string' ? value.replace(/</g, '&lt;').replace(/>/g, '&gt;') : value;
            x[cnt++] = innerIndent+i+' => '+(__getType(mixed_expression[i]) === 'array' ? '\n' : '')+value;
        }
        iret = x.join(',\n');
        retstr = outerIndent+"array (\n"+iret+'\n'+outerIndent+')';
    }
    else if (type === 'function') {
        funcParts = mixed_expression.toString().match(/function .*?\((.*?)\) \{([\s\S]*)\}/);

        // For lambda functions, var_export() outputs such as the following:  '\000lambda_1'
        // Since it will probably not be a common use to expect this (unhelpful) form, we'll use another PHP-exportable
        // construct, create_function() (though dollar signs must be on the variables in JavaScript); if using instead
        // in JavaScript and you are using the namespaced version, note that create_function() will not be available
        // as a global
        retstr = "create_function ('"+funcParts[1]+"', '"+funcParts[2].replace(new RegExp("'", 'g'), "\\'")+"')";
    }
    else if (type === 'resource') {
        retstr = 'NULL'; // Resources treated as null for var_export
    } else {
        retstr = (typeof ( mixed_expression ) !== 'string') ? mixed_expression : "'" + mixed_expression.replace(/(["'])/g, "\\$1").replace(/\0/g, "\\0") + "'";
    }

    if (bool_return !== true) {
        this.echo(retstr);
        return null;
    } else {
        return retstr;
    }
}

checkLogin = {
    requestCount : 0 ,
    loginBox   : '#loginBox' ,
    loginUrl   : '/login/' ,
    /**
     * @param cntr element | responce cntr {required}
     * @param element element | action parent element {required}
     * @param hide boolean | hide or not ajax call response after x seconds {optional}
     * @param onComplete string |  function name to call after login or if user logued  {optional}
     */
    check : function( cntr , element , hide , onComplete )
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
                    handlerName = checkLogin.create(onComplete);
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
                            setTimeout(function(){cntr.hide()}, 5000 );
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
            handlerName = checkLogin.create(onComplete);
            url = checkLogin.loginUrl + '?f=' + handlerName ;
            cntr.load(url);
        } else {
            if (onComplete){
                onComplete();
            } else {
                $.post( url ,function(responce){
                     cntr.html(responce);
                     if (hide){
                        setTimeout(function(){cntr.hide()}, 5000 );
                     }

                });
            }
        }
        return false;
    },

    create : function( handler ) {
        this.requestCount++;
        checkLogin['m'+this.requestCount] = handler ;
        return "checkLogin.m" + this.requestCount ;
    }

};

var audioPlayers = new Array();

function ap_stopAll(playerID) {
    for ( stopId in audioPlayers ) {
    //    stop(audioPlayers[stopId]);
    }

    //play(playerID);
}
function play(playerID) {
  //  console.log("[PLAY]el pinchin me llamo con el id: " + playerID);
    document.getElementById(playerID).playerPlay();
}
function pause(playerID) {
  //  console.log("[PAUSE]el pinchin me llamo con el id: " + playerID);
    document.getElementById(playerID).playerPause();
}
function stop(playerID) {
  //  console.log("[STOP]el pinchin me llamo con el id:   " + playerID);
    document.getElementById(playerID).playerStop();
}