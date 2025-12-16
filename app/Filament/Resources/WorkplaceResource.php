<?php

namespace App\Filament\Resources;

use App\Filament\Resources\WorkplaceResource\Pages;
use App\Filament\Resources\WorkplaceResource\RelationManagers;
use App\Models\Workplace;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class WorkplaceResource extends Resource
{
    protected static ?string $model = Workplace::class;

    protected static ?string $modelLabel = 'Destino';
    
    protected static ?string $pluralModelLabel = 'Destinos / Dependencias';

    protected static ?string $navigationIcon = 'heroicon-o-building-office-2';

    protected static ?string $navigationGroup = 'Configuración';

    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->label('Nombre del Destino')
                    ->required()
                    ->maxLength(200)
                    ->placeholder('Ej: Comisaría Primera, Destacamento Zona Norte')
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('location')
                    ->label('Ubicación')
                    ->maxLength(200)
                    ->placeholder('Ej: Av. Principal 1234, Zona Centro')
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Destino / Dependencia')
                    ->searchable()
                    ->sortable()
                    ->weight('bold')
                    ->wrap(),
                Tables\Columns\TextColumn::make('location')
                    ->label('Ubicación')
                    ->searchable()
                    ->sortable()
                    ->wrap()
                    ->icon('heroicon-m-map-pin')
                    ->color('gray'),
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
            'index' => Pages\ListWorkplaces::route('/'),
            'create' => Pages\CreateWorkplace::route('/create'),
            'edit' => Pages\EditWorkplace::route('/{record}/edit'),
        ];
    }
}
