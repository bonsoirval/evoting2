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
        return $db->query("SELECT concat(c.surname,' ', c.firstname, ' ', c.lastname) as cand_name, c.id AS cand_id FROM candidate AS c WHERE election_id = $election_id ")->getResultArray();}
}

if (!function_exists('get_election_id')){
    //get election id
    function get_election_id($election) {
        $last = 500;        exit(var_dump($candidates));

        return $last;
    }
}

if(!function_exists('get_election_result')){
    function get_election_result($candidate_id){
        $db = \Config\Database::connect();
        return $db->query("
        SELECT count(*) AS vote FROM `votes` WHERE candidate_id = 5;
        ")->getRow()->vote;
        // return $vote->vote;
    }
}

if(!function_exists('loggedIn')){
    function loggedIn(){
        $session = \Config\Services::session();

        if(($session->get('email') == True) && !($session->get('loggedIn') == True)){
            return redirect()->route('admin_login');
        }
        return("Paused");
        return redirect()->route('admin_login');


    }
}