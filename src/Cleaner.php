<?php

namespace TestForFeip;

class Cleaner
{
    //набор настроек
    private array $env;
	
	private array $supportedTypes;
	//ошибки форматов при очистке переданных данных
	public array $errors = [];

    //файл настроек
    private string $envFile = '/.env';
	
    public function __construct()
    {
		$this->envFile = dirname(__DIR__).$this->envFile;
        if (is_readable($this->envFile)) {
            $lines = file($this->envFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

            foreach ($lines as $line) {
                [$name, $value] = explode('=', $line);
                $this->supportedTypes[$name] = $value;
            }
        } else {
			throw new \Exception("Не найден файл с настройками БД! Проверьте наличие файла по адресу ".$this->envFile."\n");
        }

		
		$this->checkSupportedTypes();
    }
	
	//проверяем настройки и проверяем какие классы есть в папке Types
	//если в настройках типов меньше, чем классов - всё ок
	//если в настройках типов больше, чем классов - выбрасываем исключение
	private function checkSupportedTypes()
	{
		$typeClasses = scandir(__DIR__.'/Types');
		foreach ($typeClasses as $key=>$class) {
			if (!preg_match('/^.+\.(php)!*$/', $class)) {
				unset($typeClasses[$key]);
				
				continue;
			}
			$typeClasses[$key] = substr($class,0,-4);
		}
		$diffTypes = array_diff($this->supportedTypes, $typeClasses);
		if (count($diffTypes) > 0) {
			throw new \DomainException ("Не найдено соответствие типу '".array_shift($diffTypes)."', указанному в настройках");
		}
	}
	
	//главная точка входа
	public function startClean(string $json, array $types):array
	{
		$cleanedData = array(); //итоговые данные, которые отдаёт библиотека пользователю
		$dirtyData = json_decode($json,true,3);
		if (json_last_error() !== 0) {
			throw new \InvalidArgumentException('На входе ожидалась JSON-строка!');
		}
		$classes = $this->getClassesFromUserData($types);
		$this->checkReceivedTypes($classes,$dirtyData);
		foreach ($classes as $key=>$class) {
			$className = 'TestForFeip\\'.$class;
			$cleanerType = new $className(current($dirtyData),$this->supportedTypes);
			$dirtyDataKey = key($dirtyData);
			$cleanedData[$dirtyDataKey] = $cleanerType->disinfectData($key);
			$error = $cleanerType->error;
			if (!$error == '') {
				$this->errors[$dirtyDataKey] = $error;
			}
			next($dirtyData);
		}
		
		if (!empty($this->errors)) {
			throw new \LogicException("Обнаружены ошибки форматов! Весь список ошибок можно найти в свойстве errors");
		}
		
		return $cleanedData;
	}
	
	//убираем указанные внутренние типы (для массива)/внутренние ключи (для структуры) в ключи типов
	private function getClassesFromUserData(array $types):array
	{
		$classes = array();
		foreach ($types as $type) {
			$exp = explode(':',$type);
			if (count($exp) > 1) {
				$classes[$exp[1]] = $exp[0];
			}
			else {
				$classes[] = $exp[0];
			}
		}
		
		return $classes;
	}
	
	//проверяем полученные от пользователя типы и сравниваем с имеющимися в $this->supportedTypes
	//если среди переданных типов есть хотя бы 1 не корректный - выбрасываем исключение
	private function checkReceivedTypes(array $types, array $dirtyData)
	{
		$diffTypes = array_diff($types, $this->supportedTypes);
		if (count($diffTypes) > 0) {
			throw new \UnderflowException ("Указанный тип: '".array_shift($diffTypes)."' не найден в настройках библиотеки");
		}
		if (count($dirtyData) != count($types)) {
			throw new \DomainException ("Кол-во типов не соответствует кол-ву переменных в строке JSON");
		}
	}
}
