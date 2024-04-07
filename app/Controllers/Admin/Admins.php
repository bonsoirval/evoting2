<?php

    namespace App\Controllers\Admin;

    use App\Controllers\BaseController;
    use CodeIgniter\Exceptions\PageNotFoundExceptions;
    use CodeIgniter\Database\Exceptions\DatabaseException;
    // use App\Models\Admin\AdminModel;
    // use App\Models\VotersModel;
   



class Admins extends BaseController{
    
    public function manage_election(){
        $session = \Config\Services::session();
        $request = \Config\Services::request();

        // helpers 
        helper('form');
        $model = model('Admin/AdminModel');

        $data['submitted_data'] = $request->getPost(['query', 'search_type']);
        $data['title'] = "Manage Election";
        $data['username'] = $session->get('username');

        // form fields
        $data['query']        = array('type' => 'text', 'name' => 'query', 'class' => 'form-control','id' => 'query', 'required' => TRUE,'placeholder' => 'Search value, Date format : yyyy-mm-dd');
        $data['search_type']  = array('0' => 'Select Search Item', '1' => 'All Elections', '2' => 'Election Title', '3' => 'Election Region', '4' => 'Election Date', '5' => 'Election Status'); 
        $data['attr']         = array('class' => 'form-control');
        // found in update_election.php page
        $data['hidden'] = array('type' => 'hidden','name' => 'election_clicked','value' => 'clicked');
        
        if($this->validateData($data['submitted_data'], 'manage_election')){
            // validated
            print("Validated");
        }else{
            // not validate 
            print("Not validated");
        }

        return view('admin/partials/header',$data).view('admin/manage_election', $data).view('admin/partials/footer',$data);
    }

    public function add_election(){
        $db = \Config\Database::connect(); 
        $session = \Config\Services::session();
        $request = \Config\Services::request();
        
        // helpers
        helper('form');
        $model = model('Admin/AdminModel');

        $data['submitted_data'] = $request->getPost(
            ['election','election_date','region']); 
        
        // var_dump($data['submitted_data']);
        // exit(var_dump($this->validateData($data['submitted_data'], 'add_election')));

        $data['title']          = "Add election";
        $data['username']       = $session->get('username');
        $data['session'] = $session;
        

        if(!$this->validateData($data['submitted_data'], 'add_election')){
            // add form fields to this->data
            $data['election']       = array('name' => 'election', 'class'=>'form-control', 'type' => 'text', 'required' => True, 'placeholder' => 'Enter election name');
            $data['election_date']  = array('name' => 'election_date', 'class'=>'form-control', 'type' => 'date', 'required' => True);
            $data['region']         = array('name' => 'region', 'class'=>'form-control', 'type' => 'text','required' => True, 'placeholder' => 'Enter election region');
            $data['add_election']   = array('name' => 'add_election', 'type' => 'submit',  'value' => 'Add Election', 'class' => 'form-control');
            $options = array();
            foreach($model->get_regions() as $key => $val){$options[$val->id] = $val->state;}
            $data['options'] = $options;
            
            return view('admin/partials/header', $data).view('admin/add_election',$data).view('admin/partials/footer',$data);
        }else{
            if($model->add_election($data['submitted_data']) === true){
                return view('admin/partials/add_election',$data).view('admin/add_election', $data).view('admin/partials/footer',$data);
            }
        }
    }
    // update party 
    public function update_party(){
        helper('form'); // load form library 
        $model = model('Admin/AdminModel');

        $session    = \Config\Services::session();
        $request    = \Config\Services::request();
        $db         = \Config\Database::connect();
        $uri = $this->request->getUri(); // current_url(true); //service('uri');

        // posted data
        $data['submitted_data'] = $this->request->getPost(
            ['name', 'abbreviation','slogan','status', 'ideology']
        );
        $data['title'] = "Party update page";
        $data['name_from_url'] = urldecode($uri->getSegment(3)); // ' => ['slogan', 'name']]);
        $data['abbreviation'] = urldecode($uri->getSegment(4));
        $data['slogan'] = urldecode($uri->getSegment(5));
        $data['ideology'] = urldecode($uri->getSegment(6)); 
        $data['status'] = urldecode($uri->getSegment(7));
        $data['username'] = $session->get('username');
        $data['session'] = $session;

        // exit(var_dump($data['submitted_data']));

        // data posting failed, (re)load view
        if(!$this->validateData($data['submitted_data'], 'update_party')){
            // $data['party_update'] = $party_update;
            $data['name']        = array('name'=>'name', 'class'=>'form-control', 'value' => $data['name_from_url']);
            $data['abbreviation'] = array('name' => 'abbreviation', 'class'=>'form-control', 'value' => $data['abbreviation']);
            $data['slogan']       = array('name'=>'slogan', 'class'=>'form-control', 'value' => $data['slogan']);
            $data['ideology']     = array('name' => 'ideology', 'class'=>'form-control', 'value'=> $data['ideology']);
            $data['status']       = array('name' => 'status');
            $data['options']      = array('' =>'Select Status', 'deactivated' => 'Deactivated', 'active' => 'Active', 'non' => 'None existent' );
            $data['extra']        = array('class' => 'form-control');

            return view('admin/partials/header',$data).view('admin/update_party', $data).view('admin/partials/footer',$data);

        }else{
            $data['session'] = $session;
            $result = $model->update_party($data['submitted_data']);
            
            // return the view 
            return redirect()->route('manage_party');
        }

       
        // // fetch submitted data  
        // // $data['request'] = $this->request->getPost(['slogan']);
        // return view('admin/partials/header',$data).view('admin/update_party',$data).view('admin/partials/footer',$data);
        // exit(var_dump($data));
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
        
        $data['session'] = $session;
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