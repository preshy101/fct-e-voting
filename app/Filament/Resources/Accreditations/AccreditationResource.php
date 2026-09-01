<?php

namespace App\Filament\Resources\Accreditations;

use App\Filament\Resources\Accreditations\Pages\CreateAccreditation;
use App\Filament\Resources\Accreditations\Pages\EditAccreditation;
use App\Filament\Resources\Accreditations\Pages\ListAccreditations;
use App\Filament\Resources\Accreditations\Schemas\AccreditationForm;
use App\Filament\Resources\Accreditations\Tables\AccreditationsTable;
use App\Models\accreditation;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;
use UnitEnum;

class AccreditationResource extends Resource
{
    protected static ?string $model = Accreditation::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedCheckBadge;

    protected static ?string $recordTitleAttribute = 'token';

    protected static string | UnitEnum | null $navigationGroup = 'Election Management';

    protected static ?int $navigationSort = 2;

    public static function getGloballySearchableAttributes(): array
    {
        return [
            'token',
            'member.staff_ID',
            'member.first_name',
            'member.last_name',
            'member.email',
            'election.title',
        ];
    }

    public static function getGlobalSearchResultTitle(Model $record): string
    {
        return "Accreditation Token: {$record->token}";
    }

    public static function getGlobalSearchResultDetails(Model $record): array
    {
        return [
            'Member' => ($record->member->first_name ?? 'N/A') . ' ' . ($record->member->last_name ?? '') . ($record->member->staff_ID ? " ({$record->member->staff_ID})" : ''),
            'Election' => $record->election->title ?? 'N/A',
            'Status' => $record->is_used ? 'Used' : 'Active / Unused',
        ];
    }

    public static function getGlobalSearchResultUrl(Model $record): string
    {
        return AccreditationResource::getUrl('index');
    }

    public static function form(Schema $schema): Schema
    {
        return AccreditationForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return AccreditationsTable::configure($table);
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
            'index' => ListAccreditations::route('/'),
            'create' => CreateAccreditation::route('/create'),
        ];
    }
}
