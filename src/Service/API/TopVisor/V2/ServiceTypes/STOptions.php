<?php

namespace App\Service\API\TopVisor\V2\ServiceTypes;

final class STOptions
{
    public const VIEW_OPTION_FLAT = 'flat';
    public const VIEW_OPTION_TREE = 'tree';
    public const RELATIVE_FOLDER_BEFORE = 'before';
    public const RELATIVE_FOLDER_AFTER = 'after';
    public const RELATIVE_FOLDER_IN = 'in';
    public const GROUP_INSERT_IN_FOLDER = 'in_folder';
    public const GROUP_INSERT_IN_FOLDER_LAST = 'in_folder_last';
    public const GROUP_INSERT_BEFORE_GROUP = 'before_group';
    public const GROUP_INSERT_AFTER_GROUP = 'after_group';

    /**
     * @throws \Exception
     */
    public function validateByWhitelist(
        $option,
        array $whitelist,
    ): void {
        if (!\in_array($option, $whitelist, true)) {
            $msg = sprintf(
                'Invalid option %s passed to constructor. Allowed options are: %s',
                $option,
                print_r($whitelist, true),
            );

            throw new \Exception($msg);
        }
    }

    /**
     * @TODO
     */
    public function genOptionsURL(array $options): string
    {

    }
}
