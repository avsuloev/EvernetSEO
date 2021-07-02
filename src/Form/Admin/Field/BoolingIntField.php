<?php

namespace App\Form\Admin\Field;

use App\Form\BoolingIntType;
use EasyCorp\Bundle\EasyAdminBundle\Config\Option\TextAlign;
use EasyCorp\Bundle\EasyAdminBundle\Contracts\Field\FieldInterface;
use EasyCorp\Bundle\EasyAdminBundle\Field\FieldTrait;

final class BoolingIntField implements FieldInterface
{
    use FieldTrait;

    public const OPTION_RENDER_AS_SWITCH = 'renderAsSwitch';
    /** @internal */
    public const OPTION_TOGGLE_URL = 'toggleUrl';

    /**
     * @param string|false|null $label
     */
    public static function new(string $propertyName, $label = null): self
    {
        return (new self())
            ->setProperty($propertyName)
            ->setLabel($label)
            ->setTemplateName('crud/field/boolean')
            ->setFormType(BoolingIntType::class)
            ->addCssClass('field-boolean')
            ->setTextAlign(TextAlign::CENTER)
            ->setCustomOption(self::OPTION_RENDER_AS_SWITCH, true);
    }

    public function renderAsSwitch(bool $isASwitch = true): self
    {
        $this->setCustomOption(self::OPTION_RENDER_AS_SWITCH, $isASwitch);

        return $this;
    }
}
