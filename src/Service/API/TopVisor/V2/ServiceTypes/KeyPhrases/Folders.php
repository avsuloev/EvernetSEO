<?php

namespace App\Service\API\TopVisor\V2\ServiceTypes\KeyPhrases;

use App\Service\API\TopVisor\V2\ServiceTypes\STOptions;
use App\Service\API\TopVisor\V2\TvRoute;
use JetBrains\PhpStorm\ExpectedValues;

/**
 * # Ключевые фразы: папки.
 *
 * - В каждом проекте есть корневая папка, которую невозможно удалить.
 * - В папках хранятся группы ключевых фраз и другие папки.
 * - Максимальная глубина вложенности папок составляет 3 уровня.
 *
 * @see https://topvisor.com/ru/api/v2-services/keywords_2/folders/ Ключевые фразы: папки.
 */
final class Folders
{
    public function __construct(
        private STOptions $optionsWizard,
    ) {
    }

    /**
     * Получает список папок.
     *
     * При запросе с __show_trash__ = 1 будут возвращены и удаленные папки и не удаленные.
     *
     * @see https://topvisor.com/ru/api/v2-services/keywords_2/folders/get/
     */
    #[TvRoute('get/keywords_2/folders')]
    public function getGetFoldersURL(
        bool $isRemovedShown = false,
        #[ExpectedValues([
            STOptions::VIEW_OPTION_FLAT,
            STOptions::VIEW_OPTION_TREE,
        ])]
        string $setViewOption = STOptions::VIEW_OPTION_FLAT,
    ): string {
        $trashBinOption = true === $isRemovedShown ? 1 : 0;
        $this->optionsWizard->validateByWhitelist(
            $setViewOption,
            [
                STOptions::VIEW_OPTION_TREE,
                STOptions::VIEW_OPTION_FLAT,
            ]
        );

        return $this->optionsWizard->genOptionsURL([
            'show_trash' => $trashBinOption,
            'view' => $setViewOption,
        ]);
    }

    /**
     * Добавляет папку в проект.
     *
     * @see https://topvisor.com/ru/api/v2-services/keywords_2/folders/add/
     */
    #[TvRoute('add/keywords_2/folders')]
    public function getAddFolderURL(
        string $newNameOption = 'Новая папка',
        #[ExpectedValues([
            STOptions::RELATIVE_FOLDER_BEFORE,
            STOptions::RELATIVE_FOLDER_AFTER,
            STOptions::RELATIVE_FOLDER_IN,
        ])]
        string $relativePositionOption = STOptions::RELATIVE_FOLDER_IN,
        int $relativeFolderId = 0,
    ): string {
        $this->optionsWizard->validateByWhitelist(
            $relativePositionOption,
            [
                STOptions::RELATIVE_FOLDER_BEFORE,
                STOptions::RELATIVE_FOLDER_AFTER,
                STOptions::RELATIVE_FOLDER_IN,
            ]
        );

        return $this->optionsWizard->genOptionsURL([
            'name' => $newNameOption,
            'to_type' => $relativePositionOption,
            'to_id' => $relativeFolderId,
        ]);
    }

    /**
     * Удаляет папки.
     *
     * @see https://topvisor.com/ru/api/v2-services/keywords_2/folders/del/
     */
    #[TvRoute('del/keywords_2/folders')]
    public function getDelFolderURL(
        array $filters,
    ): string {

        return $this->optionsWizard->genOptionsURL([
            'filters' => $filters,
        ]);
    }

    /**
     * Перемещает папку.
     *
     * Папки представляют древовидную структуру,
     *
     * @see https://topvisor.com/ru/api/v2-services/keywords_2/folders/edit-move/
     */
    #[TvRoute('edit/keywords_2/folders/move')]
    public function getEditFolderMoveURL(
        int $folderId,
        #[ExpectedValues([
            STOptions::RELATIVE_FOLDER_BEFORE,
            STOptions::RELATIVE_FOLDER_AFTER,
            STOptions::RELATIVE_FOLDER_IN,
        ])]
        string $relativePositionOption = STOptions::RELATIVE_FOLDER_IN,
        int $relativeFolderId = 0,
    ): string {
        $this->optionsWizard->validateByWhitelist(
            $relativePositionOption,
            [
                STOptions::RELATIVE_FOLDER_BEFORE,
                STOptions::RELATIVE_FOLDER_AFTER,
                STOptions::RELATIVE_FOLDER_IN,
            ]
        );

        return $this->optionsWizard->genOptionsURL([
            'id' => $folderId,
            'to_type' => $relativePositionOption,
            'to_id' => $relativeFolderId,
        ]);
    }

    /**
     * Восстанавливает папки из временной корзины.
     *
     * В результате восстановления находящиеся
     * в этих папках группы восстановлены не будут.
     *
     * @see https://topvisor.com/ru/api/v2-services/keywords_2/folders/edit-undel/
     */
    #[TvRoute('edit/keywords_2/folders/undel')]
    public function getEditRestoreFoldersURL(
        array $filters,
    ): string {

        return $this->optionsWizard->genOptionsURL([
            'filters' => $filters,
        ]);
    }

    /**
     * Указывает новое имя для папки (папок).
     *
     * @see https://topvisor.com/ru/api/v2-services/keywords_2/folders/edit-rename/
     */
    #[TvRoute('edit/keywords_2/folders/rename')]
    public function getEditRenameFoldersURL(
        string $newNameOption,
        array $filters,
    ): string {

        return $this->optionsWizard->genOptionsURL([
            'name' => $filters,
            'filters' => $newNameOption,
        ]);
    }
}
