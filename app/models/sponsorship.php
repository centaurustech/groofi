<?php

/**
 * @property User $User
 * @property Project $Project
 * @property Prize $Prize
 *
 * */
class Sponsorship extends AppModel {

    var $name = 'Sponsorship';
    var $belongsTo = array(
        'User' => array(
            'className' => 'User',
            'foreignKey' => 'user_id',
            'counterCache' => 'sponsorships_count',
            'counterScope' => array('Sponsorship.transferred' => 1),
            'conditions' => array(),
            'dependent' => true,
        ),
        'Project' => array(
            'className' => 'Project',
            'foreignKey' => 'project_id',
            'counterCache' => 'sponsorships_count',
            'counterScope' => array('Sponsorship.transferred' => 1),
            'conditions' => array(),
            'dependent' => true,
        ),
        'Prize' => array(
            'className' => 'Prize',
            'foreignKey' => 'prize_id',
            'counterCache' => 'sponsorships_count',
            'counterScope' => array('Sponsorship.transferred' => 1),
            'conditions' => array(),
            'dependent' => true,
        ),
    );

    function getPaymentType($sponsorship) {
        return $sponsorship[$this->alias]['payment_type'];
    }

    function isTransferred($sponsorship, $payment_type) {
      
        return $sponsorship[$this->alias]['transferred'] == 1 ;
        /*
        if ($payment_type == EXPRESSCHECKOUT) {

            return ( $sponsorship[$this->alias]['status'] == PAYPAL_STATUS_COMPLETED || $sponsorship[$this->alias]['status'] == PAYPAL_STATUS_CHARGED ) && $sponsorship[$this->alias]['transferred'] == 1;
        } else {
            if (( $sponsorship[$this->alias]['status'] == PAYPAL_STATUS_COMPLETED || $sponsorship[$this->alias]['status'] == PAYPAL_STATUS_CHARGED ) && $sponsorship[$this->alias]['transferred'] == 1) {
                return true;
            } else { // check some variables.....
                if ($sponsorship[$this->alias]['preapproval_curpayments'] > 0) {
                    return true;
                } else {
                    return false;
                }
            }
        }
        
        */
    }

    /*
     * Return all tranfered sponsorships
     */

    function tranferFounds($project_id, $returnTotal=false, $adaptivepayments_pay = true) {

        App::import('Vendor', 'paypal');
        $this->Paypal = new Paypal();


        $this->recursive = -1;
        $sponsorships = $this->find('all', array('conditions' => array('Sponsorship.project_id' => $project_id)));

        $tranferredSponsorships = array();
        $total = 0;
        foreach ($sponsorships as $sponsorship) {
            $sponsorship_id = $sponsorship[$this->alias]['id'];
            if ($this->getPaymentType($sponsorship) == EXPRESSCHECKOUT) { // all of these payments are already on our paypal account, no tenemos que hacer nada.
                if ($this->isTransferred($sponsorship, EXPRESSCHECKOUT)) { // se marco como trasferido ? 
                    $total += $sponsorship[$this->alias]['contribution'];
                    $tranferredSponsorships[] = $sponsorship;
                } else {
                    $transactionId = $sponsorship[$this->alias]['expresscheckout_transaction_id'];
                    if (!empty($transactionId)) {
                        $response = $this->Paypal->hashCall('GetTransactionDetails', array('TRANSACTIONID' => $transactionId));
                        if ($this->updateExpressCheckoutStatus($sponsorship_id, $transactionId)) {
                            $total += $sponsorship[$this->alias]['contribution'];
                            $tranferredSponsorships[] = $sponsorship;
                        }
                    }
                }
            } elseif ($this->getPaymentType($sponsorship) == PREAPPROVAL) {
                if ($this->isTransferred($sponsorship, PREAPPROVAL)) { // se marco como trasferido ? 
                    $total += $sponsorship[$this->alias]['contribution'];
                    $tranferredSponsorships[] = $sponsorship;
                } else {
                    $preapproval_key = $sponsorship[$this->alias]['preapproval_key'];
                    if ($this->updatePreApprovalStatus($sponsorship_id, $preapproval_key)) { // actualizamos el pago | si esta activo ....
                        $transferred = true;
                        $sponsorship = $this->read(null, $sponsorship_id);
                        if (!$this->isTransferred($sponsorship, PREAPPROVAL)) {
                            // transferimos el pago a groofi $transferred = true ;
                            if ($adaptivepayments_pay == true && $this->adaptivepayments_pay($sponsorship)) { //
                                $total += $sponsorship[$this->alias]['contribution'];
                                $tranferredSponsorships[] = $sponsorship;
                            } elseif ($adaptivepayments_pay == false) {
                                $total += $sponsorship[$this->alias]['contribution'];
                                $tranferredSponsorships[] = $sponsorship;
                            }
                        } else {
                            $total += $sponsorship[$this->alias]['contribution'];
                            $tranferredSponsorships[] = $sponsorship;
                            $sponsorship[$this->alias]['internal_status'] = SPONSORSHIP_TRANSFERRED;
                            $sponsorship[$this->alias]['transferred'] = 1;
                            $this->save($sponsorship);
                        }
                    }
                }
            }
        }
        return $returnTotal ? $total : $tranferredSponsorships;
    }

