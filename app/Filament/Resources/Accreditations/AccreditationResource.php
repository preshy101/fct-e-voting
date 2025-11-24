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
use UnitEnum;

class AccreditationResource extends Resource
{
    protected static ?string $model = Accreditation::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedCheckBadge;

    protected static ?string $recordTitleAttribute = 'election_id';


    protected static string | UnitEnum | null $navigationGroup = 'Election Management';

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
            'edit' => EditAccreditation::route('/{record}/edit'),
        ];
    }
}
