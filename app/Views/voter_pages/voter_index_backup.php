<br/><br/><br/><br/>
<?php 
    // for($index=0; $index < count($elections); $index++){
    //   // print("<br/>");
    //   $candidates = get_candidate($elections[$index]['election_id']);

    //   // print($index+1); print("::::");
    //   // print($elections[$index]['election']); print("<br/>");

    //   // print("<br/>");
    //   $old = null;
    //   $new = null;
    //   ?>
    //   <!-- <select>
    //     <option value='0'>Select values</option>-->
    //   <?php 
    //   foreach($elections as $k => $v){
    //     // print_r($v);
    //     $new = $v['election'];
    //     if ($new != $old){
    //       // print("changed");
    //       print("New election");
    //       print("<option value='xys'>Some values</option>");
    //       $old = $v['election'];
    //     }elseif($old == $new){
    //       print("Just added new option");
    //     }
    //     // print("<br/>################<br/>");
    //   }
    // }
?>
<table class ='table table-condensed'>
  <thead>
    <tr><th>ID</th><th><center>Election</center><th><th>Choice Candidate</th></tr>
  <thead>
  <tbody>
    <?php if (count($elections) >= 1) { ?>
    <form method = 'POST' action="<?php echo base_url('index.php/voter_dashboard/vote'); ?>">
    <?= csrf_field() ?>
    <?php for($index=0; $index < count($elections); $index++){ ?>
      <?php $candidates = get_candidate($elections[$index]['election_id']); ?>
    
    
      <?php $new = null; $old = null; // setting control values ?>
      
      <tr>
      <td><?php echo $index + 1 ?></td>
      <?php // foreach($elections as $k => $v) {?>
      <td><input type = 'text' 
      value = '<?php //echo $elections[$index]['election']; ?>' 
      name = '<?php echo $elections[$index]['election']; ?>'  hidden>

      <center><input type = 'text' value = '<?php echo $elections[$index]['election']; ?>' name = '<?php echo $elections[$index]['election']; ?>'  disabled></center>
      <td>
      <td>
          <select name='<?php echo $elections[$index]['election']; ?>'>
          <option value='0'>Select Candidate</option>
          <?php for($i=0; $i < count($candidates); $i++){ ?>
          <option value='<?php  echo $candidates[$i]['cand_id']; ?>'><?php  echo $candidates[$i]['cand_name']; ?></option>
          <?php } ?>
        </select>
      </td>
      <?php } ?>
    </tr>
    <tr><td></td><td></td><td></td><td><input type='submit' value='Vote' /></td></tr>
    </form>
    <?php } elseif (!count($elections) >= 1){ ?>
      <tr>
        <td></td>
        <td><center>You Have No Pending Election To Vote For. Thanks</center></td>
        <td></td>
      </tr> 
    <?php } ?>
  <tbody> 
</table>