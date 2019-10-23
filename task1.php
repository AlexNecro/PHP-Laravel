<?php
//http://phptester.net/
function println($text = "") {
	echo($text."<br>");
}
function revert($str) {
	
	$res = "";
	
	for ($i = strlen($str); $i--; $i>=0) {
		
		$res .= substr($str, $i, 1);
		
	}
	
	return $res;
}
function addStrToArray($arr, $str) {
	if (count($arr) == 0 || $str == "")
		return false;
	for($i=0;$i<sizeof($arr);$i++) {
		$arr[$i].=$str;
	}
	return $arr;
}
function printWeekDaysOfPeriod($datestart, $dateend, $dayofweek) {
	
	$timestart = strtotime($datestart);
	$timeend = strtotime($dateend);
	
	$time = $timestart;
		
	while($time <= $timeend) {
		if (date('w', $time) == $dayofweek)
			println(date("d.m.Y",$time));
		$time += 1 * 24 * 60 * 60;
	}
}
function task1($edge) {
	println();
	println("task1($edge):");
    
    println("1");
    
    $result = 2;
    do {
        
        println($result);
        
        $result *= 2;
        
    } while ($result < $edge);
}
function task2($str) {
	println();
	println("task2($str):");
	
	println(revert($str));
}
function task3($arr) {
	println();
	println("task3([".implode(",",$arr)."]):");
	
	if (gettype($arr[3]) == "string" || gettype($arr[6]) == "string" || gettype($arr[8]) == "string") {
		println("Achtung! Achtung!");
	} else {
		println($arr[3] + $arr[6] + $arr[8]);
	}
	
}
function task4($datestart, $dateend, $dayofweek) {
	println();
	println("task4($datestart, $dateend, $dayofweek):");
	
	printWeekdaysOfPeriod($datestart, $dateend, $dayofweek);
	
}
function task5($arr, $str) {
	println();
	println("task5(".implode(",",$arr).", $str):");
	
	$res = addStrToArray($arr, $str);
	var_dump($res);
	
}
function task6($year, $month) {
	println();
	println("task6($year, $month):");
	
	if ($year < 1 || $year > 9999) {
		println("Несуществующий год и всё такое");
		return;
	};
	$time = mktime(0,0,0,1,$month,$year);
	printWeekdaysOfPeriod(date("Y-m-d"), date("Y-m-t"), 2);
	
}
//main:
task1(10000);
task2("abcd");
task3([1,2,3,4,5,6,7,8,9,10]);
task3([1,2,3,"жопа",5,6,7,8,9,10]);
task4("2019-08-1", "2019-08-31", 1);
task5([1,2,3,4,5,6,7,8,9,10], "строка");
task5([1,2,3,4,5,6,7,8,9,10], "");
task6(-1, 12);
task6(2019,8);
