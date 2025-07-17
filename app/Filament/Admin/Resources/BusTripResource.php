<?php

namespace App\Filament\Admin\Resources;

use App\Models\BusTrip;
use Filament\Forms;
use Filament\Tables;
use Filament\Resources\Resource;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Pages\CreateRecord;
use Filament\Resources\Pages\EditRecord;
use Filament\Resources\Pages\ListRecords;
use App\Filament\Admin\Resources\BusTripResource\Pages;

class BusTripResource extends Resource
{
    protected static ?string $model = BusTrip::class;
    protected static ?string $navigationIcon = 'heroicon-o-calendar';
    protected static ?string $navigationLabel = 'Bus Trips';
    protected static ?string $pluralModelLabel = 'Bus Trips';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('bus_name')->required(),
            Forms\Components\TextInput::make('origin')->required(),
            Forms\Components\TextInput::make('destination')->required(),
            Forms\Components\DateTimePicker::make('departure_time')->required(),
            Forms\Components\DateTimePicker::make('arrival_time'),
            Forms\Components\TextInput::make('price')->required()->numeric(),
            Forms\Components\TextInput::make('seats_available')->required()->numeric(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('bus_name')->searchable(),
                Tables\Columns\TextColumn::make('origin'),
                Tables\Columns\TextColumn::make('destination'),
                Tables\Columns\TextColumn::make('departure_time'),
                Tables\Columns\TextColumn::make('price'),
                Tables\Columns\TextColumn::make('seats_available'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }


    public static function getPages(): array
    {
        return [
            'index' => Pages\ListBusTrips::route('/'),
            'create' => Pages\CreateBusTrip::route('/create'),
            'edit' => Pages\EditBusTrip::route('/{record}/edit'),
        ];
    }

    public static function shouldRegisterNavigation(): bool
    {
        return false;
    }
}
