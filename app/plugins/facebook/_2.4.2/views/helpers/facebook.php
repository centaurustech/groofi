<?php
/**
* Facebook.Facebook helper generates fbxml and loads javascripts
*
* @author Nick Baker <nick [at] webtechnick [dot] com>
* @version since 2.4.2
* @license MIT
* @link http://www.webtechnick.com
*/
App::import('Lib', 'Facebook.FacebookInfo');
class FacebookHelper extends AppHelper {
	/**
	* Helpers to load with this helper.
	*/
	var $helpers = array('Html', 'Session');
	
	/**
	* Default Facebook.Share javascript URL
	* @access private
	*/
	var $__fbShareScript = 'http://static.ak.fbcdn.net/connect.php/js/FB.Share';
	
	/**
	* locale, settable in the constructor
	* @link http://developers.facebook.com/docs/internationalization/
	* @access public
	*/
	var $locale = null;
	
	/**
	* Loadable construct, pass in locale settings
	* Fail safe locale to 'en_US'
	*/
	function __construct($settings = array()){
		$this->_set($settings);
		
		if(!$this->locale){
			$this->locale = FacebookInfo::getConfig('locale');
		}
		if(!$this->locale){
			$this->locale = 'en_US';
		}
		parent::__construct();
	}
	
	/**
	* Get the info on this plugin
	* @param string name to retrieve (default 'version')
	* - 'name' => Plugin Name
	* - 'author' => Author Name
	* - 'email' => Support Email
	* - 'link' => Support Link
	* - 'license' => License Info
	* @return string plugin version
	*/
	function info($name = 'version'){
		if(FacebookInfo::_isAvailable($name)){ 
			return FacebookInfo::$name();
		}
		else {
			return "$name is not an available option";
		}
	}
	
	/**
	* Loaoder is no longer needed and is now deprecated
	* @return null
	*/
	function loader(){
		return null;
	}
	
	/**
	* HTML XMLNS tag (required)
	* @return string of html header
	* @access public
	*/
	function html(){
		return '<html xmlns="http://www.w3.org/1999/xhtml" xmlns:fb="http://www.facebook.com/2008/fbml">';
	}
	
	/**
	* Login Button
	* $this->Facebook->init() is required for this
	* @param array of options
	* - show-faces bool Show pictures of the user's friends who have joined your application
	* - width int The width of the plugin in pixels
	* - max-rows int The maximum number of rows of profile pictures to show
	* - perms list of permissions to ask for when logging in separated by commas (eg: 'email,read_stream,publish_stream'). (http://developers.facebook.com/docs/authentication/permissions)
	* @return string XFBML tag
	* @access public
	*/
	function login($options = array()){
        $label = isset($options['label']) ? $options['label'] : '' ;
		return $this->__fbTag('fb:login-button', $label , $options);
	}
	
	
	/**
	* Logout Button
	* $this->Facebook->init() is required for this
	* @param array of options
	* - redirect string to your app's logout url (default null)
	* - label string of text to use in link (default logout)
	* - confirm string Alert dialog which will be visible if user clicks on the button/link
	* - custom used to create custom link instead of standart fbml. if redirect option is set this one is not required.
	* @return string XFBML tag for logout button
	* @access public
	*/
	function logout($options = array()){
		$options = array_merge(
			array(
				'autologoutlink' => 'true', 
				'label' => 'logout',
				'custom' => false
			), 
			$options
		);
		if(isset($options['redirect']) || $options['custom']){
			if(isset($options['redirect']) && $options['redirect']){
				$options['redirect'] = Router::url($options['redirect']);
				$response = "window.location = '{$options['redirect']}'";
			} else {
				$response = "window.location.reload();";
			}
			$onclick = "FB.logout(function(response){".$response."});";
			if(isset($options['confirm'])){
				$onclick = 'if(confirm("'.$options['confirm'].'")){'.$onclick.'}';
			}
			return $this->Html->link($options['label'], '#', array('onclick' => $onclick));
		} else {
			unset($options['label'], $options['escape'], $options['custom']);
			return $this->__fbTag('fb:login-button', '', $options);
		}
	}
	
