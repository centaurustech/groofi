<?php

// include_once 'CallerService.php';
// include_once 'APIError.php';

class Paypal {

    var $apiUsername = PAYPAL_API_USERNAME;
    var $apiPassword = PAYPAL_API_PASSWORD;
    var $apiSignature = PAYPAL_SIGNATURE;
    var $apiAppId = X_PAYPAL_API_APPLICATION_ID;
    /* ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- */
    var $requestFormat = X_PAYPAL_API_REQUESTFORMAT;
    var $responseFormat = X_PAYPAL_API_RESPONSEFORMAT;
    var $ApiEndpoint = PAYPAL_API_ENDPOINT;
    var $XApiEndpoint = X_PAYPAL_API_ENDPOINT;
    /* ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- */
    var $version = PAYPAL_VERSION;
    var $subject = PAYPAL_SUBJECT;
    var $deviceIp = X_PAYPAL_DEVICE_IPADDRESS;
    var $requestSource = X_PAYPAL_REQUEST_SOURCE;
    var $userProxy = PAYPAL_USE_PROXY;
    var $proxyHost = PAYPAL_PROXY_HOST;
    var $proxyPort = PAYPAL_PROXY_PORT;

    function getUrl($methodName, $response) {
        if(!$this->checkResponse($response)) {
            return false;
        }
        switch($methodName) {
            case 'SetExpressCheckout':
                return PAYPAL_URL . urldecode($response["TOKEN"]);
                break;
            case 'SetAuthFlowParam':
                return X_PAYPAL_PAYPAL_REDIRECT_URL . '_account-authenticate-login&token=' . urldecode($response["TOKEN"]);
                break;
            case 'AdaptivePayments/Preapproval':
                return PAYPAL_ADAPTATIVE_ACCOUNTS_URL . urldecode($response["preapprovalKey"]);
                break;
            default:
                return false;
                break;
        }

    }

    function checkResponse($response) {


        if(
                (is_array($response) && array_key_exists('ACK', $response) && up($response['ACK']) == 'SUCCESS' ) ||
                (is_array($response) && array_key_exists('responseEnvelope.ack', $response) && up($response['responseEnvelope.ack']) == 'SUCCESS' )
        ) {

            return true;
        } else {
       //     debug($response);
        }
        return false;

    }

    function prepareNvpStr($nvpParams) {
        $nvpStr = is_array($nvpParams) ? http_build_query($nvpParams, '', '&') : $nvpParams;
        $nvpStr = preg_match('/^&.*$/', $nvpStr) ? $nvpStr : '&' . $nvpStr;
        return $nvpStr;

    }

    function xnvpHeader() {
        $headers_arr = array();

        $headers_arr[] = "X-PAYPAL-SECURITY-SIGNATURE: " . $this->apiSignature;
        $headers_arr[] = "X-PAYPAL-SECURITY-USERID:  " . $this->apiUsername;
        $headers_arr[] = "X-PAYPAL-SECURITY-PASSWORD: " . $this->apiPassword;
        $headers_arr[] = "X-PAYPAL-APPLICATION-ID: " . $this->apiAppId;

        $headers_arr[] = "X-PAYPAL-REQUEST-DATA-FORMAT: " . $this->requestFormat;
        $headers_arr[] = "X-PAYPAL-RESPONSE-DATA-FORMAT: " . $this->responseFormat;
        $headers_arr[] = "X-PAYPAL-DEVICE-IPADDRESS: " . $this->deviceIp;
        $headers_arr[] = "X-PAYPAL-REQUEST-SOURCE: " . $this->requestSource;

        return $headers_arr;

    }

