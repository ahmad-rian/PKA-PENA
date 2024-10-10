<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use App\Models\JenisKasus;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Card;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\JenisKasusResource\Pages;
use App\Filament\Resources\JenisKasusResource\RelationManagers;

class JenisKasusResource extends Resource
{
    protected static ?string $model = JenisKasus::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Card::make()
                    ->schema([
                        TextInput::make('jenis_kasus')
                            ->required()
                            ->label('Jenis Kasus'), // Menambahkan label jika diperlukan

                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('jenis_kasus')->label('Jenis Kasus')->sortable()->searchable(),

            ])
            ->filters([
                //
            ])
            ->actions([
                // Tables\Actions\ViewAction::make()->label('Lihat'),
                Tables\Actions\EditAction::make()->label('Ubah'),
                Tables\Actions\DeleteAction::make()->label('Hapus'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()->label('Hapus Terpilih'),
                    // ExportBulkAction::make()->label('Ekspor Terpilih'),
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
            'index' => Pages\ListJenisKasuses::route('/'),
            'create' => Pages\CreateJenisKasus::route('/create'),
            'edit' => Pages\EditJenisKasus::route('/{record}/edit'),
        ];
    }
}