    function isSponsoring($user_id, $projects) {
        return in_array($user_id, array_unique(Set::extract('/Project/Sponsorship/user_id', $projects)));
    }

    function adaptivepayments_pay($sponsorship) {

        //vd('adaptivepayments_pay'); 
        $trasferred = false;
        App::import('Vendor', 'paypal');
        $this->Paypal = new Paypal();

        $preApprovalParams = array(
            'actionType' => 'PAY',
            "receiverList.receiver(0).email" => PAYPAL_EMAIL,
            "receiverList.receiver(0).amount" => $sponsorship[$this->alias]['contribution'],
            "currencyCode" => 'USD',
            "requestEnvelope.errorLanguage" => "en_US",
            "preapprovalKey" => urlencode($sponsorship[$this->alias]['preapproval_key']),
            "cancelUrl" => Router::url(array('controller' => 'sponsorships', 'action' => 'process', 'xpayment', $sponsorship[$this->alias]['project_id'], 'cancel'), true),
            "returnUrl" => Router::url(array('controller' => 'sponsorships', 'action' => 'process', 'xpayment', $sponsorship[$this->alias]['project_id'], 'return'), true),
        );

        $paypalResponse = $this->Paypal->xhashCall('AdaptivePayments/Pay', $preApprovalParams);

        if ($this->Paypal->checkResponse($paypalResponse)) {
            if ($paypalResponse["paymentExecStatus"] == 'COMPLETED') {
                $sponsorship[$this->alias]['transferred'] = 1;
                $sponsorship[$this->alias]['internal_status'] = SPONSORSHIP_TRANSFERRED;
                $this->save($sponsorship);
                $trasferred = true;
            } else {
                $errors[] = $paypalResponse;
                $this->log(serialize($paypalResponse), 'admin_financeproject.error');
            }
        } else {
            $errors[] = $paypalResponse;
            $this->log(serialize($paypalResponse), 'admin_financeproject.error');
        }

        return $trasferred;
    }

    function updatePreApprovalStatus($sponsorship_id, $preapproval_key=null, $save=true) {
        App::import('Vendor', 'paypal');
        $this->Paypal = new Paypal();


        if (is_array($sponsorship_id) && empty($preapproval_key)) {
            $sponsorship = $sponsorship_id;
            $preapproval_key = $sponsorship['Sponsorship']['preapproval_key'];
        } else {
            $sponsorship = $this->read(null, $sponsorship_id);
        }

        $sponsorshipStatus = false;

        if ($sponsorship && !empty($preapproval_key)) {
            $params = array(
                "requestEnvelope.errorLanguage" => "en_US",
                'preapprovalKey' => $preapproval_key
            );
            $preapprovalDetails = $this->Paypal->xhashCall('AdaptivePayments/PreapprovalDetails', $params);
            //------------------------------------------------------------------
            $approved = low($preapprovalDetails['approved']) == 'true' ? true : false;
            $status = up($preapprovalDetails['status']);
            $sponsorshipStatus = $approved && (up($preapprovalDetails['status']) == 'ACTIVE');
            $sponsorship['Sponsorship']['preapproval_curpayments'] = $preapprovalDetails["curPayments"];
            $sponsorship['Sponsorship']['preapproval_curpaymentsamount'] = $preapprovalDetails["curPaymentsAmount"];
            $sponsorship['Sponsorship']['preapproval_curperiodattempts'] = $preapprovalDetails["curPeriodAttempts"];
            $sponsorship['Sponsorship']['preapproval_currencycode'] = $preapprovalDetails["currencyCode"];

            $sponsorship['Sponsorship']['preapproval_approved'] = $approved;
            $sponsorship['Sponsorship']['preapproval_status'] = $status;
            $sponsorship['Sponsorship']['status'] = $sponsorshipStatus;
            if ($sponsorshipStatus) {
                $sponsorship['Sponsorship']['internal_status'] = SPONSORSHIP_COMPLETED;
            } else {
                $sponsorship['Sponsorship']['internal_status'] = SPONSORSHIP_PENDING;
            }
            if ($save) {
                $this->save($sponsorship);
            }
        }
        return $sponsorshipStatus;
    }

