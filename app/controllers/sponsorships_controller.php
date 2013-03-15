<?php

/**
 * @property Sponsorship $Sponsorship
 */
class SponsorshipsController extends AppController {

    function beforeFilter() {
        $this->Auth->allow('view', 'paymentIpn', 'index', 'listing', 'paymentSuccess', 'paymentCancelled', 'process', 'dump', 'view_dump', 'masspay_ipn','mp_ipn');
		if (!$this->Auth->user() && $this->params['controller']=='add') {
			$_SESSION['VOLVER']=$this->params['url']['url'];
			header("Location:/signup");
			 exit;
		}else{
			if(isset($_SESSION['VOLVER'])){
				 $_SESSION['VOLVER']=0;
				 unset($_SESSION['VOLVER']);
			 }
		}
        parent::beforeFilter();
    }

    var $name = 'Sponsorships';

    function admin_index($filter='complete') {
        $this->data['Sponsorship']['filter'] = $this->params['named']['filter'] = $filter;
//echo $filter;exit;
        $this->autoPaginateOptions('filter', array(
            'not-completed' => array('Sponsorship.status' => SPONSORSHIP_STATUS_INCOMPLETE),
            'completed' => array('Sponsorship.status' => SPONSORSHIP_STATUS_COMPLETE),
			'all_paypal' => array('Sponsorship.status like' => '%%'),
            'default' => 'all',
                )
        );
		 $this->paginate['conditions']['Sponsorship.plataforma ='] = 'PAYPAL';

        $this->autoPaginateOptions('sort', array(
            'Sponsorship.id',
            'Sponsorship.created',
            'Sponsorship.project_id',
            'Sponsorship.user_id',
            'Sponsorship.status',
                )
        );


        $this->autoPaginateOptions('search', array(
            'Sponsorship.id',
            'Sponsorship.user_id',
            'Sponsorship.project_id',
            'Project.title like' => '%:value%',
            'User.display_name like' => '%:value%',
            'User.email like' => '%:value%',
            'Sponsorship.payer_email like' => '%:value%',
                )
        );

        $this->_preparePaginate();

        $this->paginate['contain'] = array('User', 'Prize', 'Project');

        $this->data['results'] = $this->paginate('Sponsorship');
		//$this->render('/sponsorships/admin_index_mp');
    }

function admin_index2($filter='complete') {
	 	$this->set('tituloadmin','Mercado Pago');
        $this->data['Sponsorship']['filter'] = $this->params['named']['filter'] = $filter;
//echo $filter;exit;
        $this->autoPaginateOptions('filter', array(
            
            'default' => 'all',
                )
        );
		 $this->paginate['conditions']['Sponsorship.plataforma ='] = 'MERCADOPAGO';

        $this->autoPaginateOptions('sort', array(
            'Sponsorship.id',
            'Sponsorship.created',
            'Sponsorship.project_id',
            'Sponsorship.user_id',
            'Sponsorship.status',
                )
        );


        $this->autoPaginateOptions('search', array(
            'Sponsorship.id',
            'Sponsorship.user_id',
            'Sponsorship.project_id',
            'Project.title like' => '%:value%',
            'User.display_name like' => '%:value%',
            'User.email like' => '%:value%',
            'Sponsorship.payer_email like' => '%:value%',
                )
        );

        $this->_preparePaginate();

        $this->paginate['contain'] = array('User', 'Prize', 'Project');

        $this->data['results'] = $this->paginate('Sponsorship');
		
		$this->render('/sponsorships/admin_index_mp');
    }

    function index($model, $id) {
        $model = Inflector::classify($model);
		
        $modelData = $this->Sponsorship->{$model}->getViewData($id); // get view data for a project.
		Project::verifyPrivacityStatus($modelData['Project']['id'],$this->here);
        if ($this->Sponsorship->{$model}->isPublic($modelData)) {
            $sponsorships = array_unique(
                    Set::extract('/Sponsorship/user_id', $this->Sponsorship->find('all', array('fields' => 'Sponsorship.user_id', 'conditions' => array(
                                    "Sponsorship.{$model}_id" => $modelData[$model]['id'],
                                    "Sponsorship.status" => array(PAYPAL_STATUS_COMPLETED)
                                )
                                    )
                            )
                    )
            );

            //vd($sponsorships);


            $this->paginate['limit'] = 100;
            $this->paginate['conditions'] = array(
                "User.id" => $sponsorships,
            );

            $this->data = $this->paginate('User');
            $this->set(compact('model', 'id'));
        } else {
            $this->redirect($this->Sponsorship->{$model}->getLink($modelData));
        }
			App::import('model', 'Link');
			$pp=new Project();
			$datos=$pp->query("select * from links where model_id=". $modelData['Project']['id']." and model='Project'");
			$modelData['LOSLINKS']=$datos;
        $this->set(low($model), $modelData);
        $this->render(low($model) . '_sponsorships');
		
			
		
		
    }




