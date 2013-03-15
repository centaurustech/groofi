<?php
ob_start();
set_time_limit(0);
//this archive contains client credentials
require_once "src/config.php";
//classes requireds
require_once "src/classes/checkoutPreference.php";
require_once "src/classes/checkoutPreferencePayer.php";
require_once "src/classes/checkoutPreferenceItems.php";
require_once "src/classes/checkoutPreferencePaymentMethods.php";
require_once "src/classes/checkoutPreferenceBackUrls.php";
require_once "src/classes/checkoutPreferenceExcludedPaymentMethods.php";
require_once "src/classes/checkoutPreferenceExcludedPaymentTypes.php";
require_once "src/classes/accessData.php";
require_once "src/services/authService.php";
require_once "src/services/checkoutService.php";
require_once "src/classes/checkoutPreferenceData.php";
require_once "src/classes/checkoutPreferenceDataItems.php";
require_once "src/classes/checkoutPreferenceDataPayer.php";
require_once "src/classes/checkoutPreferenceDataBackUrls.php";
require_once "src/classes/checkoutPreferenceDataPaymentMethods.php";
require_once "src/classes/checkoutPreferenceDataExcludedPaymentMethods.php";
require_once "src/classes/checkoutPreferenceDataExcludedPaymentTypes.php";
require_once "src/classes/checkoutPreference.php";
require_once "src/classes/checkoutPreferenceItems.php";
require_once "src/classes/checkoutPreferencePayer.php";
require_once "src/classes/checkoutPreferenceBackUrls.php";
require_once "src/classes/checkoutPreferencePaymentMethods.php";
require_once "src/classes/checkoutPreferenceExcludedPaymentMethods.php";
require_once "src/classes/checkoutPreferenceExcludedPaymentTypes.php";

class MercadoPago{
	public $at;
	public $error=1;
	function MercadoPago(){
		try {
			$authService = new AuthService();//new instance Auth class
			$accessData= $authService->create_access_data(CLIENT_ID,CLIENT_SECRET);
			if(gettype($accessData)=='string'){
				$this->error=1;
			}
			$this->at=$accessData->getAccessToken();
		}catch(Exception $e){
			$this->error=1;
		}
	}
	
	function getPreferenceValues(
								 $item_id,
								 $item_title,
								 $item_description,
								 $item_quantity,
								 $item_unit_price,
								 $item_currency_id,
								 $item_picture_url,
								 $payer_name,
								 $payer_surname,
								 $payer_email,
								 $back_urls_success,
								 $back_urls_pending,
								 $payment_methods_exc_payment_methods,
								 $payment_methods_exc_payment_types,
								 $payment_methods_installments,
								 $external_reference,
								 $expires){
	try {
		$checkoutPreferenceDataItems = new CheckoutPreferenceDataItems(); 
		$checkoutPreferenceDataItems->setItemsId($item_id);
		$checkoutPreferenceDataItems->setTitle($item_title);
		$checkoutPreferenceDataItems->setDescription($item_description);
		$checkoutPreferenceDataItems->setQuantity($item_quantity);
		$checkoutPreferenceDataItems->setUnitPrice($item_unit_price);
		$checkoutPreferenceDataItems->setCurrencyId($item_currency_id);
		$checkoutPreferenceDataItems->setPictureUrl($item_picture_url);
	
		$checkoutPreferenceDataPayer = new CheckoutPreferenceDataPayer(); 
		$checkoutPreferenceDataPayer->setName($payer_name);
		$checkoutPreferenceDataPayer->setSurname($payer_surname);
		$checkoutPreferenceDataPayer->setEmail($payer_email);
	
		$checkoutPreferenceDataBackUrls = new CheckoutPreferenceDataBackUrls(); 
		$checkoutPreferenceDataBackUrls->setSuccessUrl($back_urls_success);
		$checkoutPreferenceDataBackUrls->setPendingUrl($back_urls_pending);
	
	
		$checkoutPreferenceDataPaymentMethods = new CheckoutPreferenceDataPaymentMethods(); 
		
		$paymentMethods=explode(",",$payment_methods_exc_payment_methods);	
		for($q=0; $q<sizeof($paymentMethods); $q++)
		{
		$checkoutPreferenceDataExcludedPaymentMethods = new CheckoutPreferenceDataExcludedPaymentMethods(); 
		$checkoutPreferenceDataExcludedPaymentMethods->setExcludedPaymentMethodsId($paymentMethods[$q]);
		$checkoutPreferenceDataPaymentMethods->setExcludedPaymentMethods($checkoutPreferenceDataExcludedPaymentMethods);
		unset($checkoutPreferenceDataExcludedPaymentMethods);
		}
	
		$paymentTypes=explode(",",$payment_methods_exc_payment_types);
		for($w=0; $w<sizeof($paymentTypes); $w++)
		{
		$checkoutPreferenceDataExcludedPaymentTypes = new CheckoutPreferenceDataExcludedPaymentTypes(); 
		$checkoutPreferenceDataExcludedPaymentTypes->setExcludedPaymentTypesId($paymentTypes[$w]);
		$checkoutPreferenceDataPaymentMethods->setExcludedPaymentTypes($checkoutPreferenceDataExcludedPaymentTypes);	
		unset($checkoutPreferenceDataPaymentTypes);
		}
		$checkoutPreferenceDataPaymentMethods->setInstallments($payment_methods_installments);
	
		$checkoutPreferenceData = new CheckoutPreferenceData(); 
		$checkoutPreferenceData->setExternalReference($external_reference);
		$checkoutPreferenceData->setExpires($expires); 
		$checkoutPreferenceData->setItems($checkoutPreferenceDataItems);
		$checkoutPreferenceData->setPayer($checkoutPreferenceDataPayer);	
		$checkoutPreferenceData->setBackUrls($checkoutPreferenceDataBackUrls);
		$checkoutPreferenceData->setPaymentMethods($checkoutPreferenceDataPaymentMethods);
				
		return $checkoutPreferenceData;
		}catch(Exception $e){
			$this->error=1;
		}
	}	
}
?>