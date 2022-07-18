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
    public function error_response($message){
        // returns an error from the API
        return [
            'status' => 'ERROR',
            'message' => $message,
            'results' => []
        ];
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
    // public function get_all_clients()
    // {
    //     // return all clients from our database, ACTIVE or INACTIVE
    //     $sql = "SELECT * FROM clientes WHERE 1 ";

    //     // check if only_active exists and is true
    //     if(key_exists('only_active', $this->params)){
            
    //         if(filter_var($this->params['only_active'], FILTER_VALIDATE_BOOLEAN) == true){
    //             $sql .= "AND deleted_at IS NULL";

    //         }
    //     }

    //     $db = new database();
    //     $results = $db->EXE_QUERY($sql);

    //     return [
    //         'status' => 'SUCCESS',
    //         'message' => '',
    //         'results' => $results
    //     ];
    // }

    // ----------------------------------------------------
    // ENDPOINTS (CLIENTES)
    // ----------------------------------------------------

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
    public function get_all_active_clients()
    {
        // return all ACTIVE clients from our database

        $db = new database();
        $results = $db->EXE_QUERY("SELECT * FROM clientes WHERE deleted_at IS NULL");

        return [
            'status' => 'SUCCESS',
            'message' => '',
            'results' => $results
        ];
    }

    // ----------------------------------------------------
    public function get_all_inactive_clients()
    {
        // return all INACTIVE clients from our database

        $db = new database();
        $results = $db->EXE_QUERY("SELECT * FROM clientes WHERE deleted_at IS NOT NULL");

        return [
            'status' => 'SUCCESS',
            'message' => '',
            'results' => $results
        ];
    }

    // ----------------------------------------------------
    public function get_client()
    {
        // return of all data from a certain client

        $sql = "SELECT * FROM clientes WHERE 1 ";

        // check if id exists
        if(key_exists('id', $this->params)){
            
            if(filter_var($this->params['id'], FILTER_VALIDATE_INT)){
                $sql .= "AND id_cliente = " . intval($this->params['id']);
            }
        } else {
            return $this->error_response('ID client not specified');
        }

        $db = new database();
        $results = $db->EXE_QUERY($sql);

        return [
            'status' => 'SUCCESS',
            'message' => '',
            'results' => $results
        ];
    }

    // ----------------------------------------------------
    // ENDPOINTS (PRODUTOS)
    // ----------------------------------------------------

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

    // ----------------------------------------------------
    public function get_all_active_products()
    {
        // return all ACTIVE produtcts from our database

        $db = new database();
        $results = $db->EXE_QUERY("SELECT * FROM produtos WHERE deleted_at IS NULL");

        return [
            'status' => 'SUCCESS',
            'message' => '',
            'results' => $results
        ];
    }

    // ----------------------------------------------------
    public function get_all_inactive_products()
    {
        // return all INACTIVE products from our database

        $db = new database();
        $results = $db->EXE_QUERY("SELECT * FROM produtos WHERE deleted_at IS NOT NULL");

        return [
            'status' => 'SUCCESS',
            'message' => '',
            'results' => $results
        ];
    }

    // ----------------------------------------------------
    public function get_all_products_without_stock()
    {
        // return all products with stock <= 0 from our database

        $db = new database();
        $results = $db->EXE_QUERY("SELECT * FROM produtos WHERE quantidade <= 0 AND deleted_at IS NULL");

        return [
            'status' => 'SUCCESS',
            'message' => '',
            'results' => $results
        ];
    }

    // ----------------------------------------------------
    // ENDPOINTS (COLABORADORES)
    // ----------------------------------------------------

    // ----------------------------------------------------
    public function get_all_collaborators(){
        // return all collaborators from our database
        $db = new database();
        $results = $db->EXE_QUERY("SELECT * FROM colaboradores");
    
        return [
            'status' => 'SUCCESS',
            'message' => '',
            'results' => $results
        ];
    }

}