<?php

namespace App\Filament\Resources\AduanResource\RelationManagers;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Resources\RelationManagers\RelationManager;

class PelaporRelationManager extends RelationManager
{
    protected static string $relationship = 'pelapor';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('aduans')
                    ->label('Kode Kasus')
                    ->placeholder('Pilih Kode Kasus')
                    ->relationship('aduans', 'kode_kasus')
                    ->searchable()
                    ->options(function () {
                        // Retrieve the relevant kode_kasus options based on the current context
                        return \App\Models\Aduan::query()
                            ->where('id', $this->ownerRecord->id) // Adjust this condition as needed
                            ->pluck('kode_kasus', 'id')
                            ->toArray();
                    })
                    ->default(function ($get) {
                        // Set the default value to the kode_kasus of the current record
                        return $this->ownerRecord ? $this->ownerRecord->kode_kasus : null;
                    })
                    ->disabled(),

                TextInput::make('nama_pelapor')
                    // ->required()
                    ->label('Nama Pelapor'), // Menambahkan label jika diperlukan

                TextInput::make('nik_pelapor')
                    ->label('NIK Pelapor')
                    // ->required()
                    ->rule('digits:16') // Validasi untuk memastikan tepat 16 digit
                    ->reactive()
                    ->placeholder('Masukkan 16 digit NIK')
                    // ->helperText('NIK harus terdiri dari tepat 16 digit.')
                    ->validationMessages([
                        'digits' => 'NIK harus terdiri dari tepat 16 digit.',
                        'required' => 'Kolom NIK Pelapor wajib diisi.',
                        'unique' => 'NIK ini sudah terdaftar.',
                    ]),

                TextInput::make('no_hp_pelapor')
                    // ->required()
                    ->label('Nomor Handphone Pelapor'),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('nik_pelapor')
            ->columns([
                Tables\Columns\TextColumn::make('nama_pelapor'),
                Tables\Columns\TextColumn::make('nik_pelapor'),
                Tables\Columns\TextColumn::make('no_hp_pelapor'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
