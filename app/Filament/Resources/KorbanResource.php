<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Korban;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables\Actions\ExportBulkAction;
use App\Filament\Resources\KorbanResource\Pages;
use Filament\Tables\Filters\Filter;
use Filament\Forms\Components\DatePicker;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\KorbanResource\RelationManagers;

class KorbanResource extends Resource
{
    protected static ?string $model = Korban::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Card::make()
                    ->schema([
                        Select::make('aduans')
                            ->label('Kode Kasus')
                            ->multiple()
                            ->relationship('aduans', 'kode_kasus')
                            ->placeholder('Pilih Kode Kasus')
                            ->searchable()
                            ->options(function () {
                                return \App\Models\Aduan::pluck('kode_kasus', 'id')->toArray();
                            }),

                        TextInput::make('nama_korban')
                            ->required()
                            ->label('Nama Korban')
                            ->placeholder('Masukkan Nama Korban'),

                        Select::make('usia_korban')
                            // ->required()
                            ->label('Usia Korban')
                            ->options(array_combine(range(0, 17), range(0, 17)))
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
                            ->required()
                            ->default('Tidak'),

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
                            ->required()
                            ->rules('regex:/^[A-Z\s]+$/')
                            ->helperText('Harus diisi dengan huruf kapital semua'),

                        TextInput::make('kab_kota_korban')
                            ->label('Kab/Kota Korban')
                            ->placeholder('Masukkan Kab/Kota Korban')
                            ->extraAttributes(['class' => 'capitalize-input'])
                            ->required()
                            ->rules('regex:/^[A-Z\s]+$/')
                            ->helperText('Harus diisi dengan huruf kapital semua'),
                    ])
                    ->columns(2)
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('aduans.kode_kasus')
                    ->label('Kode Kasus')
                    ->formatStateUsing(function ($state) {
                        return nl2br(htmlspecialchars($state));
                    })
                    ->html()
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('nama_korban')
                    ->label('Nama Korban')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('usia_korban')
                    ->label('Usia Korban')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('jenis_kelamin_korban')
                    ->label('Jenis Kelamin Korban')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('provinsi_korban')
                    ->label('Provinsi Korban')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('disabilitas_korban')
                    ->label('Disabilitas Korban')
                    ->searchable()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('pendidikan_korban')
                    ->label('Pendidikan Korban')
                    ->searchable()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('pekerjaan_korban')
                    ->label('Pekerjaan Korban')
                    ->searchable()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('domisili_korban')
                    ->label('Domisili Korban')
                    ->searchable()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('kab_kota_korban')
                    ->label('Kab/Kota Korban')
                    ->searchable()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
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
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    ExportBulkAction::make(),
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
            'index' => Pages\ListKorbans::route('/'),
            'create' => Pages\CreateKorban::route('/create'),
            'view' => Pages\ViewKorban::route('/{record}'),
            'edit' => Pages\EditKorban::route('/{record}/edit'),
        ];
    }
}
