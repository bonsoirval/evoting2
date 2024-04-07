<?php 

    namespace App\Models\Admin;
    use CodeIgniter\Model;
  

    class AdminModel extends Model{
    
        public function add_election($data){
            $db = \Config\Database::connect();

            /** 
             * clean data
             * and insert into database
             * add flash data
             */
            // exit(var_dump($data));
            if(!empty($data)){
                // data supplied 
                $election = array(
                    'name' => $data['election'], 
                    'region_id' => $data['region'],
                    'election_date' => $data['election_date'],
                );
                $builder = $db->table('election');
                $builder->insert($election);
                $session->setFlashdata('election_added', "Election added successfully");
                return true;
            }

            if(null !== $this->input->post('add_election') &&
            $this->input->post() && $this->form_validation->run() == True){
                $election = $this->db->escape_str(xss_clean($this->input->post('election')));
                $region = $this->db->escape_str(xss_clean($this->input->post('region')));
                $election_date = $this->db->escape_str(xss_clean($this->input->post('election_date')));
                 
                // add flash data
                $this->session->set_flashdata('election_added', "Election added successfully.");
                return $this->db->insert('election', $data = array('name' => $election, 'region_id' => $region, 'election_date' => $election_date, 'status' => 'upcoming',), True);
            }
    
            return False;
        }

    // return election region(s) for passed id
    // or return all election regions
    public function get_regions($region_id = NULL){
        $db = \Config\Database::connect();
        $session = \Config\Services::session();
        $request = \Config\Services::request();

        if(isset ($region_id)){
            exit("Value Passed");
            // clean variable
            $region_id = xss_clean($this->db->escape_str($region_id));

            $this->db->select("state");
            $this->db->from('election');
            $this->db->where('id',$region_id);
            $result = $this->db->get();
            return $result;
        }

        $builder = $db->table('regions')
                    ->select(['id', 'state'])
                    ->where('id>=',1)
                    ->orderBy('state', 'asc');
        return $builder->get()->getResult();
       
        // // pack result into array
        // $result_arr = array(); 
        // foreach($result as $row){
        //     $result_arr[$row['id']] = $row['state'];
        // }
       
    }

        // update party  
        public function update_party($data){
            $db = \Config\Database::connect();
            $session = \Config\Services::session();

            // build table connection 
            $builder = $db->table('party');
            $data['status'] = 'active';
            $builder->where('id', (int)$session->get('search_id'));
            if($builder->update($db->escape($data))){
                $session->setFlashdata('party_update', 'Successfully updated party');
                return TRUE;
            }
            exit("stop");
        }

        // get party being searched for
        public function get_parties($query, $query_type){
            $db = \Config\Database::connect(); 
            $session = \Config\Services::session();

            $sql = "SELECT id,name, abbreviation, slogan, ideology, status FROM party WHERE $query_type = ?";
            $search_result = $db->query($sql, $query)->getRow(); //, 'live', 'Rick']);

            // Add session data if data exists 
            if (!empty($search_result)){
                $session_data = array('search_id' => $search_result->id);
                $session->set($session_data);
                return $search_result;
            }
            return FALSE;
        }

        public function add_party($data){
            $db = \Config\Database::connect();
            $session = \Config\Services::session();

            // build table connection 
            $builder = $db->table('party');
            $data['status'] = 'active';

            if($builder->insert($db->escape($data))){
                $session->setFlashdata('add_party_success', "<span class='primary success'>Party Added Successfully</span>");
                return True;
            }
            return False;
        }
        
        /** Log admin userr out */
        public function signout(){
            $session = \Config\Services::session(); // Create session variable

            $user_session = ['userid', 'username','logged_in'];
            $session->remove($user_session);
            return True;
        }

        /**Log admin users in */
        public function adminLogin(){
            $db = \Config\Database::connect();
            $request = \Config\Services::request();
            // $security = \Config\Services::security();
            $session = \Config\Services::session();


            $username = $db->escape($request->getPost('username'));
            $password = hash('sha512', $db->escape($request->getPost('password')));

            //$loggedIn = $db->query("SELECT id, username, email FROM admins WHERE username = $username AND password = $password")->getResult();
            $sql = "SELECT id, username, email FROM admins WHERE username = ? AND password = ?";
            $loggedIn = $db->query($sql,[$username, $password])->getResultArray();
            
            // exit(var_dump($loggedIn));

            if(count($loggedIn) === 1){
                $userdata = array(
                    'userid' => $loggedIn[0]['id'],
                    'username' => $loggedIn[0]['username'],
                    'logged_in' => True
                );

                $session->set($userdata);
            }
            return True;
        }
    }
?>