<?php

namespace App\Filament\Resources\HrContacts;

use App\Filament\Resources\HrContacts\Pages\CreateHrContact;
use App\Filament\Resources\HrContacts\Pages\EditHrContact;
use App\Filament\Resources\HrContacts\Pages\ListHrContacts;
use App\Filament\Resources\HrContacts\Schemas\HrContactForm;
use App\Filament\Resources\HrContacts\Tables\HrContactsTable;
use App\Models\HrContact;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class HrContactResource extends Resource
{
    protected static ?string $model = HrContact::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    public static function form(Schema $schema): Schema
    {
        return HrContactForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return HrContactsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListHrContacts::route('/'),
            'create' => CreateHrContact::route('/create'),
            'edit' => EditHrContact::route('/{record}/edit'),
        ];
    }
}
