<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Advokat;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Card;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\AdvokatResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\AdvokatResource\RelationManagers;

class AdvokatResource extends Resource
{
    protected static ?string $model = Advokat::class;

    protected static ?string $navigationIcon = 'heroicon-o-check-badge';

    protected static ?string $navigationGroup = 'Tenaga Ahli';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Card::make()
                    ->schema([
                        TextInput::make('nama_advokat')
                            ->required()
                            ->label('Nama'), // Menambahkan label jika diperlukan
                        TextInput::make('no_hp')
                            ->required()
                            ->label('Nomor Handphone'), // Menambahkan label jika diperlukan
                        TextInput::make('email')
                            ->required()
                            ->email() // Menambahkan validasi email jika diperlukan
                            ->label('Email') // Menambahkan label jika diperlukan
                            ->unique()
                            ->validationMessages([
                                'email.unique' => 'Email sudah digunakan. Silakan pilih email lain.',
                            ]),
                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('nama_advokat')->label('Nama Advokat')->sortable()->searchable(),
                TextColumn::make('no_hp')->label('No Handphone')->sortable()->searchable(),
                TextColumn::make('email')->label('Gmail')->sortable()->searchable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                // Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make()->label('Ubah'),
                Tables\Actions\DeleteAction::make()->label('Hapus'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()->label('Hapus Terpilih'),
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
            'index' => Pages\ListAdvokats::route('/'),
            'create' => Pages\CreateAdvokat::route('/create'),
            'edit' => Pages\EditAdvokat::route('/{record}/edit'),
        ];
    }
}
