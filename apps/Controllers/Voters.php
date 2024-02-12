<?php 
    namespace App\Controllers;

    use App\Controllers\BaseController;
    use CodeIgniter\Exceptions\PageNotFoundExceptions;
    use CodeIgniter\Database\Exceptions\DatabaseException;
    use App\Models\VotersModel;
    

    class Voters extends BaseController{
        
        public function voter_dashboard(){
            $model = model('VotersModel');
            $session = session();
            $elections = $model->get_elections();
           
            $data = array(
                'userid' => $session->get('userid'),
                'title'     => "page title",
                'elections'  => $elections,
            );

            return view('voter_pages/header', $data)
                    .view('voter_pages/voter_index.php', $data)
                    .view('voter_pages/footer');
        }

        public function login(){
            helper(['form', 'url']);
            $model = model(VotersModel::class);

            $rules = [
                // rules here
                'username'      => 'required|min_length[5]|max_length[20]|is_unique[voters.username]',
                'password'      => 'required',
            ];

            // get posted data
            $data = $this->request->getPost(array_keys($rules));
            // validate and login voter
            if ($this->validateData($data, $rules) && $model->voter_login($data['username'], $data['password']))
            {
                return redirect()->route('voting'); //$this->voter_dashboard(); // view('voter_pages/voter_index');
            }

            $credentials  = array(
                'username' => array('name'	=>	"username", 'id' =>	"username",'required'	=> 'required','type' => "text",'class' => "form-control",'placeholder' => 'Enter username','value' => set_value('username')),
                'password' => array('name' => 'password','id' => 'pwd','required' => 'required','type' => 'password','class' => 'form-control','placeholder' => 'Enter password','value' => set_value('password')),
                'submit' => array('type' => 'submit', 'class' => 'btn btn-default','content' => "Login",'value' => 'True')
            );
            return view('header', ['title' => 'Voter Login Page'])
                    .view('voter_login', $credentials)
                    .view('footer');

		// # Validation rules for login
		// $this->form_validation->set_rules('username', "Username", 'required');
		// $this->form_validation->set_rules('password', "Password", 'required');

		// if ($this->form_validation->run() === FALSE){
		// 	$this->login_form();
			
		// }else{
		// 	// $this->load->model('Voters_model');
		// 	$logged_in = $this->Voters_model->login_voter();

		// 	if ($logged_in === FALSE) {
		// 		// show login form
		// 		$this->login_form();
		// 	}else {
		// 		// exit("Halt");
		// 		$link = base_url() . 'index.php/voter_dashboard/index';
		// 		redirect($link); //)->to($link);

		// 	}

		// }
        }

        public function logout(){
            $model = model(VotersModel::class);
            $model->logout();
            return redirect()->route('/'); 
            
        }

        public  function register(){
            helper('form');

            if (! $this->request->is('post')){
                return index();
            }
            
            // Validation Rules
            $rules = [
                // rules here
                'firstname'     => 'required',
                'lastname'      => 'required', 
                'email'         => 'required|valid_email',
                'region'        => 'required',
                'nin'           => 'required', 
                'password'      => 'required',
                'passconf'      => 'required', 
                'username'      => 'required|min_length[5]|max_length[20]|is_unique[voters.username]'
            ];

            // exit("hold it");
            $data = $this->request->getPost(array_keys($rules));
            
            // exit(var_dump($data));
            // Check whether the submitted data passed the validation rules
            if (! $this->validateData($data, $rules))
            {
                $this->index();
            }
            $model = model(VotersModel::class);
            
            try{
                $model->register_voters();
                /*
                $model->save([
                    'firstname' => $data['firstname'],
                    'lastname'  => $data['lastname'],
                    'email'     => $data['email'],
                    'region'    => $data['region'], 
                    'nin'       => $data['nin'],
                    'password'  => hash('sha512', $data['password']),
                    'username'  => $data['username']
                ]);*/
                return view('header', ['title' => 'Create a news item'])
                    .view('voter_register_success').view('footer');

            }catch (DatabaseException $e){
                print("Some error with your entered data");
                print($e);
            }
 
            
        }

        public function index() {
            helper(['url', 'form']);

            $data = [
                'firstname' => ['name' => 'firstname','id' => 'firstname', 'class' => 'form-control'],  
                'lastname'  => ['name' => 'lastname','id' => 'lastname', 'class' => 'form-control'],
                'email'     => ['name' =>'email','id'=> 'email', 'class' => 'form-control'],
                'options'   => ['0' => 'Select xyz', '1' => 'state one', '2' => 'state two'],
                'attributes' => ['class' => 'form-control'],
                'nin'       => ['name' => 'nin', 'id' => 'nin', 'class' => 'form-control'],
                'password'  => ['name' => 'password', 'id' => 'password', 'type' => 'password', 'class' => 'form-control'],
                'passconf'  => ['name' => 'passconf', 'id' => 'passconf', 'type' => 'password',  'class' => 'form-control'],
                'username'  => ['name' => 'username', 'id' => 'username',  'class' => 'form-control'],
                'title'     => "Voter Register",
            ];
    

            return view('header', $data).view('register',$data).view('footer');
        }
    }