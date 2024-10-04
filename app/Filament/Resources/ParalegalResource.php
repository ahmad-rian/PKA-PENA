<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use App\Models\Paralegal;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Card;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\ParalegalResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\ParalegalResource\RelationManagers;

class ParalegalResource extends Resource
{
    protected static ?string $model = Paralegal::class;

    protected static ?string $navigationIcon = 'heroicon-o-check-badge';

    protected static ?string $navigationGroup = 'Tenaga Ahli';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Card::make()
                    ->schema([
                        TextInput::make('nama_paralegal')
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
                TextColumn::make('nama_paralegal')->label('Nama Pekerjas Sosial')->sortable()->searchable(),
                TextColumn::make('no_hp')->label('No Handphone')->sortable()->searchable(),
                TextColumn::make('email')->label('Gmail')->sortable()->searchable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
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
            'index' => Pages\ListParalegals::route('/'),
            'create' => Pages\CreateParalegal::route('/create'),
            'edit' => Pages\EditParalegal::route('/{record}/edit'),
        ];
    }
}
