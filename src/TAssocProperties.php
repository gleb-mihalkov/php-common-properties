<?php
namespace Common
{
    /**
     * Типаж, добавляющий классу механизм свойств. Свойства с необъявленными геттерами и сеттерами
     * хранятся в ассоциативном массиве.
     *
     * @package Common
     */
    trait TAssocProperties
    {
        use TProperties;

        /**
         * Коллекция свойств с необъявленными геттерами и сеттерами.
         *
         * @var array
         */
        protected $proprties = [];

        /**
         * Создает экземлпяр класса с предустановленными значениями свойств.
         *
         * @param array $assoc Ассоциативный массив.
         */
        public function __construct(array $assoc = [])
        {
            $this->proprties = $assoc;
        }

        /**
         * Получает значение свойства, для которого не объявлен геттер.
         *
         * @param  string $name Имя свойства.
         * @return mixed        Значение свойства.
         */
        protected function _getProperty(string $name)
        {
            return isset($this->proprties[$name])
                ? $this->proprties[$name]
                : null;
        }

        /**
         * Задает значение свойства, для которого не объявлен сеттер.
         *
         * @param string $name  Имя свойства.
         * @param mixed  $value Значение свойства.
         */
        protected function _setProperty(string $name, $value)
        {
            $this->proprties[$name] = $value;
        }

        /**
         * Показывает, существует ли свойство, для которого не объявлен геттер.
         *
         * @param  string $name Имя свойства.
         * @return bool         Существует или нет.
         */
        protected function _hasProperty(string $name)
        {
            return isset($this->proprties[$name]);
        }

        /**
         * Удаляет свойство, для которого не объявлен сеттер.
         *
         * @param  string $name Имя свойства.
         * @return void
         */
        protected function _unsetProperty(string $name)
        {
            unset($this->proprties[$name]);
        }
    }
}