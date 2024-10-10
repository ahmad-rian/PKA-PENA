<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Terlapor;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\TerlaporResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\TerlaporResource\RelationManagers;
use pxlrbt\FilamentExcel\Actions\Tables\ExportBulkAction;
use Filament\Tables\Filters\Filter;

class TerlaporResource extends Resource
{
    protected static ?string $model = Terlapor::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Card::make()
                    ->schema([

                        Select::make('aduans') // Pastikan nama field sesuai dengan relasi di model
                            ->label('Kode Kasus')
                            ->multiple() // Membolehkan pemilihan beberapa opsi
                            ->relationship('aduans', 'kode_kasus') // Relasi yang digunakan
                            ->placeholder('Pilih Kode Kasus')
                            ->searchable() // Membolehkan pencarian dalam dropdown
                            ->options(function () {
                                return \App\Models\Aduan::pluck('kode_kasus', 'id')->toArray(); // Menampilkan semua opsi dari model
                            }),

                        TextInput::make('nama_terlapor')
                            ->label('Nama Terlapor')
                            ->placeholder('Masukkan Nama Terlapor')
                            ->required()
                            ->maxLength(255),

                        Select::make('usia_terlapor')
                            ->required()
                            ->label('Usia Terlapor')
                            ->options(array_combine(range(0, 99), range(0, 99))) // Menghasilkan opsi dari 0 hingga 99
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
                            ->default('Tidak Diketahui') // Set default value here
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
                            ->rules('regex:/^[A-Z\s]+$/') // Validasi regex untuk memastikan hanya huruf kapital dan spasi
                            ->helperText('Harus diisi dengan huruf kapital semua'),

                        TextInput::make('kab_kota_terlapor')
                            ->label('Kab/Kota Terlapor')
                            ->placeholder('Masukkan Kab/Kota Terlapor')
                            ->required()
                            ->maxLength(255)
                            ->extraAttributes(['class' => 'capitalize-input'])
                            ->rules('regex:/^[A-Z\s]+$/') // Validasi regex untuk memastikan hanya huruf kapital dan spasi
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
                            ->searchable() // Membolehkan pencarian dalam dropdown
                            ->required(), // Menandai bahwa field ini wajib diisi

                    ])
                    ->columns(2),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('aduans.kode_kasus') // Mengakses kolom kode_kasus dari relasi aduans
                    ->label('Kode Kasus')
                    ->formatStateUsing(function ($state) {
                        return nl2br(htmlspecialchars($state));
                    })
                    ->html()
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('nama_terlapor')
                    ->label('Nama Terlapor')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('usia_terlapor')
                    ->label('Usia Terlapor')
                    ->sortable(),

                Tables\Columns\TextColumn::make('jenis_kelamin_terlapor')
                    ->label('Jenis Kelamin')
                    ->sortable(),

                Tables\Columns\TextColumn::make('pendidikan_terlapor')
                    ->label('Pendidikan Terlapor')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('pekerjaan_terlapor')
                    ->label('Pekerjaan Terlapor')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('domisili_terlapor')
                    ->label('Domisili Terlapor')
                    ->sortable(),

                Tables\Columns\TextColumn::make('kab_kota_terlapor')
                    ->label('Kab/Kota Terlapor')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('provinsi_terlapor')
                    ->label('Provinsi Terlapor')
                    ->sortable(),

                Tables\Columns\TextColumn::make('hubungan_terlapor')
                    ->label('Hubungan dengan Korban')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Dibuat Pada')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                // Tables\Columns\TextColumn::make('updated_at')
                //     ->label('Diperbarui Pada')
                //     ->dateTime()
                //     ->sortable()
                //     ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Filter::make('tanggal_masuk')
                    ->label('Tanggal Masuk')
                    ->form([
                        Forms\Components\DatePicker::make('start_date')
                            ->label('Dari Tanggal')
                            ->placeholder('Pilih Tanggal Awal'),
                        Forms\Components\DatePicker::make('end_date')
                            ->label('Sampai Tanggal')
                            ->placeholder('Pilih Tanggal Akhir'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->whereHas('aduans', function (Builder $subQuery) use ($data) {
                                return $subQuery
                                    ->when($data['start_date'], function (Builder $subQuery, $date) {
                                        return $subQuery->whereDate('tanggal_masuk', '>=', $date);
                                    })
                                    ->when($data['end_date'], function (Builder $subQuery, $date) {
                                        return $subQuery->whereDate('tanggal_masuk', '<=', $date);
                                    });
                            });
                    })
                    ->indicateUsing(function (array $data): array {
                        $indicators = [];
                        if ($data['start_date'] ?? null) {
                            $indicators['start_date'] = 'Dari: ' . date('d M Y', strtotime($data['start_date']));
                        }
                        if ($data['end_date'] ?? null) {
                            $indicators['end_date'] = 'Sampai: ' . date('d M Y', strtotime($data['end_date']));
                        }
                        return $indicators;
                    }),
            ])
            ->actions([
                Tables\Actions\ViewAction::make()->label('Lihat'),
                Tables\Actions\EditAction::make()->label('Ubah'),
                Tables\Actions\DeleteAction::make()->label('Hapus'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()->label('Hapus Terpilih'),
                    ExportBulkAction::make()->label('Ekspor Terpilih'),
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
            'index' => Pages\ListTerlapors::route('/'),
            'create' => Pages\CreateTerlapor::route('/create'),
            'edit' => Pages\EditTerlapor::route('/{record}/edit'),
        ];
    }
}
