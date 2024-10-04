<?php

namespace App\Filament\Resources\AduanResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;

class KorbanRelationManager extends RelationManager
{
    protected static string $relationship = 'korban';

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
                    ->disabled(), // If you want to disable this field to prevent changes



                TextInput::make('nama_korban')
                    ->required()
                    ->label('Nama Korban')
                    ->placeholder('Masukkan Nama Korban'),

                Select::make('usia_korban')
                    // ->required()
                    ->label('Usia Korban')
                    ->options(array_combine(range(0, 17), range(0, 17))) // Menghasilkan opsi dari 0 hingga 17
                    ->placeholder('Pilih Usia Korban')
                    ->searchable(),

                Select::make('jenis_kelamin_korban')
                    ->required()
                    ->label('Jenis Kelamin Korban')
                    ->options([
                        'Laki-laki' => 'Laki-laki',
                        'Perempuan' => 'Perempuan',
                        'Tidak Diketahui' => 'Tidak Diketahui',
                    ])
                    ->placeholder('Pilih Jenis Kelamin')
                    ->searchable(),

                Select::make('provinsi_korban')
                    ->required()
                    ->label('Provinsi Korban')
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
                    ->searchable()
                    ->placeholder('Pilih Provinsi'),

                Select::make('disabilitas_korban')
                    ->label('Disabilitas Korban')
                    ->options([
                        'Tidak' => 'Tidak',
                        'Disabilitas Fisik' => 'Disabilitas Fisik',
                        'Disabilitas Intelektual' => 'Disabilitas Intelektual',
                        'Disabilitas Mental' => 'Disabilitas Mental',
                        'Disabilitas Sensorik' => 'Disabilitas Sensorik',
                        'Disabilitas Ganda' => 'Disabilitas Ganda',
                    ])
                    ->placeholder('Pilih Disabilitas Korban')
                    ->required() // Pastikan field ini diperlukan
                    ->default('Tidak'), // Atur nilai default jika tidak ada pilihan

                Select::make('pendidikan_korban')
                    ->label('Pendidikan Korban')
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
                    ->required()
                    ->placeholder('Pilih Pendidikan')
                    ->searchable(),

                TextInput::make('pekerjaan_korban')
                    ->label('Pekerjaan Korban')
                    ->required()
                    ->placeholder('Masukkan Pekerjaan Korban'),

                TextInput::make('domisili_korban')
                    ->label('Domisili Korban')
                    ->placeholder('Masukkan Domisili Korban')
                    ->extraAttributes(['class' => 'capitalize-input'])
                    ->required() // Pastikan field ini diperlukan
                    ->rules('regex:/^[A-Z\s]+$/') // Validasi regex untuk memastikan hanya huruf kapital dan spasi
                    ->helperText('Harus diisi dengan huruf kapital semua'),

                TextInput::make('kab_kota_korban')
                    ->label('Kab/Kota Korban')
                    ->placeholder('Masukkan Kab/Kota Korban')
                    ->extraAttributes(['class' => 'capitalize-input'])
                    ->required() // Pastikan field ini diperlukan
                    ->rules('regex:/^[A-Z\s]+$/') // Validasi regex untuk memastikan hanya huruf kapital dan spasi
                    ->helperText('Harus diisi dengan huruf kapital semua'),
            ])
            ->columns(2);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('nama_korban')
            ->columns([
                Tables\Columns\TextColumn::make('nama_korban'),
                Tables\Columns\TextColumn::make('usia_korban'),
                Tables\Columns\TextColumn::make('jenis_kelamin_korban'),
                Tables\Columns\TextColumn::make('pendidikan_korban'),
                Tables\Columns\TextColumn::make('domisili_korban'),
                Tables\Columns\TextColumn::make('kab_kota_korban'),
                Tables\Columns\TextColumn::make('provinsi_korban'),
            ])
            ->filters([
                // Tambahkan filter jika diperlukan
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
