<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class User_model extends CI_Model {

    public function __construct() {
        $this->load->database();
    }

    /**
     * Login and User.
     * 
     * @return Json|null
     */
    public function login()
    {
        $this->db->select('id,firstName,lastName,email,role,lastLogin');
        $this->db->where('email', $_POST['email']);
        $enteredPasswordHash = md5($_POST['password']);  // MD5 hash the entered password
            $this->db->where('password',$enteredPasswordHash);
            $data = $this->db->get('users')->row();
            if($data->lastLogin==NULL) $data->lastLogin = date('Y-m-d H:i:s');
            if(isset($data->id)) $this->db->where('id',$data->id,['lastLogin'=>date('Y-m-d H:i:s')]);
            return (object)['statusCode'=>200,'data'=>$data??[]];
    }

    /**
     *  User List.
     * 
     * @return Json|null
     */
    public function userList()
    {
        $this->db->select('id,firstName,lastName,email,role,profileImage');
        $this->db->where('role', 'Customer');
        $count  = clone $this->db;
        $this->db->limit(5);
        $this->db->order_by('id','desc');
        $data = $this->db->get('users')->result();
        $totalCount = $count->get('users')->num_rows();
        return (object)['statusCode'=>200,'data'=>$data??[],'totalCount'=>$totalCount];
    }

    /**
     * User Details.
     * 
     * @return Json|null
     */
    public function userDetail($id) 
    {
        $this->db->select('id,firstName,lastName,email,role,profileImage,created_at');
            $this->db->where('role', 'Customer');
            $this->db->where('id', $id);
            $data = $this->db->get('users')->row();
    
            $this->db->select('id,userId,company,position,joinYear');
            $this->db->where('userId ', $id);
            $data->employmentDetails = $this->db->get('employment_details')->result();
    
            $this->db->select('id,userId,degree,institution,graduationYear');
            $this->db->where('userId ', $id);
            $data->educationDetails = $this->db->get('education_details')->result();
            
            return ['statusCode'=>200,'data'=>$data??[]];
    }

    /**
     * For Image in base64.
     * 
     * @return string|null
     */
    function imageToBase64($imagePath) 
    {
        if (!file_exists($imagePath)) {
            return false;
        }
    
        $imageData = file_get_contents($imagePath);

        $base64Image = "data:image/jpeg;base64," . base64_encode($imageData);
    
        return $base64Image;
    }
    
    /**
     * Create User By admin.
     * 
     * @return Json|null
     */
    public function create_user()
    {
        $image = $this->imageToBase64($_FILES['profileImage']['tmp_name']);
        $userData = [
            'firstName'    => $_POST['firstName'],
            'lastName'     => $_POST['lastName'],
            'email'        => $_POST['email'],
            'password'     => md5($_POST['password']),
            'profileImage' => $image,
            'role'         =>'Customer',
        ];

        $this->db->insert('users', $userData);
        $userId = $this->db->insert_id();
        
        if($userId){
            $employmentDetails = json_decode($_POST['employmentDetails']);
            $educationDetails = json_decode($_POST['educationDetails']);
    
            foreach ($employmentDetails as $key => $value) {
                $emp = [
                    'userId'=>$userId,
                    'createdAt'=>date('Y-m-d H:i:s'),
                    'company'=>$value->company??'',
                    'position'=>$value->position??'',
                    'joinYear'=>$value->joinYear??'',
                ];
                $this->db->insert('employment_details',$emp);
            }
    
            foreach ($educationDetails as $key => $value) {
                $emp = [
                    'userId'=>$userId,
                    'createdAt'=>date('Y-m-d H:i:s'),
                    'degree'=>$value->degree??'',
                    'institution'=>$value->institution??'',
                    'graduationYear'=>$value->graduationYear??'',
                ];
                $this->db->insert('education_details',$emp);
            }
    
            return ['statusCode'=>200,'statusMsg'=>'Sucess','redirctUrl'=>base_url().'index.php/Dashboard'];
        }else{
            return ['statusCode'=>400,'statusMsg'=>'Bad Request'];
        }
    }

    /**
     * Update User By admin.
     * 
     * @return Json|null
     */
    public function update_user()
    {
        if (empty($_POST['id'])) {
            return ['statusCode' => 400, 'statusMsg' => 'User ID is required'];
        }
    
        $userId = $_POST['id'];

        $userData = [
            'firstName'    => $_POST['firstName'],
            'lastName'     => $_POST['lastName'],
            'email'        => $_POST['email'],
            'password'     => md5($_POST['password']),
            'role'         => 'Customer',
        ];
        
        if (! empty($_FILES['profileImage']['tmp_name'])) {
            // Convert the image to base64 if it's uploaded
            $image = $this->imageToBase64($_FILES['profileImage']['tmp_name']);
            $userData['profileImage'] = $image;
        }
    
        $this->db->where('id', $userId);
        $update = $this->db->update('users', $userData);
        
        if ($update) {
            if (! empty($_POST['employmentDetails'])) {
                $employmentDetails = json_decode($_POST['employmentDetails']);
                foreach ($employmentDetails as $key => $value) {
                    if (! empty($value->company) || ! empty($value->position) || ! empty($value->joinYear)) {
                        $emp = [
                            'userId'    => $userId,
                            'createdAt' => date('Y-m-d H:i:s'),
                            'company'   => $value->company ?? '',
                            'position'  => $value->position ?? '',
                            'joinYear'  => $value->joinYear ?? '',
                        ];
                        $this->db->insert('employment_details', $emp);
                    }
                }
            }
    
            if (! empty($_POST['educationDetails'])) {
                $educationDetails = json_decode($_POST['educationDetails']);
                foreach ($educationDetails as $key => $value) {
                    if (!empty($value->degree) || !empty($value->institution) || !empty($value->graduationYear)) {
                        $edu = [
                            'userId'         => $userId,
                            'createdAt'      => date('Y-m-d H:i:s'),
                            'degree'         => $value->degree ?? '',
                            'institution'    => $value->institution ?? '',
                            'graduationYear' => $value->graduationYear ?? '',
                        ];
                        
                        $this->db->insert('education_details', $edu);
                    }
                }
            }
    
            return ['statusCode'=>200,'statusMsg'=>'Sucess','redirctUrl'=>base_url().'index.php/Dashboard'];
        }else{
            return ['statusCode'=>400,'statusMsg'=>'Bad Request'];
        }
    }

    /**
     * Delete User, Details and Education in edit mode.
     * 
     * @return array|null
     */
    public function delete_user()
    {
        if ($_POST['id'] && $_POST['company'] == 'employment' ) {
            $this->db->where('id', $_POST['id']);
            $delete = $this->db->delete('employment_details');
            if($delete){
                return ['statusCode'=>200,'statusMsg'=>'Sucess'];
            }else{
                return ['statusCode'=>400,'statusMsg'=>'Bad Request'];
            }
        }

        if ($_POST['id'] && $_POST['company'] == 'education' ) {
            $this->db->where('id', $_POST['id']);
            $delete = $this->db->delete('education_details');
            if($delete){
                return ['statusCode'=>200,'statusMsg'=>'Sucess'];
            }else{
                return ['statusCode'=>400,'statusMsg'=>'Bad Request'];
            }
        } else {
            if($_POST['id']) {
                $this->db->trans_start();
    
                // Delete related data from education_details
                $this->db->where('userId',  $_POST['id']);
                $this->db->delete('education_details');
    
                // Delete related data from employment_details
                $this->db->where('userId',  $_POST['id']);
                $this->db->delete('employment_details');
    
                // Delete the user from users table
                $this->db->where('id',  $_POST['id']);
                $this->db->delete('users');
    
                // Commit the transaction
                $this->db->trans_complete();
    
                if ($this->db->trans_status() === FALSE) {
                    // Handle errors
                    return ['statusCode'=>400,'statusMsg'=>'Bad Request'];
                } else {
                    return ['statusCode'=>200,'statusMsg'=>'Sucess'];
                }
            }
        }

    }

    /**
     * Delete by admin User, in list mode.
     * 
     * @return array|null
     */
    public function delete_userList()
    {
        if ($_POST['id']) {
            $this->db->trans_start();
            $this->db->where('userId',  $_POST['id']);
            $this->db->delete('education_details');
            $this->db->where('userId',  $_POST['id']);
            $this->db->delete('employment_details');
            $this->db->where('id',  $_POST['id']);
            $this->db->delete('users');
            $this->db->trans_complete();

            if ($this->db->trans_status() === FALSE) {
                return ['statusCode'=>400,'statusMsg'=>'Bad Request'];
            } else {
                return ['statusCode'=>200,'statusMsg'=>'Sucess'];
            }
        }
    }

    /**
     * Get user by ID
     * @param int $id
     * @return array|null
     */
    public function get_user_by_id($id)
    {
        $query = $this->db->get_where('users', ['id' => $id]);
        return $query->row_array();
    }

    public function get_employee_by_user_id($user_id)
    {
        
    $this->db->where('userId', $user_id);
    $query = $this->db->get('employment_details');
    return $query->result_array();
       
    }

    public function get_education_by_user_id($user_id)
    {
        $this->db->where('userId', $user_id);
        $query = $this->db->get('education_details');
        return $query->result_array();
    }
}
