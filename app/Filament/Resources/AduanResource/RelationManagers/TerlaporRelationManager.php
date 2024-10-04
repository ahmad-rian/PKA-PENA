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

class TerlaporRelationManager extends RelationManager
{
    protected static string $relationship = 'terlapor';

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

                TextInput::make('nama_terlapor')
                    ->label('Nama Terlapor')
                    ->placeholder('Masukkan Nama Terlapor')
                    ->required()
                    ->maxLength(255),

                Select::make('usia_terlapor')
                    ->label('Usia Terlapor')
                    ->required()
                    ->options(array_combine(range(0, 99), range(0, 99)))
                    ->placeholder('Pilih Usia Terlapor')
                    ->searchable(),

                Select::make('jenis_kelamin_terlapor')
                    ->label('Jenis Kelamin Terlapor')
                    ->options([
                        'Laki-laki' => 'Laki-laki',
                        'Perempuan' => 'Perempuan',
                        'Tidak Diketahui' => 'Tidak Diketahui',
                    ])
                    ->placeholder('Pilih Jenis Kelamin Terlapor')
                    ->required()
                    ->searchable(),

                Select::make('pendidikan_terlapor')
                    ->label('Pendidikan Terlapor')
                    ->options([
                        'SD/MI' => 'SD/MI',
                        'SMP/MTS' => 'SMP/MTS',
                        'SMA/MA/SMK' => 'SMA/MA/SMK',
                        'D1/D2/D3/D4' => 'D1/D2/D3/D4',
                        'S1' => 'S1',
                        'S2' => 'S2',
                        'S3' => 'S3',
                        'Tidak Diketahui' => 'Tidak Diketahui',
                        'Tidak Sekolah' => 'Tidak Sekolah',
                        'PAUD' => 'PAUD',
                        'TK' => 'TK',
                        'Lainnya' => 'Lainnya',
                        'SLB' => 'SLB',
                    ])
                    ->placeholder('Pilih Pendidikan Terlapor')
                    ->required()
                    ->searchable(),

                TextInput::make('pekerjaan_terlapor')
                    ->label('Pekerjaan Terlapor')
                    ->placeholder('Masukkan Pekerjaan Terlapor')
                    ->required()
                    ->maxLength(255),

                TextInput::make('domisili_terlapor')
                    ->label('Domisili Terlapor')
                    ->placeholder('Masukkan Domisili Terlapor')
                    ->required()
                    ->maxLength(255)
                    ->extraAttributes(['class' => 'capitalize-input'])
                    ->rules('regex:/^[A-Z\s]+$/')
                    ->helperText('Harus diisi dengan huruf kapital semua'),

                TextInput::make('kab_kota_terlapor')
                    ->label('Kab/Kota Terlapor')
                    ->placeholder('Masukkan Kab/Kota Terlapor')
                    ->required()
                    ->maxLength(255)
                    ->extraAttributes(['class' => 'capitalize-input'])
                    ->rules('regex:/^[A-Z\s]+$/')
                    ->helperText('Harus diisi dengan huruf kapital semua'),

                Select::make('provinsi_terlapor')
                    ->label('Provinsi Terlapor')
                    ->options([
                        'Bali' => 'Bali',
                        'Banten' => 'Banten',
                        'Bengkulu' => 'Bengkulu',
                        'DI Yogyakarta' => 'DI Yogyakarta',
                        'DKI Jakarta' => 'DKI Jakarta',
                        'Gorontalo' => 'Gorontalo',
                        'Jambi' => 'Jambi',
                        'Jawa Barat' => 'Jawa Barat',
                        'Jawa Tengah' => 'Jawa Tengah',
                        'Jawa Timur' => 'Jawa Timur',
                        'Kalimantan Barat' => 'Kalimantan Barat',
                        'Kalimantan Selatan' => 'Kalimantan Selatan',
                        'Kalimantan Tengah' => 'Kalimantan Tengah',
                        'Kalimantan Timur' => 'Kalimantan Timur',
                        'Kalimantan Utara' => 'Kalimantan Utara',
                        'Kepulauan Bangka Belitung' => 'Kepulauan Bangka Belitung',
                        'Kepulauan Riau' => 'Kepulauan Riau',
                        'Lampung' => 'Lampung',
                        'Luar Negeri' => 'Luar Negeri',
                        'Maluku' => 'Maluku',
                        'Maluku Utara' => 'Maluku Utara',
                        'Nanggroe Aceh Darussalam' => 'Nanggroe Aceh Darussalam',
                        'Nusa Tenggara Barat' => 'Nusa Tenggara Barat',
                        'Nusa Tenggara Timur' => 'Nusa Tenggara Timur',
                        'Papua' => 'Papua',
                        'Papua Barat' => 'Papua Barat',
                        'Papua Barat Daya' => 'Papua Barat Daya',
                        'Papua Pegunungan' => 'Papua Pegunungan',
                        'Papua Selatan' => 'Papua Selatan',
                        'Riau' => 'Riau',
                        'Sulawesi Barat' => 'Sulawesi Barat',
                        'Sulawesi Selatan' => 'Sulawesi Selatan',
                        'Sulawesi Tengah' => 'Sulawesi Tengah',
                        'Sulawesi Tenggara' => 'Sulawesi Tenggara',
                        'Sulawesi Utara' => 'Sulawesi Utara',
                        'Sumatera Barat' => 'Sumatera Barat',
                        'Sumatera Selatan' => 'Sumatera Selatan',
                        'Sumatera Utara' => 'Sumatera Utara',
                    ])
                    ->placeholder('Pilih Provinsi Terlapor')
                    ->required()
                    ->searchable(),

                Select::make('hubungan_terlapor')
                    ->label('Hubungan Terlapor dengan Korban')
                    ->options([
                        'Orang Tua' => 'Orang Tua',
                        'Ayah Kandung' => 'Ayah Kandung',
                        'Ayah Tiri' => 'Ayah Tiri',
                        'Ibu Kandung' => 'Ibu Kandung',
                        'Ibu Tiri' => 'Ibu Tiri',
                        'Keluarga/Saudara' => 'Keluarga/Saudara',
                        'Tetangga' => 'Tetangga',
                        'Kakek/Nenek' => 'Kakek/Nenek',
                        'Teman Sebaya' => 'Teman Sebaya',
                        'Berkenalan Online' => 'Berkenalan Online',
                        'Orang tidak dikenal' => 'Orang tidak dikenal',
                        'Aparat Penegak Hukum' => 'Aparat Penegak Hukum',
                        'Tenaga Pendidik' => 'Tenaga Pendidik',
                        'Tokoh Masyarakat' => 'Tokoh Masyarakat',
                        'Tokoh Agama' => 'Tokoh Agama',
                        'Majikan/Atasan' => 'Majikan/Atasan',
                        'Pacar/Mantan Pacar' => 'Pacar/Mantan Pacar',
                        'Lainnya' => 'Lainnya',
                    ])
                    ->placeholder('Pilih Hubungan Terlapor dengan Korban')
                    ->searchable()
                    ->required(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('nama_terlapor')
            ->columns([
                Tables\Columns\TextColumn::make('nama_terlapor'),
                Tables\Columns\TextColumn::make('usia_terlapor'),
                Tables\Columns\TextColumn::make('jenis_kelamin_terlapor'),
                Tables\Columns\TextColumn::make('hubungan_terlapor'),
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
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }
}
