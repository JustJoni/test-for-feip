<?php

namespace Tests;

use PHPUnit\Framework\TestCase;

require_once __DIR__ . "/../src/Cleaner.php";
require_once __DIR__ . "/../src/types/DataType.php";
require_once __DIR__ . "/../src/types/TString.php";
require_once __DIR__ . "/../src/types/TInt.php";

class CleanerTest extends TestCase
{
	public function testStartClean()
	{
		$cleaner = new \TestForFeip\Cleaner();
		$startClean = $cleaner->startClean('{"foo": 123, "bar": "Test string"}', ['TInt','TString']);
		$this->assertIsArray($startClean);
        $this->assertEquals(['foo'=>123,'bar'=>'Test string'], $startClean);
	}
}