    function DoExpressCheckoutPayment($sponsorship_id, $token, $payer_id) {
        $DoExpressCheckoutPayment = false;
        App::import('Vendor', 'paypal');
        $this->Paypal = new Paypal();
        //---
        $sponsorship = $this->read(null, $sponsorship_id);
        $getExpressCheckoutDetails = $this->Paypal->hashCall('GetExpressCheckoutDetails', array('TOKEN' => $token)); // obtenemos informacion del pago
        //---
        if ((float) $sponsorship['Sponsorship']['contribution'] == (float) $getExpressCheckoutDetails['AMT']) {

            $sponsorship['Sponsorship']['internal_status'] = SPONSORSHIP_PENDING;
            $sponsorship['Sponsorship']['internal_checkoutstatus'] = $getExpressCheckoutDetails['CHECKOUTSTATUS'];

            $params = array(
                'PAYMENTACTION' => 'Sale',
                'TOKEN' => $token,
                'PAYERID' => $payer_id,
                'AMT' => $getExpressCheckoutDetails['AMT'],
                'CURRENCYCODE' => $getExpressCheckoutDetails['CURRENCYCODE'],
                'IPADDRESS' => urlencode($_SERVER['SERVER_NAME']),
                'NOTIFYURL' => Router::url(array('controller' => 'sponsorships', 'action' => 'process', 'payment', $sponsorship_id, 'ipn'), true)
            );

            $DoExpressCheckoutPayment = $this->Paypal->hashCall('DoExpressCheckoutPayment', $params);

            $logData = array(
                $DoExpressCheckoutPayment, $params, $sponsorship_id, $token, $payer_id
            );

            $this->log(serialize($logData), 'DoExpressCheckoutPayment');
        } else {
            $sponsorship['Sponsorship']['internal_status'] = SPONSORSHIP_ERROR;
            $sponsorship['Sponsorship']['expresscheckout_checkoutstatus'] = $getExpressCheckoutDetails['CHECKOUTSTATUS'];
        }

        $this->save($sponsorship);

        return (bool) $DoExpressCheckoutPayment;
    }

    function updateExpressCheckoutStatus($sponsorship_id, $transaction_id=null) {
        App::import('Vendor', 'paypal');
        $this->Paypal = new Paypal();

        $sponsorshipStatus = false;



        if (is_array($sponsorship_id) && empty($transaction_id)) {
            $sponsorship = $sponsorship_id;
            $transaction_id = $sponsorship['Sponsorship']['expresscheckout_transaction_id'];
        } else {
            $sponsorship = $this->read(null, $sponsorship_id);
        }



        $transactionDetails = $this->Paypal->hashCall('gettransactionDetails', array('TRANSACTIONID' => $transaction_id)); // get transaction info from paypal
 
        if ($sponsorship && !empty($transaction_id)) {

            $this->log(serialize($transactionDetails), 'paypal.expresscheckout.transactiondetails');


            $transactionStatus = up($transactionDetails['PAYMENTSTATUS']);
            $sponsorshipStatus = Configure::read('Paypal.payment.status');
            $sponsorshipStatus = $sponsorshipStatus[$transactionStatus];
            $sponsorship['Sponsorship']['payer_id'] = $transactionDetails['PAYERID'];
            $sponsorship['Sponsorship']['payer_email'] = $transactionDetails['EMAIL'];
            $sponsorship['Sponsorship']['receiver_id'] = $transactionDetails['RECEIVERID'];
            $sponsorship['Sponsorship']['receiver_email'] = $transactionDetails['RECEIVEREMAIL'];
            $sponsorship['Sponsorship']['expresscheckout_transaction_id'] = $transaction_id;
            $sponsorship['Sponsorship']['expresscheckout_status'] = $transactionStatus;
            $sponsorship['Sponsorship']['expresscheckout_response'] = serialize($transactionDetails);
            $sponsorship['Sponsorship']['status'] = $sponsorshipStatus;

            if ($sponsorshipStatus == PAYPAL_STATUS_COMPLETED) {
                $sponsorship['Sponsorship']['internal_status'] = SPONSORSHIP_TRANSFERRED;
                $sponsorship['Sponsorship']['transferred'] = 1;
            }

            $this->save($sponsorship);
        } else {

            $this->log(serialize($transactionDetails), 'paypal.expresscheckout.transactiondetails');
        }
        return $sponsorshipStatus;
    }

