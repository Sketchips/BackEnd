<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateUser extends CreateRecord
{
    protected static string $resource = UserResource::class;

    protected function getRedirectUrl(): string
    {
        return '/admin/users';
    }

    protected function mutateFormActions(array $actions): array
    {
        unset($actions['create_another']);
        return $actions;
    }
}
