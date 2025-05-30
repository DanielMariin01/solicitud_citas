<?php

namespace App\Filament\Resources\SolicitudMedicoResource\Pages;

use App\Filament\Resources\SolicitudMedicoResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditSolicitudMedico extends EditRecord
{
    protected static string $resource = SolicitudMedicoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
