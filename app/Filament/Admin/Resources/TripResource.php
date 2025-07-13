<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\TripResource\Pages;
use App\Filament\Admin\Resources\TripResource\RelationManagers;
use App\Models\Trip;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TimePicker;
use Filament\Tables\Columns\TextColumn;

class TripResource extends Resource
{
    protected static ?string $model = Trip::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('origin')->required(),
        TextInput::make('destination')->required(),
        DatePicker::make('travel_date')->required(),
        TimePicker::make('travel_time')->required(),
        TextInput::make('bus_name')->required(),
        TextInput::make('seat_capacity')->numeric()->required(),
        TextInput::make('price')->numeric()->required(),
                
            ]);
    }
     // ✅ Add this method to restrict access to Super Admin
         public static function canAccess(): bool
    { 
            return auth()->user()?->role === 'admin';  
    }
    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('origin'),
                TextColumn::make('destination'),
                TextColumn::make('departure_date')->date(),
                TextColumn::make('departure_time')->time('h:i A'),
                TextColumn::make('bus_name'),
                TextColumn::make('seat_capacity'),
                TextColumn::make('price')->money('PHP'),
                TextColumn::make('created_at')->label('Created')->since(),
                 
                
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                //
            ])
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
        return [
            //
        ];
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