    function xhashCall($methodName, $nvpParams) {
        $nvpStr = $this->prepareNvpStr($nvpParams);
        $URL = $this->XApiEndpoint . '/' . $methodName;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $URL);
        curl_setopt($ch, CURLOPT_VERBOSE, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        if($this->userProxy) {
            curl_setopt($ch, CURLOPT_PROXY, $this->proxyHost . ":" . $this->proxyPort);
        }

        $headers_array = $this->xnvpHeader();
        if(!empty($sandboxEmailAddress)) {
            $headers_array[] = "X-PAYPAL-SANDBOX-EMAIL-ADDRESS: " . $sandboxEmailAddress;
        }
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers_array);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $nvpStr);
        $response = curl_exec($ch);

        $nvpResArray = $this->deformatNVP($response);
        if(curl_errno($ch)) {
            $_SESSION['curl_error_no'] = curl_errno($ch);
            $_SESSION['curl_error_msg'] = curl_error($ch);
            return array();
        } else {
            curl_close($ch);
        }
        return $nvpResArray;

    }

    function nvpHeader() {
        $nvpHeaderStr = "";

        if((!empty($this->apiUsername)) && (!empty($this->apiPassword)) && (!empty($this->apiSignature)) && (!empty($this->subject))) {
            $AuthMode = "THIRDPARTY";
        } else if((!empty($this->apiUsername)) && (!empty($this->apiPassword)) && (!empty($this->apiSignature))) {
            $AuthMode = "3TOKEN";
        } elseif(!empty($this->AUTH_token) && !empty($this->AUTH_signature) && !empty($this->AUTH_timestamp)) {
            $AuthMode = "PERMISSION";
        } elseif(!empty($this->subject)) {
            $AuthMode = "FIRSTPARTY";
        }
        $AuthMode = "3TOKEN";
        switch($AuthMode) {

            case "3TOKEN" :
                $nvpHeaderStr = "&PWD=" . urlencode($this->apiPassword) . "&USER=" . urlencode($this->apiUsername) . "&SIGNATURE=" . urlencode($this->apiSignature);
                break;
            case "FIRSTPARTY" :
                $nvpHeaderStr = "&SUBJECT=" . urlencode($subject);
                break;
            case "THIRDPARTY" :
                $nvpHeaderStr = "&PWD=" . urlencode($this->apiPassword) . "&USER=" . urlencode($this->apiUsername) . "&SIGNATURE=" . urlencode($this->apiSignature) . "&SUBJECT=" . urlencode($subject);
                break;
            case "PERMISSION" :
                $nvpHeaderStr = $this->formAutorization($this->AUTH_token, $this->apiSignature, $this->AUTH_timestamp);
                break;
        }
        return $nvpHeaderStr;

    }

    /**
     * hash_call: Function to perform the API call to PayPal using API signature
     * @methodName is name of API  method.
     * @nvpStr is nvp string.
     * returns an associtive array containing the response from the server.
     */
    function hashCall($methodName, $nvpParams) {

        $nvpStr = $this->prepareNvpStr($nvpParams);
        $nvpheader = $this->nvpHeader();

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->ApiEndpoint);
        curl_setopt($ch, CURLOPT_VERBOSE, 1);

        //turning off the server and peer verification(TrustManager Concept).
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);

        //in case of permission APIs send headers as HTTPheders
        if(!empty($this->AUTH_token) && !empty($this->AUTH_signature) && !empty($this->AUTH_timestamp)) {
            $headers_array[] = "X-PP-AUTHORIZATION: " . $nvpheader;

            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers_array);
            curl_setopt($ch, CURLOPT_HEADER, false);
        } else {
            $nvpStr = $nvpheader . $nvpStr;
        }

        if($this->userProxy) {
            curl_setopt($ch, CURLOPT_PROXY, $this->proxyHost . ":" . $this->proxyPort);
        }

        //check if version is included in $nvpStr else include the version.
        if(strlen(str_replace('VERSION=', '', strtoupper($nvpStr))) == strlen($nvpStr)) {
            $nvpStr = "&VERSION=" . urlencode($this->version) . $nvpStr;
        }

        $nvpreq = "METHOD=" . urlencode($methodName) . $nvpStr;


        curl_setopt($ch, CURLOPT_POSTFIELDS, $nvpreq); //setting the nvpreq as POST FIELD to curl
        $response = curl_exec($ch); //getting response from server

        $nvpReqArray = $this->deformatNVP($nvpreq);
        //convrting NVPResponse to an Associative Array
        $nvpResArray = $this->deformatNVP($response);


        $_SESSION['nvpReqArray'] = $nvpReqArray;

        if(curl_errno($ch)) {
            return false;
        } else {
            curl_close($ch);
        }

        return $nvpResArray;

    }

    /** This function will take NVPString and convert it to an Associative Array and it will decode the response.
     * It is usefull to search for a particular key and displaying arrays.
     * @nvpstr is NVPString.
     * @nvpArray is Associative Array.
     */
    function deformatNVP($nvpstr) {
        $intial = 0;
        $nvpArray = array();
        while(strlen($nvpstr)) {
            $keypos = strpos($nvpstr, '=');
            $valuepos = strpos($nvpstr, '&') ? strpos($nvpstr, '&') : strlen($nvpstr);
            $keyval = substr($nvpstr, $intial, $keypos);
            $valval = substr($nvpstr, $keypos + 1, $valuepos - $keypos - 1);
            $nvpArray[urldecode($keyval)] = urldecode($valval);
            $nvpstr = substr($nvpstr, $valuepos + 1, strlen($nvpstr));
        }
        return $nvpArray;

    }

    function formAutorization($auth_token, $auth_signature, $auth_timestamp) {
        $authString = "token=" . $auth_token . ",signature=" . $auth_signature . ",timestamp=" . $auth_timestamp;
        return $authString;

    }

    function getBalance() {
        $response = $this->hashCall('GetBalance', array()); // dinero disponible en paypal para el pago
        if($this->checkResponse($response)) {
            return $response['L_AMT0'];
        } else {
            return false;
        }

    }

}

?>
