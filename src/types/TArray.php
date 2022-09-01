<?php

namespace TestForFeip;

class TArray extends DataType
{
	public function disinfectData(string $type):array|null
	{
		$this->checkType($type);
		$sterileData = array();
		$sterileData = $this->getSterileData($this->data, $type);
		if ($this->error != '') {
			$sterileData = null;
		}

		return $sterileData;
	}
	
	//нормализация данных в соответствии с указанным типом
	private function getSterileData(array $data, string $type):array
	{
		$sterileData = array();
		foreach($data as $value) {
			if (is_array($value)) {
				$sterileData[] = $this->getSterileData($value, $type);
			}
			else {
				$className = 'TestForFeip\\'.$type;
				$cleanerType = new $className($value,$this->supportedTypes);
				$sterileData[] = $cleanerType->disinfectData();
				$this->error .= $cleanerType->error;
			}
		}
		
		return $sterileData;
	}
	
	//проверяем правильность указания типа для массива
	private function checkType(string $type)
	{
		try {
			$className = 'TestForFeip\\'.$type;
			$class = new $className($type,$this->supportedTypes);
		}
		catch(\Throwable $e) {
			throw new \LogicException("'".$type."' - не является подходящим типом для данных внутри массива! ".$e->getMessage());
		}
	}
}
