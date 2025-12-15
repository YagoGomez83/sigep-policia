<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AgentResource\Pages;
use App\Filament\Resources\AgentResource\RelationManagers;
use App\Models\Agent;
use Filament\Forms;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Grid;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class AgentResource extends Resource
{
    protected static ?string $model = Agent::class;

    protected static ?string $modelLabel = 'Agente';
    
    protected static ?string $pluralModelLabel = 'Personal Policial';

    protected static ?string $navigationIcon = 'heroicon-o-user-group';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Datos Personales')
                    ->description('Información personal del agente policial')
                    ->schema([
                        Forms\Components\FileUpload::make('avatar_path')
                            ->label('Foto de Perfil')
                            ->avatar()
                            ->image()
                            ->imageEditor()
                            ->disk('public')
                            ->directory('agent-avatars')
                            ->columnSpanFull(),
                        Grid::make(3)
                            ->schema([
                                Forms\Components\TextInput::make('nombre')
                                    ->label('Nombre')
                                    ->required()
                                    ->maxLength(100),
                                Forms\Components\TextInput::make('apellido')
                                    ->label('Apellido')
                                    ->required()
                                    ->maxLength(100),
                                Forms\Components\TextInput::make('dni')
                                    ->label('DNI')
                                    ->required()
                                    ->maxLength(20)
                                    ->unique(ignoreRecord: true),
                                Forms\Components\TextInput::make('cuil_cuit')
                                    ->label('CUIL')
                                    ->required()
                                    ->maxLength(15)
                                    ->mask('99-99999999-9')
                                    ->placeholder('20-12345678-9'),
                                Forms\Components\DatePicker::make('fecha_nacimiento')
                                    ->label('Fecha de Nacimiento')
                                    ->required()
                                    ->native(false)
                                    ->displayFormat('d/m/Y')
                                    ->maxDate(now()->subYears(18)),
                                Forms\Components\TextInput::make('grupo_sanguineo')
                                    ->label('Grupo Sanguíneo')
                                    ->maxLength(10)
                                    ->placeholder('O+, A-, B+, etc.'),
                                Forms\Components\TextInput::make('telefono')
                                    ->label('Teléfono')
                                    ->tel()
                                    ->maxLength(20)
                                    ->placeholder('11-1234-5678'),
                                Forms\Components\TextInput::make('correo_electronico')
                                    ->label('Email')
                                    ->email()
                                    ->maxLength(150)
                                    ->placeholder('agente@policia.gob.ar'),
                                Forms\Components\Textarea::make('domicilio_actual')
                                    ->label('Domicilio')
                                    ->required()
                                    ->rows(2)
                                    ->columnSpanFull(),
                            ])
                    ])->columns(1),

                Section::make('Datos Institucionales')
                    ->description('Información de destino y situación de revista')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                Forms\Components\TextInput::make('legajo')
                                    ->label('Legajo')
                                    ->required()
                                    ->maxLength(50)
                                    ->unique(ignoreRecord: true)
                                    ->placeholder('Ej: 12345'),
                                Forms\Components\Select::make('hierarchy_id')
                                    ->label('Jerarquía')
                                    ->relationship('hierarchy', 'name')
                                    ->searchable()
                                    ->preload()
                                    ->required()
                                    ->native(false),
                                Forms\Components\Select::make('situacion_revista')
                                    ->label('Situación de Revista')
                                    ->options([
                                        'Activo' => 'Activo',
                                        'Retiro' => 'Retiro',
                                        'Pasiva' => 'Pasiva',
                                        'Baja' => 'Baja',
                                    ])
                                    ->required()
                                    ->default('Activo')
                                    ->native(false),
                                Forms\Components\Select::make('workplace_id')
                                    ->label('Destino')
                                    ->relationship('workplace', 'name')
                                    ->searchable()
                                    ->preload()
                                    ->required()
                                    ->native(false),
                                Forms\Components\Select::make('job_function_id')
                                    ->label('Función')
                                    ->relationship('jobFunction', 'name')
                                    ->searchable()
                                    ->preload()
                                    ->required()
                                    ->native(false),
                                Forms\Components\DatePicker::make('fecha_ingreso')
                                    ->label('Fecha de Ingreso')
                                    ->required()
                                    ->native(false)
                                    ->displayFormat('d/m/Y')
                                    ->maxDate(now()),
                            ])
                    ])->columns(1),

                Section::make('Armamento')
                    ->description('Información del arma asignada')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                Forms\Components\TextInput::make('marca_arma')
                                    ->label('Marca del Arma')
                                    ->maxLength(100)
                                    ->placeholder('Ej: Bersa'),
                                Forms\Components\TextInput::make('numero_arma')
                                    ->label('Número del Arma')
                                    ->maxLength(100)
                                    ->placeholder('Ej: 123456'),
                            ])
                    ])
                    ->collapsed()
                    ->columns(1),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('avatar_path')
                    ->label('Foto')
                    ->circular()
                    ->defaultImageUrl(url('/images/placeholder.png')),
                Tables\Columns\TextColumn::make('legajo')
                    ->label('Legajo')
                    ->searchable()
                    ->sortable()
                    ->weight('bold')
                    ->copyable(),
                Tables\Columns\TextColumn::make('hierarchy.name')
                    ->label('Jerarquía')
                    ->badge()
                    ->color('info')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('apellido')
                    ->label('Apellido')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('nombre')
                    ->label('Nombre')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('workplace.name')
                    ->label('Destino')
                    ->searchable()
                    ->sortable()
                    ->wrap(),
                Tables\Columns\TextColumn::make('situacion_revista')
                    ->label('Situación')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'Activo' => 'success',
                        'Retiro' => 'gray',
                        'Pasiva' => 'warning',
                        'Baja' => 'danger',
                        default => 'gray',
                    })
                    ->sortable(),
                Tables\Columns\TextColumn::make('dni')
                    ->label('DNI')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('jobFunction.name')
                    ->label('Función')
                    ->searchable()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('fecha_ingreso')
                    ->label('Fecha Ingreso')
                    ->date('d/m/Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('telefono')
                    ->label('Teléfono')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
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
                SelectFilter::make('hierarchy_id')
                    ->label('Jerarquía')
                    ->relationship('hierarchy', 'name')
                    ->searchable()
                    ->preload()
                    ->multiple(),
                SelectFilter::make('workplace_id')
                    ->label('Destino')
                    ->relationship('workplace', 'name')
                    ->searchable()
                    ->preload()
                    ->multiple(),
                SelectFilter::make('situacion_revista')
                    ->label('Situación de Revista')
                    ->options([
                        'Activo' => 'Activo',
                        'Retiro' => 'Retiro',
                        'Pasiva' => 'Pasiva',
                        'Baja' => 'Baja',
                    ])
                    ->multiple(),
            ])
            ->actions([
                Tables\Actions\ViewAction::make()
                    ->label('Ver'),
                Tables\Actions\EditAction::make()
                    ->label('Editar'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()
                        ->label('Eliminar seleccionados'),
                ]),
            ])
            ->defaultSort('legajo', 'asc');
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
