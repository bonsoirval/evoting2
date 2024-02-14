<?php
use CodeIgniter\Model;

/**
 * The goal of this file is to allow developers a location
 * where they can overwrite core procedural functions and
 * replace them with their own. This file is loaded during
 * the bootstrap process and is called during the framework's
 * execution.
 *
 * This can be looked at as a `master helper` file that is
 * loaded early on, and may also contain additional functions
 * that you'd like to use throughout your entire application
 *
 * @see: https://codeigniter.com/user_guide/extending/common.html
 */

if (!function_exists('get_candidate')){
    // get candidates
    function get_candidate($election_id){

        $db = \Config\Database::connect();
        // $candidates = $db->query(
        //     "
        //         SELECT e.name as name,
        //         concat(c.firstname, ' ' , c.surname, ' ', c.lastname) as cand_name, 
        //         c.id AS cand_id, p.name AS party
        //         FROM candidate c
        //         JOIN election e ON e.id = c.election_id
        //         JOIN party p ON c.party_id = p.id
        //         WHERE c.election_id = ".(int)$election_id."

               
        //     "
        // )->getResultArray();

        $candidates = $db->query(
            "SELECT concat(c.surname, ' ',c.firstname) AS cand_name, e.name AS election
            FROM candidate AS c
            INNER JOIN election AS e ON e.id = c.election_id 
            WHERE election_id in (1,2,3)
            "
        )->getResultArray();
        exit(var_dump($candidates));
        $new_candidates = array();
        foreach($candidates as $key => $value){
            for($index=0; $index < count($value); $index++){
                if(array_key_exists($candidates[$index]['election'], $new_candidates)){
                    // dont add new election key
                    // array_push($new_candidates[$index]['election'], $value['cand_name']);
                }else{
                    // add new election key
                    $new_candidates[$candidates[$index]['election']] = array(
                        $candidates[$index]['cand_name'] = [
                            'cand_name' => $candidates[$index]['cand_name'],
                            'election' => $candidates[$index]['election']
                        ]);
                    // ); //$candidates[$index]['eleccation'];
                }
            }
        }
        exit(var_dump($new_candidates));
        return $candidates; 
    }
}
if (!function_exists('get_election_id')){
    //get election id
    function get_election_id($election) {
        $last = 500;        exit(var_dump($candidates));

        return $last;
    }
}


