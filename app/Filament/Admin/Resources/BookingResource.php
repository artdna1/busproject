<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\BookingResource\Pages;
use App\Filament\Admin\Resources\BookingResource\RelationManagers;
use App\Models\Booking;
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
use Filament\Forms\Components\Select;
use App\Models\User;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;

class BookingResource extends Resource
{
    protected static ?string $model = Booking::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('user_id')
                    ->label('Booked By')
                    ->relationship('user', 'name') // assumes 'name' column exists
                    ->searchable()
                    ->required(),

                TextInput::make('origin')->required(),
                TextInput::make('destination')->required(),
                DatePicker::make('travel_date')->required(),
                TimePicker::make('travel_time')->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user.name')->label('User'),
                TextColumn::make('origin'),
                TextColumn::make('destination'),
                TextColumn::make('travel_date')->date(),
                TextColumn::make('travel_time')->time('h:i A'),
                TextColumn::make('status') // 🟡 Only include if you have a `status` column
                    ->badge()
                    ->colors([
                        'success' => 'Confirmed',
                        'warning' => 'Pending',
                        'danger' => 'Cancelled',
                    ]),
                TextColumn::make('created_at')->label('Booked At')->since(),
            ])

            ->filters([
                // Example filter: only show bookings in the future
                Filter::make('Future Bookings')
                    ->query(fn($query) => $query->where('travel_date', '>=', now()->toDateString())),
                Tables\Filters\SelectFilter::make('origin')
                    ->options(fn() => Booking::pluck('origin', 'origin')->unique())
                    ->label('Origin'),
            ])
            ->defaultSort('created_at', 'desc')

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
            'index' => Pages\ListBookings::route('/'),
            'create' => Pages\CreateBooking::route('/create'),
            'edit' => Pages\EditBooking::route('/{record}/edit'),
        ];
    }
}
