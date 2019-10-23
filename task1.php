<?php
//http://phptester.net/
function println($text) {
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
    println("task");
    
    println("1");
    
    $result = 2;
    do {
        
        println($result);
        
        $result *= 2;
        
    } while ($result < $edge);
}

function task2($str) {
	
	println("task2:");
	
	println(revert($str));
}

//main:
task1(10000);
task2("abcd");