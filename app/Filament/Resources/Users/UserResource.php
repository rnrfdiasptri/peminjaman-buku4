<?php

namespace App\Filament\Resources\Users;

use App\Models\User;
use Filament\Resources\Resource; 
use Filament\Tables\Table;
use Illuminate\Auth\Access\Response;
use Illuminate\Database\Eloquent\Model;
use App\Filament\Resources\Users\Pages\ListUsers;
use App\Filament\Resources\Users\Pages\CreateUser;
use App\Filament\Resources\Users\Pages\EditUser;

class UserResource extends Resource
{
    protected static ?string $model = User::class;
   protected static \BackedEnum|string|null $navigationIcon = 'heroicon-o-users';
    protected static ?string $recordTitleAttribute = 'name';

   
    public static function canViewAny(): bool
    {
        return auth()->user()->isAdmin();
    }

    public static function getAuthorizationResponse(string $action, ?Model $record = null): Response
    {
        if (auth()->user()->isAdmin()) {
            return Response::allow();
        }

        return Response::deny('Kamu tidak memiliki hak akses ke menu ini.');
    }

    public static function getRelations(): array
    {
        return [
            
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListUsers::route('/'),
            'create' => CreateUser::route('/create'),
            'edit' => EditUser::route('/{record}/edit'),
        ];
    }
}