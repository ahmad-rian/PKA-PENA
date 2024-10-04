<?php

namespace App\Filament\Resources;

use Filament\Forms;
use App\Models\User;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Resources\Pages\Page;
use Spatie\Permission\Models\Role;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Database\Eloquent\Builder;
use Filament\Resources\Pages\CreateRecord;
use App\Filament\Resources\UserResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\UserResource\RelationManagers;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-s-users';

    protected static ?string $navigationGroup = 'Pengaturan';

    // public static function shouldRegisterNavigation(): bool
    // {
    //     if (auth()->user()->can(user))
    //         return true;
    //     else
    //         return false;
    // }


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Card::make()
                    ->schema([
                        TextInput::make('name')
                            ->required()
                            ->label('Nama'),

                        TextInput::make('email')
                            ->required()
                            ->label('Email')
                            ->email(),

                        Forms\Components\Select::make('roles')
                            ->relationship('roles', 'name')
                            // ->multiple()
                            ->preload()
                            ->searchable(),

                        TextInput::make('password')
                            ->password()
                            ->label('Password')
                            ->nullable() // Izinkan null jika tidak ada input
                            ->dehydrated(fn($state) => filled($state)) // Hanya simpan jika ada input
                            ->required(fn(Page $livewire): bool => $livewire instanceof CreateRecord), // Wajib diisi saat CreateRecord

                        TextInput::make('password_confirmation')
                            ->password()
                            ->label('Confirm Password')
                            ->nullable() // Izinkan null jika tidak ada input
                            ->same('password') // Harus sama dengan 'password'
                            ->required(fn(Page $livewire): bool => $livewire instanceof CreateRecord), // Wajib diisi saat CreateRecord
                    ])
                    ->columns(1),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('Nama User')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('email')
                    ->label('Email')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('roles.name') // Menambahkan kolom roles
                    ->label('Roles')
                    ->sortable()
                    ->searchable(),

            ])
            ->filters([
                // Tambahkan filter jika diperlukan
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                // Tables\Actions\DeleteBulkAction::make(), // Dapat diaktifkan jika diperlukan
            ]);
    }

    public static function getRelations(): array
    {
        return [
            // Tambahkan relasi jika ada
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
