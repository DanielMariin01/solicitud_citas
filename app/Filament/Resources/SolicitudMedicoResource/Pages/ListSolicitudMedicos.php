<?php

namespace App\Filament\Resources\SolicitudMedicoResource\Pages;

use App\Filament\Resources\SolicitudMedicoResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListSolicitudMedicos extends ListRecords
{
    protected static string $resource = SolicitudMedicoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
