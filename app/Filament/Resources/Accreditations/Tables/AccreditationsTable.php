<?php

namespace App\Filament\Resources\Accreditations\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Table;
use Filament\Actions\Action;
use Filament\Notifications\Notification;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use Twilio\Rest\Client;

class AccreditationsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->recordUrl(null)
            ->recordAction(null)
            ->columns([
                TextColumn::make('election.title')
                    ->label('Election')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),
                TextColumn::make('member.first_name')
                    ->label('Member Name')
                    ->formatStateUsing(fn ($state, $record) => ($record->member->first_name ?? 'N/A') . ' ' . ($record->member->last_name ?? ''))
                    ->searchable(query: function ($query, string $search) {
                        $query->whereHas('member', function ($q) use ($search) {
                            $q->where('first_name', 'like', "%{$search}%")
                              ->orWhere('last_name', 'like', "%{$search}%")
                              ->orWhere('staff_ID', 'like', "%{$search}%")
                              ->orWhere('email', 'like', "%{$search}%");
                        });
                    })
                    ->sortable(),
                TextColumn::make('member.staff_ID')
                    ->label('Practice ID')
                    ->badge()
                    ->color('primary')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('token')
                    ->searchable()
                    ->badge()
                    ->color('warning')
                    ->copyable(),
                ImageColumn::make('image')
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('note')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
                TextColumn::make('type')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
                IconColumn::make('is_used')
                    ->label('Used?')
                    ->boolean(),
                TextColumn::make('used_at')
                    ->dateTime()
                    ->sortable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('election_year')
                    ->label('Election Year')
                    ->options(function () {
                        return \App\Models\election::query()
                            ->select('year')
                            ->distinct()
                            ->whereNotNull('year')
                            ->pluck('year', 'year')
                            ->toArray();
                    })
                    ->query(function (Builder $query, array $data): Builder {
                        if (isset($data['value']) && $data['value'] !== null) {
                            $query->whereHas('election', function ($q) use ($data) {
                                $q->where('year', $data['value']);
                            });
                        }
                        return $query;
                    }),
                SelectFilter::make('election_category')
                    ->label('Election Category')
                    ->options(function () {
                        return \App\Models\category::pluck('title', 'id')->toArray();
                    })
                    ->query(function (Builder $query, array $data): Builder {
                        if (isset($data['value']) && $data['value'] !== null) {
                            $query->whereHas('election', function ($q) use ($data) {
                                $q->where('category_id', $data['value']);
                            });
                        }
                        return $query;
                    }),
            ])
            ->recordActions([
                Action::make('sendSms')
                    ->label('Send Token via SMS')
                    ->icon('heroicon-o-chat-bubble-left-ellipsis')
                    ->color('success')
                    ->action(function (\App\Models\accreditation $record) {
                        if (!$record->member->phone_number) {
                            Notification::make()
                                ->title('Error')
                                ->body('Member does not have a phone number.')
                                ->danger()
                                ->send();
                            return;
                        }

                        $sid = env('TWILIO_SID');
                        $token = env('TWILIO_AUTH_TOKEN');
                        $twilio_number = env('TWILIO_PHONE_NUMBER');

                        if (!$sid || !$token || !$twilio_number) {
                            Notification::make()
                                ->title('Error')
                                ->body('Twilio credentials are not set.')
                                ->danger()
                                ->send();
                            return;
                        }

                        try {
                            $client = new Client($sid, $token);
                            $client->messages->create(
                                $record->member->phone_number,
                                [
                                    'from' => $twilio_number,
                                    'body' => "Hello {$record->member->first_name}, your accreditation token is: {$record->token}"
                                ]
                            );

                            Notification::make()
                                ->title('SMS Sent')
                                ->body('Token sent successfully to ' . $record->member->phone_number)
                                ->success()
                                ->send();
                        } catch (\Exception $e) {
                            Notification::make()
                                ->title('Error sending SMS')
                                ->body($e->getMessage())
                                ->danger()
                                ->send();
                        }
                    })
                    ->requiresConfirmation(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
