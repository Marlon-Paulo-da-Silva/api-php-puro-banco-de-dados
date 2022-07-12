<?php

class api_response
{
    private $data;
    private $available_methods = ['GET', 'POST'];

    // =================================================
    public function __construct(){
        $this->data = [];
    }

    // =================================================
    public function check_method($method){
        
        // check if method is valid
        return in_array($method, $this->available_methods);
    }

    // =================================================
    public function set_method($method){

        // sets the response method
        $this->data['method'] = $method;
        
    }

    // =================================================
    public function get_method(){

        // return the request method
        return $this->data['method'];
    }    

    // =================================================
    public function set_endpoint($endpoint){
        // sets the request endpoint
        $this->data['endpoint'] = $endpoint;
    }
    
    // =================================================
    public function get_endpoint()
    {
        // return the current request endpoint
        return $this->data['endpoint'];
    }

    // =================================================
    public function add_to_data($key, $value)
    {
        // add new key to data
        $this->data[$key] = $value;

    }
    

    // OUTPUTS

    // =================================================
    public function api_request_error($message = ''){

        $data_error = [
            'status' => 'ERROR',
            'message' => $message,
            'results' => null
        ];

        // output an api error message
        $this->data['data'] = $data_error;
        $this->send_response();
    }

    // =================================================
    public function send_api_status(){
        // send api status
        $this->data['status'] = 'SUCCESS';
        $this->data['message'] = 'API is Running !!';
        $this->send_response();
    }

    // =================================================
    public function send_response(){

        // output an final response
        header("Content-Type:application/json");
        echo json_encode($this->data);
        die(1);
    }
}