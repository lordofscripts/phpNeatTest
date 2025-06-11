<?php
namespace Coralys\Tests;

/*
 *		L O C A L    F U N C T I O N S
 */

/**
 * Annouce a new Test Suite (a collection of Unit tests).
 * It resets the current TestContext instance.
 */
function AnnounceTestSuite($title) {
	global $Ctx;
	$filler = (70 - mb_strlen($title) - 6) / 2; 
	echo str_repeat("\u{22c6}", 70) . PHP_EOL;
	printf("\u{22c6}\u{22c6}%s %s %s\u{22c6}\u{22c6}\n", str_repeat(' ', $filler), $title, str_repeat(' ', $filler));
	echo str_repeat("\u{22c6}", 70) . PHP_EOL . PHP_EOL;
	$Ctx->Accumulate($title);
}

/**
 * Announce a new test Unit, invoked at the top of the test unit function.
 * A test unit may contain several test case variants.
 * Example:
 *  	use function Coralys\Tests\AnnounceCase;
 *		AnnounceCase("Test symmetric encryption");
 */
function AnnounceUnit($title) {
	$filler = (70 - mb_strlen($title)) / 2; 
	printf("%s %s %s\n", str_repeat("\u{269b}", $filler), $title, str_repeat("\u{269b}", $filler));
}

function AnnounceCase($title) {
	$filler = (70 - mb_strlen($title) - 4) / 2; 
	printf("%s\u{2668} %s \u{2668}%s\n", str_repeat(' ', $filler), $title, str_repeat(' ', $filler));
}

/**
 * Prettyfy an object's member variable or property
 */
function PropName($class_name, $method_name, $comment='') {
	return sprintf("%s\u{27a4}%s %s", $class_name, $method_name, $comment);
}

/**
 * Prettyfy an object's Method name.
 */
function MethName($class_name, $method_name, $comment='') {
	return sprintf("%s\u{27a4}%s() %s", $class_name, $method_name, $comment);
}

/**
 * Convert a boolean to OK or FAILED and print it
 */
function PrintResult($condition, $descr = null, $got = null, $expected = null) {
	// COLORED
	//$mark = $condition ?  "\u{2705}" : "\u{274c}";
	// NOT COLORED
	$mark = $condition ? "\u{2714}" : "\u{2718}";	// ✓ OR 
	if (!is_null($descr)) {
		printf("%s Test Case: %s\n", $mark, $descr);	
	}
	if (!$condition && !is_null($got)) {
		printf("\tGot     : %s\n", $got);		
	}
	if (!is_null($expected)) {
		printf("\tExpected: %s\n", $expected);		
	}
   //printf("\tResult: %s\n", $condition ? 'OK' : 'FAILED');
   printf("\tResult: %s\n", Result($condition));
}

function Indent(string $str): string {
	$pattern = '/(\n)/m';
	$replacement = "$1\t\t";
	return "\t" . preg_replace($pattern, $replacement, $str);
}
?>
