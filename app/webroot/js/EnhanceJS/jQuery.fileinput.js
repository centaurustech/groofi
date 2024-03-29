/**
 * --------------------------------------------------------------------
 * jQuery customfileinput plugin
 * Author: Scott Jehl, scott@filamentgroup.com
 * Copyright (c) 2009 Filament Group 
 * licensed under MIT (filamentgroup.com/examples/mit-license.txt)
 * --------------------------------------------------------------------
 */
$.fn.customFileInput = function(){
    return $(this).each(function(){
        //apply events and styles for file input element
        var fileInput = $(this)
        .addClass('customfile-input') //add class for CSS
        .mouseover(function(){
            upload.addClass('customfile-hover');
        })
        .mouseout(function(){
            upload.removeClass('customfile-hover');
        })
        .focus(function(){
            upload.addClass('customfile-focus');
            fileInput.data('val', fileInput.val());
        })
        .blur(function(){
            upload.removeClass('customfile-focus');
            $(this).trigger('checkChange');
        })
        .bind('disable',function(){
            fileInput.attr('disabled',true);
            upload.addClass('customfile-disabled');
        })
        .bind('enable',function(){
            fileInput.removeAttr('disabled');
            upload.removeClass('customfile-disabled');
        })
        .bind('checkChange', function(){
            fileInput.trigger('change');
        })
        .bind('change',function(){
            if(fileInput.val() && fileInput.val() != fileInput.data('val')){
                //get file name
                var fileName = $(this).val().split(/\\/).pop();
                //get file extension
                var fileExt = 'customfile-ext-' + fileName.split('.').pop().toLowerCase();
                //update the feedback
                uploadFeedback
                .text(fileName) //set feedback text to filename
                .removeClass(uploadFeedback.data('fileExt') || '') //remove any existing file extension class
                .addClass(fileExt) //add file extension class
                .data('fileExt', fileExt) //store file extension for class removal on next change
                .addClass('customfile-feedback-populated'); //add class to show populated state
                //change text of button
                uploadButton.text( langTexts.upload.change  );
            }
        })
        .click(function(){ //for IE and Opera, make sure change fires after choosing a file, using an async callback
            fileInput.data('val', fileInput.val());
            setTimeout(function(){
                fileInput.trigger('checkChange');
            },100);
        });
		
        //create custom control container
        var upload = $('<div class="customfile"></div>');
        //create custom control button
        var uploadButton = $('<span class="customfile-button" aria-hidden="true">' + langTexts.upload.browse + '</span>').appendTo(upload);
        //create custom control feedback
        var uploadFeedback = $('<span class="customfile-feedback" aria-hidden="true"></span>').appendTo(upload);
	
    
        uploadFeedback.text((fileInput.val() != '' ? fileInput.val() : langTexts.upload.no_file_selected ));
        
        
        //match disabled state
        if(fileInput.is('[disabled]')){
            fileInput.trigger('disable');
        }
		
	
        //on mousemove, keep file input under the cursor to steal click
        upload
        .mousemove(function(e){
            if ( !$(e.target).is('input') ){
                pos = {
                    'left':  e.layerX - fileInput.outerWidth()  + 20, //position right side 20px right of cursor X)
                    'top':  e.layerY - ( fileInput.height() / 2 )
                };
                fileInput.css(pos);
            }
        })
        .hover( function(){$('.customfile-button').addClass('hover')} , function(){$('.customfile-button').removeClass('hover')} )
        .insertAfter(fileInput); //insert after the input
	
        fileInput.width( 'auto' ).height( 'auto' ).appendTo(upload);
		
    });
};