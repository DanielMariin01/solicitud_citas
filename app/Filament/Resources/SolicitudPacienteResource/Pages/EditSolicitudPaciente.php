<?php

namespace App\Filament\Resources\SolicitudPacienteResource\Pages;

use App\Filament\Resources\SolicitudPacienteResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditSolicitudPaciente extends EditRecord
{
    protected static string $resource = SolicitudPacienteResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
