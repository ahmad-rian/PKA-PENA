<?php

namespace App\Filament\Resources\AduanResource\RelationManagers;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class JeniskasusRelationManager extends RelationManager
{
    protected static string $relationship = 'jenisKasus'; // Sesuaikan dengan nama relasi yang benar

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('jenis_kasus')
                    ->required()
                    ->maxLength(255)
                    ->aside()
                    ->label('Jenis Kasus'), // Tambahkan label jika diperlukan
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('jenis_kasus')
            ->columns([
                TextColumn::make('jenis_kasus')
                    ->label('name')
                    ->sortable()
            ])
            ->filters([
                // Tambahkan filter jika diperlukan
            ])
            ->headerActions([
                // Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                // Tables\Actions\EditAction::make(),
                // Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
