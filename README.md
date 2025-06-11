# PHP NEAT TEST

A super simple utility to neat-up your test cases and tally the
results of your PHP test suite. It's here because I just need
something simple.

# Usage

```php
    set_include_path(get_include_path() . PATH_SEPARATOR . NEAT_TEST);
    require_once('TestContext.php');

    use function Coralys\Tests\AnnounceTestSuite;
    use function Coralys\Tests\AnnounceUnit;
    use function Coralys\Tests\AnnounceCase;
    use function Coralys\Tests\PrintResult;
    use function Coralys\Tests\PropName;
    use function Coralys\Tests\MethName;    

    function test_Division() {
        AnnounceUnit("Division");

        $op1 = 10;  // divident
        $op2 = 2;   // divisor

        AnnounceCase("Normal division");
        $result = $op1 / $op2;  // quotient
        $expected = 5;
        PrintResult($expected == $result, 'Valid quotient', $result, $expected);

        // Variations of the same test case
        AnnounceCase("Division exception");
        try {
            $result = $op1 / 0;  // quotient
        } catch (Exception $e) {
            PrintResult(true, 'Division by zero');
        }
    }

    function test_Multiply() {
        AnnounceUnit("Multiplication");

        PrintResult($expected == $got, 'Any multiplication', $got, $expected)
    }

    AnnounceTestSuite("Mathematical Operations");
    test_Division();
    test_Multiply();
```

