<?php
namespace Coralys\Tests;

/**
 *		A simple utility to pretty-up your test suites by simply
 *	and neatly printing out the PASS/Fail result with comment and checkmark.
 * The user only has to call AnnounceCase() at the beginning of the test case
 * and then PrintResult() to test the condition which internally takes care
 * of updating the tally. Internally a shutdown function is registered so that
 * when the test suite file terminates, a summary of passed/failed is presented.
 *
 * Example:
 *		use Coralys\Tests;
 *		function testCaseOne {
 *			AnnounceCase("Testing constructor");
 *					: do the test
 *			PrintResult($got == $obtained, 'Constructor with parameters');
 *		}
 */

ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
require_once('functions.php');

/*
 *						G L O B A L S
 */
$Ctx = new TestContext();	// But no need to access it outside. PrintResult takes care of it.

/*
 *						C L A S S E S
 */
 
/**
 * A Test Context is a unique instance for every file that runs one or
 * more tests. It must be instantiated in the file that has the test cases.
 * Example:
 *		$Ctx = new Coralys\Tests\TestContext();
 */
class TestContext {
	public $Passed;
	public $Failed;
	public $SuiteCount;
	public $TotalPassed;
	public $TotalFailed;
	public $CurrentSuite;

	public function Pass() {
		$this->Passed += 1;
	}

	public function Fail() {
		$this->Failed += 1;
	}

	/**
	 * Usually invoked by AnnounceTestSuite() and saves the
	 * current tally to the total (accumulative) and resets
	 * the current count for the new test suite.
	 * @see AnnounceTestSuite()
	 */
	public function Accumulate(string $currentSuite) {
		$this->TotalPassed += $this->Passed;
		$this->TotalFailed += $this->Failed;
		$this->Passed = 0;
		$this->Failed = 0;
		$this->SuiteCount += 1;
		$this->CurrentSuite = $currentSuite;
	}

	/**
	 * Resets both the current test suite tally as well as the
	 * totals.
	 */
	public function Reset() {
		$this->Passed = 0;
		$this->Failed = 0;
		$this->TotalPassed = 0;
		$this->TotalFailed = 0;
	}

	private function SubTotal(): int {
		return $this->Passed + $this->Failed;
	}

	private function Total(): int {
		return $this->TotalPassed + $this->TotalFailed;
	}

	private function SubPercentPassed(): int {
		if ($this->SubTotal() == 0) {
			return 0;
		}
		return intval(100 * $this->Passed / $this->SubTotal());
	}

	private function TotalPercentPassed(): int {
		return intval(100 * $this->Passed / $this->Total());
	}

	public function String() {
		printf("\n\n\tUnit Test Summary\n");
		printf("\t(%s)\n", $this->CurrentSuite);
		if ($this->SuiteCount > 1) {

		}
		$pctPassed = $this->SubPercentPassed();
		$pctFailed = 100 - $pctPassed;
		printf("\t============================\n\t\u{2705} Passed: %3d / %-4d (%d%%)\n",
			$this->Passed, $this->SubTotal(), $pctPassed
		);
		if ($this->Failed > 0) {
			printf("\t\u{274c} Failed: %3d / %-4d (%d%%)\n",
			$this->Failed, $this->SubTotal(), $pctFailed
		);	
		}
	}
}


function shutdown()
{
    // This is our shutdown function, in 
    // here we can do any last operations
    // before the script is complete.

    //echo 'Script executed with success', PHP_EOL;
	global $Ctx;
	$Ctx->String();
}

register_shutdown_function('Coralys\Tests\shutdown');

/**
 * Convert a boolean to OK or FAILED.
 * @see PrintResult()
 */
function Result($condition) {
	global $Ctx;
	if ($condition) {
		$Ctx->Pass();
	} else {
		$Ctx->Fail();
	}
    return $condition ? 'OK' : 'FAILED';
}


?>

