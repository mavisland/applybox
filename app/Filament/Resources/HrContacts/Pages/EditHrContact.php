<?php

namespace App\Filament\Resources\HrContacts\Pages;

use App\Filament\Resources\HrContacts\HrContactResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditHrContact extends EditRecord
{
    protected static string $resource = HrContactResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
