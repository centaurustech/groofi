<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * @property Project $Project
 */
class PredefinidosController extends AppController {

    var $paginate = array (
        'direction' => 'DESC',
        'limit' => 10,
    );

    function beforeFilter () {
        if(isset($_SESSION['idioma']) && !empty($_SESSION['idioma'])){
            $idioma = $_SESSION['idioma'];
            Configure::write('Config.language', $idioma);
        }

        $this->Auth->allow ('view','createProjectFromBase');
		
        parent::beforeFilter ();

    }

    

    

    function admin_index ($id=NULL) {
		$base_categories = $this->Predefinido->Category->generatetreelist (null, null, null, " - ");
        foreach ($base_categories as $key => $category) {
            $base_categories[$key] = __ ('CATEGORY_' . up ($category), true);
        }
		if(!empty($id)){
			App::import('model', 'Predefinido');
			$pp=new Predefinido();
			$datos=$pp->query("select * from predefinidos where id='$id'");
			$pred=array();
			foreach($datos as $v){
				$pred[]=$v['predefinidos'];
			}
			$this->set ('proyectoPredefinido', $pred);
			App::import('model', 'Prize');
			$pp=new Prize();
			$datos=$pp->query("select * from prizes where model='Predefinido' and model_id='$id' and ente='P' order by value asc");
			$pers=array();
			foreach($datos as $v){
				$pers[]=$v['prizes'];
			}
			$this->set ('pers', $pers);
			$datos=$pp->query("select * from prizes where model='Predefinido' and model_id='$id' and ente='E' order by value asc");
			$empr=array();
			foreach($datos as $v){
				$empr[]=$v['prizes'];
			}
			$this->set ('empr', $empr);
		}
        $this->set ('base_categories',$base_categories);
		$this->set ('nobreadcrumb', 1);
		$this->set('tituloadmin','Proyectos predefinidos');
		$this->render('/predefinidos/admin_predefinidos');
		
    }
	
	function view($id,$title){
		 App::import('model', 'Predefinido');
		 $pp=new Predefinido();
		 $datos=$pp->query("select * from predefinidos where id='$id'");
		 if(!$datos[0]){
			$this->pageError = array ('code' => 404);
		 }
		 
		 $pred=array();
		 foreach($datos as $v){
		     $pred[]=$v['predefinidos'];
		 }
		 
		 
		 $base_categories = $this->Predefinido->Category->generatetreelist (null, null, null, " - ");
		 $keys_categories=array();
         foreach ($base_categories as $key => $category) {
			 $keys_categories[$key]=trim(str_replace('- ','',$category));
             $base_categories[$key] = __ ('CATEGORY_' . up ($category), true);
         }
		 
		 App::import('model', 'Prize');
			$pp=new Prize();
			$datos=$pp->query("select * from prizes where model='Predefinido' and model_id='$id' order by value asc");
			$pers=array();
			foreach($datos as $v){
				$pers[]=$v['prizes'];
			}
			$this->set ('prizes', $pers);
		
		    App::import('model', 'Project');
			$pp=new Project();
			$datos=$pp->query("select count(*) as cant from projects where plantillaid='$id' and enabled=1 and public=1 ");
			$q=$datos[0][0]['cant'];
			
		 $this->set ('q',$q);
		 $this->set ('base_categories',$base_categories);
		 $this->set ('keys_categories',$keys_categories);
		 $this->data= $pred[0];
		 $this->render('/predefinidos/view');
	}
	
	function admin_list(){
		App::import('model', 'Predefinido');
		$pp=new Predefinido();
		$datos=$pp->query("select * from predefinidos order by id desc");
		$pred=array();
		foreach($datos as $v){
			$pred[]=$v['predefinidos'];
		}
		$this->set ('proyectoPredefinido', $pred);
		$this->set ('nobreadcrumb', 1);
		$this->set('tituloadmin','Proyectos predefinidos');
		$this->render('/predefinidos/admin_list');
	}
	function createProjectFromBase($baseId){
		 App::import('model', 'Predefinido');
		 $pp=new Predefinido();
		 $datos=$pp->query("select * from predefinidos where id='$baseId'");
		 if(!$datos[0]){
			$this->pageError = array ('code' => 404);
		 }
		 
		 $pred=array();
		 foreach($datos as $v){
		     $pred[]=$v['predefinidos'];
		 }
		 $this->Session->write('predefinido', $pred[0]);
		    App::import('model', 'Prize');
			$pp=new Prize();
			$datos=$pp->query("select * from prizes where model='Predefinido' and model_id='$baseId' order by value asc");
			$pers=array();
			foreach($datos as $v){
				$pers[]=$v['prizes'];
			}
		 $this->Session->write('priz', $pers);
		 
		 header("Location:/projects/add");
	}
   

}

?>
