<?php

namespace App\Filament\Resources\HrContacts\Pages;

use App\Filament\Resources\HrContacts\HrContactResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListHrContacts extends ListRecords
{
    protected static string $resource = HrContactResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
