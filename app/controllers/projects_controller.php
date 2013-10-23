<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * @property Project $Project
 */
class ProjectsController extends AppController {
    var $helpers = array ('Session');

    var $components = array ('Auth','Session');

    var $paginate = array (
        'direction' => 'DESC',
        'limit' => 10,
    );

    function beforeFilter () {
        if(isset($_SESSION['idioma']) && !empty($_SESSION['idioma'])){
            $idioma = $_SESSION['idioma'];
            Configure::write('Config.language', $idioma);

        }
        $this->Auth->allow ('view', 'listing', 'index', 'cron_aboutToFinish', 'cron_Finished','verifyPrivate','adminuploadimage', 'show_projects','editprojects','testcropadmin','general_search','search_category','delete_sponsor');
		if (!$this->Auth->user() && $this->params['url']['url']=='projects/add') {
			$_SESSION['VOLVER']='/projects/add';
			header("Location:/signup");
			 exit;
		}else{
			if(isset($_SESSION['VOLVER'])){
				 $_SESSION['VOLVER']=0;
				 unset($_SESSION['VOLVER']);
			 }
		}
        parent::beforeFilter ();

    }

    function beforeRender () {
        $base_money = array (
            '0-1000' => __ ('LESS_THAN_1000', true),
            '1000-5000' => __ ('FROM_1000_TO_5000', true),
            '5000-10000' => __ ('FROM_5000_TO_10000', true),
            '10000-20000' => __ ('FROM_10000_TO_20000', true),
            '20000' => __ ('20000_OR_MORE', true),
        );

        $base_prizes = array (
            10 => 10,
            15 => 15,
            20 => 20,
            25 => 25,
            30 => 30,
            35 => 35,
            40 => 40,
            45 => 45,
            50 => 50,
            50 => 50,
            55 => 55,
            60 => 60,
            65 => 65,
            70 => 70,
            75 => 75,
            100 => 100,
            150 => 150,
            200 => 200,
            250 => 250,
            300 => 300,
            350 => 350,
            400 => 400,
            450 => 450,
            500 => 500,
            550 => 550,
            600 => 600,
            650 => 650,
            700 => 700,
            750 => 750,
            800 => 800,
            850 => 850,
            900 => 900,
            1000 => 1000,
            1500 => 1500,
            2000 => 2000,
        );
        $base_categories = $this->Project->Category->generatetreelist (null, null, null, " - ");
        foreach ($base_categories as $key => $category) {
            $base_categories[$key] = __ ('CATEGORY_' . up ($category), true);
        }
        $this->set (compact ('base_money', 'base_categories', 'base_prizes'));

        parent::beforeRender ();

    }

    // PROJECT_APPROVED
    function admin_approve ($projectId=null, $paymentType=EXPRESSCHECKOUT) {


        $approveLevel = 'Project.status.accepted';


        $referer = $this->referer () != '/' ? $this->referer () : '/admin/projects/view/' . $projectId;


        $this->data = $this->Project->find ('first', array ('contain' => array (), 'conditions' => array ('id' => $projectId)));



        if ($this->data) {
            if ($this->data['Project']['enabled'] == IS_DISABLED) { //accepted
                $this->data['Project'] = am ($this->data['Project'], Configure::read ($approveLevel));

                $this->data['Project']['payment_type'] = $paymentType;

                $url_to = "media/filter/";

                /*Todas las img se guardan con .png*/

                $new_image_name = explode(".",$this->data['Project']['basename']);

                foreach(Configure::read ('ImgSize.filter.image') as $key=>$value){
                    $dir = new Folder($url_to.$value."/project/".$this->data['Project']['id'], true);
                    if(is_dir($url_to.$value."/project/".$this->data['Project']['id'])){
                        $img_path = new Folder($url_to.$value."/project/".$this->data['Project']['id']."/img/", true);
                        $file = new File($url_to.$value."/project/tmp/img/".$new_image_name[0].".png", false, 0644);
                        if ($file->exists()) {
                            $file->copy($url_to.$value."/project/".$this->data['Project']['id']."/img" . DS . $file->name);
                        }
                    }
                }

                debug ($this->data);

                $this->data['Project']['dirname'] = "project/".$this->data['Project']['id']."/img";

                if ($this->Project->save ($this->data, false)) {

                    $project = $this->Project->find (array ('Project.id' => $projectId));

                    if (!$this->Project->User->Notification->add (
                                    'PROJECT_APPROVED'
                                    , $project
                                    , $project['Project']['user_id']
                            )
                    ) {
                        $this->log ('Error : notification not saved ', 'NOTIFICATIONS_LOG');
                    } else {
                        $this->requestAction (Router::url (array ('controller' => 'mails', 'action' => 'email', 'admin' => false, $this->Project->User->Notification->id)));
                    }
                    $this->redirect ($referer);
                }
            }
        }

        $this->render ('/common/ajax', 'ajax');

    }

    // PROJECT_REJECTED
    function admin_reject ($projectId=null) {
        $this->data = $this->Project->read (null, $projectId);
        if ($this->data) {

            if ($this->data['Project']['enabled'] == IS_DISABLED) { // rejected //
                $this->data['Project'] = am ($this->data['Project'], Configure::read ('Project.status.rejected'));


                unset ($this->data['Project']['file']);

                $this->Project->set ($this->data['Project']);


                if ($this->Project->save ($this->data, false)) {
                    if (!$this->Project->User->Notification->add (
                                    'PROJECT_REJECTED'
                                    , $this->Project->find (array ('Project.id' => $projectId))
                                    , $this->Auth->user ('id')
                            )
                    ) {
                        $this->log ('Error : notification not saved ', 'NOTIFICATIONS_LOG');
                    } else {
                        $this->requestAction (Router::url (array ('controller' => 'mails', 'action' => 'email', 'admin' => false, $this->Project->User->Notification->id)));
                    }

                    $this->redirect ('/admin/projects/view/' . $projectId);
                } else {
                    vd ('WE CAN NOT SAVE THIS');
                }
            }
        }
        $this->render ('/common/ajax', 'ajax');

    }

    function admin_view ($id = null) {
        if (!$id) {
            $this->Session->setFlash (__ ('Invalid project', true));
            $this->redirect (array ('action' => 'index'));
        }
        $this->set ('project', $this->Project->read (null, $id));

    }

    function admin_flag () {
        $ok = true;
        foreach ($this->data['Project'] as $id => $data) {
            $saveData['Project'] = $data;
            $saveData['Project']['id'] = $id;
            $ok &= $this->Project->save ($saveData, false);
        }

        $this->data = array (
            'status' => $ok
        );
        $this->render ('/common/json_response', 'json/default');

    }

    function admin_index ($filter=null) {
		
        $filter = empty ($filter) ? 'all' : $filter;
        $this->data['Project']['filter'] = $this->params['named']['filter'] = $filter;
        $this->autoPaginateOptions ('filter', array (
            'disabled' => Configure::read ('Project.filter.status.disabled'), // caso de exito
            'proposals' => Configure::read ('Project.filter.status.proposal'),
            'rejected' => Configure::read ('Project.filter.status.rejected'),
            'approved' => Configure::read ('Project.filter.status.accepted'),
            'published' => Configure::read ('Project.filter.status.published'),
            'about-to-finish' => Configure::read ('Project.filter.about-to-finish'), // caso de exito
            'finished' => Configure::read ('Project.filter.finished'), // caso de exito
            'funded' => Configure::read ('Project.filter.funded'), // caso de exito
            'not-funded' => Configure::read ('Project.filter.not-funded'), // caso de exito
            'outstanding' => Configure::read ('Project.filter.outstanding'), // show in home page
            'leading' => Configure::read ('Project.filter.leading'), // caso de exito
			'week'=>array ('Project.week =' => '1'),
            'default' => 'all'
                )
        );
        $this->autoPaginateOptions ('sort', array ('Project.id', 'Project.created', 'Project.user_id', 'Project.category_id', 'Project.title', 'Project.status'));
        $this->autoPaginateOptions ('search', array ('Project.id', 'Project.title like' => '%:value%'));
		
        $this->_preparePaginate ();
        $this->paginate['contain'] = array ('User', 'Category', 'Sponsorship');
        $this->data['results'] = $this->paginate ('Project');
		
		$this->render ('admin_index');
    }

    function add ($offerId=false) {

        App::import('Vendor','upload');
        $this->loadModel('Country');


        $base_countries = $this->Country->find('all');
        $this->set (compact ('base_countries'));
		$predefinido=0;
		if($this->Session->check('predefinido')){
			$predefinido=1;
			$pred=$this->Session->read('predefinido');
			
		}
				
		if($predefinido){
			unset($this->Project->validate['file']);
			if(!$this->data){
				$_POST['data']['Project']['title']=$pred['title'];
				$_POST['data']['Project']['category_id']=$pred['category_id'];
				$_POST['data']['Project']['description']=$pred['description'];
				$_POST['data']['Project']['motivation']=$pred['motivation'];
				$_POST['data']['Project']['short_description']=$pred['short_description'];
				$_POST['data']['Project']['funding_goal']=$pred['funding_goal'];
				$_POST['data']['Project']['reason']=$pred['reason'];
				$_POST['data']['Project']['moneda']=$pred['moneda'];
				$_POST['data']['Project']['project_duration']=$pred['project_duration'];
				$_POST['data']['Project']['video_url']=$pred['video'];
				$_POST['data']['Prize']=$this->Session->read('priz');
				$this->set('fotito',$pred['foto']);
			}
		}
		
		
		

        if ($offerId) {
            $offer = $this->Project->Offer->getViewData ($offerId);
            if (empty ($offer) || !Offer::isPublic ($offer)) {
                unset ($offer);
                $offerId = false;
                $this->pageError = array ('code' => 404);
            } else {
                $this->set ('offer', $offer);
            }
        }

        if ($this->data) {

            $this->data['Project'] = am ($this->data['Project'], Configure::read ('Project.status.proposal')); // set project status as proposal
            $invalid = false;

            $hasLink = count (array_unique (Set::extract ('/Link/link', $this->data))) > 1; //user has filled any link ?
            //$hasPrize = count (array_unique (Set::extract ('/Prize/value', $this->data))) > 1; //user has filled any prize ?
			$hasPrize=isset($_POST['data']['Prize']);
			
			if( ($this->data['Project']['private_pass']!=$this->data['Project']['private_pass2'] || empty($this->data['Project']['private_pass']))  &&  $this->data['Project']['private']=='1'){
				if(($this->data['Project']['private_pass']!=$this->data['Project']['private_pass2'])){
					$mjepass='La clave y su repetici&oacute;n no coinciden';
				}
				if( empty($this->data['Project']['private_pass'])){
					$mjepass='Debe definir una clave para los proyectos privados';
				}
				$privatepassko=1;
			}else{
				$privatepassko=0;
			}
			
			if($predefinido){
				$hasLink=1;
				$this->data['Project']['plantillaid']=$pred['id'];
			}
            $invalid = $invalid || !$hasLink || !$hasPrize || $privatepassko;


            $cambio_path_image= str_replace('\\','/',WWW_ROOT);
            $this->data['Project']['dirname']='project/tmp/img';
            $this->data['Project']['basename']=$_POST['data']['Project']['country'];
            $this->data['Project']['file']=$cambio_path_image.'media/transfer/project/tmp/img/'.$_POST['data']['Project']['country'];
/*echo '<pre>';
var_dump($this->data);die;*/
            if ($this->Project->saveAll ($this->data, array ('validate' => 'only')) && !$invalid) {

                $this->Project->saveAll ($this->data);

                if (!empty ($this->data['Project']['video_url'])) {

                }


                if ($this->Project->id) {


					if($predefinido && isset($pred['foto']) && strlen($pred['foto'])>4 && (!isset($_FILES['data']['name']['Project']['file']) || $_FILES['data']['name']['Project']['file']=='') ){

						$picname='____'.md5(time()).rand(0,99999).'.png';
						$this->data['Project']['dirname']='project/'.$this->Project->id.'/img';
						$this->data['Project']['basename']=$picname;
						$this->data['Project']['id']=$this->Project->id;
						mkdir ( 'media/filter/l560/project/'.$this->Project->id ,0777, false );
						mkdir ( 'media/filter/l560/project/'.$this->Project->id.'/img' ,0777, false );
						$content=implode('',file($pred['foto']));
						file_put_contents('media/filter/l560/project/'.$this->Project->id.'/img/'.$picname,$content);
						mkdir ( 'media/filter/l280/project/'.$this->Project->id ,0777, false );
						mkdir ( 'media/filter/l280/project/'.$this->Project->id.'/img' ,0777, false );
						$this->resize($pred['foto'],280,600,'media/filter/l280/project/'.$this->Project->id.'/img/'.$picname);
						
						App::import('model', 'Project');
						$pp=new Project();
						$datos=$pp->query("update projects set dirname='".$this->data['Project']['dirname']."',basename='".$picname."' where id='".$this->Project->id."'");
						$this->Session->delete('priz');
						$this->Session->delete('predefinido');
                        $this->Image = $this->Components->load("Image");

                        $this->request->$_FILES['data']['name']['Project']['file'] = $this->upload($this->request->$_FILES['data']['name']['Project']['file']);
                        $this->Image->copia_optimizada('media/filter/l560/project/'.$this->Project->id.'/img',280,600);
                        $this->Image->borrar_tmp();
					}
					
					

                    if (!$this->Project->User->Notification->add (//PROJECT_PENDING_APPROVE
                                    'PROJECT_PENDING_APPROVE'
                                    , $this->Project->find (array ('Project.id' => $this->Project->id))
                                    , $this->Auth->user ('id')
                            )
                    ) {
                        $this->log ('Error : notification not saved ', 'NOTIFICATIONS_LOG');
                    } else {
                        $this->requestAction (Router::url (array ('controller' => 'mails', 'action' => 'email', 'admin' => false, $this->Project->User->Notification->id)));
                    }




                    $this->redirect (array ('controller' => 'projects', 'action' => 'listing', 'user' => User::getSlug ($this->Auth->user ())));
                } else {
                    $this->log ('Error : PROJECT not saved ');
                }
            }


            if (!$hasPrize) {
                $this->Project->invalidate ('prize', __ ('AT_LEAST_ONE_PRIZE', true));
            }

            if (!$hasLink) {
                $this->Project->invalidate ('link', __ ('AT_LEAST_ONE_LINK', true));
            }
        } else {
            $this->data['Project']['project_duration'] = 7;
        }
        // $this->data[] ;

        $this->set ('offerId', $offerId);
		  $mas=array();
		 if($this->data && $this->data['Project']['user_id']) {
			 if($privatepassko==1){
				 $mas=array('private'=>$mjepass);

			 }
			 //if(isset($mas)&& !empty($mas)){

                 $this->set('validationErrorsArray', array_merge($mas,$this->Project->invalidFields()));
             //}

			/*echo '<pre>';
			var_dump($mas);die;*/
		 }
		 
    }

