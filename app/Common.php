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
        // $ci=& get_instance();
        // $ci->load->database(); 
        $db = \Config\Database::connect();
        $candidates = $db->query(
            "
                SELECT concat(c.firstname, ' ' , c.surname, ' ', c.lastname) as cand_name, c.id AS cand_id, p.name AS party
                FROM candidate c 
                JOIN party p ON c.party_id = p.id 
                WHERE election_id = ".(int)$election_id."
            "
        )->getResultArray();

        // var_dump($candidates);
        return $candidates; 
    }
}
if (!function_exists('get_election_id')){
    //get election id
    function get_election_id($election) {
        $last = 500;
        return $last;
    }
}


function greet(){
    printf("How u doing");
}
