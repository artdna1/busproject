<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\TripResource\Pages;
use App\Models\Trip;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TimePicker;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;

class TripResource extends Resource
{
    protected static ?string $model = Trip::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    /**
     * Only allow admins to access this resource.
     */
    public static function canAccess(): bool
    {
        return auth()->user()?->role === 'admin';
    }

    /**
     * Trip form schema for create/edit pages.
     */
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

    /**
     * Trip table listing in admin.
     */
    public static function table(Table $table): Table
    {
        return $table
            ->columns([
              Tables\Columns\TextColumn::make('origin')->sortable()->searchable(),
            Tables\Columns\TextColumn::make('destination')->sortable()->searchable(),
            Tables\Columns\TextColumn::make('travel_date')->date(),
            Tables\Columns\TextColumn::make('travel_time'),
            Tables\Columns\TextColumn::make('bus_name'),
            Tables\Columns\TextColumn::make('seat_capacity'),
            Tables\Columns\TextColumn::make('price')->money('PHP'),
            Tables\Columns\TextColumn::make('created_at')->since(),

            // 👇 This is what you add
            Tables\Columns\TextColumn::make('available_seats')
                ->label('Available Seats')
               
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
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
