<?php

namespace App\Filament\Resources\EnergyData\Pages;

use App\Filament\Resources\EnergyData\EnergyDataResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewEnergyData extends ViewRecord
{
    protected static string $resource = EnergyDataResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
