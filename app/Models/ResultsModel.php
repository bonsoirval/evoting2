<?php 

    namespace App\Models;
    use CodeIgniter\Model;
  

    class ResultssModel extends Model{
        public function getResults(){
            $db      = \Config\Database::connect();
    
            return $db->query(
                "SELECT * FROM votes"
            )->getResult();
        }

        public function getStateResult($region, $year){
            $db = \Config\Database::connect();
            
            
            return $db->query(
                "
                    SELECT v.voter_id AS votes, r.state, e.name AS election, 
                    concat(c.firstname, ' ', c.surname) AS candidate
                
                    FROM regions AS r
                    JOIN election AS e ON e.region_id = r.id
                    JOIN candidate AS c ON c.election_id = e.id
                    LEFT JOIN votes AS v ON v.candidate_id =c.id
                    -- // WHERE e.id IN  (
                    -- //     SELECT e.id
                    -- //     FROM election AS e
                    -- //     JOIN votes AS v ON YEAR(v.vote_time) = YEAR(e.election_date) 
                    -- //     WHERE YEAR(election_date) = $year
                    -- // ) 
                    ORDER BY e.name
                                 
                    
                "
            )->getResultArray();

            /*
            SELECT concat(c.surname,' ', c.firstname,' ',c.lastname) AS candidate,
                    c.id AS candidate_id,
                    e.id AS election_id, 
                    e.name AS election, 
                    count(v.candidate_id) AS votes
                    
                    FROM election AS e
                    JOIN candidate AS c ON c.election_id = e.id
                    JOIN votes AS v ON c.id = v.candidate_id AND v.election_id = v.id
                    
                    WHERE year(e.election_date) = $year
                    GROUP BY election_id
            */
            // return $db->query("
            //     SELECT concat(c.surname, ' ',c.firstname, ' ', c.lastname) as candidate,
            //     count(v.candidate_id) as votes
            //     FROM candidate c 
            //     JOIN votes v ON v.election_id = c.election_id 
            //     JOIN regions r ON e.election_id = r.id
                
            // ")->getResultArray();
        }
    }
?>