    function add($model, $id, $user_id, $prize_id = 0,$rta=0) {
		Project::verifyPrivacityStatus($id,$this->here);
		$apaypal=0;
		if($rta){
			  $pat='/\/[^\/]*?$/is';
			  $url=$this->params['url']['url'];
			  $url='/'.preg_replace($pat,'',$url);
			  $this->Session->write('rta', $rta);
			  header("Location:$url");
			  exit;
		}
        $url['prize'] = $prize_id = isset($this->data['Prize']['id']) ? $this->data['Prize']['id'] : $prize_id;
        $model = Inflector::classify($model);
        $modelData = $this->Sponsorship->{$model}->getViewData($id); // get view data for a project.
		$this->data['Project']=$modelData[$model];
        if ($this->Sponsorship->{$model}->isPublic($modelData) && $this->data['Project']['time_left']>0) {
			
			
			
			
			
            $selectedPrize = $prize_id > 0 ? $this->Sponsorship->Prize->find('first', array(
                        'conditions' => array(
                            'Prize.id' => $prize_id,
                            'Prize.model' => $model,
                            'Prize.model_id' => $modelData[$model]['id']
                        ),
                        'contain' => array()
                            )
                    ) : null; // | get selected prize if is set.|



            if ($selectedPrize === false) {
                $this->redirect(
                        array(
                            'controller' => 'Sponsorships',
                            'action' => 'add',
                            'project' => $id,
                            'user' => $user_id,
                            'model' => low($model)
                        )
                );
                $this->data['Sponsorship']['contribution'] = isset($this->data['Sponsorship']['contribution']) ? $this->data['Sponsorship']['contribution'] : $selectedPrize['Prize']['value'];
            }

			
            $this->set(compact('model', 'id', 'selectedPrize', 'prize_id'));
            $this->set(low($model), $modelData);
			
			
			if(isset($this->data['mp']) && $this->data['mp']==1){
				
				
				 $this->data['Sponsorship']['contribution']=intval($this->data['Sponsorship']['contribution']);
				 if ($this->data['Sponsorship']['no_prize'] == 1) {
					$desc='(Eligió no recibir beneficio)';
					$beneficioono=0;
					if(empty($this->data['Sponsorship']['contribution'])){
						echo 
					'<script>
						top.$("retvvali").innerHTML="Introduce un monto válido";
					</script>';
					exit;
					}
					
				 }else{
					 $beneficioono=1;
					 if($this->data['Sponsorship']['contribution']<10 || $this->data['Sponsorship']['contribution']>200000 || $this->data['Sponsorship']['contribution']<$selectedPrize['Prize']['value']){
					echo 
					'<script>
						top.$("retvvali").innerHTML="Introduce un monto válido para el beneficio seleccionado";
					</script>';
					exit;
				}
					 
					 
					 $desc='(Eligió recibir beneficio)';
				 }
				
			$back_urls_success=Router::url('/',true).$this->params['url']['url'].'/s';
			$back_urls_pending=Router::url('/',true).$this->params['url']['url'].'/f';
			try{
			App::import('Vendor', 'mercadopago/mercado');
			$m=new MercadoPago();
			$checkoutPreferenceData = $m->getPreferenceValues(
			$this->data['Project']['id'],
			$this->data['Project']['title'],
			$desc,
			1,
			intval($this->data['Sponsorship']['contribution']),
			'ARS',
			'',
			'',
			'',
			'',
			$back_urls_success,
			$back_urls_pending,
			'',
			'',
			null,
			$this->data['Project']['id'].'__'.$this->Auth->user('id').'__'.intval($this->data['Sponsorship']['contribution']).'__'.$beneficioono.'__'.$this->data['Prize']['id'],
			false
			);
			$checkoutService = new CheckoutService();//new checkoutService instance
			$checkoutPreference=$checkoutService->create_checkout_preference($checkoutPreferenceData,$m->at);
			echo 
			'<script>
				top.location="https://www.mercadopago.com/checkout/pay?pref_id='.$checkoutPreference->getId().'";
			</script>';
			exit;
			}catch(Exception $e){
				
			}
			}
			
			
			
			
			
			
			
        } else {
            $this->redirect($this->Sponsorship->{$model}->getLink($modelData));
        }

        if ($this->data) {

            $url = array(
                'controller' => 'Sponsorships',
                'action' => 'add',
                'model' => $model,
                'user' => $user_id,
                low($model) => $id,
            );





            $this->Sponsorship->validate = array(
                'contribution' => array(
                    'RANGE_10_2000' => array(
                        'rule' => array('crange', '10', '200000'),
                        'required' => true,
                        'allowEmpty' => false
                    )
                )
            );

            $prizeValid = true;
            // vd($selectedPrize['Prize']['value']);
            if (isset($this->data['Sponsorship']['no_prize']) && $this->data['Sponsorship']['no_prize'] == 1) {
                unset($this->data['Prize']);
            } else {
                if (isset($this->data['Prize'])) {
                    $this->Sponsorship->validate['contribution']['RANGE_PRIZEVALUE_2000']['rule'] = array('crange', $selectedPrize['Prize']['value'], '200000');
				
                } else {
                    $this->Sponsorship->Prize->invalidate('Prize.id', __('PLEASE_SELECT_ONE_PRIZE', true));
                    $prizeValid = false;
                }
            }

            $this->Sponsorship->set($this->data);
            $validates =( $this->Sponsorship->validates() && $prizeValid );
			//vd($prizeValid);exit;
           




			



            /*if ($step == 1 && $validates) {
                $this->render('add_step_2');
            } elseif ($step == 2) {
			*/
			if ($validates) {
				
                $this->data['Sponsorship']['user_id'] = $this->Auth->user('id');
                $this->data['Sponsorship']['project_id'] = $modelData[$model]['id'];
                $this->data['Sponsorship']['prize_id'] = isset($this->data['Prize']['id']) ? $this->data['Prize']['id'] : 0;
                $this->data['Sponsorship']['status'] = SPONSORSHIP_STATUS_INCOMPLETE; // without status.
                $this->data['Sponsorship']['internal_status'] = SPONSORSHIP_PENDING;

                if ($this->Sponsorship->save($this->data)) {
					
					//die($this->Sponsorship->id);
                    if ($this->Sponsorship->id) {
						
                        // PRIZE information
                        if (isset($this->data['Prize']['id'])) {
                            $prize = $this->Sponsorship->Prize->read(null, $this->data['Prize']['id']);
                        }
                        $prize = isset($prize) && !empty($prize) ? truncate(sprintf(__('SELECTED_PRIZE %s', true), $prize['Prize']['description'], 127)) : __('YOU_ONLY_WANT_TO_HELP', true);

                        // Project information
                        $project = $this->Sponsorship->Project->read(null, $this->data['Sponsorship']['project_id']);
                        $PreapprovalTimeLeft = PREAPPROVA_EXTRA_TIME + $project['Project']['time_left'];
                        $PreapprovalTimeLeft = $PreapprovalTimeLeft > 0 ? $PreapprovalTimeLeft : PREAPPROVA_EXTRA_TIME;
                        $paymentType = $project['Project']['payment_type'];
						
                        App::import('Vendor', 'paypal');
                        $this->Paypal = new Paypal();
						$apaypal=1;
						//vd( $paymentType) ;exit;
                        //$lname = sprintf(__('PROJECT_SPONSORSHIP %s', true), money_format('%(#10n', $this->data['Sponsorship']['contribution']));
                        $lname = sprintf(__('PROJECT_SPONSORSHIP %s', true), ( $this->data['Sponsorship']['contribution']));
						if ($paymentType == EXPRESSCHECKOUT || $paymentType == PREAPPROVAL) {
							
                            $paypalResponse = $this->Paypal->hashCall('SetExpressCheckout', array(
                                        'PAYMENTACTION' => 'Sale',
                                        'NOSHIPPING' => '1',
                                        'L_NAME0' => $lname,
                                        'L_QTY0' => '1',
                                        'L_AMT0' => $this->data['Sponsorship']['contribution'],
                                        'L_DESC0' => $prize,
                                        'AMT' => $this->data['Sponsorship']['contribution'],
                                        'CURRENCYCODE' => 'USD',
                                        'NOTIFYURL' => Router::url(array('controller' => 'sponsorships', 'action' => 'process', 'payment', $this->Sponsorship->id, 'ipn'), true),
                                        'CANCELURL' => Router::url(array('controller' => 'sponsorships', 'action' => 'process', 'payment', $this->Sponsorship->id, 'cancel'), true),
                                        'RETURNURL' => Router::url(array('controller' => 'sponsorships', 'action' => 'process', 'payment', $this->Sponsorship->id, 'return'), true),
                                        'CUSTOM' => $this->Sponsorship->id
                                            )
                            );
							/*print_r( $paypalResponse);exit;*/
                            $payPalURL = $this->Paypal->getUrl('SetExpressCheckout', $paypalResponse);
							/*echo $payPalURL;exit;*/
                        } elseif ($paymentType == 'PREAPPROVAL') {
							
                            $paypalResponse = $this->Paypal->xhashCall('AdaptivePayments/Preapproval', array(
                                        "requestEnvelope.errorLanguage" => "en_US",
                                        "currencyCode" => "USD",
                                        "cancelUrl" => Router::url(array('controller' => 'sponsorships', 'action' => 'process', 'xpayment', $this->Sponsorship->id, 'cancel'), true),
                                        "returnUrl" => Router::url(array('controller' => 'sponsorships', 'action' => 'process', 'xpayment', $this->Sponsorship->id, 'return'), true),
                                        "ipnNotificationUrl" => Router::url(array('controller' => 'sponsorships', 'action' => 'process', 'xpayment', $this->Sponsorship->id, 'ipn'), true),
                                        "startingDate" => date('Y-m-d') . "T00:00:00",
                                        "endingDate" => date('Y-m-d', strtotime("+$PreapprovalTimeLeft days")) . "T00:00:00",
                                        "maxAmountPerPayment" => $this->data['Sponsorship']['contribution'],
                                        "maxNumberOfPayments" => 1,
                                        "maxNumberOfPaymentsPerPeriod" => 1,
                                        "maxTotalAmountOfAllPayments" => $this->data['Sponsorship']['contribution'],
                                        'memo' => $lname . ', ' . $prize,
                                        'CUSTOM' => $this->Sponsorship->id
                                            )
                            );

                            $payPalURL = $this->Paypal->getUrl('AdaptivePayments/Preapproval', $paypalResponse);
                        }

						
						
                        if ($payPalURL) {
                            $this->data = $this->Sponsorship->read(null, $this->Sponsorship->id);
                            $this->data['Sponsorship']['payment_type'] = $paymentType;
                            if ($paymentType == EXPRESSCHECKOUT) {
                                $this->data['Sponsorship']['expresscheckout_token'] = $paypalResponse["TOKEN"];
                            } elseif ($paymentType == PREAPPROVAL) {
                                $this->data['Sponsorship']['preapproval_key'] = $paypalResponse["preapprovalKey"];
                            }
                            $this->Sponsorship->save($this->data);
                            $this->redirect($payPalURL);
                        } else {
                            $this->Sponsorship->delete($this->Sponsorship->id); // if paypal fail delete created sponsorship [cleaning]
                        }
                    }
                }
               // $this->render('add_step_2');
            }
            $this->set('url', Router::url($url));
        }
		 if($this->data && isset($this->data['v']) && $this->data['v']==1 && !$apaypal) {
			$this->set('validationErrorsArray', $this->Sponsorship->invalidFields());
		 }
    }
	
	
	

