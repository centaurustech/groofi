<?

class AppError extends ErrorHandler {

    function __construct($method, $messages) {
        if (Configure::read('debug') == 0 && $method != 'AppError') {
            $method = 'AppError';
            $messages = array(
                'code' => '404' ,
                'name' => 'GENERIC_PAGE_ERROR_404' ,
                'message' => 'GENERIC_PAGE_ERROR_404_BODY' ,
                
            ); 
        }
        parent::__construct($method, $messages);
    }

    function _outputMessage($template) {



        parent::_outputMessage($template);
    }

}
?>