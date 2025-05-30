<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SolicitudMedicoResource\Pages;
use App\Filament\Resources\SolicitudMedicoResource\RelationManagers;
use App\Models\SolicitudMedico;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class SolicitudMedicoResource extends Resource
{
    protected static ?string $model = SolicitudMedico::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
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
            'index' => Pages\ListSolicitudMedicos::route('/'),
            'create' => Pages\CreateSolicitudMedico::route('/create'),
            'edit' => Pages\EditSolicitudMedico::route('/{record}/edit'),
        ];
    }
}
