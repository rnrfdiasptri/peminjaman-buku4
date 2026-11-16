<?php

namespace App\Filament\Widgets;

use App\Models\Book;
use App\Models\Loan;
use App\Models\User;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Total Buku', Book::count())
                ->description('Jumlah seluruh buku di perpustakaan')
                ->descriptionIcon('heroicon-m-book-open')
                ->color('success'), 

            Stat::make('Anggota Siswa', User::where('role', 'siswa')->count())
                ->description('Total siswa yang terdaftar')
                ->descriptionIcon('heroicon-m-users')
                ->color('primary'), 

            Stat::make('Sedang Dipinjam', Loan::where('status', 'dipinjam')->count())
                ->description('Buku yang belum dikembalikan')
                ->descriptionIcon('heroicon-m-clock')
                ->color('warning'), 
        ];
    }
}