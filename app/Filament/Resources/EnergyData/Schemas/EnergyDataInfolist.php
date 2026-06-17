<?php

namespace App\Filament\Resources\EnergyData\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class EnergyDataInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('panel_id')
                    ->numeric(),
                TextEntry::make('power')
                    ->numeric(),
                TextEntry::make('consumption')
                    ->numeric(),
                TextEntry::make('voltage')
                    ->numeric(),
                TextEntry::make('current')
                    ->numeric(),
                TextEntry::make('energy_kwh')
                    ->numeric(),
                TextEntry::make('created_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->dateTime()
                    ->placeholder('-'),
            ]);
    }
}
