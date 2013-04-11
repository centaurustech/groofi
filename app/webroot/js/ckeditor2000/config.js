/*
Copyright (c) 2003-2011, CKSource - Frederico Knabben. All rights reserved.
For licensing, see LICENSE.html or http://ckeditor.com/license
*/



CKEDITOR.editorConfig = function( config )
{
	// Define changes to default configuration here. For example:
	// config.language = 'fr';
	// config.uiColor = '#AADC6E';
    config.LinkBrowser = true ;
    config.ImageBrowser = true ;
    config.FlashBrowser = true ;
    config.LinkUpload = true ;
    config.ImageUpload = true ;
    config.FlashUpload = true ;

    config.resize_enabled = false;
    config.height = '120px';
    config.width = '840px';
    config.toolbar = 'Full';

    config.toolbar_Full =
        [
            ['Cut','Copy','Paste','PasteText','PasteFromWord','-','Print', 'SpellChecker', 'Scayt'],
            ['Undo','Redo','-','Find','Replace','-','SelectAll','RemoveFormat'],
            ['Form', 'Checkbox', 'Radio', 'TextField', 'Textarea', 'Select', 'Button', 'ImageButton', 'HiddenField'],
            '/',
            ['Bold','Italic','Underline','Strike','-','Subscript','Superscript','Image'],
            ['NumberedList','BulletedList','-','Outdent','Indent','Blockquote'],
            ['JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock'],
            ['Link','Unlink','Anchor'],
            '/',
            ['Styles','Format','Font','FontSize'],
            ['TextColor','BGColor']


        ];







}