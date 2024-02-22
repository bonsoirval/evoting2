<br/><br/><br/><br/>

<?php 
  $printed_elections = array(); // hold printed elections

  if (count($elections) >= 1 ){ ?>
  <br/><br/><br/><br/>
  <table class ='table table-condensed'>
  <thead>
    <tr><th>ID</th><th><center>Election</center><th><th>Choice Candidate</th></tr>
  <thead>
  <tbody>
  <form method = 'POST' action="<?php echo base_url('/vote'); ?>">
  <?= csrf_field() ?>
  <?php 
    for ($index = 0; $index <= count($elections) - 1; $index++){
      if (!array_key_exists($elections[$index]['election'], $printed_elections)){
        ?>
        <tr>
        <td><?= $index + 1 ?></td>
        <td><?= $elections[$index]['election'] ?></td>
        <td>
        <?php $candidates = get_candidate($elections[$index]['election_id']); ?>  
          <select name='<?php echo $elections[$index]['election']; ?>' required = required>
          <option value=''>Select Candidate</option>
          <?php for($i=0; $i < count($candidates); $i++){ ?>
          <option value="<?= $candidates[$i]['cand_id']?>"><?= $candidates[$i]['cand_name'] ?></option>
          <?php } ?>
        </select>
      </td>
  <?php 
        $election_keys = array($elections[$index]['election'] => $index);
        $printed_elections[$elections[$index]['election']] = $elections[$index]['election'];
      ?>
      </tr>
      <?php 
      }else{

      }
    }
  }
?>
  <tr><td></td><td></td><td></td><td><input type='submit' value='Vote' /></td></tr>

</form>
<tbody>
</table>
<?php // else no ongoing elections data found ?>
