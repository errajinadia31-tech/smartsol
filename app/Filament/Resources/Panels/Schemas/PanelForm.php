<?php

namespace App\Filament\Resources\Panels\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class PanelForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required(),
                TextInput::make('serial_number')
                    ->required(),
                TextInput::make('power_capacity')
                    ->required()
                    ->numeric(),
                Select::make('status')
                    ->options(['active' => 'Active', 'inactive' => 'Inactive', 'maintenance' => 'Maintenance'])
                    ->default('active')
                    ->required(),
                TextInput::make('user_id')
                    ->required()
                    ->numeric(),
             Select::make('zone_id')
    ->relationship('zone', 'city') 
    ->label('Ville')
    ->required()
            ]);
    }
}
