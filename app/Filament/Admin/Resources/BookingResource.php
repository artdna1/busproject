<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\BookingResource\Pages;
use App\Models\Booking;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TimePicker;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Forms\Components\Radio;

class BookingResource extends Resource
{
    protected static ?string $model = Booking::class;
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('trip_id')
                    ->label('Trip')
                    ->relationship('trip', 'bus_name') // Adjust this if the label isn't bus_name
                    ->searchable()
                    ->required(),

                TextInput::make('origin')->required(),
                TextInput::make('destination')->required(),
                DatePicker::make('travel_date')->required(),
                TimePicker::make('travel_time')->required(),

                Select::make('status')
                    ->required()
                    ->options([
                        'pending' => 'Pending',
                        'approved' => 'Approved',
                        'cancelled' => 'Cancelled',
                    ])
                    ->label('Booking Status'),

                Select::make('payment_status')
                    ->label('Payment Status')
                    ->options([
                        'pending' => 'Pending',
                        'confirmed' => 'Confirmed',
                        'rejected' => 'Rejected',
                    ])
                    ->required(),
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
                TextColumn::make('status')
                    ->badge()
                    ->colors([
                        'approved' => 'success',
                        'pending' => 'warning',
                        'cancelled' => 'danger',
                    ]),
                TextColumn::make('created_at')->label('Booked At')->since(),

                TextColumn::make('payment_method')->label('Payment Method'),
                TextColumn::make('payment_status')
                    ->label('Payment Status')
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'pending' => 'warning',
                        'confirmed' => 'success',
                        'rejected' => 'danger',
                    }),
            ])
            ->filters([
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

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListBookings::route('/'),
            'create' => Pages\CreateBooking::route('/create'),
            'edit' => Pages\EditBooking::route('/{record}/edit'),
        ];
    }

    public static function canAccess(): bool
    {
        return auth()->user()?->role === 'admin';
    }
}
