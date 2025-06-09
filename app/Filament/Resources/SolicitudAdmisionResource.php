<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SolicitudAdmisionResource\Pages;
use App\Filament\Resources\SolicitudAdmisionResource\RelationManagers;
use App\Models\SolicitudAdmision;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Models\Solicitud_Admision;


class SolicitudAdmisionResource extends Resource
{
    protected static ?string $model = Solicitud_Admision::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
         
                Forms\Components\TextInput::make('estado')
                    ->label('Estado')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('comentario')
                    ->label('Comentario')
                    ->maxLength(1000),
                Forms\Components\DateTimePicker::make('hora')
                    ->label('Hora')
                    ->required(),
                Forms\Components\DatePicker::make('fecha')
                    ->label('Fecha')
                    ->required(),
            
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
    
           Tables\Columns\TextColumn::make('paciente.nombre')
                ->label('Nombre')
                ->sortable()
                ->searchable(),

            Tables\Columns\TextColumn::make('paciente.apellido')
                ->label('Apellido')
                ->sortable()
                ->searchable(),

            Tables\Columns\TextColumn::make('paciente.tipo_identificacion')
                ->label('Tipo ID'),

            Tables\Columns\TextColumn::make('paciente.numero_identificacion')
                ->label('Número ID'),

            Tables\Columns\TextColumn::make('paciente.correo')
                ->label('Correo'),

            Tables\Columns\TextColumn::make('paciente.fk_ciudad')
                ->label('Ciudad'),

            Tables\Columns\TextColumn::make('paciente.procedimiento')
                ->label('Procedimiento'),

            Tables\Columns\TextColumn::make('paciente.fk_eps')
                ->label('EPS'),

            Tables\Columns\TextColumn::make('paciente.celular')
                ->label('Celular'),

            Tables\Columns\TextColumn::make('paciente.observacion')
                ->label('Observación'),

            Tables\Columns\TextColumn::make('estado')
                ->label('Estado'), // Esto viene directamente de la solicitud
                      
            
            ])
            ->filters([
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
