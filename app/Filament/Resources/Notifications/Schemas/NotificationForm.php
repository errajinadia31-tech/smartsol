<?php

namespace App\Filament\Resources\Notifications\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class NotificationForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('user_id')
                    ->required()
                    ->numeric(),
                TextInput::make('message')
                    ->required(),
                Toggle::make('is_read')
                    ->required(),
            ]);
    }
}
