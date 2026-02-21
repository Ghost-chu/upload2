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
use Flarum\User\User;

class UserResourceFields
{
    public function __invoke(): array
    {
        return [
            Schema\Integer::make('fof-upload-uploadCountCurrent')
                ->get(fn (User $user) => $user->foffiles_current_count ?? 0),

            Schema\Integer::make('fof-upload-uploadCountAll')
                ->get(fn (User $user) => $user->foffiles_count ?? 0),

            Schema\Boolean::make('fof-upload-viewOthersMediaLibrary')
                ->visible(fn (User $user, Context $context) => $context->getActor()->id === $user->id)
                ->get(fn (User $user, Context $context) => $context->getActor()->hasPermission('fof-upload.viewUserUploads')),

            Schema\Boolean::make('fof-upload-deleteOthersMediaLibrary')
                ->visible(fn (User $user, Context $context) => $context->getActor()->id === $user->id)
                ->get(fn (User $user, Context $context) => $context->getActor()->hasPermission('fof-upload.deleteUserUploads')),

            Schema\Boolean::make('fof-upload-uploadSharedFiles')
                ->visible(fn (User $user, Context $context) => $context->getActor()->id === $user->id)
                ->get(fn (User $user, Context $context) => $context->getActor()->hasPermission('fof-upload.upload-shared-files')),

            Schema\Boolean::make('fof-upload-accessSharedFiles')
                ->visible(fn (User $user, Context $context) => $context->getActor()->id === $user->id)
                ->get(fn (User $user, Context $context) => $context->getActor()->hasPermission('fof-upload.access-shared-files')),
        ];
    }
}
