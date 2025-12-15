<?php

namespace App\Filament\Resources;

use App\Filament\Resources\HierarchyResource\Pages;
use App\Filament\Resources\HierarchyResource\RelationManagers;
use App\Models\Hierarchy;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class HierarchyResource extends Resource
{
    protected static ?string $model = Hierarchy::class;

    protected static ?string $modelLabel = 'Jerarquía';
    
    protected static ?string $pluralModelLabel = 'Jerarquías';

    protected static ?string $navigationIcon = 'heroicon-o-shield-check';

    protected static ?string $navigationGroup = 'Configuración';

    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->label('Nombre de la Jerarquía')
                    ->required()
                    ->maxLength(100)
                    ->placeholder('Ej: Comisario General, Oficial, Suboficial')
                    ->unique(ignoreRecord: true),
                Forms\Components\TextInput::make('rank_level')
                    ->label('Orden Jerárquico')
                    ->required()
                    ->numeric()
                    ->minValue(1)
                    ->maxValue(100)
                    ->placeholder('1 = Mayor jerarquía')
                    ->helperText('Número que define el orden jerárquico (menor número = mayor jerarquía)'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('rank_level')
                    ->label('Orden')
                    ->numeric()
                    ->sortable()
                    ->badge()
                    ->color('info'),
                Tables\Columns\TextColumn::make('name')
                    ->label('Jerarquía')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),
                Tables\Columns\TextColumn::make('agents_count')
                    ->label('Personal')
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
            ->defaultSort('rank_level', 'asc');
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
            'index' => Pages\ListHierarchies::route('/'),
            'create' => Pages\CreateHierarchy::route('/create'),
            'edit' => Pages\EditHierarchy::route('/{record}/edit'),
        ];
    }
}
