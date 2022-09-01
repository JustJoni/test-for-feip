<?php

namespace TestForFeip;

class TStruct extends DataType
{
	public function disinfectData(string $keys):array|null
	{
		$sterileData = array();
		$this->checkKeys($keys);
		$sterileData = $this->getSterileData($this->data, $this->supportedTypes);
		if ($this->error != '') {
			$sterileData = null;
		}

		return $sterileData;
	}
	
	//нормализация данных
	private function getSterileData(array $data, array $supportedTypes):array
	{
		$sterileData = array();
		$thisClass = explode("\\",get_class());
		$thisType = $thisClass[1];
		foreach($data as $key=>$value) {
			$classError = false;
			$typesError = '';
			foreach($supportedTypes as $type) {
				if($type == $thisType) {
					continue;
				}
				if (is_array($value)) {
					$sterileData[] = $this->getSterileData($value, $supportedTypes);
				}
				else {
					$className = 'TestForFeip\\'.$type;
					try {
						$cleanerType = new $className($value,$supportedTypes);
						$sterileData[$key] = $cleanerType->disinfectData($type);
						$typesError = $cleanerType->error;
						$classError = false;
					}
					catch(\Throwable $e) {
						$classError = true;
					}
				}
				if ($typesError == '' && !$classError) {
					break;
				}
			}
			if ($classError) {
				$this->error .= "Полученное значение '".$value."' не является ни одним из разрешенных типов";
			}
			$this->error .= $typesError;
			
		}
		
		return $sterileData;
	}
	
	//проверка на соответствие ключей
	private function checkKeys(string $keys)
	{
		$data = array();
		$data = $this->data;
		$expKeys = explode(',',$keys);
		foreach($expKeys as $key) {
			if (isset($data[$key])) {
				unset($data[$key]);
			}
		}
		$errorValues = implode(', ',$data);
		if (!empty($data)) {
			$this->error = "Полученные значения ('".$errorValues."') не соответствуют переданным ключам!";
		}
	}
}
