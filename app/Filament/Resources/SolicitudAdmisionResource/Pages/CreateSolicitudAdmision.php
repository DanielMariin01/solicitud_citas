<?php



namespace App\Filament\Resources\SolicitudAdmisionResource\Pages;

use App\Filament\Resources\SolicitudAdmisionResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Auth; // Asegúrate de importar Auth si lo usas para created_by

class CreateSolicitudAdmision extends CreateRecord
{
    protected static string $resource = SolicitudAdmisionResource::class;

   
}