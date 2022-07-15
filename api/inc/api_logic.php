<?php

class api_logic
{
    private $endpoint;
    private $params;

    public function __construct($endpoint, $params = null)
    {
        //define the object/class properties
        $this->endpoint = $endpoint;
        $this->params = $params;
    }


    // ----------------------------------------------------

    public function endpoint_exists()
    {
        // check if the endpoint is a valid class method
        return method_exists($this, $this->endpoint);
    }


    // ----------------------------------------------------
    // ENDPOINTS
    // ----------------------------------------------------


    public function status()
    {

        return [
            'status' => 'SUCCESS',
            'message' => 'API is Running',
            'results' => null
        ];
    }

    // ----------------------------------------------------
    public function get_all_clients()
    {
        // return all clients from our database
        $db = new database();
        $results = $db->EXE_QUERY("SELECT * FROM clientes");

        return [
            'status' => 'SUCCESS',
            'message' => '',
            'results' => $results
        ];
    }

    // ----------------------------------------------------
    public function get_all_products()
    {
        // return all products in the database
        $db = new database();
        $results = $db->EXE_QUERY("SELECT * FROM produtos");

        return [
            'status' => 'SUCCESS',
            'message' => '',
            'results' => $results
        ];
    }

}