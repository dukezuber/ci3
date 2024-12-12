<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        if (json_decode((file_get_contents('php://input')), true) != '') {
            $_POST = json_decode((file_get_contents('php://input')), true);
        }
        $this->load->model('User_model');

    }

    /**
     * Authincate user list Controller.
     * 
     * @return Json|null
     */
    public function userList()
    {
        try {
            $users = $this->User_model->userList();
            echo json_encode($users);
    
        } catch (\Throwable $th) {
            echo json_encode(['statusCode'=>400,'statusMsg'=>$th->getMessage()]);
        }
    }

    /**
     * user Details Controller.
     * 
     * @return Json|null
     */
    public function userDetail($id) 
    {
        try {
            $users = $this->User_model->userDetail($id);
            echo json_encode($users);
    
        } catch (\Throwable $th) {
            echo json_encode(['statusCode'=>400,'statusMsg'=>$th->getMessage()]);
        }
    }

    /**
     * Create user By Admin.
     * 
     * @return Json|null
     */
    public function create_user() 
    {
        try {
            $users = $this->User_model->create_user();
            echo json_encode($users);
    
        } catch (\Throwable $th) {
            echo json_encode(['statusCode'=>400,'statusMsg'=>$th->getMessage()]);
        }
    }

    /**
     * Update User Controller.
     * 
     * @return Json|null
     */
    public function update_user()
    {
        try {
            $users = $this->User_model->update_user();
            echo json_encode($users);
    
        } catch (\Throwable $th) {
            echo json_encode(['statusCode'=>400,'statusMsg'=>$th->getMessage()]);
        }
    }

    /**
     * Delete user by admin Controller.
     * 
     * @return Json|null
     */    
    public function delete_user()
    {
        try {
            $users = $this->User_model->delete_user();
            echo json_encode($users);
    
        } catch (\Throwable $th) {
            echo json_encode(['statusCode'=>400,'statusMsg'=>$th->getMessage()]);
        }
    }

    /**
     * delete user list by admin Controller.
     * 
     * @return Json|null
     */
    public function delete_userList()
    {
        try {
            $users = $this->User_model->delete_userList();
            echo json_encode($users);
    
        } catch (\Throwable $th) {
            echo json_encode(['statusCode'=>400,'statusMsg'=>$th->getMessage()]);
        }
    }
}

