<?php

class StaticpagesController extends AppController {

    function beforeFilter() {
        if(isset($_SESSION['idioma']) && !empty($_SESSION['idioma'])){
            $idioma = $_SESSION['idioma'];
            Configure::write('Config.language', $idioma);
        }

        $this->Auth->allow('view', 'home','message','guidelines','comofunciona','faq','contacto','translate', 'country');
        parent::beforeFilter();

    }

    var $name = 'Staticpages';

    function message($messageSlug) {

        $message = Configure::read('Message.' . $messageSlug);


        if ($message) {
            $this->data['Staticpage']['title'] = __($message['title'], true);
            $this->data['Staticpage']['content'] = __($message['content'], true);
            $this->data['Staticpage']['variables'] = $message['variables'];
        } else {
            if (Configure::read('debug') > 0) {
                $this->data['Staticpage']['title'] = 'La pantalla no existe creala en messages.php';
                $this->data['Staticpage']['content'] = "
                <pre>
                \$config['Message.$messageSlug'] = array(
                    'title' => '" . up($messageSlug) . "-TITLE',
                    'content' => '" . up($messageSlug) . "-CONTENT',
                    'variables' => array() 
                );
                </pre>
            ";
                $this->data['Staticpage']['variables'] = array();
            } else {
                //404 ----------------------------------------------------------
            }
        }

        $this->set('pageTitle', false);
        $this->set('title_for_layout', $this->data['Staticpage']['title']);
    }

    function view($id = null) {
        if (!$id) {
            $this->flash(__('Invalid staticpage', true), array('action' => 'index'));
        } else {
            $this->data = $this->Staticpage->find('first', array('conditions' => array('or' => array('Staticpage.id' => $id, 'Staticpage.slug' => $id))));
        }

        if (empty($this->data)) {
            $this->cakeError('error404', array(array('url' => $this->params['url']['url'])));
        } else {
            if ($this->data['Staticpage']['template'] == 'default') {
                $render = 'view';
            } else {
                $render = $this->data['Staticpage']['template'];
            }
            $this->render($render);
        }
    }

    
    function admin_index() {
        $this->autoPaginateOptions('filter', array());
        $this->autoPaginateOptions('sort', array('Staticpage.id', 'Staticpage.title'));
        $this->_preparePaginate();
        
        $this->Staticpage->recursive = 0;
        $this->paginate['conditions']['Staticpage.template <>'] = 'message' ;
        $this->data['results'] = $this->paginate() ;
    }

    
    function admin_view($id = null) {

        if (!$id) {
            $this->flash(__('Invalid staticpage', true), array('action' => 'index'));
        }
        $this->set('staticpage', $this->Staticpage->read(null, $id));
    }

    function admin_add() {

        if (!empty($this->data)) {
            if (empty($this->data['Statipage']['slug'])) {
                $this->data['Statipage']['slug'] = Inflector::slug($this->data['Statipage']['title']);
            }
            $this->Staticpage->create();
            if ($this->Staticpage->saveAll($this->data, array('validate' => 'first'))) {
                $this->flash(__('Staticpage saved.', true), array('action' => 'index'));
            } else {
                
            }
        }



        $this->set('templates', array('default' => 'default', 'message' => 'message'));

        $this->set('sections', array('footer' => 'footer', 'header' => 'header', 'both' => 'both'));
    }

    function admin_edit($id = null) {
        if (!$id && empty($this->data)) {
            $this->flash(sprintf(__('Invalid staticpage', true)), array('action' => 'index'));
        }
        if (!empty($this->data)) {
            if ($this->Staticpage->saveAll($this->data, array('validate' => 'first'))) {
                $this->redirect( array('action' => 'index'));
            } else {
                
            }
        }
        if (empty($this->data)) {
            $this->data = $this->Staticpage->read(null, $id);
        }
        $this->set('templates', array('default' => 'default', 'message' => 'message'));

        $this->set('sections', array('footer' => 'footer', 'header' => 'header', 'both' => 'both'));
    }

    function admin_delete($id = null) {
        if (!$id) {
            $this->flash(sprintf(__('Invalid staticpage', true)), array('action' => 'index'));
        }
        if ($this->Staticpage->delete($id)) {
            $this->flash(__('Staticpage deleted', true), array('action' => 'index'));
        }
        $this->flash(__('Staticpage was not deleted', true), array('action' => 'index'));
        $this->redirect(array('action' => 'index'));
    }

