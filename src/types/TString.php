<?php

namespace TestForFeip;

class TString extends DataType
{	
	public function disinfectData():string|null
	{
		$sterileData = null;
		$val = strval($this->data);
		if (!is_string($val)) {
			$this->error = "'".$this->data."' - не является строкой!";
		}
		else {
			$sterileData = $this->data;
		}
		
		return $sterileData;
	}
}
