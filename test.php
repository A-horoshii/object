<?php
$arr = ['test','test2'];

function barber($type)
{
   return "�� ������ ������� $type, ��� �������\n";
}
$new_arr = array_map('barber', $arr);
print_r($new_arr);

?>