    function process($api, $sponsorship_id, $status=null) {
        App::import('Vendor', 'paypal');
        $this->Paypal = new Paypal();
        $messageStatus = null;
        $this->Sponsorship->recursive = -1;

        if (low($api) == 'xpayment') {
            if ($status == 'ipn' && !empty($this->params['form'])) {

                $sponsorshipStatus = $this->Sponsorship->updatePreApprovalStatus($sponsorship_id, $this->params['form']['preapproval_key']);

                if (!$this->Sponsorship->User->Notification->add(
                                'PROJECT_NEW_BACKER'
                                , $this->Sponsorship->find(array('Sponsorship.id' => $sponsorship['Sponsorship']['id']))
                                , $sponsorship['Sponsorship']['user_id']
                        )
                ) {
                    $this->log('Error : notification not saved ', 'NOTIFICATIONS_LOG');
                } else {
                    $this->requestAction(Router::url(array('controller' => 'mails', 'action' => 'email', 'admin' => false, $this->Sponsorship->User->Notification->id)));
                }

                if ($this->Sponsorship->User->Notification->add('PROJECT_NEW_BACKER_PRE_APPROVAL', $sponsorship, $user_id, $owner_id)) {
                    $this->requestAction(Router::url(array('controller' => 'mails', 'action' => 'email', 'admin' => false, $this->Sponsorship->User->Notification->id)));
                }
            }
        } elseif (low($api) == 'payment') {
            $token = $this->params['url']['token']; // TOKEN FROM URL
            $payerID = $this->params['url']['PayerID'];
            if ($status == 'return') { // EL USUARUIO VUELVE DESDE PAYPAL
                if (!$this->Sponsorship->DoExpressCheckoutPayment($sponsorship_id, $token, $payerID)) {
                    $messageStatus = 'not-complete';
                    $this->log("$sponsorship_id $token has not been finished", 'DoExpressCheckoutPayment');
                } else {
					
                    $this->log("$sponsorship_id $token has been finished", 'DoExpressCheckoutPayment');
                }
				
            } elseif ($status == 'ipn') { //--------------------- EXPRESS CHECKOUT IPN --------------------------- || listo
                $transaction_id = $this->params['form']['txn_id'];
                $sponsorshipStatus = $this->Sponsorship->updateExpressCheckoutStatus($sponsorship_id, $transaction_id);

                $this->log("$sponsorship_id $transaction_id has been finished with status [$sponsorshipStatus]", 'updateExpressCheckoutStatus');
				
				
				

                if ($sponsorshipStatus == PAYPAL_STATUS_COMPLETED) { // create notification and send emails-
					 $this->Sponsorship->recursive = 1;
                    $sponsorship = $this->Sponsorship->find(array('Sponsorship.id' =>$sponsorship_id));
					
                    $user_id = $sponsorship['Sponsorship']['user_id'];
                    $owner_id = $sponsorship['Project']['user_id'];
					
					
					
					if (!$this->Sponsorship->User->Notification->add(
									'PROJECT_NEW_BACKER'
									, $sponsorship
									,  $user_id,$owner_id
							)
					) {
						$this->log('Error : notification not saved ', 'NOTIFICATIONS_LOG');
					} else {
						
						$this->requestAction(Router::url(array('controller' => 'mails', 'action' => 'email', 'admin' => false, $this->Sponsorship->User->Notification->id)));
					}
					//$sponsorship['User']['id']=$user_id;
					
					if ($this->Sponsorship->User->Notification->add('PROJECT_NEW_BACKER_PRE_APPROVAL', $sponsorship, $user_id)) {
						
						$this->requestAction(Router::url(array('controller' => 'mails', 'action' => 'email', 'admin' => false, $this->Sponsorship->User->Notification->id)));
					}
					
					
					
					
					
                }
            }
        } elseif (low($api) == 'message') {
			// $this->set('message', 'PAYMENT_' . up($sponsorship_id));
			
        }

        if ($status == 'cancel') {
            $sponsorship = $this->Sponsorship->find(array('Sponsorship.expresscheckout_token' => $this->params['url']['token']));
            if ($sponsorship) {
                $this->Sponsorship->delete($sponsorship['Sponsorship']['id']);
            }
        }

        if (low($api) != 'message') {
            $this->log(serialize($this->params), 'paypal.payments.' . $api);
        }

        if (is_null($messageStatus) && low($status) == 'return') {
            $messageStatus = 'complete';
        } elseif (is_null($messageStatus) && low($status) == 'cancel') {
            $messageStatus = 'canceled';
        } elseif (is_null($messageStatus) && low($status) == 'ipn') {
            $this->render('/common/ajax', 'ajax');
        }

        if (isset($messageStatus)) {
            $this->redirect(Router::url(
                            array(
                                'controller' => 'sponsorships',
                                'action' => 'process',
                                'message',
                                $messageStatus
                            )
                    )
            );
        } else {
            $this->set('message', 'PAYMENT_' . up($sponsorship_id));
        }
		
    }