    function refound_project($project_id) {
        App::import('Vendor', 'paypal');
        $this->Paypal = new Paypal();
        $this->recursive = -1;
        //'Sponsorship.refound' => 0, 
        $refound_payments = $this->find('all', array('conditions' => array('Sponsorship.project_id' => $project_id, 'Sponsorship.payment_type' => EXPRESSCHECKOUT))); // Only not refunded payments


        foreach ($refound_payments as $key => $payment) {
            $status = $this->updateExpressCheckoutStatus($payment);
            if ($status != PAYPAL_STATUS_COMPLETED) {
                unset($refound_payments[$key]);
            }
        }

        $balance = $this->Paypal->getBalance();

        $ok = true;
        // ---------------------------------------------------------------- 
        $refoundTotal = 0;

        $massPaymentParams = array(
            'EMAILSUBJECT' => __('PAYMENT_FROM_GROOFI', true),
            'RECEIVERTYPE' => 'EmailAddress',
            'CURRENCYCODE' => 'USD',
        );


        //----------------------------------------------------------------------

        $key = 0;
        foreach ($refound_payments as $sponsorship) {
            if ($sponsorship['Sponsorship']['refound'] == 0) {
                $massPaymentParams["L_EMAIL$key"] = $sponsorship['Sponsorship']['payer_email'];
                $massPaymentParams["L_AMT$key"] = $sponsorship['Sponsorship']['contribution'];
                $massPaymentParams["L_UNIQUEID$key"] = $sponsorship['Sponsorship']['id'];
                $massPaymentParams["L_NOTE$key"] = __('PAYMENT_FROM_GROOFI', true);
                $refoundTotal += $sponsorship['Sponsorship']['contribution'] + PAYPAL_MASSPAYMENT_COST;
                $key++;
            }
        }



        if ($balance > $refoundTotal) {
            $paypalResponse = $this->Paypal->hashCall('MassPay', $massPaymentParams);

            if ($this->Paypal->checkResponse($paypalResponse)) {
                foreach ($refound_payments as $sponsorship) {
                    $sponsorship['Sponsorship']['refound'] = 1;
                    $this->Project->Sponsorship->save($sponsorship);
                }
            }
        } else {
            $ok = false;  // We have not enought money to refound the transaction
        }

        //----------------------------------------------------------------------

        $cancellable_payments = $this->find('all', array('conditions' => array('Sponsorship.refound' => 0, 'Sponsorship.project_id' => $project_id, 'Sponsorship.payment_type' => PREAPPROVAL)));

        foreach ($cancellable_payments as $key => $payment) {
            if ($this->cancel_pre_appoval($payment['Sponsorship']['preapproval_key'])) {

                $payment['Sponsorship']['refound'] = 1;

                $this->Project->Sponsorship->save($payment);

                $this->updatePreApprovalStatus($payment, null, false);
            }
        }



        return $ok;
    }

    function cancel_pre_appoval($preapproval_key) {

        App::import('Vendor', 'paypal');
        $this->Paypal = new Paypal();
        if (!empty($preapproval_key)) {

            $nvpParams = array("requestEnvelope.errorLanguage" => "en_US",
                "preapprovalKey" => $preapproval_key
            );

            $response = $this->Paypal->xhashCall('AdaptivePayments/CancelPreapproval', $nvpParams);

            return $this->Paypal->checkResponse($response);
        } else {
            return false;
        }
    }

    function refound_transaction($sponsorship) {
        
    }

}

?>