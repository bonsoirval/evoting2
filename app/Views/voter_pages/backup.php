

 
    <?php if (count($elections) >= 1) { ?>
        
    <?php 
          //  used to count printed elections
          $printed_elections = array(); 
    ?>

    <?php for($index=0; $index < count($elections); $index++){ ?>
      <?php $candidates = get_candidate($elections[$index]['election_id']); ?>  
      <?php $new = null; $old = null; // setting control values ?>
      <tr>
      <td><?php echo $index + 1 ?></td>
      <?php // foreach($elections as $k => $v) {?>
      <td><input type = 'text' 
      value = '<?php //echo $elections[$index]['election']; ?>' 
      name = '<?php echo $elections[$index]['election']; ?>' hidden>
      <center>
        <?php 
        if(!array_key_exists($elections[$index]['election'], $printed_elections)){?>
          <input 
          type = 'text' 
          value = '<?php echo $elections[$index]['election']; ?>' 
          name = '<?php echo $elections[$index]['election']; ?>'  
          disabled>
        <?php 
          // add the just printed elections to printed elections
          array_push($printed_elections, $elections[$index]['election']);
        
        ?>
      </center>
      <td>
      <td>
          <select name='<?php echo $elections[$index]['election']; ?>'>
          <option value='0'>Select Candidate</option>
          <?php for($i=0; $i < count($candidates); $i++){ ?>
          <option value=''>Something Here</option>
          <?php } ?>
        </select>
      </td>
      <?php  }else{} ?>
      <?php } ?>
    </tr>
    <tr><td></td><td></td><td></td><<br/><br/><br/><br/>
    <tr><td></td><td></td><td></td><td><input type='submit' value='Vote' /></td></tr>

<?php 
  } 
  // print all elections
  print("All elections captured");
  print_r($printed_elections);
?>

