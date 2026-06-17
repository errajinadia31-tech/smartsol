<?php

namespace App\Filament\Resources\Panels\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class PanelInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('name'),
                TextEntry::make('serial_number'),
                TextEntry::make('power_capacity')
                    ->numeric(),
                TextEntry::make('status')
                    ->badge(),
                TextEntry::make('user_id')
                    ->numeric(),
                TextEntry::make('zone_id')
                    ->numeric()
                    ->placeholder('-'),
                TextEntry::make('created_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->dateTime()
                    ->placeholder('-'),
            ]);
    }
}
