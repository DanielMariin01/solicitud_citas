<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PacienteResource\Pages;
use App\Filament\Resources\PacienteResource\RelationManagers;
use App\Models\Paciente;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Crypt;
use App\Enums\SolicitudEstado;
use Filament\Tables\Filters\DateFilter;

class PacienteResource extends Resource
{
    protected static ?string $model = Paciente::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
Forms\Components\Select::make('estado')
    ->label('Estado de Solicitud')
    ->options(SolicitudEstado::class)
    ->required()
    ->native(false)


       
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nombre')
                ->label('Nombre')
                ->sortable()
                ->searchable()
                ->formatStateUsing(fn ($state) => Crypt::decryptString($state)),

            Tables\Columns\TextColumn::make('apellido')
                ->label('Apellido')
                ->sortable()
                ->searchable()
                ->formatStateUsing(fn ($state) => Crypt::decryptString($state)),

            Tables\Columns\TextColumn::make('tipo_identificacion')
                ->label('Tipo de Identificación')
                ->sortable()
                ->searchable()
                ->formatStateUsing(fn ($state) => Crypt::decryptString($state))
                // Si no está cifrado, no hace falta desencriptar
                ,

            Tables\Columns\TextColumn::make('numero_identificacion')
                ->label('Número de Identificación')
                ->sortable()
                ->searchable()
                ->formatStateUsing(fn ($state) => Crypt::decryptString($state)),

            Tables\Columns\TextColumn::make('correo')
                ->label('Correo Electrónico')
                ->sortable()
                ->searchable()
                ->formatStateUsing(fn ($state) => Crypt::decryptString($state)),

            Tables\Columns\TextColumn::make('fk_ciudad.nombre')
                ->label('Ciudad'),

            Tables\Columns\TextColumn::make('fk_eps.nombre')
                ->label('EPS'),

            Tables\Columns\TextColumn::make('celular')
                ->label('Celular')
                ->formatStateUsing(fn ($state) => Crypt::decryptString($state)),

            Tables\Columns\TextColumn::make('procedimiento')
                ->label('Procedimiento')
                ->sortable()
                ->searchable()
                ->formatStateUsing(fn ($state) => Crypt::decryptString($state))
                ->extraHeaderAttributes([
        'style' => 'min-width: 200px;', // Establece un ancho mínimo para el encabezado
    ])
    ->extraAttributes([
        'class' => 'whitespace-normal', // Asegura que el texto se envuelva (aunque ->wrap() ya lo hace)
        'style' => 'max-width: 300px; word-break: break-word;', // Ayuda con palabras muy largas
    ]),

           Tables\Columns\BadgeColumn::make('estado')
    ->label('Estado')
    ->sortable()
    ->colors([
        'warning' => 'pendiente',
        'info' => 'enviada_a_medico',
        'success' => 'aprobada',
        'danger' => ['rechazada', 'cancelada'],
        'gray' => 'finalizada',
    ])
    ->formatStateUsing(function ($state) {
        try {
            return SolicitudEstado::from($state)->label();
        } catch (\ValueError $e) {
            return $state;
        }
    }),
            Tables\Columns\TextColumn::make('observacion')
                ->label('Observación')
                ->sortable()
                ->searchable()
                ->wrap() 
                ->formatStateUsing(fn ($state) => Crypt::decryptString($state))
                ->extraHeaderAttributes([
        'style' => 'min-width: 200px;', // Establece un ancho mínimo para el encabezado
    ])
    ->extraAttributes([
        'class' => 'whitespace-normal', // Asegura que el texto se envuelva (aunque ->wrap() ya lo hace)
        'style' => 'max-width: 300px; word-break: break-word;', // Ayuda con palabras muy largas
    ]),
            
            //mostrar los archivos subidos pero que se puedan descargar
 Tables\Columns\TextColumn::make('historia_clinica')
    ->label('Historia Clínica')
    ->formatStateUsing(function ($state) {
        if (!$state) {
            return '<span class="text-gray-500 italic">No disponible</span>';
        }

        $url = asset('storage/' . $state);
        $ext = strtolower(pathinfo($state, PATHINFO_EXTENSION));

        // Solo un ícono simple SVG con color negro para prueba
        $icon = match ($ext) {
            'pdf' => '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="black" viewBox="0 0 24 24"><path d="M19 2H8a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h8l5-5V4a2 2 0 0 0-2-2z"/></svg>',
            default => '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="black" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/></svg>',
        };

        return '<a href="' . $url . '" target="_blank" style="display:inline-flex; align-items:center; gap:6px; color:#1d4ed8; font-weight:600;">' . $icon . ' Descargar</a>';
    })
    ->html(),

     Tables\Columns\TextColumn::make('created_at') // Columna para mostrar la fecha de creación
                    ->label('Fecha de Creación')
                    ->sortable()
                    ->dateTime(),
                Tables\Columns\TextColumn::make('updated_at')  // Columna para mostrar la fecha de última actualización
                    ->label('Última Actualización')
                    ->sortable()
                    ->dateTime(),   
            ])
            ->filters([

                // Puedes agregar filtros personalizados aquí
                 Tables\Filters\SelectFilter::make('estado')
                    ->options([
                      'pendiente' => 'Pendiente',
                       'aprobada' => 'Aprobada',
                        'rechazada' => 'Rechazada',
                    ]),
                //filtro por ultima fecha de creación
             

            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPacientes::route('/'),
            'create' => Pages\CreatePaciente::route('/create'),
            'edit' => Pages\EditPaciente::route('/{record}/edit'),
        ];
    }
}
