<?php

namespace App\Filament\Resources\Inscritos;

use BackedEnum;
use App\Models\User;
use Filament\Tables\Table;
use Filament\Schemas\Schema;
use Filament\Resources\Resource;
use Filament\Support\Icons\Heroicon;
use App\Filament\Resources\Inscritos\Pages\EditInscrito;
use App\Filament\Resources\Inscritos\Pages\ListInscritos;
use App\Filament\Resources\Inscritos\Pages\CreateInscrito;
use App\Filament\Resources\Inscritos\Schemas\InscritoForm;
use App\Filament\Resources\Inscritos\Tables\InscritosTable;

class InscritoResource extends Resource
{
    protected static ?string $model = User::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'id';

    public static function form(Schema $schema): Schema
    {
        return InscritoForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return InscritosTable::configure($table);
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
            'index' => ListInscritos::route('/'),
            'create' => CreateInscrito::route('/create'),
            'edit' => EditInscrito::route('/{record}/edit'),
        ];
    }
}
