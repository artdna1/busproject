<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\TripResource\Pages;
use App\Models\Trip;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Tables;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TimePicker;
use Filament\Tables\Columns\TextColumn;

class TripResource extends Resource
{
    protected static ?string $model = Trip::class;
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationLabel = 'Trips'; // 👈 Shows "Trips" in sidebar
    protected static ?string $navigationGroup = null;     // 👈 Optional: no group
    protected static ?int $navigationSort = 1;            // 👈 Optional: top order
    public static function form(Form $form): Form
    {
        return $form->schema([
            TextInput::make('origin')->required(),
            TextInput::make('destination')->required(),
            DatePicker::make('travel_date')->required(),
            TimePicker::make('travel_time')->required(),
            TextInput::make('bus_name')->required(),
            TextInput::make('seat_capacity')->numeric()->required(),
            TextInput::make('price')->numeric()->required(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            TextColumn::make('origin')->sortable()->searchable(),
            TextColumn::make('destination')->sortable()->searchable(),
            TextColumn::make('travel_date')->date(),
            TextColumn::make('travel_time'),
            TextColumn::make('bus_name'),
            TextColumn::make('seat_capacity'),
            TextColumn::make('price')->money('PHP'),
            TextColumn::make('created_at')->since(),
        ])
            ->defaultSort('created_at', 'desc')
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTrips::route('/'),
            'create' => Pages\CreateTrip::route('/create'),
            'edit' => Pages\EditTrip::route('/{record}/edit'),
        ];
    }
}
