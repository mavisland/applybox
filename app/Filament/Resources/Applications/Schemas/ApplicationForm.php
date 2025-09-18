<?php

namespace App\Filament\Resources\Applications\Schemas;

use App\Models\Company;
use App\Models\HrContact;
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
                    ->relationship('company', 'name')
                    ->searchable()
                    ->preload()
                    ->required(),
                Select::make('hr_contact_id')
                    ->relationship('hrContact', 'name')
                    ->searchable()
                    ->preload(),
                TextInput::make('position')
                    ->required(),
                DatePicker::make('applied_date')
                    ->required(),
                Select::make('status')
                    ->options([
            'applied' => 'Applied',
            'interview' => 'Interview',
            'offer' => 'Offer',
            'rejected' => 'Rejected',
            'withdrawn' => 'Withdrawn',
        ])
                    ->required(),
                Textarea::make('notes'),
                FileUpload::make('documents')
                    ->label('Documents')
                    ->multiple()
                    ->disk('public')
                    ->directory('application-documents'),
            ]);
    }
}
