<?php
$a=array(array(1,2,3,4),array(1,2,3,4)){
	for($i=0;$i<=sizeof($a);$i++){
		for($j=0;$j<=sizeof($a[$i]);$j++){
			echo $a[$i][$j];
		}
	}
}