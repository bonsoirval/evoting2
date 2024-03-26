<?php

    namespace App\Controllers\Admin;

    use App\Controllers\BaseController;
    use CodeIgniter\Exceptions\PageNotFoundExceptions;
    use CodeIgniter\Database\Exceptions\DatabaseException;
    // use App\Models\Admin\AdminModel;
    // use App\Models\VotersModel;
   



class Admins extends BaseController{

    public function add_party(){
        echo "adding party";
    }

    public function index(){
        helper('form');
        // $request = \Config\Services::request();
        $request = $this->request->getPost(['username', 'password']);
        $session = \Config\Services::session();

        // checks whether the submitted data passed validation rules:
        if(!$this->validateData($request, 'admin_login'))
        {
        
            $data['username'] = array('type' => 'text', 'name' => 'username', 'class' => 'form-control', 'id' => 'username', 'required' => TRUE, 'placeholder' => "Enter Username");
            $data['password'] = array('type' => "password", 'name' => 'password', 'class' => 'form-control', 'id' => 'password', 'required' => TRUE, 'placeholder' => 'Enter Password');
            $data['title'] = "Admin Login";
            $data['action'] = 'h_admin/index';

            return view('admin/partials/login_header', $data)
                    .view('admin/login',$data)
                    .view('admin/partials/footer');
        }else{
            // load admin model
            $adminModel = model('Admin/AdminModel');

            $data['title'] = "Admin Login";
            
            if($adminModel->adminLogin() == True){
                $data['username'] = $session->get('username');
                
                return view('admin/partials/header', $data)
                        .view('admin/index', $data)
                        .view('admin/partials/footer', $data);
            }
        }         
    }

    public function signout(){
        $adminModel = model('Admin/AdminModel');
        if($adminModel->signout() === True){
            return redirect()->route('admin_login');
        }
    }
}
?>