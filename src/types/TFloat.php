<?php

namespace TestForFeip;

class TFloat extends DataType
{
	public function disinfectData():float|null
	{
		$sterileData = null;
		$val = floatval($this->data);
		if (!is_float($val)) {
			$this->error = "'".$this->data."' - не является числом с плавающей точкой!";
		}
		else {
			$sterileData = $this->data;
		}
		
		return $sterileData;
	}
}
