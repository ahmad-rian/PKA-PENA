<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Pelapor;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\PelaporResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\PelaporResource\RelationManagers;
use pxlrbt\FilamentExcel\Actions\Tables\ExportBulkAction;
use Filament\Tables\Filters\Filter;
use Filament\Forms\Components\DatePicker;


class PelaporResource extends Resource
{
    protected static ?string $model = Pelapor::class;

    protected static ?string $navigationIcon = 'heroicon-o-home';

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
                        TextInput::make('nik_pelapor')
                            ->label('NIK Pelapor')
                            ->rule('digits:16') // Validasi untuk memastikan tepat 16 digit
                            ->reactive()
                            ->placeholder('Masukkan 16 digit NIK')
                            // ->helperText('NIK harus terdiri dari tepat 16 digit.')
                            ->validationMessages([
                                'digits' => 'NIK harus terdiri dari tepat 16 digit.',
                                'required' => 'Kolom NIK Pelapor wajib diisi.',
                                'unique' => 'NIK ini sudah terdaftar.',
                            ]),



                        TextInput::make('nama_pelapor')
                            // ->required()
                            ->label('Nama Pelapor'), // Menambahkan label jika diperlukan
                        TextInput::make('no_hp_pelapor')
                            // ->required()
                            ->label('Nomor Handphone Pelapor'),

                    ])
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
                TextColumn::make('nik_pelapor')->label('NIK Pelapor')->sortable()->searchable(),
                TextColumn::make('nama_pelapor')->label('Nama  Pelapor')->sortable()->searchable(),
                TextColumn::make('no_hp_pelapor')->label('No Handphone Pelapor')->sortable()->searchable(),
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
            'index' => Pages\ListPelapors::route('/'),
            'create' => Pages\CreatePelapor::route('/create'),
            'edit' => Pages\EditPelapor::route('/{record}/edit'),
        ];
    }
}
