<?php

namespace Tests;

use PHPUnit\Framework\TestCase;

require_once __DIR__ . "/../../src/types/DataType.php";
require_once __DIR__ . "/../../src/types/TString.php";

class TStringTest extends TestCase
{
	public function testDisinfectData()
	{
		$tstring = new \TestForFeip\TString("Oh, my...",['STRING'=>'TString']);
		$disinfectData = $tstring->disinfectData();
		$this->assertIsString($disinfectData);
        $this->assertEquals("Oh, my...", $disinfectData);
	}
}
