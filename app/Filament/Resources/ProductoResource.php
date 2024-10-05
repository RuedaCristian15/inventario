<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductoResource\Pages;
use App\Filament\Resources\ProductoResource\RelationManagers;
use App\Models\Producto;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Tables\Filters\SelectFilter;

class ProductoResource extends Resource
{
    protected static ?string $model = Producto::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-circle';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('nombre')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('descripcion')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('stock')
                    ->numeric()
                    ->default(0)
                    ->formatStateUsing(fn($state) => $state !== null ? $state : 0),
                Forms\Components\TextInput::make('preciocompra')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('precioventa')
                    ->required()
                    ->numeric(),
                Forms\Components\Select::make(name: 'id_proveedor')
                    ->relationship('Proveedores', 'nombre')
                    ->required()
                    ->searchable()
                    ->preload(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nombre')
                    ->searchable(),
                Tables\Columns\TextColumn::make('descripcion')
                    ->searchable(),
                Tables\Columns\TextColumn::make('stock')
                    ->numeric()
                    ->sortable()
                    ->default(0)
                    ->formatStateUsing(fn($state) => $state !== null ? $state : 0),
                Tables\Columns\TextColumn::make('preciocompra')
                    ->numeric()
                    ->sortable()
                    ->prefix('$'),
                Tables\Columns\TextColumn::make('precioventa')
                    ->numeric()
                    ->sortable()
                    ->prefix('$'),
                Tables\Columns\TextColumn::make('Proveedores.nombre')
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('id_proveedor')
                    ->relationship('Proveedores', 'nombre')
                    ->label('Proveedores')
                    ->preload(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
              /*   Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]), */
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }
    /*  */
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProductos::route('/'),
            'create' => Pages\CreateProducto::route('/create'),
            'edit' => Pages\EditProducto::route('/{record}/edit'),
        ];
    }
}