	/**
	* Unsubscribe Button - Function which creates link for disconnecting user from the specific application
	* $this->Facebook->init() is required for this
	* @param array of options
	* - redirect string to your app's logout url (default null)
	* - label string of text to use in link (default logout)
	* - confirm string Alert dialog which will be visible if user clicks on the button/link
	* @return string Link for disconnect button
	* @access public
	*/
	function disconnect($options = array()){
		$options = array_merge(
			array(
				'label' => 'logout'
			), 
			$options
		);
		if(isset($options['redirect']) && $options['redirect']){
			$options['redirect'] = Router::url($options['redirect']);
			$response = "window.location = '{$options['redirect']}'";
		} else {
			$response = "window.location.reload();";   
		}
		$onclick = "FB.api({ method: 'Auth.revokeAuthorization' }, function(response) {".$response."});";
		if(isset($options['confirm'])){
			$onclick = 'if(confirm("'.$options['confirm'].'")){'.$onclick.'}';
		}
		return $this->Html->link($options['label'], '#', array('onclick' => $onclick));
	}
	
	/**
	* Share this page
	* @param string url: url to share with facebook (default current page) 
	* @param array options to pass into share
	* - style: 'button' or 'link' (default'button')
	* - label: title of text to link(default 'share')
	* - anchor: a href anchor name (default 'fb_share')
	* - fbxml: true or false.  If true, use fb:share-button xml style instead of javascript share (default false)
	* @return string XFBML tag along with shareJs script
	* @access public
	*/
	function share($url = null, $options = array()){
		// @todo this can be improved using the router
		if(!$url) $url = env('SERVER_NAME') . $this->here;
		$defaults = array(
			'style' => 'button',
			'label' => 'share',
			'anchor' => 'fb_share',
			'fbxml' => false
		);
		$options = array_merge($defaults, $options);
		
		if(!$options['fbxml']){
			switch($options['style']){
			case 'link': $options['type'] = 'icon_link'; break;
				default: $options['type'] = 'button'; break;
			}
		}
		
		if($options['fbxml']){
			unset($options['fbxml']);
			$retval = $this->__fbTag('fb:share-button','',$options);
		}
		else {
			$retval = $this->Html->link($options['label'], 'http://www.facebook.com/sharer.php', array('share_url' => $url, 'type' => $options['type'], 'name' => $options['anchor']));
			$retval .= $this->Html->script($this->__fbShareScript);
		}
		
		return $retval;
	}
	
	/**
	* Profile Picture of Facebook User
	* $facebook->init() is required for this
	* @param int facebook user id.
	* @param array options to pass into pic
	* - uid : user_id to view profile picture
	* - size : size of the picture represented as a string. 'thumb','small','normal','square' (default thumb)
	* - facebook-logo: (default true)
	* - width: width of the picture in pixels 
	* - height: height of the picture in pixels 
	* @return string fb tag for profile picture or empty string if uid is not present
	* @access public
	*/
	function picture($uid = null, $options = array()){
		$options = array_merge(
			array(
				'uid' => $uid,
				'facebook-logo' => 1,
			),
			$options
		);
		if($options['uid']){
			return $this->__fbTag('fb:profile-pic', '', $options);
		}
		else {
			return "";
		}
	}
	
	/**
	* Build a like box
	* $facebook->init() is required for this
	* @link http://developers.facebook.com/docs/reference/plugins/like-box
	* @param array of options to pass into likebox
	* - stream : 1 turns stream on, 0 turns stream off (default false)
	* - header : 1 turns header on, 0 turns logobar off (default false)
	* - width : width of the box (default 300)
	* - connections : number of connections to show (default 10)
	* - colorscheme : dark | light (default light)
	*/
	function likebox($url = null, $options = array()){
		$options = array_merge(
			array(
				'href' => $url,
				'stream' => 'false',
				'header' => 'false',
				'width' => '300',
				'connections' => '10'
			),
			$options
		);
		return $this->__fbTag('fb:like-box', '', $options);
	}
	
	/**
	* Build a become a fan, fanbox
	* $facebook->init() is required for this
	* @param array options to pass into fanbox
	* - stream : 1 turns stream on, 0 turns stream off (default 0)
	* - connections : 1 turns connections on, 0 turns connections off (default 0)
	* - logobar : 1 turns logobar on, 0 turns logobar off (default 0)
	* - profile_id : Your Application Id (default Configure::read('Facebook.app_id')
	* @return string xfbhtml tag
	* @access public
	*/
	function fanbox($options = array()){
		$options = array_merge(
			array(
				'profile_id' => FacebookInfo::getConfig('appId'),
				'stream' => 0, 
				'logobar' => 0, 
				'connections' => 0,
			),
			$options
		);
		return $this->__fbTag('fb:fan', '', $options);
	}
	
	/**
	* Build a livestream window to your live stream app on facebook
	* $facebook->init() is required for this
	* @param array options to pass into livestream
	* - event_app_id : Your Application Id (default Configure::read('Facebook.appId')
	* - xid : Your event XID
	* - width : width of window in pixels
	* - height: height of window in pixels
	* @return string xfbhtml tag
	* @access public
	*/
	function livestream($options = array()){
		$options = array_merge(
			array(
				'event_app_id' => FacebookInfo::getConfig('appId'),
				'xid' => 'YOUR_EVENT_XID',
				'width' => '300',
				'height' => '500',
			),
			$options
		);
		return $this->__fbTag('fb:live-stream','',$options);
	}
	
