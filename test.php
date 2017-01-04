<?php
$arr = ['test','test2'];

function barber($type)
{
   return "Вы хотели стрижку $type, без проблем\n";
}
$new_arr = array_map('barber', $arr);
print_r($new_arr);

?>
