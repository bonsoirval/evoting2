<?php 

    namespace App\Models\Admin;
    use CodeIgniter\Model;
  

    class AdminModel extends Model{

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