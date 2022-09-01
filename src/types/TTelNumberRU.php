<?php

namespace TestForFeip;

class TTelNumberRU extends DataType
{
	public function disinfectData():string|null
	{
		$sterileData = null;
		$dataOnlyNumbers = preg_replace('/[^\d]*/', '', $this->data);
		$regexp = '/^(7|8){1}[0-9]{10}$/';
		if (!preg_match($regexp,$dataOnlyNumbers)) {
			$this->error = "'".$this->data."' - не является российским номером телефона!";
		}
		else {
			if (substr($dataOnlyNumbers,0,1) == '8') {
				$dataOnlyNumbers = substr_replace($dataOnlyNumbers,'7',0,1);
			}
			$sterileData = $dataOnlyNumbers;
		}
		
		return $sterileData;
	}
}