    function testcrop(){


        /*
        * Copyright (c) 2008 http://www.webmotionuk.com / http://www.webmotionuk.co.uk
        * "Jquery image upload & crop for php"
        * Date: 2008-11-21
        * Ver 1.0
        * Redistributions of source code must retain the above copyright notice, this list of conditions and the following disclaimer.
        * Redistributions in binary form must reproduce the above copyright notice, this list of conditions and the following disclaimer in the documentation and/or other materials provided with the distribution.
        *
        * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS" AND
        * ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE IMPLIED
        * WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE ARE DISCLAIMED.
        * IN NO EVENT SHALL THE COPYRIGHT OWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT,
        * INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT LIMITED TO,
        * PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE, DATA, OR PROFITS; OR BUSINESS
        * INTERRUPTION) HOWEVER CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT,
        * STRICT LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF
        * THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
        *
        * http://www.opensource.org/licenses/bsd-license.php
        */
#########################################################################################################
# CONSTANTS																								#
# You can alter the options below																		#
#########################################################################################################
        //$_FILES['data']['name']['Project']['file'] = $_FILES;

        //var_dump($_FILES);
        if (isset($_GET['s'])&& $_GET['s']==1){
            $upload_dir = "../webroot/upload_sponsors";
        }
         				else{
                $upload_dir = "../webroot/media/transfer/project/tmp/img";

                         }// The directory for the images to be saved in
        $upload_path = $upload_dir."/";				// The path to where the image will be saved
//$image_handling_file = "vendors/crop/image_handling.php"; // The location of the file that will handle the upload and resizing (RELATIVE PATH ONLY!)
        $large_image_prefix = "resize_"; 			// The prefix name to large image
        $thumb_image_prefix = "thumbnail_";			// The prefix name to the thumb image
        $large_image_name = $large_image_prefix.$_SESSION['random_key'];     // New name of the large image (append the timestamp to the filename)
        $thumb_image_name = $thumb_image_prefix.$_SESSION['random_key'];     // New name of the thumbnail image (append the timestamp to the filename)
        $max_file = "1"; 							// Maximum file size in MB
        $max_width = "650";							// Max width allowed for the large image
        $thumb_width = "200";						// Width of thumbnail image
        $thumb_height = "130";						// Height of thumbnail image
// Only one of these image types should be allowed for upload
        $allowed_image_types = array('image/pjpeg'=>"jpg",'image/jpeg'=>"jpg",'image/jpg'=>"jpg",'image/png'=>"png",'image/x-png'=>"png",'image/gif'=>"gif");
        $allowed_image_ext = array_unique($allowed_image_types); // Do not change this
        $image_ext = "";
        foreach ($allowed_image_ext as $mime_type => $ext) {
            $image_ext.= strtoupper($ext)." ";
        }


##########################################################################################################
# IMAGE FUNCTIONS																						 #
# You do not need to alter these functions																 #
##########################################################################################################
        function resizeImage($image,$width,$height,$scale) {
            $image_data = getimagesize($image);
            $imageType = image_type_to_mime_type($image_data[2]);
            $newImageWidth = ceil($width * $scale);
            $newImageHeight = ceil($height * $scale);
            $newImage = imagecreatetruecolor($newImageWidth,$newImageHeight);
            switch($imageType) {
                case "image/gif":
                    $source=imagecreatefromgif($image);
                    break;
                case "image/pjpeg":
                case "image/jpeg":
                case "image/jpg":
                    $source=imagecreatefromjpeg($image);
                    break;
                case "image/png":
                case "image/x-png":
                    $source=imagecreatefrompng($image);
                    break;
            }
            imagecopyresampled($newImage,$source,0,0,0,0,$newImageWidth,$newImageHeight,$width,$height);

            switch($imageType) {
                case "image/gif":
                    imagegif($newImage,$image);
                    break;
                case "image/pjpeg":
                case "image/jpeg":
                case "image/jpg":
                    imagejpeg($newImage,$image,90);
                    break;
                case "image/png":
                case "image/x-png":
                    imagepng($newImage,$image);
                    break;
            }

            chmod($image, 0777);
            return $image;
        }
//You do not need to alter these functions
        function resizeThumbnailImage($thumb_image_name, $image, $width, $height, $start_width, $start_height, $scale){
            list($imagewidth, $imageheight, $imageType) = getimagesize($image);
            $imageType = image_type_to_mime_type($imageType);

            $newImageWidth = ceil($width * $scale);
            $newImageHeight = ceil($height * $scale);
            $newImage = imagecreatetruecolor($newImageWidth,$newImageHeight);
            switch($imageType) {
                case "image/gif":
                    $source=imagecreatefromgif($image);
                    break;
                case "image/pjpeg":
                case "image/jpeg":
                case "image/jpg":
                    $source=imagecreatefromjpeg($image);
                    break;
                case "image/png":
                case "image/x-png":
                    $source=imagecreatefrompng($image);
                    break;
            }
            imagecopyresampled($newImage,$source,0,0,$start_width,$start_height,$newImageWidth,$newImageHeight,$width,$height);
            switch($imageType) {
                case "image/gif":
                    imagegif($newImage,$thumb_image_name);
                    break;
                case "image/pjpeg":
                case "image/jpeg":
                case "image/jpg":
                    imagejpeg($newImage,$thumb_image_name,90);
                    break;
                case "image/png":
                case "image/x-png":
                    imagepng($newImage,$thumb_image_name);
                    break;
            }
            chmod($thumb_image_name, 0777);
            return $thumb_image_name;
        }
//You do not need to alter these functions
        function getHeight($image) {
            $size = getimagesize($image);
            $height = $size[1];
            return $height;
        }
//You do not need to alter these functions
        function getWidth($image) {
            $size = getimagesize($image);
            $width = $size[0];
            return $width;
        }

//Image Locations
        $large_image_location = $upload_path.$large_image_name;
        $thumb_image_location = $upload_path.$thumb_image_name;


//Create the upload directory with the right permissions if it doesn't exist
        if(!is_dir($upload_dir)){
            mkdir($upload_dir, 0777);
            chmod($upload_dir, 0777);
        }


        error_reporting (E_ALL ^ E_NOTICE);
        /*
        * Copyright (c) 2008 http://www.webmotionuk.com / http://www.webmotionuk.co.uk
        * "Jquery image upload & crop for php"
        * Date: 2008-11-21
        * Ver 1.0
        * Redistributions of source code must retain the above copyright notice, this list of conditions and the following disclaimer.
        * Redistributions in binary form must reproduce the above copyright notice, this list of conditions and the following disclaimer in the documentation and/or other materials provided with the distribution.
        *
        * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS" AND
        * ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE IMPLIED
        * WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE ARE DISCLAIMED.
        * IN NO EVENT SHALL THE COPYRIGHT OWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT,
        * INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT LIMITED TO,
        * PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE, DATA, OR PROFITS; OR BUSINESS
        * INTERRUPTION) HOWEVER CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT,
        * STRICT LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF
        * THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
        *
        * http://www.opensource.org/licenses/bsd-license.php
        */
#################################################################################################
#	IMAGE FUNCTIONS FILE  - Adjust directory as required									   	#
#	Please also adjust the directory to this file in the "index.php" page						#
        //include("vendors/crop/image_functions.php"); 									#
#################################################################################################

########################################################
#	UPLOAD THE IMAGE								   #
########################################################
        if ($_POST["upload"]=="Upload") {
            //Get the file information
            $userfile_name = $_FILES['image']['name'];
            $userfile_tmp = $_FILES['image']['tmp_name'];
            $userfile_size = $_FILES['image']['size'];
            $userfile_type = $_FILES['image']['type'];
            $filename = basename($_FILES['image']['name']);
            $file_ext = strtolower(substr($filename, strrpos($filename, '.') + 1));

            //Only process if the file is a JPG and below the allowed limit
            if((!empty($_FILES["image"])) && ($_FILES['image']['error'] == 0)) {

                foreach ($allowed_image_types as $mime_type => $ext) {
                    //loop through the specified image types and if they match the extension then break out
                    //everything is ok so go and check file size
                    if($file_ext==$ext && $userfile_type==$mime_type){
                        $error = "";
                        break;
                    }else{
                        $error = "Only <strong>".$image_ext."</strong> images accepted for upload<br />";
                    }
                }
                //check if the file size is above the allowed limit
                if ($userfile_size > ($max_file*3048576)) {
                    $error.= "Images must be under ".$max_file."MB in size";
                }

            }else{
                $error= "Please select an image for upload";
            }
            //Everything is ok, so we can upload the image.
            if (strlen($error)==0){

                if (isset($_FILES['image']['name'])){
                    //this file could now has an unknown file extension (we hope it's one of the ones set above!)
                    $large_image_location = $large_image_location.".".$file_ext;
                    $thumb_image_location = $thumb_image_location.".".$file_ext;

                    //put the file ext in the session so we know what file to look for once its uploaded
                    if($_SESSION['user_file_ext']!=$file_ext){
                        $_SESSION['user_file_ext']="";
                        $_SESSION['user_file_ext']=".".$file_ext;
                    }

                    move_uploaded_file($userfile_tmp, $large_image_location);
                    chmod($large_image_location, 0777);

                    $width = getWidth($large_image_location);
                    $height = getHeight($large_image_location);
                    //Scale the image if it is greater than the width set above
                    if ($width > $max_width){
                        $scale = $max_width/$width;
                        $uploaded = resizeImage($large_image_location,$width,$height,$scale);
                    }else{
                        $scale = 1;
                        $uploaded = resizeImage($large_image_location,$width,$height,$scale);
                    }
                    //Delete the thumbnail file so the user can create a new one
                    if (file_exists($thumb_image_location)) {
                        unlink($thumb_image_location);
                    }
                    $json = array('regular' => array("ubicacion"=>$large_image_location,"width"=>getWidth($large_image_location), "height"=>getHeight($large_image_location)),'thumbs' => array("ubicacion"=>$thumb_image_location,"width"=>getWidth($thumb_image_location), "height"=>getHeight($thumb_image_location)));
                    echo json_encode($json);

                    //echo "success|".$large_image_location."|".getWidth($large_image_location)."|".getHeight($large_image_location)."|".$thumb_image_location;
                }
            }else{
                echo "error|".$error;
            }
        }

########################################################
#	CREATE THE THUMBNAIL							   #
########################################################
        if ($_POST["save_thumb"]=="Save Thumbnail") {

            //Get the new coordinates to crop the image.
            $x1 = $_POST["x1"];
            $y1 = $_POST["y1"];
            $x2 = $_POST["x2"];
            $y2 = $_POST["y2"];
            $w = $_POST["w"];
            $h = $_POST["h"];
            //Scale the image to the thumb_width set above
            $large_image_location = $large_image_location.$_SESSION['user_file_ext'];
            $thumb_image_location = $thumb_image_location.$_SESSION['user_file_ext'];
            $scale = $thumb_width/$w;
            if (isset($_POST['s'])&& $_POST['s']==1){


                $cropped1 = resizeThumbnailImage('../webroot/upload_sponsors/'.$thumb_image_prefix.$_SESSION['random_key'].'.png', $large_image_location,280,210,$x1,$y1,1);

            }else{
            $cropped = resizeThumbnailImage($thumb_image_location, $large_image_location,$w,$h,$x1,$y1,$scale);
            $cropped1 = resizeThumbnailImage('../webroot/media/filter/l280/project/tmp/img/'.$thumb_image_prefix.$_SESSION['random_key'].'.png', $large_image_location,280,210,$x1,$y1,1);
            $cropped2 = resizeThumbnailImage('../webroot/media/filter/l560/project/tmp/img/'.$thumb_image_prefix.$_SESSION['random_key'].'.png', $large_image_location,560,420,$x1,$y1,1);
            $cropped3 = resizeThumbnailImage('../webroot/media/filter/m156/project/tmp/img/'.$thumb_image_prefix.$_SESSION['random_key'].'.png', $large_image_location,156,104,$x1,$y1,1);
            $cropped4 = resizeThumbnailImage('../webroot/media/filter/m188/project/tmp/img/'.$thumb_image_prefix.$_SESSION['random_key'].'.png', $large_image_location,188,141,$x1,$y1,1);
            $cropped5 = resizeThumbnailImage('../webroot/media/filter/m200/project/tmp/img/'.$thumb_image_prefix.$_SESSION['random_key'].'.png', $large_image_location,200,200,$x1,$y1,1);
            $cropped6 = resizeThumbnailImage('../webroot/media/filter/s30/project/tmp/img/'.$thumb_image_prefix.$_SESSION['random_key'].'.png', $large_image_location,30,30,$x1,$y1,1);
            $cropped7 = resizeThumbnailImage('../webroot/media/filter/s31/project/tmp/img/'.$thumb_image_prefix.$_SESSION['random_key'].'.png', $large_image_location,31,31,$x1,$y1,1);
            $cropped8 = resizeThumbnailImage('../webroot/media/filter/s50/project/tmp/img/'.$thumb_image_prefix.$_SESSION['random_key'].'.png', $large_image_location,50,50,$x1,$y1,1);
            $cropped9 = resizeThumbnailImage('../webroot/media/filter/s64/project/tmp/img/'.$thumb_image_prefix.$_SESSION['random_key'].'.png', $large_image_location,64,64,$x1,$y1,1);
            }

            echo "success|".$large_image_location."|".$thumb_image_location;
            $_SESSION['random_key']= "";
            $_SESSION['user_file_ext']= "";
        }

#####################################################
#	DELETE BOTH IMAGES								#
#####################################################
        if ($_POST['a']=="delete" && strlen($_POST['large_image'])>0 && strlen($_POST['thumbnail_image'])>0){
//get the file locations
            $large_image_location = $_POST['large_image'];
            $thumb_image_location = $_POST['thumbnail_image'];
            if (file_exists($large_image_location)) {
                unlink($large_image_location);
            }
            if (file_exists($thumb_image_location)) {
                unlink($thumb_image_location);
            }
            echo "success|Files have been deleted";
        }
        $this->autoRender=false;

    }

