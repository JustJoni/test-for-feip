<?php

namespace Tests;

use PHPUnit\Framework\TestCase;

require_once __DIR__ . "/../../src/types/DataType.php";
require_once __DIR__ . "/../../src/types/TFloat.php";

class TFloatTest extends TestCase
{
	public function testDisinfectData()
	{
		$tfloat = new \TestForFeip\TFloat(1.3,['STRING'=>'TString','FLOAT'=>'TFloat']);
		$disinfectData = $tfloat->disinfectData();
		$this->assertIsFloat($disinfectData);
        $this->assertEquals(1.3, $disinfectData);
	}
}
