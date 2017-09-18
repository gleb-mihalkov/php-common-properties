# Типаж "Свойства"

Типаж, реализующий механизм свойств класса. Библиотека является частью пакета [php-common](https://github.com/gleb-mihalkov/php-common/).

* [Документация](https://gleb-mihalkov.github.io/php-common-properties/)

## Использование

Для включения механизма геттеров и сеттеров нужно сделать следующее:

```php
require 'vendor/autoload.php';
use Common\IProperties;
use Common\TProperties;

class MyClass implements IProperties
{
    use TProperties;

    protected $_foo = 'bar';
 
    // Объявляем метод получения значения свойства с именем "foo".
    protected function getFooProperty()
    {
        return $this->_foo;
    }
 
    // Объявляем метод установки значения свойства с именем "foo".
    protected function setFooProperty($value)
    {
        $this->_foo = $value;
    }
}

$a = new MyClass();
echo $a->foo;        // Выведет: bar

$a->foo = 'foo';
echo $a->foo;        // Выведет: foo

echo isset($a->foo); // Выведет: TRUE

unset($a->foo);
echo $a->foo;        // Выведет: NULL
```

Также `TProperties` поддерживает доступ к объектку как к ассоциативному массиву и специальные методы для работы со свойствами:

```php
require 'vendor/autoload.php';
use Common\IProperties;
use Common\TProperties;

class MyClass implements IProperties, ArrayAccess
{
    use TProperties;

    protected $_foo = 'bar';
 
    protected function getFooProperty()
    {
        return $this->_foo;
    }
 
    protected function setFooProperty($value)
    {
        $this->_foo = $value;
    }
}

$a = new MyClass();
echo $a->foo;
echo $a['foo'];
echo $a->getProperty('foo');
// Во всех трех случаях выведет "bar".
```

Далее. Типаж `TProperties` поддерживает работу со свойствами, у которых не объявлен геттер и сеттер. По применению это напоминает магические методы `__get`, `__set`, `__isset` и `__unset`. Пример:

```php
require 'vendor/autoload.php';
use Common\IProperties;
use Common\TProperties;

class MyClass implements IProperties, ArrayAccess
{
    use TProperties;

    protected $_unknown = 'bar';

    protected function _getProperty(string $name)
    {
        return $this->_unknown;
    }
 
    protected function _setProperty(string $name, $value)
    {
        $this->_unknown = $value;
    }

    protected function _hasProperty(string $name)
    {
        return true;
    }

    protected function _unsetProperty(string $name)
    {
        $this->_unknown = null;
    }
}

$a = new MyClass();
echo $a->foo;
echo $a->bar;
echo $a->unnamed;
echo $a->random;
// Во всех случаях выведет "bar".
```

В библиотеке уже есть типаж, который поддерживат работу с необъявленными свойствами - `IAssocProperties`. Этот типаж хранит значения необъявленных свойств в защищенном ассоциативном массиве `$properties`:

```php
require 'vendor/autoload.php';
use Common\IProperties;
use Common\TAssocProperties;

class MyClass implements IProperties, ArrayAccess
{
    use TAssocProperties;

    public function debug()
    {
        var_dump($this->properties);
    }
}

$a = new MyClass();
$a->foo = 'bar';
$a->bar = 'foo';
$a->debug();

// Выведет:

// array(2) {
//   'foo' => 'bar',
//   'bar' => 'foo'
// }
```

Далее. В типаже предполагается, что имена свойств записаны в нотации lowerCamelCase. Вы можете переопределить это поведение. Например, в CMS Битрикс имена свойств традиционно записываются в UPPER_UNDERSCORE_CASE. Следующий класс будет работать с такими именами:

```php
require 'vendor/autoload.php';
use Common\IProperties;
use Common\TAssocProperties;

class MyClass implements IProperties, ArrayAccess
{
    use TAssocProperties;

    protected static function convertPropertyNameFromLowerCase(string $name)
    {
        $name = preg_replace('/[A-Z]/', '_\\0', $name);
        return strtoupper($name);
    }

    protected static function convertPropertyNameToUpperCase(string $name)
    {
        $name = strtolower($name);
        $func = function($matches) { return strtoupper($matches[1]); };
        $name = preg_replace_callback('/_([a-z])/', $func, $name);
        return ucfirst($name);
    }

    protected $_foo = 'Bar';

    protected function getFooProperty()
    {
        return $this->_foo;
    }
}

$bitrix = [
    'ID' => 1,
    'NAME' => 'Name',
    'CODE' => 'Code',
    'PREVIEW_TEXT' => 'Some text.'
];

$a = new MyClass($bitrix);

echo $a->id;    // Выведет: 1
echo $a['FOO']; // Выведет: Bar
```