<?php
$array = array(0 => 100, 'color' => 'red');
print_r(array_keys($array));
print("<br/>above are array keys");

$array = array('blue', 'red', 'green');
print_r(array_keys($array, 'blue'));

$array = array('color' => array('blue', 'red', 'green'), 
                  'size'  => array('small', 'medium', 'large'));

print_r(array_keys($array));
?>
