<?php

namespace App\Filament\Agendar\Resources\SolicitudAgendamientoResource\Pages;

use App\Filament\Agendar\Resources\SolicitudAgendamientoResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditSolicitudAgendamiento extends EditRecord
{
    protected static string $resource = SolicitudAgendamientoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
