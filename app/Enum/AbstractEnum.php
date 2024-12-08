<?php

namespace App\Enum;

trait AbstractEnum
{
    use EnumToArray;

    /**
     * 利用 enum value 返回相對應的 enum 解釋
     */
    abstract public static function matchTitle($value): string;

    public static function selectArray(): array
    {
        $type_select = [];

        collect(value: self::values())->each(function ($value) use (&$type_select) {
            $type_select[$value] = self::matchTitle($value);
        });

        return $type_select;
    }
}
