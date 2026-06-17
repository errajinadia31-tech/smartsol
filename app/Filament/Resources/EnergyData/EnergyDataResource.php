<?php

namespace App\Filament\Resources\EnergyData;

use App\Filament\Resources\EnergyData\Pages\CreateEnergyData;
use App\Filament\Resources\EnergyData\Pages\EditEnergyData;
use App\Filament\Resources\EnergyData\Pages\ListEnergyData;
use App\Filament\Resources\EnergyData\Pages\ViewEnergyData;
use App\Filament\Resources\EnergyData\Schemas\EnergyDataForm;
use App\Filament\Resources\EnergyData\Schemas\EnergyDataInfolist;
use App\Filament\Resources\EnergyData\Tables\EnergyDataTable;
use App\Models\EnergyData;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class EnergyDataResource extends Resource
{
    protected static ?string $model = EnergyData::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

protected static ?string $recordTitleAttribute = 'energy_kwh';
    public static function form(Schema $schema): Schema
    {
        return EnergyDataForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return EnergyDataInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return EnergyDataTable::configure($table);
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
            'index' => ListEnergyData::route('/'),
            'create' => CreateEnergyData::route('/create'),
            'view' => ViewEnergyData::route('/{record}'),
            'edit' => EditEnergyData::route('/{record}/edit'),
        ];
    }
}
