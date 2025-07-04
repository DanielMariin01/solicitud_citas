<?php

namespace App\Filament\Resources\PacienteResource\Pages;

use App\Filament\Resources\PacienteResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPacientes extends ListRecords
{
    protected static string $resource = PacienteResource::class;


      protected function getHeaderActions(): array
    {
        // Devuelve un array vacío para eliminar el botón de creación
        return [];
    }
}
