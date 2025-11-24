<div class="p-4">
    @if($voters->isEmpty())
        <div class="text-center py-8">
            <x-filament::icon
                icon="heroicon-o-inbox"
                class="w-12 h-12 mx-auto text-gray-400 mb-2"
            />
            <p class="text-gray-500">No votes cast for this candidate yet.</p>
        </div>
    @else
        <div class="space-y-2">
            <div class="mb-4 p-3 bg-gray-50 dark:bg-gray-800 rounded-lg">
                <p class="text-sm font-semibold text-gray-700 dark:text-gray-300">
                    Total Votes: <span class="text-lg text-primary-600">{{ $voters->count() }}</span>
                </p>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead class="bg-gray-50 dark:bg-gray-800">
                        <tr>
                            <th class="px-4 py-2 text-left font-medium text-gray-700 dark:text-gray-300">#</th>
                            <th class="px-4 py-2 text-left font-medium text-gray-700 dark:text-gray-300">Member Name</th>
                            <th class="px-4 py-2 text-left font-medium text-gray-700 dark:text-gray-300">Email</th>
                            <th class="px-4 py-2 text-left font-medium text-gray-700 dark:text-gray-300">Vote Date</th>
                            <th class="px-4 py-2 text-left font-medium text-gray-700 dark:text-gray-300">Token</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                        @foreach($voters as $index => $vote)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-800">
                                <td class="px-4 py-3 text-gray-600 dark:text-gray-400">{{ $index + 1 }}</td>
                                <td class="px-4 py-3">
                                    <span class="font-medium text-gray-900 dark:text-gray-100">
                                        {{ $vote->member->first_name ?? 'N/A' }} {{ $vote->member->last_name ?? '' }}
                                    </span>
                                </td>
                                <td class="px-4 py-3 text-gray-600 dark:text-gray-400">
                                    {{ $vote->member->email ?? 'N/A' }}
                                </td>
                                <td class="px-4 py-3 text-gray-600 dark:text-gray-400">
                                    {{ $vote->created_at->format('M d, Y H:i') }}
                                </td>
                                <td class="px-4 py-3">
                                    <code class="text-xs bg-gray-100 dark:bg-gray-700 px-2 py-1 rounded text-gray-700 dark:text-gray-300">
                                        {{ Str::limit($vote->token, 10) }}
                                    </code>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endif
</div>
