<?php
namespace Common
{
    /**
     * Содержит методы реализации магических методов интерфейса ArrayAccess 
     * класса TProperties.
     *
     * @package Common
     */
    trait TPropertiesArrayAccess
    {
        /**
         * Получает значение свойства по его имени.
         *
         * @param  string $name Имя свойства.
         * @return mixed        Значение свойства.
         */
        public function offsetGet($name)
        {
            return $this->getProperty($name);
        }

        /**
         * Задает значение свойства по его имени.
         *
         * @param string $name  Имя свойства.
         * @param mixed  $value Значение свойства.
         */
        public function offsetSet($name, $value)
        {
            $this->setProperty($name, $value);
        }

        /**
         * Показывает, существует ли свойство по его имени.
         *
         * @param  string $name Имя свойства.
         * @return bool         Существует или нет.
         */
        public function offsetExists($name)
        {
            return $this->hasProperty($name);
        }

        /**
         * Удаляет свойство по его имени.
         *
         * @param string $name Имя свойства.
         */
        public function offsetUnset($name)
        {
            $this->unsetProperty($name);
        }
    }
}