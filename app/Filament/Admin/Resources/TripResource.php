<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\TripResource\Pages;
use App\Models\Trip;
use Filament\Forms\Form;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TimePicker;
use Filament\Resources\Resource;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;

class TripResource extends Resource
{
    protected static ?string $model = Trip::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function canAccess(): bool
    {
        return in_array(auth()->user()?->role, ['admin', 'super_admin']);
    }

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
        return $table
            ->columns([
                TextColumn::make('origin')->sortable()->searchable(),
                TextColumn::make('destination')->sortable()->searchable(),
                TextColumn::make('travel_date')->date(),
                TextColumn::make('travel_time'),
                TextColumn::make('bus_name'),
                TextColumn::make('seat_capacity'),
                TextColumn::make('price')->money('PHP'),
                TextColumn::make('created_at')->since(),

                TextColumn::make('available_seats')
                    ->label('Available Seats')
                    ->getStateUsing(fn($record) => $record->seatsAvailable()), // or remove if you have an accessor
            ])
            ->defaultSort('created_at', 'desc')
            ->actions([
                \Filament\Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                \Filament\Tables\Actions\BulkActionGroup::make([
                    \Filament\Tables\Actions\DeleteBulkAction::make(),
                ]),
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
