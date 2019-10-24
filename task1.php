<?php
//http://phptester.net/

/* ========================== tasks =========================== */
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
	$time = mktime(0,0,0,$month,1,$year);
	printWeekdaysOfPeriod(date("Y-m-d", $time), date("Y-m-t", $time), 2);
	
}

function task7(){
    println();
	println("task7():");
    $num = genLowestNumber();
    println($num);
}

/* ========================== helper funcs ============================ */
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

function isDivisible($num) {
    if ($num % 7 != 0 || $num % 3 != 0) 
        return false;
    return true;
}

function sumDigits($num) {
    $sum = 0;
    for ($i = 0; $i < strlen($num); $i++) {
        $sum += substr($num, $i, 1);
    }
    return $sum;
}

function isGoodDigits($num) {
    $has7 = false;
    $has3 = false;

    for ($i = 0; $i < strlen($num); $i++) {
        $ch = substr($num, $i, 1);
        if ($ch == 7)
            $has7 = true;
        elseif($ch == 3)
            $has3 = true;
        else 
            return false;
    }
    return $has3 && $has7;
}

function genLowestNumber($seed = "") {
    for ($i = 21; $i<999999999;$i++) {
        //simple tests:
        if (!isDivisible($i))
            continue;
            
        if (!isGoodDigits($i))
            continue;

        $sumDigits = sumDigits($i);

        println("genLowestNumber($i), sum = ".$sumDigits.", %7=".($sumDigits%7).", %3=".($sumDigits%3));
        if (!isDivisible($sumDigits))
            continue;

        return $i;
        
    }
    /*$sum = sumDigits($seed);
    println("genLowestNumber($seed), %7=".($seed%7).", %3=".($seed%3).", sum = ".$sum."%7=".($sum%7)."%3=".($sum%3));
    if ($seed != "" && isGoodNum($seed) || $seed > 999999) 
        return $seed;
    $num3 = genLowestNumber($seed."3");
    $num7 = genLowestNumber($seed."7");
    return min($num3, $num7);*/
}

/* ==================== test suite ==============================*/
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
task7();
