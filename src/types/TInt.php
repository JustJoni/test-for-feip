<?php

namespace TestForFeip;

class TInt extends DataType
{
	public function disinfectData():int|null
	{
		$sterileData = null;
		if (!is_int($this->data)) {
			$this->error = "'".$this->data."' - не является целым числом!";
		}
		else {
			$sterileData = $this->data;
		}
		
		return $sterileData;
	}

}