    function testcropadmin(){


        /*
        * Copyright (c) 2008 http://www.webmotionuk.com / http://www.webmotionuk.co.uk
        * "Jquery image upload & crop for php"
        * Date: 2008-11-21
        * Ver 1.0
        * Redistributions of source code must retain the above copyright notice, this list of conditions and the following disclaimer.
        * Redistributions in binary form must reproduce the above copyright notice, this list of conditions and the following disclaimer in the documentation and/or other materials provided with the distribution.
        *
        * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS" AND
        * ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE IMPLIED
        * WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE ARE DISCLAIMED.
        * IN NO EVENT SHALL THE COPYRIGHT OWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT,
        * INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT LIMITED TO,
        * PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE, DATA, OR PROFITS; OR BUSINESS
        * INTERRUPTION) HOWEVER CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT,
        * STRICT LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF
        * THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
        *
        * http://www.opensource.org/licenses/bsd-license.php
        */
#########################################################################################################
# CONSTANTS																								#
# You can alter the options below																		#
#########################################################################################################
        //$_FILES['data']['name']['Project']['file'] = $_FILES;

        //var_dump($_FILES);

            $upload_dir = "../webroot/upload_sponsors";

        $upload_path = $upload_dir."/";				// The path to where the image will be saved
//$image_handling_file = "vendors/crop/image_handling.php"; // The location of the file that will handle the upload and resizing (RELATIVE PATH ONLY!)
        $large_image_prefix = "resize_"; 			// The prefix name to large image
        $thumb_image_prefix = "thumbnail_";			// The prefix name to the thumb image
        $large_image_name = $large_image_prefix.$_SESSION['random_key'];     // New name of the large image (append the timestamp to the filename)
        $thumb_image_name = $thumb_image_prefix.$_SESSION['random_key'];     // New name of the thumbnail image (append the timestamp to the filename)
        $max_file = "1"; 							// Maximum file size in MB
        $max_width = "500";							// Max width allowed for the large image
        $thumb_width = "250";						// Width of thumbnail image
        $thumb_height = "100";						// Height of thumbnail image
// Only one of these image types should be allowed for upload
        $allowed_image_types = array('image/pjpeg'=>"jpg",'image/jpeg'=>"jpg",'image/jpg'=>"jpg",'image/png'=>"png",'image/x-png'=>"png",'image/gif'=>"gif");
        $allowed_image_ext = array_unique($allowed_image_types); // Do not change this
        $image_ext = "";
        foreach ($allowed_image_ext as $mime_type => $ext) {
            $image_ext.= strtoupper($ext)." ";
        }


##########################################################################################################
# IMAGE FUNCTIONS																						 #
# You do not need to alter these functions																 #
##########################################################################################################
        function resizeImage($image,$width,$height,$scale) {
            $image_data = getimagesize($image);
            $imageType = image_type_to_mime_type($image_data[2]);
            $newImageWidth = ceil($width * $scale);
            $newImageHeight = ceil($height * $scale);
            $newImage = imagecreatetruecolor($newImageWidth,$newImageHeight);
            switch($imageType) {
                case "image/gif":
                    $source=imagecreatefromgif($image);
                    break;
                case "image/pjpeg":
                case "image/jpeg":
                case "image/jpg":
                    $source=imagecreatefromjpeg($image);
                    break;
                case "image/png":
                case "image/x-png":
                    $source=imagecreatefrompng($image);
                    break;
            }
            imagecopyresampled($newImage,$source,0,0,0,0,$newImageWidth,$newImageHeight,$width,$height);

            switch($imageType) {
                case "image/gif":
                    imagegif($newImage,$image);
                    break;
                case "image/pjpeg":
                case "image/jpeg":
                case "image/jpg":
                    imagejpeg($newImage,$image,90);
                    break;
                case "image/png":
                case "image/x-png":
                    imagepng($newImage,$image);
                    break;
            }

            chmod($image, 0777);
            return $image;
        }
//You do not need to alter these functions
        function resizeThumbnailImage($thumb_image_name, $image, $width, $height, $start_width, $start_height, $scale){
            list($imagewidth, $imageheight, $imageType) = getimagesize($image);
            $imageType = image_type_to_mime_type($imageType);

            $newImageWidth = ceil($width * $scale);
            $newImageHeight = ceil($height * $scale);
            $newImage = imagecreatetruecolor($newImageWidth,$newImageHeight);
            switch($imageType) {
                case "image/gif":
                    $source=imagecreatefromgif($image);
                    break;
                case "image/pjpeg":
                case "image/jpeg":
                case "image/jpg":
                    $source=imagecreatefromjpeg($image);
                    break;
                case "image/png":
                case "image/x-png":
                    $source=imagecreatefrompng($image);
                    break;
            }
            imagecopyresampled($newImage,$source,0,0,$start_width,$start_height,$newImageWidth,$newImageHeight,$width,$height);
            switch($imageType) {
                case "image/gif":
                    imagegif($newImage,$thumb_image_name);
                    break;
                case "image/pjpeg":
                case "image/jpeg":
                case "image/jpg":
                    imagejpeg($newImage,$thumb_image_name,90);
                    break;
                case "image/png":
                case "image/x-png":
                    imagepng($newImage,$thumb_image_name);
                    break;
            }
            chmod($thumb_image_name, 0777);
            return $thumb_image_name;
        }
//You do not need to alter these functions
        function getHeight($image) {
            $size = getimagesize($image);
            $height = $size[1];
            return $height;
        }
//You do not need to alter these functions
        function getWidth($image) {
            $size = getimagesize($image);
            $width = $size[0];
            return $width;
        }

//Image Locations
        $large_image_location = $upload_path.$large_image_name;
        $thumb_image_location = $upload_path.$thumb_image_name;


//Create the upload directory with the right permissions if it doesn't exist
        if(!is_dir($upload_dir)){
            mkdir($upload_dir, 0777);
            chmod($upload_dir, 0777);
        }


        error_reporting (E_ALL ^ E_NOTICE);
        /*
        * Copyright (c) 2008 http://www.webmotionuk.com / http://www.webmotionuk.co.uk
        * "Jquery image upload & crop for php"
        * Date: 2008-11-21
        * Ver 1.0
        * Redistributions of source code must retain the above copyright notice, this list of conditions and the following disclaimer.
        * Redistributions in binary form must reproduce the above copyright notice, this list of conditions and the following disclaimer in the documentation and/or other materials provided with the distribution.
        *
        * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS" AND
        * ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE IMPLIED
        * WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE ARE DISCLAIMED.
        * IN NO EVENT SHALL THE COPYRIGHT OWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT,
        * INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT LIMITED TO,
        * PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE, DATA, OR PROFITS; OR BUSINESS
        * INTERRUPTION) HOWEVER CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT,
        * STRICT LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF
        * THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
        *
        * http://www.opensource.org/licenses/bsd-license.php
        */
#################################################################################################
#	IMAGE FUNCTIONS FILE  - Adjust directory as required									   	#
#	Please also adjust the directory to this file in the "index.php" page						#
        //include("vendors/crop/image_functions.php"); 									#
#################################################################################################

########################################################
#	UPLOAD THE IMAGE								   #
########################################################
        if ($_POST["upload"]=="Upload") {
            //Get the file information
            $userfile_name = $_FILES['image']['name'];
            $userfile_tmp = $_FILES['image']['tmp_name'];
            $userfile_size = $_FILES['image']['size'];
            $userfile_type = $_FILES['image']['type'];
            $filename = basename($_FILES['image']['name']);
            $file_ext = strtolower(substr($filename, strrpos($filename, '.') + 1));

            //Only process if the file is a JPG and below the allowed limit
            if((!empty($_FILES["image"])) && ($_FILES['image']['error'] == 0)) {

                foreach ($allowed_image_types as $mime_type => $ext) {
                    //loop through the specified image types and if they match the extension then break out
                    //everything is ok so go and check file size
                    if($file_ext==$ext && $userfile_type==$mime_type){
                        $error = "";
                        break;
                    }else{
                        $error = "Only <strong>".$image_ext."</strong> images accepted for upload<br />";
                    }
                }
                //check if the file size is above the allowed limit
                if ($userfile_size > ($max_file*3048576)) {
                    $error.= "Images must be under ".$max_file."MB in size";
                }

            }else{
                $error= "Please select an image for upload";
            }
            //Everything is ok, so we can upload the image.
            if (strlen($error)==0){

                if (isset($_FILES['image']['name'])){
                    //this file could now has an unknown file extension (we hope it's one of the ones set above!)
                    $large_image_location = $large_image_location.".".$file_ext;
                    $thumb_image_location = $thumb_image_location.".".$file_ext;

                    //put the file ext in the session so we know what file to look for once its uploaded
                    if($_SESSION['user_file_ext']!=$file_ext){
                        $_SESSION['user_file_ext']="";
                        $_SESSION['user_file_ext']=".".$file_ext;
                    }

                    move_uploaded_file($userfile_tmp, $large_image_location);
                    chmod($large_image_location, 0777);

                    $width = getWidth($large_image_location);
                    $height = getHeight($large_image_location);
                    //Scale the image if it is greater than the width set above
                    if ($width > $max_width){
                        $scale = $max_width/$width;
                        $uploaded = resizeImage($large_image_location,$width,$height,$scale);
                    }else{
                        $scale = 1;
                        $uploaded = resizeImage($large_image_location,$width,$height,$scale);
                    }
                    //Delete the thumbnail file so the user can create a new one
                    if (file_exists($thumb_image_location)) {
                        unlink($thumb_image_location);
                    }
                    $json = array('regular' => array("ubicacion"=>$large_image_location,"width"=>getWidth($large_image_location), "height"=>getHeight($large_image_location)),'thumbs' => array("ubicacion"=>$thumb_image_location,"width"=>getWidth($thumb_image_location), "height"=>getHeight($thumb_image_location)));
                    echo json_encode($json);

                    //echo "success|".$large_image_location."|".getWidth($large_image_location)."|".getHeight($large_image_location)."|".$thumb_image_location;
                }
            }else{
                echo "error|".$error;
            }
        }

########################################################
#	CREATE THE THUMBNAIL							   #
########################################################
        if ($_POST["save_thumb"]=="Save Thumbnail") {

            //Get the new coordinates to crop the image.
            $x1 = $_POST["x1"];
            $y1 = $_POST["y1"];
            $x2 = $_POST["x2"];
            $y2 = $_POST["y2"];
            $w = $_POST["w"];
            $h = $_POST["h"];
            //Scale the image to the thumb_width set above
            $large_image_location = $large_image_location.$_SESSION['user_file_ext'];
            $thumb_image_location = $thumb_image_location.$_SESSION['user_file_ext'];
            $scale = $thumb_width/$w;



                $cropped1 = resizeThumbnailImage('../webroot/upload_sponsors/'.$thumb_image_prefix.$_SESSION['random_key'].'.png', $large_image_location,336,121,$x1,$y1,1);


            echo "success|".$large_image_location."|".$thumb_image_location;
            $_SESSION['random_key']= "";
            $_SESSION['user_file_ext']= "";
        }

#####################################################
#	DELETE BOTH IMAGES								#
#####################################################
        if ($_POST['a']=="delete" && strlen($_POST['large_image'])>0 && strlen($_POST['thumbnail_image'])>0){
//get the file locations
            $large_image_location = $_POST['large_image'];
            $thumb_image_location = $_POST['thumbnail_image'];
            if (file_exists($large_image_location)) {
                unlink($large_image_location);
            }
            if (file_exists($thumb_image_location)) {
                unlink($thumb_image_location);
            }
            echo "success|Files have been deleted";
        }
        $this->autoRender=false;
        //$this->redirect(array('controller' => 'projects', 'action' => 'index', 'admin' => true));
    }