	/**
	* Build a facebook comments area.
	* $facebook->init() is required for this
	* @param array of options for comments
	* - numposts : number of posts to show (default 10)
	* - width : int width of comments blog (default 550)
	* @return string xfbhtml tag
	* @access public
	*/
	function comments($options = array()){
		return $this->__fbTag('fb:comments', '', $options);
	}
	
	/**
	* Build a facebook recommendations area.
	* $facebook->init() is required for this
	* @param array of options for recommendations
	* - width : int width of object (default 300)
	* - height : int height of object (default 300)
	* - header : boolean (default true)
	* - colorscheme : light, dark (default light)
	* - font : default arial
	* - bordercolor : color of border (black, white, grey)
	* @return string xfbhtml tag
	* @access public
	*/
	function recommendations($options = array()){
		return $this->__fbTag('fb:recommendations', '', $options);
	}
	
	/**
	* Build a facebook friendpile area.
	* $facebook->init() is required for this
	* @param array of options for recommendations
	* - numrows : int of rows object (default 1)
	* - width : int width of object (default 300)
	* @return string xfbhtml tag
	* @access public
	*/
	function friendpile($options = array()){
		return $this->__fbTag('fb:friendpile', '', $options);
	}
	
	/**
	* Build a facebook activity feed area.
	* $facebook->init() is required for this
	* @param array of options for recommendations
	* - width : int width of object (default 300)
	* - height : int height of object (default 300)
	* - header : boolean (default true)
	* - colorscheme : light, dark (default light)
	* - font : default arial
	* - bordercolor : color of border (black, white, grey)
	* - recommendations : show recommendations default "false"
	* @return string xfbhtml tag
	* @access public
	*/
	function activity($options = array()){
		return $this->__fbTag('fb:activity', '', $options);
	}
	
	/**
	* Build a facebook like box
	* $facebook->init() is required for this
	* @param array of options for like box
	* - href : URL to like (default same page)
	* - show_faces : boolean (default true)
	* - font : font type (arial, lucida grande, segoe ui, tahoma, trebuchet ms, verdana)
	* - layout : the layout type if the button (button_count, standard, default: standard)
	* - action : the title of the action (like or recommend, default: like)
	* - colorscheme : the look of the button (dark or light, default: light)
	* @return string xfbhtml tag
	* @access public
	*/
	function like($options = array()){
        
		return $this->__fbTag('fb:like', '', $options);
	}
	
	/**
	* HTML XMLNS tag (required)
	* @param array of options
	* @example $this->Facebook->init();
	* @return string of scriptBlock for FB.init() or error
	* @access public
	*/
	function init($options = array()){
		if(FacebookInfo::getConfig('appId')){
			$appId = FacebookInfo::getConfig('appId');
			$session = json_encode($this->Session->read('FB.Session'));
			$init = '<div id="fb-root"></div>';
			$init .=  $this->Html->scriptBlock(
				"
				window.fbAsyncInit = function() {
					FB.init({
						appId   : '{$appId}',
						session : {$session}, // don't refetch the session when PHP already has it
						status  : true, // check login status
						cookie  : true, // enable cookies to allow the server to access the session
						xfbml   : true // parse XFBML
					});
					// whenever the user logs in, we refresh the page
					FB.Event.subscribe('auth.login', function() {
						window.location.reload();
					});
				};
				(function() {
					var e = document.createElement('script');
					e.src = document.location.protocol + '//connect.facebook.net/{$this->locale}/all.js';
					e.async = true;
					document.getElementById('fb-root').appendChild(e);
				}());
				",
				$options
			);
			return $init;
		}
		else {
			return "<span class='error'>No Facebook configuration detected. Please add the facebook configuration file to your config folder.</span>";
		} 
	}
	
	/**
	* Generate a facebook tag
	* @param string fb:tag
	* @param string label to pass inbetween the tag
	* @param array of options as name=>value pairs to add to facebook tag attribute
	* @access private
	*/
	private function __fbTag($tag, $label, $options){
		//TODO make this a little nicer, pron to errors if a value has a ' in it.
		$retval = "<$tag";
		foreach($options as $name => $value){
			if($value === false) $value = 0;
			$retval .= " " . $name . "='" . $value . "'";
		}
		$retval .= ">$label</$tag>";
		return $retval;
	}
	
}