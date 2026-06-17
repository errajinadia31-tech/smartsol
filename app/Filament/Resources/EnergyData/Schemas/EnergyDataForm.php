<?php

namespace App\Filament\Resources\EnergyData\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class EnergyDataForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('panel_id')
                    ->required()
                    ->numeric(),
                TextInput::make('power')
                    ->required()
                    ->numeric(),
                TextInput::make('consumption')
                    ->required()
                    ->numeric(),
                TextInput::make('voltage')
                    ->required()
                    ->numeric(),
                TextInput::make('current')
                    ->required()
                    ->numeric(),
                TextInput::make('energy_kwh')
                    ->required()
                    ->numeric(),
            ]);
    }
}
