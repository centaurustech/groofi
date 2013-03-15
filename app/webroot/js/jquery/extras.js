(function($){
    jQuery.fn.extend({
//plugin name - changecss
        changecss: function(className , propertyName , value) {

            return this.each(function(  ) {
               
                if(
                ( className == '' ) ||
                ( propertyName == '' ) ||
                ( value == '' ) ) {
                    return ;
                }

                var propertyIndexName = false;
                var falg = false;
                var numberOfStyles = document.styleSheets.length
               
                if (document.styleSheets[0]['rules']) {
                    propertyIndexName = 'rules';
                } else if (document.styleSheets[0]['cssRules']) {
                    propertyIndexName = 'cssRules';
                }
               
                for (var i = 0; i < numberOfStyles; i++) {
                    for (var j = 0; j < document.styleSheets[i][propertyIndexName].length; j++) {
                        if (document.styleSheets[i][propertyIndexName][j].selectorText == className) {
                            if(document.styleSheets[i][propertyIndexName][j].style[propertyName]){
                                document.styleSheets[i][propertyIndexName][j].style[propertyName] = value;
                                falg=true;
                                break;
                            }
                        }
                    }
                    if(!falg){
                        if(document.styleSheets[i].insertRule){
                            document.styleSheets[i].insertRule(className+' { '+propertyName+': '+value+'; }',document.styleSheets[i][propertyIndexName].length);
                        } else if (document.styleSheets[i].addRule) {
                            document.styleSheets[i].addRule(className,propertyName+': '+value+';');
                        }
                    }
                }
            }
    );
        }
    });
})(jQuery);


$(function(){
	$.extend($.fn.disableTextSelect = function() {
		return this.each(function(){
			if($.browser.mozilla){//Firefox
				$(this).css('MozUserSelect','none');
			}else if($.browser.msie){//IE
				$(this).bind('selectstart',function(){return false;});
			}else{//Opera, etc.
				$(this).mousedown(function(){return false;});
			}
		});
	});
	$('.noSelect').disableTextSelect();//No text selection on elements with a class of 'noSelect'
});