    function associateWithPaypal ($projectId, $operation='set') {
        App::import ('Vendor', 'paypal');
        $this->Paypal = new Paypal();
        if (isset ($this->params['url']['token'])) {
            if ($operation == 'return') {
                $paypalResponse = $this->Paypal->hashCall ('GetAuthDetails', array (
                    'TOKEN' => $this->params['url']['token'],
                        )
                );
                $this->Project->recursive = -1;
                $this->data = $this->Project->read (null, $projectId);
                if ($this->Paypal->checkResponse ($paypalResponse) && $this->data) {
                    $this->data['Project']['paypal_id'] = $paypalResponse['PAYERID'];
                    $this->data['Project']['paypal_email'] = $paypalResponse['EMAIL'];
                    $this->Project->save ($this->data, false);
                }
            }

            $this->redirect (Router::url (
                            array (
                                'controller' => 'projects',
                                'action' => 'edit',
                                $projectId
                            )
                    )
            );
        }
        $this->render ('/common/ajax', 'ajax');

    }

    function admin_not_finance_project ($project_id) {

        // $this->Project->Sponsorship->refound_project($project_id); // cancel and refound all sponsorships.

        $query['conditions'] = array (
            'Sponsorship.project_id' => $project_id,
            'Sponsorship.payment_type' => PREAPPROVAL,
            'Sponsorship.preapproval_approved' => 1
        );

        $this->data['preapprovals'] = $this->Project->Sponsorship->find ('all', $query);

        $query['conditions'] = array (
            'Sponsorship.project_id' => $project_id,
            'Sponsorship.payment_type' => EXPRESSCHECKOUT,
            'Sponsorship.transferred' => 1
        );


        $this->data['expresscheckouts'] = $this->Project->Sponsorship->find ('all', $query);

    }

    /*
     * - Tranfer founds to groofi account
     * - Get founding total for project
     *
     */

    // tranfer all founds to groofi account
    function admin_tranfer_founds ($project_id, $returnTotal=false) {

        App::import ('Vendor', 'paypal');
        $this->Paypal = new Paypal();
        $balance = $this->Paypal->hashCall ('GetBalance', array ());
        $balance = $balance['L_AMT0'];

        $tranferFounds = $this->Project->Sponsorship->tranferFounds ($project_id, $returnTotal);

        $balance2 = $this->Paypal->hashCall ('GetBalance', array ());
        $balance2 = $balance['L_AMT0'];

        if ($returnTotal) {
            $this->data = array (
                'pre-balance' => $balance,
                'total' => $tranferFounds,
                'balance' => $balance2
            );
        } else {
            $this->data = array (
                'response' => $tranferFounds
            );
        }

        $this->render ('/common/ajax');

    }

