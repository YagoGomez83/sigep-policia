<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AgentResource\Pages;
use App\Filament\Resources\AgentResource\RelationManagers;
use App\Models\Agent;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class AgentResource extends Resource
{
    protected static ?string $model = Agent::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('job_function_id')
                    ->relationship('jobFunction', 'name')
                    ->required(),
                Forms\Components\Select::make('hierarchy_id')
                    ->relationship('hierarchy', 'name')
                    ->required(),
                Forms\Components\TextInput::make('apellido')
                    ->required()
                    ->maxLength(100),
                Forms\Components\TextInput::make('nombre')
                    ->required()
                    ->maxLength(100),
                Forms\Components\TextInput::make('dni')
                    ->required()
                    ->maxLength(20),
                Forms\Components\TextInput::make('legajo')
                    ->required()
                    ->maxLength(50),
                Forms\Components\TextInput::make('cuil_cuit')
                    ->required()
                    ->maxLength(15),
                Forms\Components\DatePicker::make('fecha_nacimiento')
                    ->required(),
                Forms\Components\TextInput::make('grupo_sanguineo')
                    ->maxLength(10),
                Forms\Components\Textarea::make('domicilio_actual')
                    ->required()
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('telefono')
                    ->tel()
                    ->maxLength(20),
                Forms\Components\TextInput::make('correo_electronico')
                    ->maxLength(150),
                Forms\Components\Select::make('workplace_id')
                    ->relationship('workplace', 'name')
                    ->required(),
                Forms\Components\TextInput::make('numero_despacho')
                    ->numeric(),
                Forms\Components\DatePicker::make('fecha_ingreso')
                    ->required(),
                Forms\Components\TextInput::make('situacion_revista')
                    ->required(),
                Forms\Components\TextInput::make('marca_arma')
                    ->maxLength(100),
                Forms\Components\TextInput::make('numero_arma')
                    ->maxLength(100),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('jobFunction.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('hierarchy.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('apellido')
                    ->searchable(),
                Tables\Columns\TextColumn::make('nombre')
                    ->searchable(),
                Tables\Columns\TextColumn::make('dni')
                    ->searchable(),
                Tables\Columns\TextColumn::make('legajo')
                    ->searchable(),
                Tables\Columns\TextColumn::make('cuil_cuit')
                    ->searchable(),
                Tables\Columns\TextColumn::make('fecha_nacimiento')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('grupo_sanguineo')
                    ->searchable(),
                Tables\Columns\TextColumn::make('telefono')
                    ->searchable(),
                Tables\Columns\TextColumn::make('correo_electronico')
                    ->searchable(),
                Tables\Columns\TextColumn::make('workplace.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('numero_despacho')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('fecha_ingreso')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('situacion_revista'),
                Tables\Columns\TextColumn::make('marca_arma')
                    ->searchable(),
                Tables\Columns\TextColumn::make('numero_arma')
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('deleted_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
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
            'index' => Pages\ListAgents::route('/'),
            'create' => Pages\CreateAgent::route('/create'),
            'edit' => Pages\EditAgent::route('/{record}/edit'),
        ];
    }
}