    function masspay_ipn($response) {

        $ok = true;
        if (is_string($response)) {
            $response = unserialize(base64_decode($response));
            if ($response['form']['test_ipn'] != 1) {
                $ok = false;
            }
        }

        if ($ok) {

            for ($a = 1; $a <= 250; $a++) {
                if (isset($response['form']["masspay_txn_id_$a"])) {

                    $this->data = $this->Sponsorship->read(null, $response['form']["unique_id_$a"]);

                    $this->data['Sponsorship']["masspay_masspay_txn_id"] = $response['form']["masspay_txn_id_$a"];
                    $this->data['Sponsorship']["masspay_receiver_email"] = $response['form']["receiver_email_$a"];
                    $this->data['Sponsorship']["masspay_status"] = up($response['form']["status_$a"]);
                    $this->data['Sponsorship']["masspay_mc_currency"] = $response['form']["mc_currency_$a"];
                    $this->data['Sponsorship']["masspay_mc_gross"] = (real) $response['form']["mc_gross_$a"];
                    $this->data['Sponsorship']["masspay_mc_fee"] = (real) $response['form']["mc_fee_$a"];

                    $this->Sponsorship->save($this->data);
                } else {
                    break;
                }
            }



            // get transaction details ?¿
        }
        $this->render('/common/ajax', 'default');
    }

