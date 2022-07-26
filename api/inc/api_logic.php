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
            WHERE 1
            AND (nome = :nome OR email = :email)
            AND deleted_at IS NULL
            LIMIT 1
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
    public function update_client(){
        

        // check if all data is available
        if(
            !isset($this->params['id_cliente']) ||
            !isset($this->params['nome']) ||
            !isset($this->params['email']) ||
            !isset($this->params['telefone'])
        ){
            return $this->error_response('Insuficient client data');
        }

        $db = new database();

        // check if there is already another client with the same: name os email
        $params = [
            ':id_cliente' => $this->params['id_cliente'],
            ':nome' => $this->params['nome'],
            ':email' => $this->params['email']
        ];

        $results = $db->EXE_QUERY("
            SELECT id_cliente FROM clientes
            WHERE 1
            AND (nome = :nome OR email = :email)
            AND deleted_at IS NULL
            AND id_cliente <> :id_cliente
        ", $params);

        if(count($results) != 0){
            return $this->error_response('There is already another client with the same name or email');
        }


        // update client to the database
        $params = [
            ':id_cliente' => $this->params['id_cliente'],
            ':nome' => $this->params['nome'],
            ':email' => $this->params['email'],
            ':telefone' => $this->params['telefone']
        ];

        $db->EXE_NON_QUERY("
            UPDATE clientes SET
                nome = :nome,
                email = :email,
                telefone = :telefone,
                update_at = now()
            WHERE
                id_cliente = :id_cliente
        ", $params);

        return [
            'status' => 'SUCCESS',
            'message' => 'Client data updated with success',
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

        // SOFT delete client on database
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
            WHERE produto = :produto
            AND deleted_at IS NULL
            LIMIT 1
        ", $params);

        if(count($results) != 0){
            return $this->error_response('There is already another product with the same name');
        }

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
    public function update_product()
    {
        // check if all data is available
        if (
            !isset($this->params['id_produto']) ||
            !isset($this->params['produto']) ||
            !isset($this->params['quantidade'])
        ) {
            return $this->error_response('Insufficient product data.');
        }

        // check if there is already another product with the same
        $db = new database();
        $params = [
            ':id_produto' => $this->params['id_produto'],
            ':produto' => $this->params['produto'],
        ];
        $results = $db->EXE_QUERY("
            SELECT id_produto FROM produtos
            WHERE produto = :produto
            AND deleted_at IS NULL
            AND id_produto <> :id_produto
        ", $params);
        if (count($results) != 0) {
            return $this->error_response('There is already another product with the same name.');
        }

        // edit product in the database
        $params = [
            ':id_produto' => $this->params['id_produto'],
            ':produto' => $this->params['produto'],
            ':quantidade' => $this->params['quantidade']
        ];

        $db->EXE_NON_QUERY("
            UPDATE produtos SET
            produto = :produto,
            quantidade = :quantidade
            WHERE id_produto = :id_produto
        ", $params);

        return [
            'status' => 'SUCCESS',
            'message' => 'Product updated with success.',
            'results' => []
        ];
    }

    // ----------------------------------------------------
    public function delete_product(){
        
        // check if all data is available
        if(
            !isset($this->params['id'])
        ){
            return $this->error_response('Insuficient product data');
        }

        // soft delete product on database
        $db = new database();

        
        $params = [
            ':id_produto' => $this->params['id']
        ];

        $db->EXE_NON_QUERY("
            UPDATE produtos SET deleted_at = NOW() WHERE id_produto = :id_produto LIMIT 1
            ", $params);

        return [
            'status' => 'SUCCESS',
            'message' => 'Product deleted with success',
            'results' => []
        ];
    }

    // ----------------------------------------------------
    public function get_product()
    {
        // return of all data from a certain product

        $sql = "SELECT * FROM produtos WHERE 1 ";

        // check if id exists
        if(key_exists('id', $this->params)){
            
            if(filter_var($this->params['id'], FILTER_VALIDATE_INT)){
                $sql .= "AND id_produto = " . intval($this->params['id']) . " LIMIT 1";
            }
        } else {
            return $this->error_response('ID product not specified');
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