<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SolicitudAdmisionResource\Pages;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Models\Solicitud_Admision;
use App\Enums\SolicitudEstado;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\BadgeColumn;

use Illuminate\Support\Facades\Crypt;





class SolicitudAdmisionResource extends Resource
{
    protected static ?string $model = Solicitud_Admision::class;

    protected static ?string $navigationIcon = 'heroicon-o-chat-bubble-bottom-center-text';
      protected static ?string $navigationGroup = 'Respuesta Solicitudes';
    protected static ?int $navigationSort = 1;
    protected static ?string $navigationLabel = 'Respuesta Solicitudes';
     protected static ?string $modelLabel = 'Responder Solicitud';
   


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
              Forms\Components\Select::make('estado')
                    ->label('Estado de Solicitud')
                    ->options(SolicitudEstado::class)
                    ->required()
                    ->native(false),
                Forms\Components\TextInput::make('comentario')
                    ->label('Comentario')
                    ->maxLength(1000),
                 Select::make('fk_paciente') // Usa Select si quieres que sea un desplegable de pacientes
                    ->label('Paciente Asociado') // Etiqueta para el formulario
                    ->relationship('paciente', 'nombre') // 'paciente' es el método de relación en tu modelo SolicitudAdmisiones
                                                                  // 'nombre_completo' es la columna que quieres mostrar en el desplegable
                                                                  // (si no tienes 'nombre_completo', usa 'nombre' o el campo que identifique al paciente)
                    ->required() // Si es un campo obligatorio
                    ->default(fn () => request()->query('fk_paciente')) // <-- ¡AQUÍ SE PRE-RELLENA DESDE LA URL!
                    ->disabled() // Hace que el campo sea visible pero no editable por el usuario
                    ->dehydrated(true), // Asegura que el valor se incluya cuando se guarden los datos

                // Si prefieres que sea un campo de texto oculto para el ID del paciente:
                // TextInput::make('fk_paciente')
                //     ->hidden() // Lo hace invisible en el formulario
                //     ->required() // Si es obligatorio
                //     ->default(fn () => request()->query('fk_paciente')), 
            
            ]);
    }
    public static function getEloquentQuery(): Builder
{
    return parent::getEloquentQuery()->with('paciente');
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
            ->filters([
                 Tables\Filters\SelectFilter::make('estado')
                    ->label('Estado')
                    ->options([
                        \App\Enums\SolicitudEstado::PENDIENTE->value => 'Pendiente',
                        \App\Enums\SolicitudEstado::APROBADA->value => 'Aprobada',
                        \App\Enums\SolicitudEstado::RECHAZADA->value => 'Rechazada',
                        \App\Enums\SolicitudEstado::CANCELADA->value => 'Cancelada',
                        \App\Enums\SolicitudEstado::ENVIADA_A_MEDICO->value => 'Enviada a Médico',
                        \App\Enums\SolicitudEstado::FINALIZADA->value => 'Finalizada',
                    ])
                    ->searchable(),
                //
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
            'index' => Pages\ListSolicitudAdmisions::route('/'),
            'create' => Pages\CreateSolicitudAdmision::route('/create'),
            'edit' => Pages\EditSolicitudAdmision::route('/{record}/edit'),
        ];
    }
}