    function dump() {

        $this->log(serialize($this->params), 'paypal.dump');

        $txn_type = !empty($this->params['form']['txn_type']) ? low($this->params['form']['txn_type']) : null;
        if ($txn_type) {


            switch ($txn_type) {
                case 'masspay':
                    $this->masspay_ipn($this->params);
                    break;
                default:
                    break;
            }
        }


        $this->render('/common/ajax', 'ajax');
    }

    function view_dump($file = 'paypal.dump.log', $response=false) {

        $logs = array();
        $this->set('file', $file);


        $log = fopen(LOGS . $file, 'r');

        if ($log) {
            $line = 0;

            while (($buffer = fgets($log, 4096)) !== false) {
                list($date, $serializedData) = array_map('trim', explode(': ', $buffer));
                $logs[$line]['date'] = $date;
                $logs[$line]['data'] = base64_encode($serializedData);
                $line++;
            }

            if (!feof($log)) {
                vd("Error: fallo inesperado de fgets()\n");
            }

            fclose($log);
        } else {

            vd("No log opened");
        }

        if ($response) {
            $data = base64_decode($response);
            if (unserialize($data)) {
                $data = unserialize($data);
            } else {
                $data = $data;
            }

            $this->set('response', $data);
        }

        if ($logs) {

            $this->set('logs', $logs);
        }

        $dir = opendir(LOGS);
        while ($file = readdir($dir)) {
            if (preg_match("/\.log$/", $file)) {
                $files[] = $file;
            }
        }
        closedir($dir);



        $this->set('files', $files);

        //  $this->layout = 'ajax';
    }

