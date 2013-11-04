/**
 * @license Copyright (c) 2003-2013, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.html or http://ckeditor.com/license
 */

CKEDITOR.editorConfig = function( config ) {

	// Define changes to default configuration here.
	// For the complete reference:
	// http://docs.ckeditor.com/#!/api/CKEDITOR.config

	// The toolbar groups arrangement, optimized for two toolbar rows.
    config.LinkBrowser = false ;
    config.resize_enabled = false;
    config.height = '150px';
    config.width = '845px';
    config.toolbar = 'Full';
    config.enterMode = CKEDITOR.ENTER_BR;
    config.toolbarGroups = [
		{ name: 'clipboard',   groups: [ 'clipboard', 'undo' ] },
		{ name: 'editing',     groups: [ 'find', 'selection', 'spellchecker' ] },
		{ name: 'links' },
		{ name: 'insert' },
		{ name: 'forms' },
		{ name: 'tools' },
		{ name: 'document',	   groups: [ 'mode', 'document', 'doctools' ] },
		{ name: 'others' },
		'/',
		{ name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ] },
		{ name: 'paragraph',   groups: [ 'list', 'indent', 'blocks', 'align' ] },
		{ name: 'styles' },
		{ name: 'colors' },
		{ name: 'about' }
        /*'/',
        { name: 'JustifyLeft'},
        { name: 'JustifyCenter'},
        { name: 'JustifyRight'},
        { name: 'JustifyBlock'}*/
	];

	// Remove some buttons, provided by the standard plugins, which we don't
	// need to have in the Standard(s) toolbar.
	config.removeButtons = 'Underline,Subscript,Superscript';

	// Se the most common block elements.
	config.format_tags = 'p;h1;h2;h3;pre';

	// Make dialogs simpler.
	config.removeDialogTabs = 'image:advanced;link:advanced';

    config.removePlugins = '';
};

CKEDITOR.on( 'dialogDefinition', function( ev )
{
    console.log(ev);
    // Take the dialog name and its definition from the event data.
    var dialogName = ev.data.name;
    var dialogDefinition = ev.data.definition;

    // Check if the definition is from the dialog we're
    // interested in (the 'image' dialog). This dialog name found using DevTools plugin
    if ( dialogName == 'image' )
    {
        // Remove the 'Link' and 'Advanced' tabs from the 'Image' dialog.
        dialogDefinition.removeContents( 'Link' );

        // Get a reference to the 'Image Info' tab.
        var infoTab = dialogDefinition.getContents('info');

        // Remove unnecessary widgets/elements from the 'Image Info' tab.
        infoTab.remove( 'txtHSpace');
        infoTab.remove( 'txtVSpace');
        infoTab.remove( 'txtBorder');
    }
});