    function admin_financeProject ($project_id, $tranferFounds = true) {
        App::import ('Vendor', 'paypal');
        $this->Paypal = new Paypal();

        $balance2 = $this->Paypal->getBalance ();








        // pagos cobrados --


        if (!$tranferFounds) {
            vd ('WE CAN NOT DO THIS TRANSACTION');
        } else {


            // get all tranfered payments and try to complete not tranfered.
            $collected = array_sum (Set::extract ('/Sponsorship/contribution', $this->Project->Sponsorship->tranferFounds ($project_id, false, true)));


            $groofiComision = $collected * PROJECT_COMISION / 100;

            $projectOwner_aux = $projectOwner = $collected - $groofiComision; // parte para el projecto ??


            $payments = array ();
            $currentPayment = $nPayments = 1;

            if ($projectOwner > PAYPAL_LIMIT) {

                $nPayments = ceil ($projectOwner / PAYPAL_LIMIT); // how many payment we will need
                for ($currentPayment; $currentPayment <= $nPayments; $currentPayment++) {
                    if ($projectOwner_aux > PAYPAL_LIMIT) {
                        $payments[$currentPayment] = PAYPAL_LIMIT;
                    } else {
                        $payments[$currentPayment] = $projectOwner_aux;
                    }
                    $projectOwner_aux = $projectOwner_aux - PAYPAL_LIMIT;
                }
            } else {
                $payments[$currentPayment] = $projectOwner;
            }

            $project = $this->Project->getViewData ($project_id); // get Project data

            $this->loadModel ('Projectpayment');

            if ($project['Project']['paypal_id'] != '' && $project['Project']['paypal_email'] != '') {

                foreach ($payments as $currentPayment => $paymentAmount) {

                    $query = array (
                        'Projectpayment.project_id' => $project_id,
                        'Projectpayment.current_payment' => $currentPayment,
                        'Projectpayment.responseEnvelope_ack' => 'Success'
                    );
                    $projectpayment = $this->Projectpayment->find ($query); // check if this payment has been payed

                    if (!$projectpayment) {
                        $this->Projectpayment->create ();
                        $projectpayment = array ();
                        $query['Projectpayment.responseEnvelope_ack'] = 'Failure';
                        $projectpayment = $this->Projectpayment->find ($query); // check if this payment exist but has status "Failure"
                        // existe un pago igual a este que fallo ?  que hacemos
                        if (!$projectpayment) {
                            $payParams = array (
                                "requestEnvelope.errorLanguage" => "en_US",
                                "actionType" => "PAY", // CREATE | PAY
                                "currencyCode" => "USD",
                                "cancelUrl" => "http://www.paypal.com",
                                "returnUrl" => "http://www.paypal.com",
                                "senderEmail" => PAYPAL_EMAIL, // groofy email
                                "fundingType" => 'BALANCE',
                                "feesPayer" => 'EACHRECEIVER', // quien pago los fees
                                "receiverList.receiver(0).email" => $project['Project']['paypal_email'], //TODO
                                "receiverList.receiver(0).amount" => $paymentAmount,
                            );
                            $response = $this->Paypal->xhashCall ('AdaptivePayments/Pay', $payParams);
                            $this->log (serialize (array ('payParams' => $payParams, 'response' => $response)), 'ADMIN_FINANCEPROJECT.ADAPTIVEPAYMENTS.PAY');

                            // ---------------------------------------------- //


                            $projectpayment['Projectpayment']['project_id'] = $project_id;
                            $projectpayment['Projectpayment']['current_payment'] = $currentPayment;
                            $projectpayment['Projectpayment']['total_payments'] = $nPayments;
                            $projectpayment['Projectpayment']['amount'] = $paymentAmount;
                            $projectpayment['Projectpayment']['amount_total'] = $projectOwner;
                            $projectpayment['Projectpayment']['receiver_email'] = $project['Project']['paypal_email'];
                            $projectpayment['Projectpayment']['sender_email'] = PAYPAL_EMAIL;

                            // payment request info
                            $projectpayment['Projectpayment']['responseenvelope_timestamp'] = $response["responseEnvelope.timestamp"];
                            $projectpayment['Projectpayment']['responseEnvelope_ack'] = $response["responseEnvelope.ack"];
                            $projectpayment['Projectpayment']['responseEnvelope_correlationId'] = $response["responseEnvelope.correlationId"];
                            $projectpayment['Projectpayment']['responseEnvelope_build'] = $response["responseEnvelope.build"];

                            if ($this->Paypal->checkResponse ($response)) {
                                $projectpayment['Projectpayment']['payKey'] = $response["payKey"];
                                $projectpayment['Projectpayment']['paymentExecStatus'] = $response["paymentExecStatus"];

                                // get details from payment.

                                $PaymentDetailsParams = array (
                                    "requestEnvelope.errorLanguage" => "en_US",
                                    "payKey" => $response["payKey"]
                                );
                                $PaymentDetails = $this->Paypal->xhashCall ('AdaptivePayments/PaymentDetails', $PaymentDetailsParams);


                                $info = array ();
                                for ($num = 0;; $num++) {
                                    if (!isset ($PaymentDetails["paymentInfoList.paymentInfo($num).transactionId"])) {
                                        break;
                                    } else {
                                        $info[$num] = array (
                                            'transactionId' => $PaymentDetails["paymentInfoList.paymentInfo($num).transactionId"],
                                            'transactionStatus' => $PaymentDetails["paymentInfoList.paymentInfo($num).transactionStatus"],
                                            'receiver.amount' => $PaymentDetails["paymentInfoList.paymentInfo($num).receiver.amount"],
                                            'receiver.email' => $PaymentDetails["paymentInfoList.paymentInfo($num).receiver.email"],
                                            'receiver.primary' => $PaymentDetails["paymentInfoList.paymentInfo($num).receiver.primary"],
                                            'receiver.paymentType' => $PaymentDetails["paymentInfoList.paymentInfo($num).receiver.paymentType"],
                                            'refundedAmount' => $PaymentDetails["paymentInfoList.paymentInfo($num).refundedAmount"],
                                            'pendingRefund' => $PaymentDetails["paymentInfoList.paymentInfo($num).pendingRefund"],
                                            'senderTransactionId' => $PaymentDetails["paymentInfoList.paymentInfo($num).senderTransactionId"],
                                            'senderTransactionStatus' => $PaymentDetails["paymentInfoList.paymentInfo($num).senderTransactionStatus"],
                                        );
                                    }
                                }

                                $info = serialize ($info);
                                $projectpayment['Projectpayment']['info'] = $info;
                                $projectpayment['Projectpayment']['error'] = '';
                            } else {
                                $errors = array ();
                                for ($error = 0;; $error++) {
                                    if (!isset ($response["error($error).errorId"])) {
                                        break;
                                    } else {
                                        $errors[$error] = array (
                                            'error_errorId' => $response["error($error).errorId"],
                                            'error_domain' => $response["error($error).domain"],
                                            'error_subdomain' => $response["error($error).subdomain"],
                                            'error_severity' => $response["error($error).severity"],
                                            'error_category' => $response["error($error).category"],
                                            'error_message' => $response["error($error).message"],
                                            'error_parameter_1' => $response["error($error).parameter(0)"],
                                            'error_parameter_2' => $response["error($error).parameter(1)"],
                                        );
                                    }
                                }

                                $errors = serialize ($errors);
                                $projectpayment['Projectpayment']['info'] = '';
                                $projectpayment['Projectpayment']['errors'] = $errors;
                            }
                            $this->Projectpayment->save ($projectpayment);
                        }
                    }

                    // check status for all payments.
                }
            } else {

                $this->data['error'][] = array (
                    __ ('USER_PAYPAY_ACCOUNT_INFORMATION_INCOMPLETE')
                );
            }
        }


        $query = array (
            'conditions' => array ('Projectpayment.project_id' => $project_id),
            'fields' => array ('distinct(paymentExecStatus)'),
        );

        $paymentsDone = Set::extract ('/Projectpayment/paymentExecStatus', $this->Projectpayment->find ('all', $query));

        $paymentsComplete = ( count ($paymentsDone) == 1 && low (array_shift ($paymentsDone)) == 'completed' );

        if ($paymentsComplete) {

            $project['Project']['funded'] = 1;
            $this->Project->save ($project);


            // creamos y enviamos la notificacion de funded.
            if (!$this->Project->User->Notification->add (
                            'PROJECT_FUNDED'
                            , $project
                            , $project['Project']['user_id']
                            , $project['Project']['user_id']
                    )
            ) {
                $this->requestAction (Router::url (array ('controller' => 'mails', 'action' => 'email', 'admin' => false, $this->Project->User->Notification->id)));
            }
        }

        $this->set ('paymentsComplete', $paymentsComplete);  // are all payments complete and Ok ?
        $this->data['Projectpayments'] = $this->Projectpayment->find ('all', array ('conditions' => array ('Projectpayment.project_id' => $project_id)));

    }
    function adminuploadimage($id_project, $admin='0'){

if (isset($admin) && $admin != '0'){

$control = base64_decode($admin);
    $control1 = $admin;
}else{


    if(isset($this->data['Sponsor']['control'])){

        $control = base64_decode($this->data['Sponsor']['control']);
        $control1 = $this->data['Sponsor']['control'];
}
}
if ($control == '1'){

        $this->loadModel('Sponsor');
        //App::import('model', 'Sponsor');
        $this->set('Project', $this->Project->findById($id_project));

        if ($this->data) {

           // $this->Sponsor->saveAll();

            if($this->Sponsor->saveAll($this->data)){

                $this->redirect (Router::url (array ('controller' => 'projects', 'action' => 'adminuploadimage', $this->data['Sponsor']['id_project'], $control1)));

            }

        }
    $this->set('control', $admin);
        $show_sponsor = $this->Sponsor->find('all',array('conditions' => array('Sponsor.id_project'=> $id_project)));
        $this->set('show_sponsor', $show_sponsor);
}else{
    $this->cakeError('error404');
}


    }
    function admin_projectBalance ($project_id) {

        App::import ('Vendor', 'paypal');
        $this->Paypal = new Paypal();

        $this->Project->contains = array ('Sponsorship');

        $this->data = $this->Project->read (null, $project_id);


        $preApprovalRefoundTotal = $expressCheckoutRefoundTotal = $refoundTotal = $preApprovalTotal = $expressCheckoutTotal = $total = 0;

        $preApproval = $expressCheckout = array ();


        $sponsorships = $this->Project->Sponsorship->tranferFounds ($project_id, false, false);
        //-----------------
        foreach ($sponsorships as $sponsorship) {
            $sponsorship = array_shift ($sponsorship);

            if ($sponsorship['payment_type'] == PREAPPROVAL) {

                $sponsorship['refound_cost'] = 0;

                $preApproval[] = $sponsorship;

                $preApprovalTotal += $sponsorship['contribution'];

                $preApprovalRefoundTotal += 0;
            }

            if ($sponsorship['payment_type'] == EXPRESSCHECKOUT) {


                $refound_cost = $sponsorship['contribution'] * .02;
                $refound_cost = $refound_cost > PAYPAL_MASSPAYMENT_COST ? PAYPAL_MASSPAYMENT_COST : $refound_cost;
                $sponsorship['refound_cost'] = $refound_cost;

                $expressCheckout[] = $sponsorship;

                $expressCheckoutTotal += $sponsorship['contribution'];

                $refoundTotal += $sponsorship['refound_cost'];

                $expressCheckoutRefoundTotal += $sponsorship['refound_cost'];
            }
        }


        //-----------------

        $paypalResponse = $this->Paypal->hashCall ('GetBalance', array ());
        $balance = $paypalResponse['L_AMT0'];


        $projectOwnert = ($expressCheckoutTotal + $preApprovalTotal) * ( 100 - PROJECT_COMISION ) / 100;
        // check here
        if ($projectOwnert > PAYPAL_LIMIT) {
            $nPayments = ceil ($projectOwnert / PAYPAL_LIMIT);
            for ($a = 1; $a <= $nPayments; $a++) {
                if ($projectOwnert > PAYPAL_LIMIT) {
                    $payments[$a] = PAYPAL_LIMIT;
                } else {
                    $payments[$a] = $projectOwnert;
                }
                $projectOwnert = $projectOwnert - PAYPAL_LIMIT;
            }
        } else {
            $nPayments = 1;
            $payments[1] = $projectOwnert;
        }


        $this->data = am ($this->data, array (
            'balance' => $balance,
            'total' => ($expressCheckoutTotal + $preApprovalTotal),
            'refoundTotal' => $preApprovalRefoundTotal + $expressCheckoutRefoundTotal,
            'groofi' => ( ($expressCheckoutTotal + $preApprovalTotal) * PROJECT_COMISION / 100 ),
            'owner' => ($expressCheckoutTotal + $preApprovalTotal) * ( 100 - PROJECT_COMISION ) / 100,
            'expressCheckout' => $expressCheckout,
            'expressCheckoutTotal' => $expressCheckoutTotal,
            'expressCheckoutRefoundTotal' => $expressCheckoutRefoundTotal,
            'preApproval' => $preApproval,
            'preApprovalTotal' => $preApprovalTotal,
            'preApprovalRefoundTotal' => $preApprovalRefoundTotal,
            'nPayments' => $nPayments,
            'payments' => $payments,
            'paypalLimit' => PAYPAL_LIMIT
                )
        );

    }

