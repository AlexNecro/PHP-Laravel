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

function task1($edge) {
	println();
	println("task1:");
    
    println("1");
    
    $result = 2;
    do {
        
        println($result);
        
        $result *= 2;
        
    } while ($result < $edge);
}

function task2($str) {
	println();
	println("task2:");
	
	println(revert($str));
}

function task3($arr) {
	println();
	println("task3:");
	
	if (gettype($arr[3]) == "string" || gettype($arr[6]) == "string" || gettype($arr[8]) == "string") {
		println("Achtung! Achtung!");
	} else {
		println($arr[3] + $arr[6] + $arr[8]);
	}
	
}

//main:
task1(10000);
task2("abcd");
task3([1,2,3,4,5,6,7,8,9,10]);
task3([1,2,3,"жопа",5,6,7,8,9,10]);