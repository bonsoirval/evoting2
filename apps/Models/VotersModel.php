<?php 

    namespace App\Models;
    use CodeIgniter\Model;
  

    class VotersModel extends Model{
        protected $table = 'voters';
        protected $allowedFields = ['firstname','lastname', 'username','email', 'nin', 'password', 'region_id'];
        

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

            $election_result = $this->db->query(
                "
                SELECT DISTINCT(e.name) AS election,c.surname as candidate,  e.id AS election_id
                FROM election e 
                JOIN candidate c ON c.election_id = e.id
                WHERE e.id IN (
                    SELECT vhe.election_id 
                    FROM voter_has_election vhe
                    WHERE vhe.voter_id = ".$session->get('userid')." 
                    AND status = 'not voted'
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

            $username = $this->db->escape($username);
            $password = hash('sha512',$this->db->escape($password));
    
            
            $sql = "SELECT id,username, email FROM voters WHERE username = ? AND password = ?";
            $result = $this->db->query($sql, array($username, $password));
            // exit(var_dump($result->getNumRows));
            if ($result->getNumRows() === 1){
                $result = $result->getRowArray(); // convert to array
                $userdata = [
                    'userid'        => $result['id'],
                    'username'  => $result['username'],
                    'email'     => $result['email'],
                    'logged_in' => TRUE
                ];
                $session->set($userdata);
                
                return TRUE;
                }
            return FALSE;
            
        }

        public function logout(){
            $session = \Config\Services::session(); // instantiate session
            $session->destroy();
            return True;
        }
    


}
?>