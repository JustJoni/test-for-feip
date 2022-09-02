<?php

namespace Tests;

use PHPUnit\Framework\TestCase;

require_once __DIR__ . "/../../src/types/DataType.php";
require_once __DIR__ . "/../../src/types/TInt.php";

class TIntTest extends TestCase
{
	public function testDisinfectData()
	{
		$tint = new \TestForFeip\TInt(6,['INTEGER'=>'TInt']);
		$disinfectData = $tint->disinfectData();
		$this->assertIsInt($disinfectData);
        $this->assertEquals(6, $disinfectData);
	}
}
