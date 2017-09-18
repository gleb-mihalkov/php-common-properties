<?php
namespace Common
{
    /**
     * Интерфейс класса, реализующего механизм свойств.
     *
     * @package Common
     */
    interface IProperties
    {
        /**
         * Получает значение свойства по его имени.
         *
         * @param  string $name Имя свойства.
         * @return mixed        Значение свойства.
         */
        public function getProperty(string $name);

        /**
         * Задает значение свойства по его имени.
         *
         * @param string $name  Имя свойства.
         * @param mixed  $value Значение свойства.
         */
        public function setProperty(string $name, $value);

        /**
         * Показывает, существует ли свойство с указаным именем.
         *
         * @param  string $name Имя свойства.
         * @return bool         Существует или нет.
         */
        public function hasProperty(string $name);

        /**
         * Удаляет свойство по его имени.
         *
         * @param  string $name Имя свойства.
         * @return void
         */
        public function unsetProperty(string $name);
    }
}