    function edit ($id = null, $publish=false, $getData = false) {
			
				
		    App::import('model', 'Project');
			$pp=new Project();
			$datos=$pp->query("select * from projects where id=".$id);

        	if(!empty($datos[0]['projects']['basename'])){
				unset($this->Project->validate['file']);
				$this->set ('yaHayImg', 1);
				$img=str_replace('.jpg','.png','media/filter/l560/'.$datos[0]['projects']['dirname'].'/'.$datos[0]['projects']['basename']);
                   if (file_exists($img) ){
						$img='/comodo.php?imagen=media/filter/l560/'.$datos[0]['projects']['dirname'].'/'.$datos[0]['projects']['basename'];
						$img=str_replace('.jpg','.png',$img);
						
					}else{
						$img='/comodo.php?imagen=img/assets/img_default_280x210px.png';	
					}
				$this->set ('laim', $img);
			}else{
				$this->set ('yaHayImg', 0);
				$this->set ('laim', '/comodo.php?imagen=img/assets/img_default_280x210px.png');
			}
			
		
		
        if ($getData) { // try to validate and save data directly.
            $query['contain'] = array ('Prize', 'User', 'User.Link','Link'); //,'Prize'
            $query['conditions'] = array (
                'Project.user_id' => $this->Auth->user ('id'),
                'Project.id' => $id,
                'Project.enabled' => 1
            );
            $this->data = $this->Project->find ('first', $query);
			
			
        }
		
		
		
		
		
        if (empty ($this->data)) {
            if ($id) {
                $this->data = $this->Project->find ('first', array (
                    'conditions' => array ('Project.id' => $id, 'Project.user_id' => $this->Auth->user ('id')),
                    'contain' => array ('Prize', 'User', 'User.Link','Link')
                        )
                );
            }
			
            if (empty ($this->data)) {
                $this->pageError = array ('code' => 404);
            }/*elseif ($this->data['Project']['enabled'] != 1 && $this->data['Project']['public'] != 0) { // if project exist and belongs to an auth user, check if it's editable
                $this->pageError = array ('code' => 404);
            }*/
            elseif ($this->data['Project']['public'] == 0) { // if project exist and belongs to an auth user, check if it's editable
                $this->pageError = array ('code' => 404);
            } elseif ($this->data['Project']['enabled'] == 0) {
                $this->pageError = array ('code' => 404);
            }

		
        } else {
			
			 /*if(!empty($this->data['Project']['basename'])){
				unset($this->Project->validate['file'])	;			  
			 }*/
			 /*vd($this->Project->validate['file']);
			 exit;
		    */
			
			
			
			$no=0;
			if(empty($this->data[Project][funding_goal]) || $this->data[Project][funding_goal]<10 || $this->data[Project][funding_goal]>200000){
				$no=1;
			}
			
			
			if( ($this->data['Project']['private_pass']!=$this->data['Project']['private_pass2'] || empty($this->data['Project']['private_pass']))  &&  $this->data['Project']['private']=='1'){
				if(($this->data['Project']['private_pass']!=$this->data['Project']['private_pass2'])){
					$mjepass='La clave y su repetici&oacute;n no coinciden';
				}
				if( empty($this->data['Project']['private_pass'])){
					$mjepass='Debe definir una clave para los proyectos privados';
				}
				$privatepassko=1;
			}else{
				$privatepassko=0;
			}
			
			if($privatepassko || $no){$publish=0;}
			
			
			
			
			
			
            if ($publish) { // Wich validation set we will use ?
			
               // $validData = $this->Project->publishValidation ($this->data);

				$data=$this->data;
				$this->data['Project']['public'] = IS_PUBLIC;
        		$this->data['Project']['status'] = PROJECT_STATUS_PUBLISHED;
        		$this->data['Project']['puplish_date'] = date('Y-m-d');
        		$this->data['Project']['end_date'] = date('Y-m-d', strtotime("+{$data['Project']['project_duration']} days"));
				$validData=$this->data;
            } else {

                $validData = $this->Project->editValidation2 ($this->data);
            }
			if(empty($_POST['data']['Prize']) && !$getData){
				  $this->Project->invalidate ('prize', __ ('AT_LEAST_ONE_PRIZE', true));
				   $validData=0;
				  
			}

if($this->data['Project']['basename']!= $datos[0]['projects']['basename']){


            $cambio_path_image= str_replace('\\','/',WWW_ROOT);
  //          $this->data['Project']['dirname']='project/tmp/img';
            $this->data['Project']['basename']=$_POST['data']['Project']['country'];
            $this->data['Project']['file']=$cambio_path_image.'media/transfer/project/tmp/img/'.$_POST['data']['Project']['country'];
}
            /*echo '<pre>';
            var_dump($no);die;
            /*if ($validData && !$privatepassko && !$no) {*/
                if (!$privatepassko && !$no) {
     //           $this->data['Project']['dirname'] = "project/".$this->data['Project']['id']."/img";
                if ($this->Project->saveAll ($validData, array ('validate' => false))) {
                    if($this->data['Project']['basename']!= $datos[0]['projects']['basename']){

                        $url_to = "media/filter/";

                    /*Todas las img se guardan con .png*/

                    $new_image_name = explode(".",$this->data['Project']['basename']);

                    foreach(Configure::read ('ImgSize.filter.image') as $key=>$value){
                        $dir = new Folder($url_to.$value."/project/".$this->data['Project']['id'], true);
                        if(is_dir($url_to.$value."/project/".$this->data['Project']['id'])){
                            $img_path = new Folder($url_to.$value."/project/".$this->data['Project']['id']."/img/", true);
                            $file = new File($url_to.$value."/project/tmp/img/".$new_image_name[0].".png", false, 0644);
                            if ($file->exists()) {
                                $file->copy($url_to.$value."/project/".$this->data['Project']['id']."/img" . DS . $file->name);
                            }
                        }
                    }

                    }





                    if ($publish) {

						 $this->Session->write('sipublicado', 1);
                        $project = $this->Project->find (array ('Project.id' => $this->Project->id));
                        if (!$this->Project->User->Notification->add (
                                        'PROJECT_CREATED'
                                        , $project
                                        , $this->Auth->user ('id')
                                )
                        ) {
                            $this->log ('Error : notification not saved ', 'NOTIFICATIONS_LOG');
                        } else {
                            $this->requestAction (Router::url (array ('controller' => 'mails', 'action' => 'email', 'admin' => false, $this->Project->User->Notification->id)));
                        }


                        if (Project::belongsToOffer ($project)) { // ??
                            $offer = $this->Project->Offer->getViewData ($project['Project']['offer_id']);

                            if (!$this->Project->User->Notification->add (//OFFER_NEW_PROJECT
                                            'OFFER_NEW_PROJECT'
                                            , $this->Project->find (array ('Project.id' => $this->Project->id))
                                            , $this->Auth->user ('id')
                                            , $offer['Offer']['user_id']
                                    )
                            ) {
                                $this->log ('Error : notification not saved ', 'NOTIFICATIONS_LOG');
                            } else {
                                $this->requestAction (Router::url (array ('controller' => 'mails', 'action' => 'email', 'admin' => false, $this->Project->User->Notification->id)));
                            }
                        }
                    }

                    // send user to project pre/view
                    $this->redirect (Router::url (array ('controller' => 'projects', 'action' => 'view', 'project' => Project::getSlug ($validData), 'user' => User::getSlug ($this->Auth->user ()))));
                }
            } else {
                $this->Session->setFlash (__ (( $publish ? 'THIS_PROJECT_IS_NOT_VALID_IT_CAN_NOT_BE_PUBLISHED' : 'THE_PROJECT_COULD_NOT_BE_SAVED_PLEASE_TRY_AGAIN.'), true));
            }
        }


        $this->set ('leadingProject', $this->Project->getLeading ());
        App::import ('Vendor', 'paypal');
        $this->Paypal = new Paypal();
        $paypalResponse = $this->Paypal->hashCall ('SetAuthFlowParam', array (
            'RETURNURL' => Router::url (array ('controller' => 'projects', 'action' => 'associateWithPaypal', $id, 'return'), true),
            'CANCELURL' => Router::url (array ('controller' => 'projects', 'action' => 'associateWithPaypal', $id, 'cancel'), true),
            'LOGOUTURL' => Router::url (array ('controller' => 'projects', 'action' => 'associateWithPaypal', $id, 'logout'), true),
            'SERVICENAME0' => 'Name',
            'SERVICEDEFREQ0' => 'Required',
            'SERVICENAME1' => 'Email',
            'SERVICEDEFREQ1' => 'Required',
                )
        );

        $this->set ('payPalURL', $this->Paypal->getUrl ('SetAuthFlowParam', $paypalResponse));


        $mas=array();
        if($this->data && $this->data['Project']['user_id']) {
            if($privatepassko==1){
                $mas=array('private'=>$mjepass);

            }
            if(isset($mas)&& !empty($mas)){
                $this->set('validationErrorsArray', array_merge($mas,$this->Project->invalidFields()));
            }

            /*echo '<pre>';
            var_dump($mas);die;*/
        }
		
		 /*if($this->data && $_POST['data']['Project']['user_id']) {
			if($privatepassko){
				 $mas=array('private'=>$mjepass);
			 }
			 if($no){
				 $mas['funding_goal']='Debe escoger un valor entre 10 y 200000';
			 }

			$this->set('validationErrorsArray', array_merge($mas,$this->Project->invalidFields()));
		 }*/
		
		
    }


