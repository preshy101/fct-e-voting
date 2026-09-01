<?php

namespace App\Filament\Resources\Votes;

use App\Filament\Resources\Votes\Pages\CreateVote;
use App\Filament\Resources\Votes\Pages\EditVote;
use App\Filament\Resources\Votes\Pages\ListVotes;
use App\Filament\Resources\Votes\Pages\ViewVote;
use App\Filament\Resources\Votes\Schemas\VoteForm;
use App\Filament\Resources\Votes\Schemas\VoteInfolist;
use App\Filament\Resources\Votes\Tables\VotesTable;
use App\Models\vote;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;
use UnitEnum;

class VoteResource extends Resource
{
    protected static ?string $model = Vote::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedDocumentArrowDown;

    protected static ?string $recordTitleAttribute = 'token';

    protected static string | UnitEnum | null $navigationGroup = 'Election Management';

    protected static ?int $navigationSort = 4;

    public static function getGloballySearchableAttributes(): array
    {
        return [
            'token',
            'member.staff_ID',
            'member.first_name',
            'member.last_name',
            'member.email',
            'candidate.first_name',
            'candidate.last_name',
            'election.title',
            'accreditation.token',
        ];
    }

    public static function getGlobalSearchResultTitle(Model $record): string
    {
        return "Vote Ref: {$record->token}";
    }

    public static function getGlobalSearchResultDetails(Model $record): array
    {
        return [
            'Voter' => ($record->member->first_name ?? 'N/A') . ' ' . ($record->member->last_name ?? '') . ($record->member->staff_ID ? " ({$record->member->staff_ID})" : ''),
            'Candidate' => ($record->candidate->first_name ?? 'N/A') . ' ' . ($record->candidate->last_name ?? ''),
            'Election' => $record->election->title ?? 'N/A',
            'Cast At' => $record->created_at?->format('M d, Y h:i A') ?? 'N/A',
        ];
    }

    public static function getGlobalSearchResultUrl(Model $record): string
    {
        return VoteResource::getUrl('view', ['record' => $record]);
    }

    public static function form(Schema $schema): Schema
    {
        return VoteForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return VoteInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return VotesTable::configure($table);
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
            'index' => ListVotes::route('/'),
            'view' => ViewVote::route('/{record}'),
        ];
    }
}
