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
use Filament\Tables\Columns\BadgeColumn;

class PacienteResource extends Resource
{
    protected static ?string $model = Paciente::class;

    protected static ?string $navigationIcon = 'heroicon-o-bell';
    protected static ?string $navigationGroup = 'Solicitudes';
    protected static ?int $navigationSort = 1;
    protected static ?string $navigationLabel = 'Solicitudes Admisiones';
    protected static ?string $pluralModelLabel = 'Gestión de Solicitudes'; 

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
                    ->formatStateUsing(fn ($state) => Crypt::decryptString($state)),

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

                Tables\Columns\TextColumn::make('ciudad.nombre')
                    ->label('Ciudad'),

                Tables\Columns\TextColumn::make('eps.nombre')
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

                BadgeColumn::make('estado')
                    ->label('Estado')
                    ->formatStateUsing(fn (string $state) => SolicitudEstado::from($state)->label())
                    ->color(fn (string $state) => SolicitudEstado::from($state)->getColor())
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

                        return '<a href="' . $url . '" target="_blank" style="display:inline-flex; align-items:center; gap:6px; color:#1d4ed8; font-weight:600;">' . $icon . 'Visualizar</a>';
                    })
                    ->html(),

                Tables\Columns\TextColumn::make('autorizacion')
                    ->label('Autorizacion')
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

                        return '<a href="' . $url . '" target="_blank" style="display:inline-flex; align-items:center; gap:6px; color:#1d4ed8; font-weight:600;">' . $icon . ' Visualizar</a>';
                    })
                    ->html(),


                Tables\Columns\TextColumn::make('orden_medica')
                    ->label('Orden medica')
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

                        return '<a href="' . $url . '" target="_blank" style="display:inline-flex; align-items:center; gap:6px; color:#1d4ed8; font-weight:600;">' . $icon . ' Visualizar</a>';
                    })
                    ->html(),

                Tables\Columns\TextColumn::make('created_at') // Columna para mostrar la fecha de creación
                    ->label('Fecha de Creación')
                    ->sortable()
                    ->dateTime(),
                //Tables\Columns\TextColumn::make('updated_at')  // Columna para mostrar la fecha de última actualización
                   // ->label('Última Actualización')
                    //->sortable()
                    //->dateTime(),
            ])
            ->filters([
                // Puedes agregar filtros personalizados aquí
                 // permite buscar dentro de las opciones del select

                    Tables\Filters\SelectFilter::make('id_eps')
                    ->label('EPS')
                  ->relationship('eps', 'nombre')
                  //->searchable(),

            
            ])
            ->actions([
                //Tables\Actions\EditAction::make(),
               //Tables\Actions\Action::make('responderSolicitud')
                    //->label('Responder')
                   // ->icon('heroicon-o-chat-bubble-left-right') // Icono de chat
                    //->color('primary') // Color principal
                    //->modalIcon('heroicon-o-chat-bubble-left-right')
                   // ->action(function (Paciente $record) {
                        // Aquí puedes definir la lógica para responder a la solicitud
                        // Por ejemplo, redirigir a una página de respuesta o abrir un modal
                        //return redirect()->route('filament.admin.resources.solicitud-admisions.create', ['fk_paciente' => $record->id_paciente]);
                        //'paciente_id' => $record->id,
                   // })
                     Tables\Actions\Action::make('Responder')
                    ->url(fn (Paciente $record): string => SolicitudAdmisionResource::getUrl('create', [
                        // Asegúrate de que el nombre del parámetro sea 'fk_paciente'
                        // Y que el valor sea el ID correcto del paciente de la tabla 'pacientes'
                        'fk_paciente' => $record->id_paciente, // O $record->id si el ID de tu tabla Paciente es 'id'
                    ]))
                    ->icon('heroicon-o-chat-bubble-left-right')
                    ->color('primary'),
                    

            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
             ->defaultSort('created_at', 'desc');
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
            //'create' => Pages\CreatePaciente::route('/create'),
            //'edit' => Pages\EditPaciente::route('/{record}/edit'),
        ];
    }
      public static function getEloquentQuery(): Builder
    {
        // Esto filtrará la tabla para que solo muestre registros donde 'estado' sea 'aprobada'.
        // Los usuarios no podrán cambiar este filtro desde la UI.
        return parent::getEloquentQuery()->where('estado', 'pendiente');

    }
}