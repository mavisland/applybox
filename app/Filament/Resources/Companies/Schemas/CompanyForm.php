<?php

namespace App\Filament\Resources\Companies\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class CompanyForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label(__('Company name'))
                    ->required(),
                TextInput::make('industry')
                    ->label(__('Industry')),
                Textarea::make('address')
                    ->label(__('Address'))
                    ->columnSpanFull(),
                TextInput::make('phone')
                    ->label(__('Phone number'))
                    ->tel(),
                TextInput::make('email')
                    ->label('Email address')
                    ->email(),
                TextInput::make('website')
                    ->label(__('Website'))
                    ->url(),
            ]);
    }
}
