<?php
namespace Common
{
    /**
     * Содержит функционал геттеров и сеттеров значений свойств класса TProperties.
     *
     * @package Common
     */
    trait TPropertiesAccessors
    {
        /**
         * Преобразует имя свойства из нотации, принятой в целевом классе, в нотацию UpperCamelCase.
         * Может быть переопределен в целевом классе. По умолчанию предполагается, что нотация,
         * принятая в классе - это lowerCamelCase, так что метод преобразует первую букву
         * имени свойства в заглавную.
         *
         * @param  string $name Имя свойства в нотации целевого класса.
         * @return string       Имя свойства в нотации UpperCamelCase.
         */
        protected static function convertPropertyNameToUpperCase(string $name)
        {
            return ucfirst($name);
        }



        /**
         * Коллекция имен геттеров целевого и его дочерних классов.
         *
         * @var array
         */
        private static $_propertyGetters = [];

        /**
         * Коллекция имен сеттеров целевого и его дочерних классов.
         *
         * @var array
         */
        private static $_propertySetters = [];

        /**
         * Инициализирует коллекции геттеров и сеттеров класса.
         *
         * @return void
         */
        private static function initClassAccessors()
        {
            $isInited = isset(self::$_propertyGetters[static::class]);
            if ($isInited) return;

            $patternGet = '/^get([A-Z][a-zA-Z0-9_]*)Property$/';
            $patternSet = '/^set([A-Z][a-zA-Z0-9_]*)Property$/';

            self::$_propertyGetters[static::class] = [];
            self::$_propertySetters[static::class] = [];

            foreach (get_class_methods(static::class) as $method)
            {
                $isGetter = false;
                $isSetter = false;

                $match = [];

                $isAccessor = 
                    ($isGetter = preg_match($patternGet, $method, $match)) ||
                    ($isSetter = preg_match($patternSet, $method, $match));

                if (!$isAccessor) continue;

                if ($isGetter)
                {
                    self::$_propertyGetters[static::class][$match[1]] = $method;
                }
                else
                {
                    self::$_propertySetters[static::class][$match[1]] = $method;
                }
            }
        }



        /**
         * Получает коллекцию имен геттеров класса.
         *
         * @return array Коллекция имен геттеров.
         */
        private static function getClassGetters()
        {
            self::initClassAccessors();

            return isset(self::$_propertyGetters[static::class])
                ? self::$_propertyGetters[static::class]
                : [];
        }

        /**
         * Получает имя геттера свойства с указанным именем.
         *
         * @param  string $name Имя свойства.
         * @return string       Имя геттера.
         */
        private static function getPropertyGetterName(string $name)
        {
            $name = static::convertPropertyNameToUpperCase($name);
            
            $getters = static::getClassGetters();
            return isset($getters[$name]) ? $getters[$name] : null;
        }

        /**
         * Получает геттер свойства с указанным именем
         *
         * @param  string   $name Имя свойства.
         * @return callable       Геттер.
         */
        private function getPropertyGetter(string $name)
        {
            $method = static::getPropertyGetterName($name);
            return $method ? [$this, $method] : null;
        }



        /**
         * Получает коллекцию имен сеттеров класса.
         *
         * @return array Коллекция имен сеттеров.
         */
        private static function getClassSetters()
        {
            self::initClassAccessors();

            return isset(self::$_propertySetters[static::class])
                ? self::$_propertySetters[static::class]
                : [];
        }

        /**
         * Получает имя сеттера свойства с указанным именем.
         *
         * @param  string $name Имя свойства.
         * @return string       Имя сеттера.
         */
        private static function getPropertySetterName(string $name)
        {
            $name = static::convertPropertyNameToUpperCase($name);

            $setters = self::getClassSetters();
            return isset($setters[$name]) ? $setters[$name] : null;
        }

        /**
         * Получает сеттер свойства с указанным именем.
         *
         * @param  string $name Имя свойства.
         * @return string       Сеттер.
         */
        private function getPropertySetter(string $name)
        {
            $method = static::getPropertySetterName($name);
            return $method ? [$this, $method] : null;
        }
    }
}