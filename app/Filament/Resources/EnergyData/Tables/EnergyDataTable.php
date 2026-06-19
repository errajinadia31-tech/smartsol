<?php

namespace App\Filament\Resources\EnergyData\Tables;

use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class EnergyDataTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('panel_id')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('power')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('consumption')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('voltage')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('current')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('energy_kwh')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
             ->headerActions([
                Action::make('imprimer')
                    ->label('Imprimer')
                    ->icon('heroicon-o-printer')
                    ->url(route('admin.energy-data.print'))
                    ->openUrlInNewTab(),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
