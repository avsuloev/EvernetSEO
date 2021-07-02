<?php

namespace App\Entity\Etxt;

/**
 * @see https://www.etxt.ru/api/#tasks.saveTask Добавление/редактирование заказа.
 */
abstract class EtxtTaskOptions
{
    /**
     * Aka 'public'.
     */
    public const SET_PUBLISHED_STATUS = [
        'unpublished' => 0,
        'published' => 1,
    ];
    /**
     * Aka 'price'.
     */
    public const SET_PRICING_MODE = [
        '1kChars' => 1,
        'total' => 2,
    ];
    /**
     *  Aka 'multione'.
     *  Etxt default = 0.
     */
    public const SET_MULTITASK_WORK_MODE = [
        'unbound' => 0,
        'oneToOne' => 1,
    ];
    /**
     *  Aka 'locate'.
     *  Etxt default = 0.
     */
    public const REQUIRE_PLACING_ON_SITE = [
        'no' => 0,
        'yes' => 1,
    ];
    /**
     * Aka 'whitespaces'.
     */
    public const COUNT_WHITESPACES = [
        'no' => 0,
        'yes' => 1,
    ];
    /**
     * Aka 'only_stars'.
     */
    public const REQUIRE_SKILL_CHECK = [
        'no' => 0,
        'yes' => 1,
    ];
    /**
     * Aka 'checksize'.
     */
    public const REQUIRE_90_PERCENT_COMPLETION = [
        'no' => 0,
        'yes' => 1,
    ];
    /**
     * Aka 'id_type'.
     */
    public const TASK_TYPE_ID = [
        'copywriting ' => 1,
    ];
    /**
     * Aka 'id_subtype'.
     * Etxt default = 0.
     */
    public const TASK_SUBTYPE_ID = [
        'unspecified' => 0,
        // default
        'selling' => 1,
        // продающий текст
        'infoArticle' => 2,
        // информационная статья
        'newsOrPressRelease' => 3,
        // новость/пресс-релиз
        'mailing' => 4,
        // текст для email-рассылки
        'socialNetwork' => 5,
        // текст для соцсетей
        'review' => 6,
        // отзыв
    ];
    /**
     * Aka 'auto_work'.
     */
    public const AUTOACCEPT_DEAL = [
        'no' => 0,
        'yes' => 1,
    ];
    /**
     *  Aka 'multitask'.
     */
    public const SET_MULTITASK = [
        'no' => 0,
        'yes' => 1,
    ];
    /**
     *  Aka 'target_task'.
     */
    public const SET_WHITELIST_MODE = [
        'everyone' => 1,
        'whitelist' => 2,
        'individual' => 3,
    ];
    /**
     *  Aka 'bwgroup_send'.
     */
    public const REQUIRE_NOTIFICATION_FOR_AUTHORS = [
        'no' => 0,
        'yes' => 1,
    ];
    /**
     *  Aka 'attestat'.
     */
    public const REQUIRE_CERTIFIED_ONLY = [
        'no' => 0,
        'yes' => 1,
    ];
    /**
     *  Aka 'diplom'.
     */
    public const REQUIRE_GRADUATED_ONLY = [
        'no' => 0,
        'yes' => 1,
    ];
}
