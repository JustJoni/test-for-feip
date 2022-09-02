<?php

namespace Tests;

use PHPUnit\Framework\TestCase;

require_once __DIR__ . "/../../src/types/DataType.php";
require_once __DIR__ . "/../../src/types/TTelNumberRU.php";

class TTelNumberRUTest extends TestCase
{
	public function testDisinfectData()
	{
		$ttelnumberru = new \TestForFeip\TTelNumberRU("8 (900) 1-23-456-7",['TEL_NUMBER_RU'=>'TTelNumberRU']);
		$disinfectData = $ttelnumberru->disinfectData();
		$this->assertIsString($disinfectData);
        $this->assertEquals("79001234567", $disinfectData);
	}
}
