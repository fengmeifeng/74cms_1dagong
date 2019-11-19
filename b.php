<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php
function formatArray($array)
{
sort($array);
$tem = "";
$temarray = array();
$j = 0;
for($i=0;$i<count($array);$i++)
{
if($array[$i]!=$tem)
{
$temarray[$j] = $array[$i];
$j++;
}
$tem = $array[$i];
}
return $temarray;
}
$array = array(5,5,6,6,25,37,5);
$arr = formatArray($array);
echo "数组中值为相同的组合成一个<br>";
echo "<pre>";
print_r($arr);

$array = array(2, "hello", 1, "world", "hello");
echo "<pre>";
print_r(array_count_values($array));
?>