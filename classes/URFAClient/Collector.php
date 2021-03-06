<?php

/**
 * Сборщик информации для класса URFAClient_API
 *
 * @license https://github.com/k-shym/URFAClient/blob/master/LICENSE.md
 * @author  Konstantin Shum <k.shym@ya.ru>
 */
final class URFAClient_Collector extends URFAClient_Function {

    /**
     * @var URFAClient_API  $api
     */
    private $_api;

    /**
     * Конструктор сборщика
     *
     * @param   URFAClient_API  $api
     */
    public function __construct(URFAClient_API $api)
    {
        $this->_api = $api;
    }

    /**
     * Магический метод для сборки информации о вызваных методах API
     *
     * @param   string    $name   Имя метода
     * @param   array     $args   Аргументы
     * @return  bool
     */
    public function __call($name, array $args)
    {
        try
        {
            $ts = microtime(TRUE);
            $result = call_user_func_array(array($this->_api, $name), $args);
            $te = microtime(TRUE);
            URFAClient_Log::instance()->method($name, ($args) ? $args[0] : array(), $result, $te - $ts);
            return $result;
        } catch (Exception $e) {
            URFAClient_Log::instance()->method($name, ($args) ? $args[0] : array(), NULL, 0, $e->getMessage());
            return FALSE;
        }
    }
}