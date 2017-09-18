<?php
namespace Common
{
    /**
     * Содержит методы реализации магических методов __get, __set, __isset и __unset 
     * класса TProperties.
     *
     * @package Common
     */
    trait TPropertiesMemberAccess
    {
        /**
         * Преобразует имя свойства из lowerCamelCase в нотацию, принятую в целевом классе.
         * Может быть переопределен в целевом классе. По умолчанию предполагается, что
         * нотация, принятая в целевом классе - это lowerCamelCase, так что метод
         * возвращает имя свойства без изменений.
         *
         * @param  string $name Имя свойства в lowerCamelCase.
         * @return string       Имя свойства в нужной нотации.
         */
        protected static function convertPropertyNameFromLowerCase(string $name)
        {
            return $name;
        }

        /**
         * Получает значение свойства по его имени.
         *
         * @param  string $name Имя свойства в lowerCamelCase.
         * @return mixed        Значение свойства.
         */
        public function __get(string $name)
        {
            $name = static::convertPropertyNameFromLowerCase($name);
            return $this->getProperty($name);
        }

        /**
         * Задает значение свойства по его имени.
         *
         * @param string $name  Имя свойства в lowerCamelCase.
         * @param mixed  $value Значение свойства.
         */
        public function __set(string $name, $value)
        {
            $name = static::convertPropertyNameFromLowerCase($name);
            $this->setProperty($name, $value);
        }

        /**
         * Показывает, существует ли свойство по его имени.
         *
         * @param  string $name Имя свойства в lowerCamelCase.
         * @return bool         Существует или нет.
         */
        public function __isset(string $name)
        {
            $name = static::convertPropertyNameFromLowerCase($name);
            return $this->hasProperty($name);
        }

        /**
         * Удаляет свойство по его имени.
         *
         * @param string $name Имя свойства в lowerCamelCase.
         */
        public function __unset(string $name)
        {
            $name = static::convertPropertyNameFromLowerCase($name);
            $this->unsetProperty($name);
        }
    }
}