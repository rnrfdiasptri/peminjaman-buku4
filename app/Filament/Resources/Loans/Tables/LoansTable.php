<?php

namespace App\Filament\Resources\Loans\Tables;

use App\Models\Loan;
use Filament\Actions\Action;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Notifications\Notification;
use Carbon\Carbon;

class LoansTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user.name')
                    ->label('Peminjam')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('book.title')
                    ->label('Judul Buku')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('borrowed_date')
                    ->label('Tanggal Pinjam')
                    ->dateTime('d-m-Y')
                    ->sortable(),
                TextColumn::make('due_date')
                    ->label('Tenggat (Due Date)')
                    ->dateTime('d-m-Y')
                    ->sortable(),
                TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'dipinjam' => 'warning',
                        'dikembalikan' => 'success',
                        'terlambat' => 'danger',
                        default => 'gray',
                    }),
                TextColumn::make('fine')
                    ->label('Denda')
                    ->money('IDR', true)
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                Action::make('kembalikan')
                    ->label('Kembalikan Buku')
                    ->color('success')
                    ->icon('heroicon-o-check-circle')
                    ->requiresConfirmation()
                    ->visible(fn (Loan $record) => $record->status === 'dipinjam')
                    ->action(function (Loan $record) {
                        $now = Carbon::now();
                        $dueDate = Carbon::parse($record->due_date);
                        
                        $fine = 0;
                        if ($now->greaterThan($dueDate)) {
                            $daysLate = (int) $now->diffInDays($dueDate);
                            $finePerDay = 2000; 
                            $fine = $daysLate * $finePerDay;
                        }

                        $record->update([
                            'status' => 'dikembalikan',
                            'returned_date' => $now,
                            'fine' => $fine,
                        ]);

                        if ($record->book) {
                            $record->book->increment('stock');
                        }

                        $message = $fine > 0 
                            ? "Buku berhasil dikembalikan. Terlambat, denda Anda: Rp " . number_format($fine, 0, ',', '.') 
                            : "Buku berhasil dikembalikan tepat waktu!";

                        Notification::make()
                            ->title($message)
                            ->success()
                            ->send();
                    })
            ]);
    }
}