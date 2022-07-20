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
                $sql .= "AND id_cliente = " . intval($this->params['id']) . " LIMIT 1";
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
    public function create_new_client(){
        

        // check if all data is available
        if(
            !isset($this->params['nome']) ||
            !isset($this->params['email']) ||
            !isset($this->params['telefone'])
        ){
            return $this->error_response('Insuficient client data');
        }

        $db = new database();

        // check if there is already another client with the same: name os email
        $params = [
            ':nome' => $this->params['nome'],
            ':email' => $this->params['email']
        ];

        $results = $db->EXE_QUERY("
            SELECT id_cliente FROM clientes
            WHERE nome = :nome OR email = :email LIMIT 1
        ", $params);

        if(count($results) != 0){
            return $this->error_response('There is already another client with the same name or email');
        }


        // add new client to the database
        $params = [
            ':nome' => $this->params['nome'],
            ':email' => $this->params['email'],
            ':telefone' => $this->params['telefone']
        ];


        $db->EXE_QUERY("
            INSERT INTO clientes VALUES(
                0,
                :nome,
                :email,
                :telefone,
                NOW(),
                NOW(),
                NULL
            )
        ", $params);


        return [
            'status' => 'SUCCESS',
            'message' => 'New client add with success',
            'results' => []
        ];
    }


    // ----------------------------------------------------
    public function delete_client(){
        
        // check if all data is available
        if(
            !isset($this->params['id'])
        ){
            return $this->error_response('Insuficient client data');
        }

        // HARD delete client on database
        $db = new database();

        
        $params = [
            ':id_cliente' => $this->params['id']
        ];

        $db->EXE_NON_QUERY("
            UPDATE clientes SET deleted_at = NOW() WHERE id_cliente = :id_cliente LIMIT 1
            ", $params);

        return [
            'status' => 'SUCCESS',
            'message' => 'Client deleted with success',
            'results' => []
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
    public function create_new_product(){
        

        // check if all data is available
        if(
            !isset($this->params['produto']) ||
            !isset($this->params['quantidade']) 
        ){
            return $this->error_response('Insuficient product data');
        }

        $db = new database();

        // check if there is already another product  with the same: name
        $params = [
            ':produto' => $this->params['produto']
        ];

        $results = $db->EXE_QUERY("
            SELECT id_produto FROM produtos
            WHERE produto = :produto LIMIT 1
        ", $params);

        if(count($results) != 0){
            return $this->error_response('There is already another product with the same name');
        }


        // add new client to the database
        $params = [
            ':produto' => $this->params['produto'],
            ':quantidade' => $this->params['quantidade'],
        ];


        $db->EXE_QUERY("
            INSERT INTO produtos VALUES(
                0,
                :produto,
                :quantidade,
                NOW(),
                NOW(),
                NULL
            )
        ", $params);


        return [
            'status' => 'SUCCESS',
            'message' => 'New product add with success',
            'results' => []
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