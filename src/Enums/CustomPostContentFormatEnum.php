<?php

declare(strict_types=1);

namespace PoP\CustomPosts\Enums;

use PoP\ComponentModel\Enums\AbstractEnum;

class CustomPostContentFormatEnum extends AbstractEnum
{
    public const NAME = 'CustomPostContentFormat';

    public const VALUE_CONTENT_HTML = 'html';
    public const VALUE_CONTENT_PLAIN_TEXT = 'plain_text';

    protected function getEnumName(): string
    {
        return self::NAME;
    }
    public function getValues(): array
    {
        return [
            self::VALUE_CONTENT_HTML,
            self::VALUE_CONTENT_PLAIN_TEXT,
        ];
    }
}
