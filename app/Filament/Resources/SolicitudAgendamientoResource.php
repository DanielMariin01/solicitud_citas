<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SolicitudAgendamientoResource\Pages;
use App\Filament\Resources\SolicitudAgendamientoResource\RelationManagers;
use App\Models\Solicitud_agendamiento;
use App\Models\SolicitudAgendamiento;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Enums\SolicitudEstado;
use App\Enums\SolicitudEstadoAgendamiento;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\BadgeColumn;

use Illuminate\Support\Facades\Crypt;


class SolicitudAgendamientoResource extends Resource
{
    protected static ?string $model = Solicitud_agendamiento::class;
protected static ?string $navigationIcon = 'heroicon-o-calendar-days';
      protected static ?string $navigationGroup = 'Agendamiento';
    protected static ?int $navigationSort = 1;
    protected static ?string $navigationLabel = 'Agendamiento';
    protected static ?string $modelLabel = 'Gestión de Agenda ';


     public static function getNavigationBadge(): ?string
    {
        // Esto reflejará el conteo de registros visibles bajo el scope getEloquentQuery()
        return static::getEloquentQuery()->count();
    }

    // Color del contador: NARANJA
    public static function getNavigationBadgeColor(): ?string
    {
        return 'warning'; // Cambiado a 'warning' para el color naranja
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                     Forms\Components\Select::make('estado')
                    ->label('Estado de Solicitud')
                    ->options(SolicitudEstadoAgendamiento::class)
                    ->required()
                    ->native(false)
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id_solicitud_admision')
                    ->label('ID Solicitud')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('paciente.nombre') // Asegúrate de que 'nombre_completo' sea un campo válido
                    ->label('Nombre')
                    ->sortable()
                    ->searchable()
                    ->formatStateUsing(fn ($state) => Crypt::decryptString($state)),
                Tables\Columns\TextColumn::make('paciente.apellido') // Asegúrate de que 'nombre_completo' sea un campo válido
                    ->label('Apellido')
                    ->sortable()
                    ->searchable()
                    ->formatStateUsing(fn ($state) => Crypt::decryptString($state)),
                Tables\Columns\TextColumn::make('paciente.tipo_identificacion') // Asegúrate de que 'nombre_completo' sea un campo válido
                    ->label('Tipo de Identificación')
                    ->sortable()
                    ->searchable()
                    ->formatStateUsing(fn ($state) => Crypt::decryptString($state)),
                Tables\Columns\TextColumn::make('paciente.numero_identificacion') // Asegúrate de que 'nombre_completo' sea un campo válido
                    ->label('Número de Identificación')
                    ->sortable()
                    ->searchable()
                    ->formatStateUsing(fn ($state) => Crypt::decryptString($state)),
                    
                 Tables\Columns\TextColumn::make('paciente.procedimiento.nombre')
                    ->label('Procedimiento')
                    ->limit(1000)
                    ->extraHeaderAttributes([
                        'style' => 'min-width: 200px;', // Establece un ancho mínimo para el encabezado
                    ])
                    ->extraAttributes([
                        'class' => 'whitespace-normal', // Asegura que el texto se envuelva (aunque ->wrap() ya lo hace)
                        'style' => 'max-width: 300px; word-break: break-word;', // Ayuda con palabras muy largas
                    ]), 

               
                Tables\Columns\TextColumn::make('paciente.historia_clinica') // <-- ¡Aquí usas la notación de punto!
                    ->label('Historia Clínica')
                    ->formatStateUsing(function ($state) {
                        if (empty($state)) { // Usar empty para cubrir null, cadenas vacías o 0
                            return '<span class="text-gray-500 italic">No disponible</span>';
                        }

                        $url = asset('storage/' . $state);
                        $ext = strtolower(pathinfo($state, PATHINFO_EXTENSION));

                        // Usar 'currentColor' para que el SVG tome el color del texto del enlace
                        $icon = match ($ext) {
                            'pdf' => '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" viewBox="0 0 24 24"><path d="M19 2H8a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h8l5-5V4a2 2 0 0 0-2-2z"/></svg>',
                            'png', 'jpg', 'jpeg', 'gif' => '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" viewBox="0 0 24 24"><path d="M19 2H5a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V4a2 2 0 0 0-2-2zm-1.5 15h-11L6 14.5 9 12l2.5 2.5L15 11z"/></svg>',
                            default => '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/></svg>',
                        };

                        // Clases de Filament para un buen estilo de enlace
                        return '<a href="' . $url . '" target="_blank" class="flex items-center gap-2 text-primary-600 hover:text-primary-700 font-semibold">' . $icon . 'Visualizar                                                                                                                                                                                                                                                                                                                                                                               </a>';
                    })
                    ->html(),
                
                    Tables\Columns\TextColumn::make('paciente.autorizacion') // <-- ¡Aquí usas la notación de punto!
                    ->label('Autorizacion')
                    ->formatStateUsing(function ($state) {
                        if (empty($state)) { // Usar empty para cubrir null, cadenas vacías o 0
                            return '<span class="text-gray-500 italic">No disponible</span>';
                        }

                        $url = asset('storage/' . $state);
                        $ext = strtolower(pathinfo($state, PATHINFO_EXTENSION));

                        // Usar 'currentColor' para que el SVG tome el color del texto del enlace
                        $icon = match ($ext) {
                            'pdf' => '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" viewBox="0 0 24 24"><path d="M19 2H8a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h8l5-5V4a2 2 0 0 0-2-2z"/></svg>',
                            'png', 'jpg', 'jpeg', 'gif' => '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" viewBox="0 0 24 24"><path d="M19 2H5a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V4a2 2 0 0 0-2-2zm-1.5 15h-11L6 14.5 9 12l2.5 2.5L15 11z"/></svg>',
                            default => '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/></svg>',
                        };

                        // Clases de Filament para un buen estilo de enlace
                        return '<a href="' . $url . '" target="_blank" class="flex items-center gap-2 text-primary-600 hover:text-primary-700 font-semibold">' . $icon . 'Visualizar                                                                                                                                                                                                                                                                                                                                                                               </a>';
                    })
                    ->html(),


                    Tables\Columns\TextColumn::make('paciente.orden_medica') // <-- ¡Aquí usas la notación de punto!
                    ->label('Orden medica')
                    ->formatStateUsing(function ($state) {
                        if (empty($state)) { // Usar empty para cubrir null, cadenas vacías o 0
                            return '<span class="text-gray-500 italic">No disponible</span>';
                        }

                        $url = asset('storage/' . $state);
                        $ext = strtolower(pathinfo($state, PATHINFO_EXTENSION));

                        // Usar 'currentColor' para que el SVG tome el color del texto del enlace
                        $icon = match ($ext) {
                            'pdf' => '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" viewBox="0 0 24 24"><path d="M19 2H8a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h8l5-5V4a2 2 0 0 0-2-2z"/></svg>',
                            'png', 'jpg', 'jpeg', 'gif' => '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" viewBox="0 0 24 24"><path d="M19 2H5a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V4a2 2 0 0 0-2-2zm-1.5 15h-11L6 14.5 9 12l2.5 2.5L15 11z"/></svg>',
                            default => '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/></svg>',
                        };

                        // Clases de Filament para un buen estilo de enlace
                        return '<a href="' . $url . '" target="_blank" class="flex items-center gap-2 text-primary-600 hover:text-primary-700 font-semibold">' . $icon . 'Visualizar                                                                                                                                                                                                                                                                                                                                                                               </a>';
                    })
                    ->html(),

            
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





                
                //Tables\Columns\TextColumn::make('estado')
                    //->label('Estado de Solicitud')
                    //->enum(SolicitudEstado::asSelectArray()), // Muestra el estado como texto legible
                Tables\Columns\TextColumn::make('comentario')
                    ->label('Comentario')
                    ->limit(1000)
                    ->extraHeaderAttributes([
                        'style' => 'min-width: 200px;', // Establece un ancho mínimo para el encabezado
                    ])
                    ->extraAttributes([
                        'class' => 'whitespace-normal', // Asegura que el texto se envuelva (aunque ->wrap() ya lo hace)
                        'style' => 'max-width: 300px; word-break: break-word;', // Ayuda con palabras muy largas
                    ]), 
                //agregar columna created_at y updated_at
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Fecha de Creación')
                    ->dateTime('d/m/Y H:i:s'),
                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Fecha de Actualización')
                    ->dateTime('d/m/Y H:i:s'),
       
            ])
            ->defaultPaginationPageOption(10)
            ->paginationPageOptions([10, 25, 50, 100])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                ->label('Gestionar Solicitud') // Cambia el texto del botón
                ->icon('heroicon-o-pencil-square'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
                ->defaultSort('created_at', 'asc');
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
            'index' => Pages\ListSolicitudAgendamientos::route('/'),
            'create' => Pages\CreateSolicitudAgendamiento::route('/create'),
            //'edit' => Pages\EditSolicitudAgendamiento::route('/{record}/edit'),
        ];
    }

          public static function getEloquentQuery(): Builder
    {
        // Esto filtrará la tabla para que solo muestre registros donde 'estado' sea 'aprobada'.
        // Los usuarios no podrán cambiar este filtro desde la UI.
        return parent::getEloquentQuery()->where('estado', 'agendar');
    }
}
