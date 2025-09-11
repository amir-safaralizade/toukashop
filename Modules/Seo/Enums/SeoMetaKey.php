<?php

namespace Modules\Seo\Enums;

enum SeoMetaKey: string
{
    case META_TITLE = 'meta_title';
    case META_DESCRIPTION = 'meta_description';
    case META_KEYWORDS = 'meta_keywords';
    case CANONICAL = 'canonical';
    case ROBOTS = 'robots';
    case OG_TITLE = 'og_title';
    case OG_DESCRIPTION = 'og_description';
    case OG_IMAGE = 'og_image';
    case TWITTER_TITLE = 'twitter_title';
    case TWITTER_DESCRIPTION = 'twitter_description';
    case TWITTER_IMAGE = 'twitter_image';
    case CUSTOM_SCHEMA = 'custom_schema'; // ✅ جدید

    public function label(): string
    {
        return match ($this) {
            self::META_TITLE => 'Meta Title',
            self::META_DESCRIPTION => 'Meta Description',
            self::META_KEYWORDS => 'Meta Keywords',
            self::CANONICAL => 'Canonical URL',
            self::ROBOTS => 'Robots',
            self::OG_TITLE => 'OG Title',
            self::OG_DESCRIPTION => 'OG Description',
            self::OG_IMAGE => 'OG Image',
            self::TWITTER_TITLE => 'Twitter Title',
            self::TWITTER_DESCRIPTION => 'Twitter Description',
            self::TWITTER_IMAGE => 'Twitter Image',
            self::CUSTOM_SCHEMA => 'Custom Schema', // ✅ جدید
        };
    }

    public function type(): string
    {
        return match ($this) {
            self::OG_IMAGE, self::TWITTER_IMAGE => 'image',
            self::META_DESCRIPTION, self::OG_DESCRIPTION, self::TWITTER_DESCRIPTION, self::CUSTOM_SCHEMA => 'textarea', // ✅
            default => 'text',
        };
    }
}
