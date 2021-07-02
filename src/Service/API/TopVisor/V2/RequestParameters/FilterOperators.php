<?php

namespace App\Service\API\TopVisor\V2\RequestParameters;

/**
 * # Фильтры (__filters__ и __id__).
 * Фильтры используются для получения, редактирования или удаления определенных объектов.
 * id используется для получения, редактирования или удаления конкретного объекта.
 *
 * ## Структура параметра __filters__.
 * __filters__ представляет собой массив, содержащий объекты фильтров __fieldFilter__.
 * Фильтр имеет следующие характеристики:
 * - fieldFilter.__name__ - имя поля.
 * - fieldFilter.__operator__ - оператор сравнения.
 * - fieldFilter.__values__ - массив (всегда, в том числе для операторов сравнения с одним значением) со значениями фильтра.
 *
 * ```json
 * {
 *  "filters": [{
 *      "name": Имя поля (строка),
 *      "operator": Оператор сравнения (строка),
 *      "values": Значения фильтра,
 *  }, ... ]
 * }
 * ```
 * @see https://topvisor.com/ru/api/v2/basic-params/filters Топвизор - Фильтры (filters и id).
 */
final class FilterOperators
{
    /**
     * Function '='.
     * Равно указанному значению.
     */
    public const EQUALS = 'EQUALS';
    /**
     * Function '!='.
     * Не равно указанному значению.
     */
    public const NOT_EQUALS = 'NOT_EQUALS';
    /**
     * Function 'IN()'.
     * Есть в указанных значениях.
     */
    public const IN = 'IN';
    /**
     * Function 'NOT IN()'.
     * Нет в указанных значениях.
     */
    public const NOT_IN = 'NOT_IN';
    /**
     * Function '>'.
     * Больше, чем указанное значение.
     */
    public const GREATER_THAN = 'GREATER_THAN';
    /**
     * Function '>='.
     * Больше или равно указанному значению.
     */
    public const GREATER_THAN_EQUALS = 'GREATER_THAN_EQUALS';
    /**
     * Function '<'.
     * Меньше, чем указанное значение.
     */
    public const LESS_THAN = 'LESS_THAN';
    /**
     * Function '<='.
     * Меньше или равно указанному значению.
     */
    public const LESS_THAN_EQUALS = 'LESS_THAN_EQUALS';
    /**
     * Function 'BETWEEN'.
     * В промежутке между значениями 1 и 2.
     * Последовательно можно перечислять несколько промежутков:
     * ```php
     * values = [10,20,50,100]; // 10..20 или 50..100.
     * ```
     */
    public const BETWEEN = 'BETWEEN';
    /**
     * Function "LIKE '%_'".
     * Начинается с указанного значения.
     */
    public const STARTS_WITH = 'STARTS_WITH';
    /**
     * Function "LIKE '%_%'".
     * Содержит подстроку с указанным значением.
     */
    public const CONTAINS = 'CONTAINS';
    /**
     * Function "NOT LIKE '%_%'".
     * Не содержит подстроку с указанным значением.
     */
    public const DOES_NOT_CONTAIN = 'DOES_NOT_CONTAIN';
    /**
     * Function 'REGEXP()'.
     * Удовлетворяет указанному регулярному выражению.
     */
    public const REGEXP = 'REGEXP';
    /**
     * Function 'NOT REGEXP()'.
     * Не удовлетворяет указанному регулярному выражению.
     */
    public const NOT_REGEXP = 'NOT_REGEXP';
    /**
     * Function 'IS NULL'.
     * Поле установлено в NULL.
     */
    public const IS_NULL = 'IS_NULL';
    /**
     * Function 'IS NOT NULL'.
     * Поле не установлено в NULL.
     */
    public const IS_NOT_NULL = 'IS_NOT_NULL';
}
