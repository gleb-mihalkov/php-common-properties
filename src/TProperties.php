<?php
namespace Common
{
    /**
     * Типаж, добавляющий классу реализацию механизма свойств.
     *
     * @package Common
     */
    trait TProperties
    {
        use TPropertiesMemberAccess;
        use TPropertiesArrayAccess;
        use TPropertiesAccessors;

        /**
         * Получает значение свойства, для которого не объявлен геттер. Виртуальный метод.
         *
         * @param  string $name Имя свойства.
         * @return mixed        Значение свойства.
         */
        protected function _getProperty(string $name) {}

        /**
         * Задает значение свойства, для которого не объявлен сеттер. Виртуальный метод.
         *
         * @param string $name  Имя свойства.
         * @param mixed  $value Значение свойства.
         */
        protected function _setProperty(string $name, $value) {}

        /**
         * Показывает, существует ли свойство, для которого не объявлен геттер. Виртуальный метод.
         *
         * @param  string $name Имя свойства.
         * @return bool         Существует или нет.
         */
        protected function _hasProperty(string $name) {}

        /**
         * Удаляет значение свойства, для которого не объявлен сеттер. Виртуальный метод.
         *
         * @param  string $name Имя свойства.
         * @return void
         */
        protected function _unsetProperty(string $name) {}



        /**
         * Получает значение свойства по его имени.
         *
         * @param  string $name Имя свойства.
         * @return mixed        Значение свойства.
         */
        public function getProperty(string $name)
        {
            $getter = static::getPropertyGetter($name);
            return $getter ? call_user_func($getter) : $this->_getProperty($name);
        }

        /**
         * Задает значение свойства по его имени.
         *
         * @param string $name  Имя свойства.
         * @param mixed  $value Значение свойства.
         */
        public function setProperty(string $name, $value)
        {
            if ($setter = static::getPropertySetter($name))
            {
                call_user_func($setter, $value);
                return;
            }

            $this->_setProperty($name, $value);
        }

        /**
         * Показывает, существует ли свойство с указаным именем.
         *
         * @param  string $name Имя свойства.
         * @return bool         Существует или нет.
         */
        public function hasProperty(string $name)
        {
            return static::getPropertyGetter($name) || $this->_hasProperty($name);
        }

        /**
         * Удаляет свойство по его имени.
         *
         * @param  string $name Имя свойства.
         * @return void
         */
        public function unsetProperty(string $name)
        {
            if ($setter = static::getPropertySetter($name))
            {
                call_user_func($setter, null);
                return;
            }

            $this->_unsetProperty($name);
        }
    }
}