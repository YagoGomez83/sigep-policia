<?php

namespace App\Filament\Resources;

use App\Filament\Resources\JobFunctionResource\Pages;
use App\Filament\Resources\JobFunctionResource\RelationManagers;
use App\Models\JobFunction;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class JobFunctionResource extends Resource
{
    protected static ?string $model = JobFunction::class;

    protected static ?string $modelLabel = 'Función';
    
    protected static ?string $pluralModelLabel = 'Funciones';

    protected static ?string $navigationIcon = 'heroicon-o-briefcase';

    protected static ?string $navigationGroup = 'Configuración';

    protected static ?int $navigationSort = 3;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->label('Nombre de la Función')
                    ->required()
                    ->maxLength(150)
                    ->placeholder('Ej: Jefe de Guardia, Personal de Calle, Administrativo')
                    ->unique(ignoreRecord: true)
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Función')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),
                Tables\Columns\TextColumn::make('agents_count')
                    ->label('Personal Asignado')
                    ->counts('agents')
                    ->badge()
                    ->color('success'),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Creado')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Actualizado')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->label('Editar'),
                Tables\Actions\DeleteAction::make()
                    ->label('Eliminar'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()
                        ->label('Eliminar seleccionados'),
                ]),
            ])
            ->defaultSort('name', 'asc');
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
            'index' => Pages\ListJobFunctions::route('/'),
            'create' => Pages\CreateJobFunction::route('/create'),
            'edit' => Pages\EditJobFunction::route('/{record}/edit'),
        ];
    }
}
