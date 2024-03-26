<?php 

    namespace App\Models\Admin;
    use CodeIgniter\Model;
  

    class AdminModel extends Model{
        
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