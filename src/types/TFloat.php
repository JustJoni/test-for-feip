<?php

namespace TestForFeip;

class TFloat extends DataType
{
	public function disinfectData():float|null
	{
		$sterileData = null;
		if (!is_float($this->data)) {
			$this->error = "'".$this->data."' - не является числом с плавающей точкой!";
		}
		else {
			$sterileData = $this->data;
		}

		return $sterileData;
	}
}
