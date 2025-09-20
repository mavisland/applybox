<?php

namespace App\Filament\Resources\Applications\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class ApplicationForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('company_id')
                    ->label(__('Company Name'))
                    ->relationship('company', 'name')
                    ->searchable()
                    ->preload()
                    ->required(),
                Select::make('hr_contact_id')
                    ->label(__('HR Contact'))
                    ->relationship('hrContact', 'name')
                    ->searchable()
                    ->preload(),
                TextInput::make('position')
                    ->label(__('Position'))
                    ->required(),
                DatePicker::make('applied_date')
                    ->label(__('Applied Date'))
                    ->required(),
                Select::make('status')
                    ->label(__('Status'))
                    ->options([
                        'draft' => __('Draft'),
                        'applied' => __('Applied'),
                        'interview' => __('Interview'),
                        'offer' => __('Offer'),
                        'rejected' => __('Rejected'),
                        'withdrawn' => __('Withdrawn'),
                    ])
                    ->required(),
                Textarea::make('notes')
                    ->label(__('Notes'))
                    ->rows(3),
                FileUpload::make('documents')
                    ->label(__('Documents'))
                    ->multiple()
                    ->disk('public')
                    ->directory('application-documents'),
            ]);
    }
}