    function editprojects ($id = null, $id_pro = null,$publish=false, $getData = false) {

 if(isset($id_pro) &&  $id_pro==1){


        App::import('model', 'Project');
        $pp=new Project();
        $datos=$pp->query("select * from projects where id=".$id);

        if(!empty($datos[0]['projects']['basename'])){
            unset($this->Project->validate['file']);
            $this->set ('yaHayImg', 1);
            $img=str_replace('.jpg','.png','media/filter/l560/'.$datos[0]['projects']['dirname'].'/'.$datos[0]['projects']['basename']);
            if (file_exists($img) ){
                $img='/comodo.php?imagen=media/filter/l560/'.$datos[0]['projects']['dirname'].'/'.$datos[0]['projects']['basename'];
                $img=str_replace('.jpg','.png',$img);

            }else{
                $img='/comodo.php?imagen=img/assets/img_default_280x210px.png';
            }
            $this->set ('laim', $img);
        }else{
            $this->set ('yaHayImg', 0);
            $this->set ('laim', '/comodo.php?imagen=img/assets/img_default_280x210px.png');
        }



        if ($getData) { // try to validate and save data directly.
            $query['contain'] = array ('Prize', 'User', 'User.Link','Link'); //,'Prize'
            $query['conditions'] = array (
                'Project.user_id' => $this->Auth->user ('id'),
                'Project.id' => $id,
                'Project.enabled' => 1
            );
            $this->data = $this->Project->find ('first', $query);


        }





        if (empty ($this->data)) {
            if ($id) {
                $this->data = $this->Project->find ('first', array (
                        'conditions' => array ('Project.id' => $id),
                        'contain' => array ('Prize', 'User', 'User.Link','Link')
                    )
                );
            }

            if (empty ($this->data)) {
                $this->pageError = array ('code' => 404);
            }/*elseif ($this->data['Project']['enabled'] != 1 && $this->data['Project']['public'] != 0) { // if project exist and belongs to an auth user, check if it's editable
                $this->pageError = array ('code' => 404);
            }*/
            elseif ($this->data['Project']['public'] == 0) { // if project exist and belongs to an auth user, check if it's editable
                $this->pageError = array ('code' => 404);
            } elseif ($this->data['Project']['enabled'] == 0) {
                $this->pageError = array ('code' => 404);
            }


        } else {

            /*if(!empty($this->data['Project']['basename'])){
               unset($this->Project->validate['file'])	;
            }*/
            /*vd($this->Project->validate['file']);
            exit;
           */



            $no=0;
            if(empty($this->data[Project][funding_goal]) || $this->data[Project][funding_goal]<10 || $this->data[Project][funding_goal]>200000){
                $no=1;
            }


            if( ($this->data['Project']['private_pass']!=$this->data['Project']['private_pass2'] || empty($this->data['Project']['private_pass']))  &&  $this->data['Project']['private']=='1'){
                if(($this->data['Project']['private_pass']!=$this->data['Project']['private_pass2'])){
                    $mjepass='La clave y su repetici&oacute;n no coinciden';
                }
                if( empty($this->data['Project']['private_pass'])){
                    $mjepass='Debe definir una clave para los proyectos privados';
                }
                $privatepassko=1;
            }else{
                $privatepassko=0;
            }

            if($privatepassko || $no){$publish=0;}






            if ($publish) { // Wich validation set we will use ?

                // $validData = $this->Project->publishValidation ($this->data);

                $data=$this->data;
                $this->data['Project']['public'] = IS_PUBLIC;
                $this->data['Project']['status'] = PROJECT_STATUS_PUBLISHED;
                $this->data['Project']['puplish_date'] = date('Y-m-d');
                $this->data['Project']['end_date'] = date('Y-m-d', strtotime("+{$data['Project']['project_duration']} days"));
                $validData=$this->data;
            } else {

                $validData = $this->Project->editValidation2 ($this->data);
            }
            if(empty($_POST['data']['Prize']) && !$getData){
                $this->Project->invalidate ('prize', __ ('AT_LEAST_ONE_PRIZE', true));
                $validData=0;

            }

            if($this->data['Project']['basename']!= $datos[0]['projects']['basename']){


                $cambio_path_image= str_replace('\\','/',WWW_ROOT);
                //          $this->data['Project']['dirname']='project/tmp/img';
                $this->data['Project']['basename']=$_POST['data']['Project']['country'];
                $this->data['Project']['file']=$cambio_path_image.'media/transfer/project/tmp/img/'.$_POST['data']['Project']['country'];
            }
            //echo '<pre>';
            //var_dump($this->data);
            if ($validData && !$privatepassko && !$no) {

                //           $this->data['Project']['dirname'] = "project/".$this->data['Project']['id']."/img";
                if ($this->Project->saveAll ($validData, array ('validate' => false))) {
                    if($this->data['Project']['basename']!= $datos[0]['projects']['basename']){

                        $url_to = "media/filter/";

                        /*Todas las img se guardan con .png*/

                        $new_image_name = explode(".",$this->data['Project']['basename']);

                        foreach(Configure::read ('ImgSize.filter.image') as $key=>$value){
                            $dir = new Folder($url_to.$value."/project/".$this->data['Project']['id'], true);
                            if(is_dir($url_to.$value."/project/".$this->data['Project']['id'])){
                                $img_path = new Folder($url_to.$value."/project/".$this->data['Project']['id']."/img/", true);
                                $file = new File($url_to.$value."/project/tmp/img/".$new_image_name[0].".png", false, 0644);
                                if ($file->exists()) {
                                    $file->copy($url_to.$value."/project/".$this->data['Project']['id']."/img" . DS . $file->name);
                                }
                            }
                        }

                    }





                    if ($publish) {

                        $this->Session->write('sipublicado', 1);
                        $project = $this->Project->find (array ('Project.id' => $this->Project->id));
                        if (!$this->Project->User->Notification->add (
                            'PROJECT_CREATED'
                            , $project
                            , $this->Auth->user ('id')
                        )
                        ) {
                            $this->log ('Error : notification not saved ', 'NOTIFICATIONS_LOG');
                        } else {
                            $this->requestAction (Router::url (array ('controller' => 'mails', 'action' => 'email', 'admin' => false, $this->Project->User->Notification->id)));
                        }


                        if (Project::belongsToOffer ($project)) { // ??
                            $offer = $this->Project->Offer->getViewData ($project['Project']['offer_id']);

                            if (!$this->Project->User->Notification->add (//OFFER_NEW_PROJECT
                                'OFFER_NEW_PROJECT'
                                , $this->Project->find (array ('Project.id' => $this->Project->id))
                                , $this->Auth->user ('id')
                                , $offer['Offer']['user_id']
                            )
                            ) {
                                $this->log ('Error : notification not saved ', 'NOTIFICATIONS_LOG');
                            } else {
                                $this->requestAction (Router::url (array ('controller' => 'mails', 'action' => 'email', 'admin' => false, $this->Project->User->Notification->id)));
                            }
                        }
                    }

                    // send user to project pre/view
                    $this->redirect (Router::url (array ('controller' => 'projects', 'action' => 'view', 'project' => Project::getSlug ($validData), 'user' => User::getSlug ($this->Auth->user ()))));
                }
            } else {
                $this->Session->setFlash (__ (( $publish ? 'THIS_PROJECT_IS_NOT_VALID_IT_CAN_NOT_BE_PUBLISHED' : 'THE_PROJECT_COULD_NOT_BE_SAVED_PLEASE_TRY_AGAIN.'), true));
            }
        }


        $this->set ('leadingProject', $this->Project->getLeading ());
        App::import ('Vendor', 'paypal');
        $this->Paypal = new Paypal();
        $paypalResponse = $this->Paypal->hashCall ('SetAuthFlowParam', array (
                'RETURNURL' => Router::url (array ('controller' => 'projects', 'action' => 'associateWithPaypal', $id, 'return'), true),
                'CANCELURL' => Router::url (array ('controller' => 'projects', 'action' => 'associateWithPaypal', $id, 'cancel'), true),
                'LOGOUTURL' => Router::url (array ('controller' => 'projects', 'action' => 'associateWithPaypal', $id, 'logout'), true),
                'SERVICENAME0' => 'Name',
                'SERVICEDEFREQ0' => 'Required',
                'SERVICENAME1' => 'Email',
                'SERVICEDEFREQ1' => 'Required',
            )
        );

        $this->set ('payPalURL', $this->Paypal->getUrl ('SetAuthFlowParam', $paypalResponse));


        $mas=array();
        if($this->data && $this->data['Project']['user_id']) {
            if($privatepassko==1){
                $mas=array('private'=>$mjepass);

            }
            if(isset($mas)&& !empty($mas)){
                $this->set('validationErrorsArray', array_merge($mas,$this->Project->invalidFields()));
            }

            /*echo '<pre>';
            var_dump($mas);die;*/
        }

        /*if($this->data && $_POST['data']['Project']['user_id']) {
           if($privatepassko){
                $mas=array('private'=>$mjepass);
            }
            if($no){
                $mas['funding_goal']='Debe escoger un valor entre 10 y 200000';
            }

           $this->set('validationErrorsArray', array_merge($mas,$this->Project->invalidFields()));
        }*/


    }
    else {echo 'NO AUTORIZADO';
    }
        $this->render ('/projects/edit');


}
    function search_category(){/*Busqueda por categorias*/
        $this->loadModel('Country');
        $base_countries = $this->Country->getCountries($_SESSION['idioma']);
        $this->set (compact ('base_countries'));


        if (isset ($this->params['pass'][0])) {

            $baseUrl=array($this->params['pass'][0]);
            //$this->loadModel ('Search');

            //$this->paginate['conditions']['Project.id'] = $this->Search->customSearch ($this->params['search'], 'Project');
            App::import('model', 'Project');


            $category_info = $this->Project->Category->getFromSlug ($this->params['pass'][0]);
            $this->paginate['conditions']['Project.category_id'] = @array_shift (Set::extract ('/Category/id', $category_info));


            /*echo '<pre>';print_r($this->paginate);echo '</pre>';*/
        }

        $this->paginate['limit'] = 6;
        $this->data = $this->paginate ('Project');

        $this->set ('baseUrl', $baseUrl);

        $this->paginate['conditions']['Project.idioma ='] = $_SESSION['idioma'];
        $this->render ('index');
    }

    function general_search()/*Busqueda general layout*/
    {
        $this->loadModel('Country');
        $base_countries = $this->Country->getCountries($_SESSION['idioma']);
        $this->set (compact ('base_countries'));

    if (isset ($this->params['pass'][0])) {

        $baseUrl=array($this->params['pass'][0]);
        //$this->loadModel ('Search');

        //$this->paginate['conditions']['Project.id'] = $this->Search->customSearch ($this->params['search'], 'Project');
        App::import('model', 'Project');
        $pp=new Project;
        $dato=$pp->query("select id from projects where title like '%".$this->params['pass'][0]."%' or short_description like '%".$this->params['pass'][0]."%' or description like '%".$this->params['pass'][0]."%'");
        //$dato=array(44,2);
        $ids=array();
        foreach($dato as $k=>$v)$ids[]=$v['projects']['id'];
        $this->paginate['conditions']['Project.idioma ='] = $_SESSION['idioma'];/*se agrego para que solo buscara proyectos acorde al idioma de la session*/
        $this->paginate['conditions']['Project.id']=$ids;


        /*echo '<pre>';print_r($this->paginate);echo '</pre>';*/
    }
    $this->paginate['limit'] = 6;
    $this->data = $this->paginate ('Project');

    $this->set ('baseUrl', $baseUrl);
    $this->paginate['conditions']['Project.idioma ='] = $_SESSION['idioma'];
    $this->render ('index');
}

    function index ()/*Busqueda filtros especificos*/

    {

    //DISCOVER

        $this->loadModel('Country');
        $base_countries = $this->Country->getCountries($_SESSION['idioma']);
        $this->set (compact ('base_countries'));


        $statuses = array (
            'most-popular' => __ ('MOST_POPULAR', true),
            'most-recent' => __ ('MOST_RECENT', true),
            'by-end' => __ ('BY_END', true),
            'finished' => __ ('FINISHED', true),
        );


      /* if (isset ($this->params['search']) && empty ($this->params['search'])) {
            $this->redirect ('/projects', 403);
        }*/



        $this->set ('statuses', $statuses);

        $this->set ('categories', $this->Project->Category->find ('all', array ('conditions' => array ('Category.project_count >' => 0), 'contain' => array ())));

        $cities = $this->Project->City->find ('all', array (
            'conditions' => array ('City.project_count >' => 0),
            'contain' => array ()
                )
        );
        if (!empty ($cities)) {
            $this->set ('cities', $cities);
        }

        $baseUrl = array_filter (array (
            //'city' => isset ($this->params['city']) ? $this->params['city'] : null,
            'country' => isset ($this->params['pass'][0]) ? $this->params['pass'][0] : null,
            'category' => isset ($this->params['pass'][1]) ? $this->params['pass'][1] : null,
            'status' => isset ($this->params['pass'][2]) ? $this->params['pass'][2] : null
			          ), function ($element) {
                    return!is_null ($element);
                });

        $this->set ('cityName', $this->params['pass'][0]);
        extract ($baseUrl);

        $this->set (compact (array_keys ($baseUrl)));

        /* -------------------------------------------------------------------- */

        $this->paginate = $this->Project->queryStandarSet (false);
        $this->paginate['limit'] = 6;

		
		if($this->params['pass'][0]=='search' && (isset($this->params['pass'][1]) && !empty($this->params['pass'][1]))){

			//$this->params['search']=$this->params['pass'][1];
		}
		

        //if (isset ($category)) {


            $category_info = $this->Project->Category->getFromSlug ($this->params['pass'][1]);
            $this->paginate['conditions']['Project.category_id'] = @array_shift (Set::extract ('/Category/id', $category_info));
            $this->set ('categoryName', Category::getName ($category_info));



        //}

      /*  if (isset ($country) && !isset ($city)) {
            $cities = $this->Project->City->find ('all', array (
                'conditions' => array (
                    'City.country_slug' => $country
                ),
                'contain' => array ()
                    )
            );
            $this->set ('cityName', array_shift (Set::extract ('/City/country', $cities)));
        } elseif (isset ($city)) {
            $cities = $this->Project->City->find ('all', array (
                'conditions' => array (
                    'City.country_slug' => $country,
                    'City.city_slug' => $city
                ),
                'contain' => array ()
                    )
            );
            $city_name = array_shift (Set::extract ('/City/city_name', $cities));
            $this->set ('cityName', array_shift (Set::extract ('/City/city_name', $cities)));
        }*/
        //$this->paginate['order'] = 'Project.publish_date DESC'; // mas recientemente publicados , no filtra
        $this->paginate['conditions']['Project.paislugar ='] = $this->params['pass'][0];
        //$this->paginate['conditions']['Project.idioma ='] = $_SESSION['idioma'];
        //$this->paginate['conditions']['Project.public ='] = 1;



        //if (isset ($status)) {
            switch ($this->params['pass'][2]) {
                case 'most-recent' :
                    $this->paginate['order'] = 'Project.publish_date DESC'; // mas recientemente publicados , no filtra
                    $this->paginate['conditions']['Project.end_date >'] = date ('Y-m-d');
                    break;
                case 'most-popular' : // DEFINIR CUALES SON LOS CRITERIOS PARA ESTO
                    $this->paginate['order'] = 'Project.sponsorships_count DESC , User.score , Project.follow_count DESC'; // mas recientemente publicados , no filtra
                    break;
                case 'by-end' :  // muestra los proyectos que terminan dentro de los proximos 10 dias ordenados por fecha de finalizacion.
                    $this->paginate['conditions']['Project.end_date >'] = date ('Y-m-d');
                    $this->paginate['conditions']['Project.end_date <'] = date ('Y-m-d', strtotime ('+10 days'));
                    $this->paginate['order'] = 'Project.end_date ASC';
                    break;
                case 'finished' :
                    $this->paginate['conditions']['Project.end_date <'] = date ('Y-m-d');
                    $this->paginate['order'] = 'Project.end_date DESC';
                    break;
            }
            $this->set ('statusName',$this->params['pass'][2]);
        //}



        $this->data = $this->paginate ('Project');
        $this->set ('baseUrl', $baseUrl);

        $this->paginate['conditions']['Project.idioma ='] = $_SESSION['idioma'];
        $this->render('search_filtro');


    }
    function show_projects(){
        $this->loadModel('Country');
        $base_countries = $this->Country->getCountries($_SESSION['idioma']);
        $this->set (compact ('base_countries'));

        $this->paginate = $this->Project->queryStandarSet (false);
        $this->paginate['limit'] = 6;
        $this->paginate['conditions']['Project.idioma ='] = $_SESSION['idioma'];
        $baseUrl = array_filter (array (
            'city' => isset ($this->params['city']) ? $this->params['city'] : null,
            'country' => isset ($this->params['country']) ? $this->params['country'] : null,
            'category' => isset ($this->params['category']) ? $this->params['category'] : null,
            'status' => isset ($this->params['status']) ? $this->params['status'] : null
        ), function ($element) {
            return!is_null ($element);
        });
        $this->data = $this->paginate ('Project');
        $this->set ('baseUrl', $baseUrl);
    }

