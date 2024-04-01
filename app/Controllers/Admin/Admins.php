<?php

    namespace App\Controllers\Admin;

    use App\Controllers\BaseController;
    use CodeIgniter\Exceptions\PageNotFoundExceptions;
    use CodeIgniter\Database\Exceptions\DatabaseException;
    // use App\Models\Admin\AdminModel;
    // use App\Models\VotersModel;
   



class Admins extends BaseController{
    // update party 
    public function update_party(){
        $session    = \Config\Services::session();
        $request    = \Config\Services::request();
        $db         = \Config\Database::connect();
        $uri = service('uri');

        $data1 = $uri->getSegment(3); // ' => ['slogan', 'name']]);
        // fetch submitted data  
        // $data['request'] = $this->request->getPost(['slogan']);

        exit(var_dump($data1));
    }

    // fetch party details from database
    public function manage_party(){
        helper('form');
        $request    = \Config\Services::request(); 
        $session    = \Config\Services::session();
        $db         = \Config\Database::connect();

        // data values 
        $data['request'] = $this->request->getPost(['query', 'search_type','attr']);
        $data['username'] = $session->get('username');

        // form fields
        $data['query']        = array('type' => 'text','name' => 'query','class' => 'form-control','id' => 'query','required' => TRUE,'placeholder' => 'Search');
        $data['search_type']  = array('' => 'Select Search Item','name' => 'Party Name','party_slogan' => 'Party Slogan','party_abbreviation' => 'Party Abbreviation');
        $data['attr']         = array('class' => 'form-control');
        
        $data['title'] = "Admin title";
        // exit(var_dump($data['request']));
        if($this->validateData($data['request'], 'manage_party')){
            $model = model('Admin/AdminModel');
            // execute needed functions
            
            $query = $request->getPost('query');
            $query_type = $request->getPost('search_type'); 
            
            $data['table_data'] = $model->get_parties($query, $query_type);
            // exit(var_dump($data['table_data']));

            }

            /**
             * Load the view with $data['table_data'] if 
             * $model->get_parties($query, $query_type) return value
             * otherwise just load the detault form view
             */
            return(
                view('admin/partials/header', $data)
                .view('admin/manage_party', $data)
                .view('admin/partials/footer', $data)
            );
           
        
    }

    public function add_party(){
        helper('form'); 
        $request = \Config\Services::request(); # request service
        $session = \Config\Services::session(); # session service

        # fetch user input 
        $data['request'] = $this->request->getPost(['name', 'abbreviation', 'slogan', 'ideology']);
        
        // form fields
        $data['name'] = array('name' => 'name', 'type' => 'text','class' => 'form-control');
        $data['abbreviation'] = array('name' => 'abbreviation', 'type' => "text",'class' => "form-control");
        $data['slogan'] = array('name' => 'slogan', 'type' => "text",'class' => "form-control");
        $data['ideology'] = array('name' => 'ideology', 'style' => "height: 100px", 'class' => "form-control");
        $data['register'] = array('name' => 'register', 'type' => "submit", 'class' => "btn btn-primary",'content' => "Register");
        $data['title'] = 'Add Party';
        $data['username'] = $session->get('username');
        $data['errors'] = \Config\Services::validation()->listErrors();
        $data['status'] = null;

        // if validation failed
        if(!$this->validateData($data['request'], 'add_party')){
            // validation failed
            return view('admin/partials/header', $data)
                    .view('admin/add_party', $data)
                    .view('admin/partials/footer',$data);
        }else{
            $model = model('Admin/AdminModel');
            if($model->add_party($data['request']) === True){
                
                // get flash message 
                $data['status'] = $session->getFlashdata('add_party_success');
                
                return view('admin/partials/header',$data)
                        .view('admin/add_party', $data)
                        .view('admin/partials/footer',$data);

            }else{
                print('Catch error pls');
            }
        }

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