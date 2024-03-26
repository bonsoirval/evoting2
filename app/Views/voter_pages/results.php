<br/><br/><br/><br/>
<form method = 'post' action="<?php base_url('result'); ?>">
    <?= csrf_field(); ?>
    <!-- election area -->
    <select name='region' required=required>
        <option value=''>--Select Area--</option>
        <option value = '0'>Federal</option>
        <option value='1'>Abia State</option>
    </select>

    <!-- election year -->
    <select name='year' required=required>
        <option value=''>--Select Year--</option>
        <option value='2023'>2023</option>
    </select>

    <input type='submit' value = 'Show Result' />
</form>
<?php 
    if($result != null){    
        for($i=0; $i<=count($result) - 1; $i++){
        /**
         * { [0]=> array(5) { ["candidate"]=> string(26) "surname firstname lastname" ["candidate_id"]=> string(1) "5" 
         * ["election_id"]=> string(1) "3" ["election"]=> string(13) "test_election" ["votes"]=> string(1) "1" } }
         */
            print("Candidate : " . $result[$i]['candidate']);
            print("<br/>Candidate ID : ". $result[$i]['candidate_id']);
            print("<br/>Election ID : " . $result[$i]['election_id']);
            print("<br/>Election  : " . $result[$i]['election']);
            print("<br/>Vote : " .get_election_result($result[$i]['candidate_id']));
        }
    }
?>