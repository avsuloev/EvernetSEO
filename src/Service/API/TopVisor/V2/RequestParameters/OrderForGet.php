<?php

namespace App\Service\API\TopVisor\V2\RequestParameters;

/**
 * # Сортировка результата (__orders__).
 * Сортировка по умолчанию зависит от конкретного метода.
 *
 * ## Структура параметра __orders__.
 * __orders__ представляет собой массив, содержащий объекты сортируемых полей __fieldOrder__.
 * Объект сортируемого поля имеет следующие характеристики:
 * - fieldOrder.__name__ - имя поля.
 * - fieldOrder.__direction__ - направление сортировки (__ASC__ или __DESC__).
 *
 * ## __WARNING__:
 * Данный параметр предназначен только для операций чтения,
 * т.е. для работы с оператором __get__.
 *
 * В некоторых методах этот параметр может использоваться
 * в связке с оператором __edit__ для пересортировки объектов.
 *
 * ```json
 * {
 *  "orders": [{
 *      "name": Имя поля (строка),
 *      "direction": ASC || DESC,
 *  }]
 * }
 * ```
 *
 * @see https://topvisor.com/ru/api/v2/basic-params/orders Топвизор - Сортировка результата (orders).
 */
class OrderForGet
{
    /**
     * The __ASC__ is used to sort the data returned in ascending order.
     */
    public const ASC = 'ASC';
    /**
     * The __DESC__ is used to sort the data returned in descending order.
     */
    public const DESC = 'DESC';
}