    function home() {
        App::import('model', 'User');
        App::import('model', 'Project');
        App::import('model', 'Offer');
        $this->User = new User();
        $this->Project = new Project();
        $this->Offer = new Offer();
        $this->data['HighlightUsers']    = $this->User->getHighlight();
        $this->data['NewestUsers']       = $this->User->getNewest();
        $this->data['HighlightProjects'] = $this->Project->getHighlight();
        $this->data['HighlightOffers']   = $this->Offer->getHighlight();
		$this->data['WeekProjects']   = $this->Project->getWeek();
		App::import('model', 'Predefinido');
		$pp=new Predefinido();
		$datos=$pp->query("select * from predefinidos order by id desc ");
		$pred=array();
		foreach($datos as $v){
				$pred[]=$v;
		}
		$this->data['PredefinedProjects']=$pred;
		App::import('model', 'Category');
		$pp=new Category();
		$base_categories = $pp->generatetreelist (null, null, null, " - ");
		$keys_categories=array();
         foreach ($base_categories as $key => $category) {
			 $keys_categories[$key]=trim(str_replace('- ','',$category));
             $base_categories[$key] = __ ('CATEGORY_' . up ($category), true);
         }
		 $this->set ('base_categories',$base_categories);
		 $this->set ('keys_categories',$keys_categories);
    }
	function guidelines(){
		
	}
	function comofunciona(){
		
	}
	function faq(){
	}
	function contacto(){
		
		$pat="/^[^@]*@[^@]*\.[^@]*$/";
	
		if(isset($_POST['nombre'])){
			if(empty($_POST['nombre'])){
				$this->set('error', 'Por favor complete el campo Nombre');
			}elseif(empty($_POST['email'])){
				$this->set('error', 'Por favor complete el campo E-mail');
			}elseif(!(preg_match($pat,$_POST['email']))){
				$this->set('error', 'Por favor complete correctamente el campo E-mail');
			}elseif(empty($_POST['comentario'])){
				$this->set('error', 'Por favor complete correctamente el campo Comentario');
			}else{
				$mensaje='';
				foreach($_POST as $k => $v){
					$v=strtr($v,"\r\n\t",'   ');
					$pattern = '/(;|\||`|>|<|&|^|"|'."\n|\r|'".'|{|}|[|]|\)|\()/i';
					$v=preg_replace($pattern, "", $v); 
					$find = array("/bcc\:/i","/Content\-Type\:/i","/cc\:/i","/to\:/i"); 
					$v=preg_replace($find, "", $v);
					if($k!='Submit' && $k!='code' && $k!='panino'){
						$v=utf8_decode($v);
						$mensaje.=ucfirst($k).": $v\n";
					}
				}
				$headers = "Reply-To: buenosaires@groofi.com\r\n"; 
				$headers .= "From: groofi.es <buenosaires@groofi.com>\r\n";
				mail('jona@4060.com.ar','Contacto desde el website',$mensaje,$headers);
			}
			$this->layout='panino';
			$this->render('/staticpages/panino2');
		}
	}

    function translate(){
       $idioma = $_GET['idioma'];
       switch ($idioma){
           case "en": $new_idioma = "eng";
           break;
           case "es": $new_idioma = "esp";
           break;
           case "it": $new_idioma = "ita";
           break;
           default:  $new_idioma = "esp";
       }
       unset($_SESSION['idioma']);
       $_SESSION['idioma'] = $new_idioma;
       $this->redirect(array('controller' => 'staticpages', 'action' => 'home'));
    }

    function country(){
        App::import('Vendor', 'geoip');

        $this->GeoIP = new GeoIP();

        $ip_pais = (string) $_SERVER['REMOTE_ADDR'];

        $gi = $this->GeoIP->geoip_open("GeoIP.dat",GEOIP_STANDARD);

        $ip_string =long2ip($ip_pais);

        $sigla_pais = $this->GeoIP->geoip_country_code_by_addr($gi , $ip_pais );

        if( $sigla_pais =='AR'){
            $moneda= 'Peso';
        }else if($sigla_pais =='BR'){
            $moneda= 'Real';
        }else if($sigla_pais =='GB'){
            $moneda= 'Libra';
        }else if($sigla_pais =='ES'){
            $moneda= 'Euro';
        }else if($sigla_pais =='ES'){
            $moneda= 'Euro';
        }else{
            $moneda= 'Dolar';
        }

        echo $moneda;
        die;
    }


}

?>