    function listing($user=true) { //listing
        $this->data = $this->Sponsorship->User->getUser($user);

        if ($this->data) {


            $sponsorships = array_unique(Set::extract('/Sponsorship/project_id', $this->Sponsorship->find('all', array('fields' => 'Sponsorship.project_id', 'conditions' => array("Sponsorship.status" => array(PAYPAL_STATUS_COMPLETED), "Sponsorship.user_id" => $this->data['User']['id'])))));

            $query = $this->Sponsorship->Project->queryStandarSet(false);

            $query['conditions'] = array('Project.id' => $sponsorships);

            // $query['contain'][] =   'Sponsorship.Prize' ;

            $this->data['Projects'] = $this->Sponsorship->Project->find('all', $query);
        } else {
            $this->pageError = array('code' => 404);
        }



        $this->set('section', 'sponsorships'); //??
        $this->render('/users/view');
    }

    function admin_charge($sponsorshipId) {
        $sponsorship = $this->Sponsorship->read(null, $sponsorshipId);
        if ($this->Sponsorship->adaptivepayments_pay($sponsorship)) {
            $this->data = array('status' => 1);
        } else {
            $this->data = array('status' => 0);
        }
        $this->render('/common/json_response', 'json/default');
    }

    function admin_charge_all($projectId) {
        App::import('Vendor', 'paypal');
        $this->Paypal = new Paypal();

        $balance = $this->Paypal->getBalance();

        $total = $this->Sponsorship->tranferFounds($projectId, true);

        $balance2 = $this->Paypal->getBalance();



        $this->redirect(
                Router::url(array(
                    'controller' => 'projects',
                    'action' => 'projectBalance',
                    'admin' => true,
                    $projectId
                        )
                )
        );
    }
	function mp_ipn(){
		$err=0;
		//mail('andres@genes.com.ar','test',$_REQUEST['topic'].'---'.$_REQUEST['id']);
		//exit;
		App::import('Vendor', 'mercadopago/mercado');
		$m=new MercadoPago();
		
		//$_REQUEST['id']='433263334';
		
		$URL = "https://api.mercadolibre.com/collections/notifications/".$_REQUEST['id']."?access_token=".$m->at; //checkout API
		
		// START Request
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); //return the transference value like a string
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Accept: application/json', 'Content-Type: application/json'));//sets the header
		curl_setopt($ch, CURLOPT_URL, $URL); //Preference API
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
		

