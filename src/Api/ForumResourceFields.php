<?php

/*
 * This file is part of fof/upload.
 *
 * Copyright (c) FriendsOfFlarum.
 * Copyright (c) Flagrow.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace FoF\Upload\Api;

use Flarum\Api\Context;
use Flarum\Api\Schema;
use Flarum\Foundation\Config;
use Flarum\Settings\SettingsRepositoryInterface;
use Illuminate\Contracts\Filesystem\Cloud;
use Illuminate\Contracts\Filesystem\Factory;

class ForumResourceFields
{
    protected Cloud $assetsDir;

    public function __construct(
        protected SettingsRepositoryInterface $settings,
        Factory $factory
    ) {
        $this->assetsDir = $factory->disk('flarum-assets');
    }

    public function __invoke(): array
    {
        return [
            Schema\Boolean::make('fof-upload.canUpload')
                ->get(fn ($model, Context $context) => $context->getActor()->can('fof-upload.upload')),

            Schema\Boolean::make('fof-upload.canDownload')
                ->get(fn ($model, Context $context) => $context->getActor()->can('fof-upload.download')),

            Schema\Str::make('fof-upload.composerButtonVisiblity')
                ->get(fn () => $this->settings->get('fof-upload.composerButtonVisiblity', 'both')),

            Schema\Str::make('fof-watermarkUrl')
                ->nullable()
                ->get(function () {
                    $watermark = $this->settings->get('fof-watermark_path');
                    return $watermark ? $this->assetsDir->url($watermark) : null;
                }),
        ];
    }
}
