<?php

namespace App\Filament\Resources\EnergyData\Pages;

use App\Filament\Resources\EnergyData\EnergyDataResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditEnergyData extends EditRecord
{
    protected static string $resource = EnergyDataResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
