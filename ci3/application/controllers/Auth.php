<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once FCPATH . 'vendor/autoload.php';
use \Firebase\JWT\JWT;

class Auth extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        if (json_decode((file_get_contents('php://input')), true) != '') {
            $_POST = json_decode((file_get_contents('php://input')), true);
        }
          //user model
        $this->load->model('User_model');

    }

    /**
     * Authincate user and admin login Controller.
     * 
     * @return Json|null
     */
    public function login()
    {
        try {
            if(! isset($_POST['email']) || empty(trim($_POST['email']))) throw new Error("Email is required");
            if(! isset($_POST['password']) || empty(trim($_POST['password']))) throw new Error("Password is required");
            $user = $this->User_model->login();

            if(!isset($user->data->id)) throw new Error("Invalid credentials");

            // Generate JWT
            $key = "test";
            $payload = array(
                "iss" => "test",
                "sub" => $user->data,
                "iat" => time(),
                "exp" => time() + 3600
            );

            if($user->data->role=='Admin') $redirctUrl = base_url().'index.php/Dashboard';
            if($user->data->role=='Customer') $redirctUrl = base_url().'index.php/CustomerDashboard';
            $token = JWT::encode($payload, $key, 'HS256');
            echo json_encode(['statusCode'=>200,'statusMsg'=>'Success','token'=>$token,'data'=>$user->data,'redirctUrl'=>$redirctUrl]);
    
        } catch (\Throwable $th) {
            echo json_encode(['statusCode'=>400,'statusMsg'=>$th->getMessage()]);
        }
    }
}

