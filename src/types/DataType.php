<?php

namespace TestForFeip;

class DataType
{
	protected $data;
	public string $error = '';
	protected array $supportedTypes;

    public function __construct($data, array $supportedTypes)
    {
		$this->data = $data;
		$this->supportedTypes = $supportedTypes;
	}

}
