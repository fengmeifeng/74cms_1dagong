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
$fruits = array ( "0" => array ( "companyname" => "orange",
"trade" => "6",
"shortitle" => "apple",
"wage_cn" => "200",
),
"1" => array ( "companyname"=>"adsd",
"trade"=>'45',
"shortitle"=>"免费食宿",
"wage_cn"=>"100"
),
"2" => array ( "companyname"=>"asd",
"trade" => "6",
"shortitle"=>"免费食宿",
"wage_cn"=>"6",
)
);
foreach($fruits as $k=>$v){
	$html.=",".$v['trade'];
}
$bb=explode(",",$html);
$arr = formatArray($bb);
foreach($arr as $k=>$v){
	foreach($fruits as $key=>$val){

		if($v==$val['trade']){
			$row[$v]['companyname']=$val['companyname'];
			$row[$v]['shortitle']=$val['shortitle'];
			$row[$v]['wage_cn']=$val['wage_cn'];
		}
	}
}
echo "<pre>";
print_r($fruits);//开始原数组
print_r($row);//最终的数组
?>             
              