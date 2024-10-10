<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Aduan;
use App\Models\Korban;
use App\Models\Layanan;
use App\Models\Pelapor;
use Filament\Forms\Form;
use App\Models\jenisKasus;
use Filament\Tables\Table;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Infolists\Components;
use Filament\Forms\Components\Card;
use Filament\Tables\Grouping\Group;
use Filament\Forms\Components\Select;
use App\Filament\Exports\AduanExporter;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Filament\Tables\Actions\ExportAction;
use Illuminate\Database\Eloquent\Builder;
use Filament\Infolists\Components\Section;
use App\Filament\Resources\AduanResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\AduanResource\RelationManagers;
use App\Filament\Resources\AduanResource\RelationManagers\KorbanRelationManager;
use App\Filament\Resources\AduanResource\RelationManagers\PelaporRelationManager;
use App\Filament\Resources\AduanResource\RelationManagers\TerlaporRelationManager;
use App\Filament\Resources\AduanResource\RelationManagers\JeniskasusRelationManager;
use App\Filament\Resources\AduanResource\RelationManagers\JenislayananRelationManager;
use pxlrbt\FilamentExcel\Actions\Tables\ExportBulkAction;
use Filament\Tables\Filters\Filter;

class AduanResource extends Resource
{
    protected static ?string $model = Aduan::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Card::make()
                    ->schema([
                        TextInput::make('kode_kasus')
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->label('Kode Kasus')
                            ->placeholder('Masukkan Kode Kasus'),

                        Select::make('jeniskasus')
                            ->required()
                            ->multiple()
                            ->label('Jenis Kasus')
                            ->relationship('jeniskasus', 'jenis_kasus')
                            ->placeholder('Pilih Jenis Kasus')
                            ->searchable()
                            ->options(function () {
                                return \App\Models\JenisKasus::pluck('jenis_kasus', 'id')->toArray();
                            }),

                        Select::make('jenislayanan')
                            ->required()
                            ->multiple()
                            ->label('Jenis Layanan')
                            ->relationship('jenislayanan', 'jenis_layanan')
                            ->placeholder('Pilih Layanan')
                            ->searchable()
                            ->options(function () {
                                return \App\Models\Layanan::pluck('jenis_layanan', 'id')->toArray();
                            }),

                        Select::make('kanal_pengaduan')
                            ->required()
                            ->label('Kanal Pengaduan')
                            ->options([
                                'NON ADUAN - LAPORAN MEDIA' => 'NON ADUAN - LAPORAN MEDIA',
                                'PENGADUAN LANGSUNG' => 'PENGADUAN LANGSUNG',
                                'SAPA 129 - HOTLINE WA' => 'SAPA 129 - HOTLINE WA',
                                'SAPA 129 - TELEPON' => 'SAPA 129 - TELEPON',
                                'SP4N LAPOR' => 'SP4N LAPOR',
                                'SURAT' => 'SURAT',
                                'Mobile Apps' => 'Mobile Apps',
                            ])
                            ->placeholder('Pilih Kanal Pengaduan')
                            ->searchable(),

                        DatePicker::make('tanggal_masuk')
                            ->required()
                            ->label('Tanggal Masuk')
                            ->placeholder('Pilih Tanggal Masuk'),

                        DatePicker::make('tanggal_kejadian')
                            ->required()
                            ->label('Tanggal Kejadian')
                            ->placeholder('Pilih Tanggal Kejadian'),

                        Select::make('tempat_kejadian')
                            ->required()
                            ->label('Tempat Kejadian')
                            ->options([
                                'Rumah Tangga' => 'Rumah Tangga',
                                'Tempat Kerja' => 'Tempat Kerja',
                                'Sekolah' => 'Sekolah',
                                'Fasilitas Umum' => 'Fasilitas Umum',
                                'Lembaga Pendidikan' => 'Lembaga Pendidikan',
                                'Lembaga Pendidikan Kilat' => 'Lembaga Pendidikan Kilat',
                                'Lainnya' => 'Lainnya',
                            ])
                            ->placeholder('Pilih Tempat Kejadian')
                            ->searchable(),

                        Select::make('kewenangan')
                            ->required()
                            ->label('Kewenangan')
                            ->options([
                                'daerah' => 'Daerah',
                                'pusat' => 'Pusat',
                            ])
                            ->searchable()
                            ->placeholder('Pilih Kewenangan'),

                        Select::make('provinsi_kejadian')
                            ->required()
                            ->label('Provinsi Kejadian')
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

                        TextInput::make('sumber_tambahan')
                            ->nullable()
                            ->label('Sumber Tambahan')
                            ->placeholder('Masukkan Sumber Tambahan'),

                        Textarea::make('kronologi_singkat')
                            ->nullable()
                            ->label('Kronologi Singkat')
                            ->placeholder('Masukkan Kronologi Singkat'),

                        Select::make('manajer_id')
                            ->label('Manajer Kasus')
                            ->relationship('manajer', 'nama_mk')
                            ->placeholder('Pilih Manajer Kasus'),

                        Select::make('advokat_id')
                            ->label('Advokat')
                            ->relationship('advokat', 'nama_advokat')
                            ->placeholder('Pilih Advokat'),

                        Select::make('peksos_id')
                            ->label('Pekerja Sosial')
                            ->relationship('peksos', 'nama_peksos')
                            ->placeholder('Pilih Pekerja Sosial'),

                        Select::make('psikolog_id')
                            ->label('Psikolog')
                            ->relationship('psikolog', 'nama_psikolog')
                            ->placeholder('Pilih Psikolog'),

                        Select::make('konselor_id')
                            ->label('Konselor')
                            ->relationship('konselor', 'nama_konselor')
                            ->placeholder('Pilih Konselor'),

                        Select::make('paralegal_id')
                            ->label('Paralegal')
                            ->relationship('paralegal', 'nama_paralegal')
                            ->placeholder('Pilih Paralegal'),

                    ])
                    ->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('jenis_kasus')
            ->columns([
                Tables\Columns\TextColumn::make('kode_kasus')
                    ->label('Kode Kasus')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('tanggal_masuk')
                    ->label('Tanggal Masuk')
                    ->date()
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('tanggal_kejadian')
                    ->label('Tanggal Kejadian')
                    ->date()
                    ->searchable()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('jeniskasus.jenis_kasus')
                    ->label('Jenis Kasus')
                    ->formatStateUsing(function ($state) {
                        return nl2br(htmlspecialchars($state));
                    })
                    ->html()
                    ->searchable()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('kanal_pengaduan')
                    ->label('Kanal Pengaduan')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('kewenangan')
                    ->label('Kewenangan')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('provinsi_kejadian')
                    ->label('Provinsi Kejadian')
                    ->searchable()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('manajer.nama_mk')
                    ->label('Manajer Kasus')
                    ->searchable()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('advokat.nama_advokat')
                    ->label('Advokat')
                    ->searchable()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('psikolog.nama_psikolog')
                    ->label('Psikolog')
                    ->searchable()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('peksos.nama_peksos')
                    ->label('Pekerja Sosial')
                    ->searchable()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('konselor.nama_konselor')
                    ->label('Konselor')
                    ->searchable()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('paralegal.nama_paralegal')
                    ->label('Paralegal')
                    ->searchable()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('korban.nama_korban')
                    ->label('Korban')
                    ->searchable()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('terlapor.nama_terlapor')
                    ->label('Terlapor')
                    ->searchable()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('pelapor.nama_pelapor')
                    ->label('Pelapor')
                    ->searchable()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('tanggal_masuk', 'desc')
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
                    ->query(function (Builder $query, array $data) {
                        return $query
                            ->when($data['start_date'] ?? null, function ($query, $date) {
                                return $query->whereDate('tanggal_masuk', '>=', $date);
                            })
                            ->when($data['end_date'] ?? null, function ($query, $date) {
                                return $query->whereDate('tanggal_masuk', '<=', $date);
                            });
                    })
                    ->indicateUsing(function (array $data): array {
                        $indicators = [];
                        if (!empty($data['start_date'])) {
                            $indicators['start_date'] = 'Dari: ' . date('d M Y', strtotime($data['start_date']));
                        }
                        if (!empty($data['end_date'])) {
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
            KorbanRelationManager::class,
            TerlaporRelationManager::class,
            PelaporRelationManager::class
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAduans::route('/'),
            'create' => Pages\CreateAduan::route('/create'),
            'view' => Pages\ViewAduan::route('/{record}'),
            'edit' => Pages\EditAduan::route('/{record}/edit'),
        ];
    }
}
