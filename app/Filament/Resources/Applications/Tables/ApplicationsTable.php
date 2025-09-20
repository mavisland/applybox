<?php

namespace App\Filament\Resources\Applications\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ApplicationsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('company.name')
                    ->label(__('Company Name'))
                    ->searchable()
                    ->sortable(),
                TextColumn::make('hrContact.name')
                    ->label(__('HR Contact'))
                    ->searchable()
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('position')
                    ->label(__('Position'))
                    ->searchable(),
                TextColumn::make('applied_date')
                    ->label(__('Applied Date'))
                    ->date()
                    ->sortable(),
                TextColumn::make('status')
                    ->label(__('Status'))
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'applied' => 'gray',
                        'interview' => 'info',
                        'offer' => 'success',
                        'rejected' => 'danger',
                        'withdrawn' => 'warning',
                        default => 'gray',
                    }),
                TextColumn::make('created_at')
                    ->label(__('Created At'))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->label(__('Updated At'))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->emptyStateHeading(__('application.empty_state.heading'))
            ->emptyStateDescription(__('application.empty_state.description'))
            ->emptyStateIcon('heroicon-o-document-text');
    }
}
