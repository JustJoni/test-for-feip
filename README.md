# Библиотека для валидации и нормализации данных поступающих из JSON
Test for FEIP

## Примеры использования
### 1. Проверяется соответствие данных типам integer, string, array (внутри должен иметь только элементы типа integer, и типу struct(ассоциативный массив) с ключами id,type:
$app = new TestForFeip\Cleaner;

$result = $app->startClean('{"foo": 123, "bar": 123, "baz": [
				5001, 123,5002,456,5003,789],
				"gaz":
				{ "id": "5004", "type": "Maple" }
			}', ['TInt','TString','TArray:TInt','TStruct:id,type']);

### 2. Проверяется соответствие данных типам float и tel_number_ru (сотовый номер телефона РФ):
$app = new TestForFeip\Cleaner;

$result = $app->startClean('{"foo": 1.3, "bar": 123}', ['TFloat','TTelNumberRU']);
