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