		$datos = curl_exec($ch);//execute the conection
		$datosHttpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);//status
		
		if($datosHttpcode != 201)
	 	{
	        $err=1;
	 	}
		curl_close($ch); //conection close
		// Request OK
		$datos=json_decode(($datos),true);//co
		
		/*echo '<pre>';
		print_r($datos);
		echo '</pre>';
		exit;*/
		if(isset($datos['collection']['id']) && isset($datos['collection']['status'])  && $datos['collection']['status']=='approved'){
		//if(isset($datos['collection']['id']) && isset($datos['collection']['status'])  && $datos['collection']['status']=='pending'){
				$varios=explode('__',$datos['collection']['external_reference']);
				
				/*App::import('model', 'Sponsorship');
				$pp=new Sponsorship();
				$pp->query("insert into sponsorships 
				(
					user_id,
					project_id,
					prize_id,
					contribution,
					status,
					created,
					modified,
					plataforma,
					transferred								  
				) 
				values 
				(
					'".$varios[1]."',
					'".$varios[0]."',
					'".$varios[4]."',
					'".$varios[2]."',
					'1',
					'".$datos['collection']['date_created']."',
					'".$datos['collection']['last_modified']."',
					'MERCADOPAGO',
					'1'	
				)");
				*/
				$this->data['Sponsorship']['user_id']=$varios[1];
				$this->data['Sponsorship']['project_id']=$varios[0];
				$this->data['Sponsorship']['prize_id']=$varios[4];
				$this->data['Sponsorship']['contribution']=$varios[2];
				$this->data['Sponsorship']['status']=1;
				$this->data['Sponsorship']['created']=$datos['collection']['date_created'];
				$this->data['Sponsorship']['modified']=$datos['collection']['last_modified'];
				$this->data['Sponsorship']['plataforma']='MERCADOPAGO';
				$this->data['Sponsorship']['transferred']=1;
				$this->data['Sponsorship']['idmercadolibre']=$_REQUEST['id'];
				$this->data['Sponsorship']['payment_type']='EXPRESSCHECKOUT';
				$this->data['Sponsorship']['expresscheckout_status']='COMPLETED';
				if (!$this->Sponsorship->save($this->data)) {
					header('HTTP/1.1 404 Not Found');
					exit;
				}
				//echo $this->Sponsorship->id;
				//$sponsorship=$this->Sponsorship->find(array('Sponsorship.id' => $sponsorship['Sponsorship']['id']));
				
				if ($this->Sponsorship->id) {
					
					$sponsorship=$this->Sponsorship->find(array('Sponsorship.id' => $this->Sponsorship->id));
					//vd($sponsorship);
					$owner_id=$sponsorship["Project"]["user_id"];
					
					$user_id=$varios[1];
					
					if (!$this->Sponsorship->User->Notification->add(
									'PROJECT_NEW_BACKER'
									, $this->Sponsorship->find(array('Sponsorship.id' => $sponsorship['Sponsorship']['id']))
									, $owner_id
							)
					) {
						$this->log('Error : notification not saved ', 'NOTIFICATIONS_LOG');
					} else {
						
						$this->requestAction(Router::url(array('controller' => 'mails', 'action' => 'email', 'admin' => false, $this->Sponsorship->User->Notification->id)));
					}
					//$sponsorship['User']['id']=$user_id;
					
					if ($this->Sponsorship->User->Notification->add('PROJECT_NEW_BACKER_PRE_APPROVAL', $sponsorship, $user_id)) {
						
						$this->requestAction(Router::url(array('controller' => 'mails', 'action' => 'email', 'admin' => false, $this->Sponsorship->User->Notification->id)));
					}
				
				}
				
				
		}
		
		echo 'ok';
		exit;
		
		
	}

}
?>