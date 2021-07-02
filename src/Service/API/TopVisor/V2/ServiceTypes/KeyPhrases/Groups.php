<?php

namespace App\Service\API\TopVisor\V2\ServiceTypes\KeyPhrases;

use App\Service\API\TopVisor\V2\ServiceTypes\STOptions;
use App\Service\API\TopVisor\V2\TvRoute;
use JetBrains\PhpStorm\ExpectedValues;

/**
 * # Ключевые фразы: группы.
 *
 * Группа обязательно должна быть привязана к одной папке.
 * Если папка не указана, группа будет добавляться в корневую папку проекта.
 *
 * @see https://topvisor.com/ru/api/v2-services/keywords_2/groups/ Ключевые фразы: группы.
 */
final class Groups
{
    public function __construct(
        private STOptions $optionsWizard,
    ) {
    }

    /**
     * Получает список групп.
     *
     * При запросе с show_trash = 1 будут возвращены и удаленные группы и не удаленные.
     *
     * @see https://topvisor.com/ru/api/v2-services/keywords_2/groups/get/
     */
    #[TvRoute('get/keywords_2/groups')]
    public function getGetGroupURL(
        bool $isRemovedShown = false,
    ): string {
        $trashBinOption = true === $isRemovedShown ? 1 : 0;

        return $this->optionsWizard->genOptionsURL([
            'show_trash' => $trashBinOption,
        ]);
    }

    /**
     * Добавляет группы в проект.
     *
     * @see https://topvisor.com/ru/api/v2-services/keywords_2/groups/add/
     */
    #[TvRoute('add/keywords_2/groups')]
    public function getAddGroupsURL(
        array $newNamesOption = ['Новая группа'],
        bool $isActive = true,
        #[ExpectedValues([
            STOptions::GROUP_INSERT_IN_FOLDER,
            STOptions::GROUP_INSERT_IN_FOLDER_LAST,
            STOptions::GROUP_INSERT_BEFORE_GROUP,
            STOptions::GROUP_INSERT_AFTER_GROUP,
        ])]
        string $relativeInsertOption = STOptions::GROUP_INSERT_IN_FOLDER,
        int $relativeId = 0,
    ): string {
        $activeOption = true === $isActive ? 1 : 0;
        $this->optionsWizard->validateByWhitelist(
            $relativeInsertOption,
            [
                STOptions::GROUP_INSERT_IN_FOLDER,
                STOptions::GROUP_INSERT_IN_FOLDER_LAST,
                STOptions::GROUP_INSERT_BEFORE_GROUP,
                STOptions::GROUP_INSERT_AFTER_GROUP,
            ]
        );

        return $this->optionsWizard->genOptionsURL([
            'name' => $newNamesOption,
            'on' => $activeOption,
            'to_type' => $relativeInsertOption,
            'to_id' => $relativeId,
        ]);
    }

    /**
     * Удаляет группы.
     *
     * @see https://topvisor.com/ru/api/v2-services/keywords_2/groups/del/
     */
    #[TvRoute('del/keywords_2/groups')]
    public function getDelGroupsURL(
        array $filters,
    ): string {
        return $this->optionsWizard->genOptionsURL([
            'filters' => $filters,
        ]);
    }

    /**
     * Включает/выключает группу.
     *
     * @see https://topvisor.com/ru/api/v2-services/keywords_2/groups/edit-on/
     */
    #[TvRoute('edit/keywords_2/groups/on')]
    public function getSetIsActiveGroupURL(
        bool $isActive,
        array $filters,
    ): string {
        $activeOption = true === $isActive ? 1 : 0;

        return $this->optionsWizard->genOptionsURL([
            'on' => $activeOption,
            'filters' => $filters,
        ]);
    }

    /**
     * Перемещает группы.
     *
     * @see https://topvisor.com/ru/api/v2-services/keywords_2/groups/edit-move/
     */
    #[TvRoute('edit/keywords_2/groups/move')]
    public function getMoveGroupsURL(
        array $filters,
        #[ExpectedValues([
            STOptions::GROUP_INSERT_IN_FOLDER,
            STOptions::GROUP_INSERT_IN_FOLDER_LAST,
            STOptions::GROUP_INSERT_BEFORE_GROUP,
            STOptions::GROUP_INSERT_AFTER_GROUP,
        ])]
        string $relativeInsertOption = STOptions::GROUP_INSERT_IN_FOLDER,
        int $relativeId = 0,
    ): string {
        $this->optionsWizard->validateByWhitelist(
            $relativeInsertOption,
            [
                STOptions::GROUP_INSERT_IN_FOLDER,
                STOptions::GROUP_INSERT_IN_FOLDER_LAST,
                STOptions::GROUP_INSERT_BEFORE_GROUP,
                STOptions::GROUP_INSERT_AFTER_GROUP,
            ]
        );

        return $this->optionsWizard->genOptionsURL([
            'to_type' => $relativeInsertOption,
            'to_id' => $relativeId,
            'filters' => $filters,
        ]);
    }

    /**
     * Изменяет сортировку групп внутри каждой папки по параметру сортировки.
     *
     * @see https://topvisor.com/ru/api/v2-services/keywords_2/groups/edit-sort/
     */
    #[TvRoute('edit/keywords_2/groups/sort')]
    public function getSortGroupsURL(
        array $orders,
        array $filters,
    ): string {
        return $this->optionsWizard->genOptionsURL([
            'orders' => $orders,
            'filters' => $filters,
        ]);
    }

    /**
     * Восстанавливает группы из временной корзины.
     * В результате восстановления будут восстановлены папки восстанавливаемых групп.
     *
     * @see https://topvisor.com/ru/api/v2-services/keywords_2/groups/edit-undel/
     */
    #[TvRoute('edit/keywords_2/groups/undel')]
    public function getRestoreGroupsURL(
        array $filters,
    ): string {
        return $this->optionsWizard->genOptionsURL([
            'filters' => $filters,
        ]);
    }

    /**
     * Указывает новое имя для группы (групп).
     *
     * @see https://topvisor.com/ru/api/v2-services/keywords_2/groups/edit-rename/
     */
    #[TvRoute('edit/keywords_2/groups/rename')]
    public function getRenameGroupsURL(
        string $newNameOption,
        array $filters,
    ): string {

        return $this->optionsWizard->genOptionsURL([
            'name' => $filters,
            'filters' => $newNameOption,
        ]);
    }
}
