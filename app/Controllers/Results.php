<?php 
    namespace App\Controllers;

    use App\Controllers\BaseController;
    use CodeIgniter\Exceptions\PageNotFoundExceptions;
    use CodeIgniter\Database\Exceptions\DatabaseException;
    use App\Models\ResultsModel;
    

    class Results extends BaseController{
        public function index(){
            $request = \Config\Services::request();

            $region = $request->getPost('region');
            if($region == '0'){
                
                exit("Choice is federal");
            }
            elseif($region != '0' && $request->getPost('year')){
                $model = model('ResultsModel');
                $year = $request->getPost('year');
                $values = array($year, $region);

                $state_result = $model->getStateResult($region, $year);
                $data = array(
                    'title' => "Vote Result",
                    'result' => $state_result
                );


                return view('voter_pages/header', $data)
                        .view('voter_pages/results', $data)
                        .view('voter_pages/footer',$data);
                
            }elseif(!$request || !$request->getPost('year')){
                // no submit value, reload page
                $data = [
                    'title' => 'Vote Result',
                    'result' => null,
                ];
                return 
                    view('voter_pages/header', $data)
                    .view('voter_pages/results')
                    .view('voter_pages/footer');
            }         
             
        }    
    }