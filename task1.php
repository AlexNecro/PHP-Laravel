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

function task7_recurrent(){
    println();
	println("task7_recurrent():");
    $num = genLowestNumberRecurrent();
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

/* ========================== task7() ============================ */
function genLowestNumber() {
	
	$numbers = array();
	array_push($numbers, 0);
	
	while (true) {		
		$newnumbers = array();
		
		foreach ($numbers as $elem) {
			
			$elem7 =$elem*10 + 7;
            $elem3 = $elem*10 + 3;
			
			if (isNumberOK($elem7)) {       
				return $elem7;
            };
			
			if (isNumberOK($elem3)) {
				return $elem3;
            };
			
			array_push($newnumbers, $elem3);
			array_push($newnumbers, $elem7);	
		};
        $numbers = $newnumbers;	
	};
	
	return -1;
}

function isNumberOK($num) { 

    if ($num % 7 != 0 || $num % 3 != 0)
        return false;
    
    $has7 = false;
	$has3 = false;
    $sum = 0;
    $len = numberlen($num);
	
    for ($i = 0 ; $i < $len; $i++) {
		
        $ch = digit($num, $i, $len);

		$sum = $sum + $ch;
		
		if ($ch == 7) {
			$has7 = true;
        } elseif ($ch == 3) {
			$has3 = true;
        } else {
			return false;
		};
    };

    return $has3 and $has7 and ($sum % 7 == 0) and ($sum % 3 == 0);
}

function digit($num, $pos, $len) {
	
	$temp = $num;
	
	for ($i = 0; $i < ($len - $pos); $i++) {
		
		$temp = $temp / 10;
		
    };
	return (int)(($temp - (int)($temp)) * 10);
}

function numberlen($num) {
	
	$k = 1;
	
	while( $num > 10) {
		$num = $num / 10;
		$k =$k + 1;
    };
	
	return $k;
}

function genLowestNumberRecurrent($num = 0, $sum = 0, $d1qty = 0, $d2qty = 0, $levels = 15) {
    $levels--;
    
    if ($levels==0) return $num;

    if ($num%7==0 && $num%3==0 && $sum%7==0 && $sum%3==0 && $d1qty > 0 && $d2qty > 0) {
        return $num;
    }
    
    $branch3 = genLowestNumberRecurrent($num*10 + 3, $sum + 3, $d1qty + 1, $d2qty, $levels);
    $branch7 = genLowestNumberRecurrent($num*10 + 7, $sum + 7, $d1qty, $d2qty + 1, $levels);

    return min($branch3, $branch7);
}

/* ==================== test suite ==============================*/
//main:
println("@alexnecro работа#1");
task1(10000);
task2("abcd");
task3([1,2,3,4,5,6,7,8,9,10]);
task3([1,2,3,"жопа",5,6,7,8,9,10]);
task4("2019-08-1", "2019-08-31", 1);
task5([1,2,3,4,5,6,7,8,9,10], "строка");
task5([1,2,3,4,5,6,7,8,9,10], "");
task6(-1, 12);
task6(2019,8);
task7(); //ответ 3333377733
task7_recurrent(); //ответ 3333377733
