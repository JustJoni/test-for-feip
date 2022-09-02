<?php

namespace Tests;

use PHPUnit\Framework\TestCase;

require_once __DIR__ . "/../../src/types/DataType.php";
require_once __DIR__ . "/../../src/types/TStruct.php";
require_once __DIR__ . "/../../src/types/TString.php";
require_once __DIR__ . "/../../src/types/TInt.php";

class TStructTest extends TestCase
{
	public function testDisinfectData()
	{
		$tstruct = new \TestForFeip\TStruct(['foo'=>123,'bar'=>"456"],['STRING'=>'TString','INTEGER'=>'TInt','STRUCTURE'=>'TStruct']);
		$disinfectData = $tstruct->disinfectData("foo,bar");
		$this->assertIsArray($disinfectData);
        $this->assertEquals(['foo'=>123,'bar'=>"456"], $disinfectData);
		$this->assertArrayHasKey("foo",$disinfectData);
		$this->assertArrayHasKey("bar",$disinfectData);
	}
}
