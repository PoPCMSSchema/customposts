<?php

declare(strict_types=1);

namespace PoP\CustomPosts\Enums;

use PoP\ComponentModel\Enums\AbstractEnum;

class CustomPostContentFormatEnum extends AbstractEnum
{
    public const NAME = 'CustomPostContentFormat';

    public const HTML = 'html';
    public const PLAIN_TEXT = 'plain_text';

    protected function getEnumName(): string
    {
        return self::NAME;
    }
    public function getValues(): array
    {
        return [
            self::HTML,
            self::PLAIN_TEXT,
        ];
    }
}
