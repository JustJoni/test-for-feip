<?php

namespace Tests;

use PHPUnit\Framework\TestCase;

require_once __DIR__ . "/../../src/types/DataType.php";
require_once __DIR__ . "/../../src/types/TArray.php";
require_once __DIR__ . "/../../src/types/TInt.php";

class TArrayTest extends TestCase
{
	public function testDisinfectData()
	{
		$tarray = new \TestForFeip\TArray(['foo'=>123,'bar'=>456],['STRING'=>'TString','INTEGER'=>'TInt']);
		$disinfectData = $tarray->disinfectData('TInt');
		$this->assertIsArray($disinfectData);
        $this->assertEquals([123,456], $disinfectData);
	}
}
