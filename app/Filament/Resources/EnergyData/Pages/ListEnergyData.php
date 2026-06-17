<?php

namespace App\Filament\Resources\EnergyData\Pages;

use App\Filament\Resources\EnergyData\EnergyDataResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListEnergyData extends ListRecords
{
    protected static string $resource = EnergyDataResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
