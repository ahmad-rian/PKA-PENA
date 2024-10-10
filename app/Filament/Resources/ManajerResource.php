<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Manajer;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Card;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use App\Filament\Resources\ManajerResource\Pages;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\ManajerResource\RelationManagers;

class ManajerResource extends Resource
{
    protected static ?string $model = Manajer::class;

    protected static ?string $navigationIcon = 'heroicon-o-check-badge';

    protected static ?string $navigationGroup = 'Tenaga Ahli';

    public static function shouldRegisterNavigation(): bool
    {
        return auth()->user()->can('manajer');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Card::make()
                    ->schema([
                        TextInput::make('nama_mk')
                            ->required()
                            ->label('Nama Manajer Kasus'), // Improved label for clarity

                        TextInput::make('no_hp')
                            ->required()
                            ->label('Nomor Handphone'),

                        TextInput::make('email')
                            ->required()
                            ->email() // Menambahkan validasi email
                            ->label('Email')
                            ->unique() // Validasi untuk memastikan email belum ada di database
                            // ->validationRules([
                            //     'email' => 'required|email|unique:table_name,email', // Ganti 'table_name' dengan nama tabel yang sesuai
                            // ])
                            ->validationMessages([
                                'email.unique' => 'Email sudah digunakan. Silakan pilih email lain.',
                            ]),

                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('nama_mk')
                    ->label('Nama Manajer Kasus')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('no_hp')
                    ->label('Nomor Handphone')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('email')
                    ->label('Email')
                    ->sortable()
                    ->searchable(),
            ])
            ->filters([
                // Add filters if necessary
            ])
            ->actions([
                Tables\Actions\EditAction::make()->label('Ubah'),
                Tables\Actions\DeleteAction::make()->label('Hapus'),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make()->label('Hapus Terpilih'),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            // Add relations if necessary
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListManajers::route('/'),
            'create' => Pages\CreateManajer::route('/create'),
            'edit' => Pages\EditManajer::route('/{record}/edit'),
        ];
    }
}
