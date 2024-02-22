<?php 

    namespace App\Models;
    use CodeIgniter\Model;
  

    class VotersModel extends Model{
        protected $table = 'voters';
        protected $allowedFields = ['firstname','lastname', 'username','email', 'nin', 'password', 'region_id'];
        public $session;

        public function __construct(){
           $this->session = \Config\Services::session();
        }
        public function vote(array $votes){
            $db      = \Config\Database::connect();
            $session = \Config\Services::session();
            

            // loop through the votes and vote each candidate
            foreach($votes as $key => $val){
                $builder = $db->table('candidate');
                $builder->select(['id', 'election_id']);
                $builder->where(['id' => $val]);
                $data = $builder->get()->getResultArray();

                // vote for each candidate chosen
                foreach($data as $row){
                    // cast vote
                    $insert_data = [
                        'voter_id' => $this->session->get('userid'),
                        'candidate_id'  =>  $row['id'],
                        'election_id'   =>  $row['election_id']
                    ];

                    $builder = $db->table('votes'); // insertion table
                    $builder->insert($insert_data);
                    
                    // update voter_has_election
                    // prevents multiple voting
                    $builder = $db->table('voter_has_election');
                    $update_data = [
                        'status'    => 'voted',
                    ];
                    $builder->where('voter_id', $this->session->get('userid'));
                    $builder->update($update_data);
                }
                
            }
            return TRUE;
        }
        
        public function register_voter(){
            // check if user already registered
            $data = array(
                'firstname' => $this->db->escape($this->security->xss_clean($this->input->post('firstname'))),
                'lastname'  => $this->db->escape($this->security->xss_clean($this->input->post('lastname'))),
                'username'  => $this->db->escape($this->security->xss_clean($this->input->post('username'))),
                'email'     => $this->db->escape($this->security->xss_clean($this->input->post('email'))),
                'nin'       => $this->db->escape($this->security->xss_clean($this->db->escape($this->input->post('nin')))),
                // password hash
                'password'  => hash('sha512', $this->db->escape($this->input->post('password'))),
            );   
            $this->db->insert('voters', $data);
            $new_voter_id = $this->db->select_max('id')->from('voters')->get()->row()->id;

            $region_id = $this->input->post('region');

            $this->db->select('id,region_id');
            $this->db->from('election');
            $this->db->where('region_id', $region_id);
            $region_elections =  $this->db->get()->result_array();
            
            for($index = 0; $index < count($region_elections); $index++){
                $data = array(
                    'voter_id' => (int)$new_voter_id, 
                    'status' => 'not voted',
                    'election_id' => (int)$region_elections[$index]['id']);
                $this->db->insert('voter_has_election', $data);
            }
            /**
             * register voter
             * pick his id 
             * pick the id of his chosen region 
             * for all elections in the region and fct
             * add voter_has_election
             */
            echo $this->db->affected_rows();
            
        }

        public function get_elections(){
            $session = session(); // \Config\Services::session($config);
            $db = \Config\Database::connect();

            $election_result = $db->query(
                "
                SELECT DISTINCT(e.name) AS election,c.surname as candidate,  
                e.id AS election_id
                FROM election e 
                JOIN candidate c ON c.election_id = e.id
                WHERE e.id IN (
                    SELECT vhe.election_id 
                    FROM voter_has_election vhe
                    WHERE vhe.voter_id = ".$session->get('userid')." 
                    AND vhe.status = 'not voted'
                )
                AND e.status = 'ongoing'
                order by election
                "
            )->getResultArray();
            // exit(var_dump($election_result));
            return $election_result; 
        }

        public function getNews($slug = 'home'){
            if($slug == false){
                return $this->findAll();
            }
            return $this->where(['slug' => $slug])->first();
        }

        // log voter in
        public function voter_login($username, $password){  
            // var_dump($user_session_data);
            $session = \Config\Services::session(); // initialize session
            $db      = \Config\Database::connect();

            $username = $db->escape($username);
            $password = hash('sha512',$db->escape($password));
    

            // $sql = "SELECT id,username, email FROM voters WHERE username = ? AND password = ?";
            // $result = $db->query($sql, array($username, $password));
            
            $builder = $db->table('voters');
            $builder->select(['id', 'username', 'email']);
            $builder->where('username', $username);
            $builder->where('password', $password);
            $result = $builder->get()->getResult();
 
            // if user exists
            if(count($result)){
                // add session value
                foreach($result as $user){
                    // collate session data
                    $userdata = [
                        'userid'    => $user->id,
                        'username'  => $user->username,
                        'email'     => $user->email,
                        'logged_in' => True 
                    ];
                    $session->set($userdata);
                    return TRUE;
                }
                return TRUE;
            }
            
        }

        public function logout(){
            $session = \Config\Services::session(); // instantiate session
            $session->destroy();
            return True;
        }
    


}
?>