    function list_offers ($model, $id) {
        $modelData = $this->Project->Offer->getViewData ($id); // get view data for a project.
        if ($this->Project->Offer->isPublic ($modelData)) {
            $query = $this->Project->queryStandarSet ();
            $query['order'] = 'Project.created DESC';
            $query['conditions']['Project.offer_id'] = $modelData['Offer']['id'];
            $this->data = $this->Project->find ('all', $query);
            $this->set ('model', $model);
            $this->set ('id', $modelData['Offer']['id']);
        } else {
            $this->redirect ($this->Project->Offer->getLink ($modelData));
        }

        $this->set ('offer', $modelData);

    }

    function listing ($user=true) { //listing

        $this->data = $this->Project->User->getUser ($user);




        // create and send email
        /*
          $this->User->Notification->add('USER_WELCOME_MAIL', $this->data ,$this->data['User']['id']  , null , $this->Email ) ;
          $params = $this->User->Notification->prepareEmail('USER_WELCOME_MAIL', $this->data ,$this->data['User']['id'] ) ;
          $this->User->Notification->setupEmail($this->Email,$params);
          $this->set('emailData',$params['data']);
          $this->set('emailMessage',$params['message']);
          $this->Email->send();

         */


        if ($this->data) {



            $query = $this->Project->queryStandarSet (true, true);
            $query['conditions'] = array ('Project.user_id' => $this->data['User']['id']);

            $this->data['Projects'] = $this->Project->find ('all', $query);
            if (!empty ($this->data['Projects'])) {
                foreach ($this->data['Projects'] as $key => $project) {
                    if (!Project::isOwnProject ($project) && !Project::isPublic ($project)) {
                        unset ($this->data['Projects'][$key]);
                    }
                }
            }
        } else {
            $this->pageError = array ('code' => 404);
        }

        $this->set ('section', 'projects'); //??
        $this->render ('/users/view');

    }

    function view ($id = null) {

        $this->loadModel ('Sponsor');
		if ($id) {

            $this->data = $this->Project->getViewData ($id);

            $this->set('sponsors', $this->Sponsor->find('all',array('conditions'=>array('Sponsor.id_project' => $this->data['Project']['id']), 'order'=>'Sponsor.id DESC') ));
			/*vd($this->data['Project']['user_id']);
			vd($this->Auth->user ('id'));
			exit;*/
        }
		
		/*$this->data['Project']['private'];*/
			App::import('model', 'Link');
			$pp=new Project();
			$datos=$pp->query("select * from links where model_id=".$this->data['Project']['id']." and model='Project'");
			$this->data['LOSLINKS']=$datos;
		$this->Project->verifyPrivacityStatus($this->data['Project']['id'],$this->here);
        if (empty ($this->data)) {
            $this->pageError = array ('code' => 404);
        } elseif ($this->data['Project']['enabled'] == 0) { // project was not revised by system admins.
            $this->pageError = array ('code' => 403);
        } elseif ($this->data['Project']['user_id'] != $this->Auth->user ('id') && $this->data['Project']['public'] == 0) { // the project exist
            $this->pageError = array ('code' => 404);
        } else {
            /*
              if ($this->data['Project']['offer_id'] > 0  ) {
              $this->set('offer', $this->Project->Offer->getViewData($this->data['Project']['offer_id']) );
              }
             */
        }

    }

    function delete ($id) {
        $query['contain'] = false;
        $query['conditions'] = array (
            'Project.user_id' => $this->Auth->user ('id'),
            'Project.id' => $id,
            'Project.public' => IS_NOT_PUBLIC
        );
        $this->data = $this->Project->find ('first', $query);
        if (!$this->data) {
            $this->pageError = array ('code' => 403);
        } else {
             $this->Project->delete($id);
			 $this->Session->write('deletedok', 1);
             $this->redirect('/profile');
        }
        $this->render ('/common/ajax');

    }
    function delete_sponsor ($id) {
        $this->loadModel ('Sponsor');
        $query['contain'] = false;
        $query['conditions'] = array (
            'Sponsor.id' => $id,
        );

        $this->data = $this->Sponsor->find ('first', $query);

        if (!$this->data) {
            $this->pageError = array ('code' => 403);
        } else {
            $this->Sponsor->delete($id);

            $this->redirect (Router::url (array ('controller' => 'projects', 'action' => 'adminuploadimage', $this->data['Sponsor']['id_project'])));
        }
        $this->render ('/common/ajax');

    }
    function cron_aboutToFinish () {
        $query = array ();
        $query['contain'] = array ();
        $query['fields'] = array ('Project.id', 'Project.user_id');
        $query['conditions']['Project.end_date'] = date ('Y-m-d', strtotime ("+" . DAYS_TO_BE_FINISHING . " days"));
        $query['conditions']['Project.about_to_finish'] = 0;

        $endingProjects = $this->Project->find ('all', $query);




        foreach ($endingProjects as $project) {
            $project['Project']['about_to_finish'] = 1;
            $this->Project->belongsTo = array (); // deshabilitamos los counter chaches.
            $this->Project->save ($project, array ('callbacks' => false, 'validate' => false));
            $query = array ();
            $query['contain'] = array ('Category', 'User');
            $query['conditions']['Project.id'] = $project['Project']['id'];
            if ($this->Project->User->Notification->add (
                            'PROJECT_ABOUT_TO_FINISH'
                            , $project['Project']['id']
                            , $project['Project']['user_id']
                    )
            ) {
                $notification_ids[] = $this->Project->User->Notification->id;
            }
        }

        foreach ($notification_ids as $notification_id) {
            $emailed = $this->requestAction (Router::url (array ('controller' => 'mails', 'action' => 'email', 'admin' => false, $notification_id)));
        }


        $this->render ('/common/ajax', 'ajax');

    }

    function cron_Finished () {
        $query = array ();
        $query['contain'] = array ('Sponsorship');
        $query['fields'] = array ('Project.id', 'Project.user_id', 'Project.funding_goal');

        $query['conditions']['Project.end_date'] = date ('Y-m-d');
        $query['conditions']['Project.finished'] = 0;

        $finishedProjects = $this->Project->find ('all', $query);

        $notification_ids = array ();

        foreach ($finishedProjects as $project) {


            $project['Project']['finished'] = 1;
            $this->Project->belongsTo = array (); // deshabilitamos los counter chaches.
            $this->Project->save ($project, array ('callbacks' => false, 'validate' => false));
            $query = array ();
            $query['contain'] = array ('Category', 'User');
            $query['conditions']['Project.id'] = $project['Project']['id'];
            if ($this->Project->User->Notification->add (
                            'PROJECT_FINISH'
                            , $project['Project']['id']
                            , $project['Project']['user_id']
                    )
            ) {
                $notification_ids[] = $this->Project->User->Notification->id;
            }
        }

        foreach ($notification_ids as $notification_id) {
            $emailed = $this->requestAction (Router::url (array ('controller' => 'mails', 'action' => 'email', 'admin' => false, $notification_id)));
        }


        $this->render ('/common/ajax', 'ajax');

    }

    function sponsors ($id) {


        if ($id) {
            $this->data = $this->Project->getViewData ($id);
        }

        if (Project::isOwnProject ($this->data)) {
            foreach ($this->data['Sponsorship'] as $key => $sponsorship) {
                $this->data['Sponsorship'][$key]['User'] = array_shift ($this->Project->User->read (null, $sponsorship['user_id']));
                $this->data['Sponsorship'][$key]['Prize'] = array_shift ($this->Project->Prize->read (null, $sponsorship['prize_id']));
            }
        } else {
            $this->redirect ('/');
        }

    }
	function verifyPrivate(){
		if($this->Project->verifyPrivacityPass($_REQUEST['keyPrivate'])){
			$this->set('pass','ok');
		}else{
			$this->set('pass','ko');
		}
		$this->layout='panino';
		$this->render('/projects/panino3');
	}
	function resize($im,$MAX_ANCHO,$MAX_ALTO,$name){
	$datos = getimagesize($im); 
	if($datos[0]<=$MAX_ANCHO && $datos[1]<=$MAX_ALTO){
		file_put_contents($name,implode('',file($im)));
		return;
	}
	if($datos[2]==1){
		$img = @imagecreatefromgif($im);
	}elseif($datos[2]==2){
		$img = @imagecreatefromjpeg($im);
	}elseif($datos[2]==3){
		$img = @imagecreatefrompng($im);
	}else{
		return;
	} 
	$scale = min($MAX_ANCHO/$datos[0], $MAX_ALTO/$datos[1]);
	$anchura = floor($scale*$datos[0]);
	$altura = floor($scale*$datos[1]);
	$thumb = imagecreatetruecolor($anchura,$altura); 
	imagealphablending($thumb, false);
	imagesavealpha($thumb,true);
	//$transparent = imagecolorallocatealpha($thumb, 255, 255, 255, 127);
	//imagefilledrectangle($thumb, 0, 0, $anchura, $altura, $transparent);
	imagecopyresampled ($thumb, $img, 0, 0, 0, 0, $anchura, $altura, $datos[0], $datos[1]); 
	if($datos[2]==1){
		imagegif($thumb,$name);
	}elseif($datos[2]==2){
		imagejpeg($thumb,$name,90);
	}else{
		imagepng($thumb,$name);
	} 
	imagedestroy($thumb);
	}

}

?>
