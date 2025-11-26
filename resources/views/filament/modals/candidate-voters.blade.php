<div class="p-6">
    @if($voters->isEmpty())
        <div class="text-center py-12">
            <div class="mx-auto w-20 h-20 bg-gray-100 dark:bg-gray-800 rounded-full flex items-center justify-center mb-4">
                <x-filament::icon
                    icon="heroicon-o-inbox"
                    class="w-10 h-10 text-gray-400"
                />
            </div>
            <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-2">No Votes Yet</h3>
            <p class="text-gray-500 dark:text-gray-400">This candidate hasn't received any votes yet.</p>
        </div>
    @else
        <div class="space-y-6">
            <!-- Statistics Summary -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="bg-gradient-to-br from-blue-50 to-blue-100 dark:from-blue-900/20 dark:to-blue-800/20 rounded-xl p-4 border border-blue-200 dark:border-blue-800">
                    <div class="flex items-center gap-3">
                        <div class="p-3 bg-blue-500 rounded-lg">
                            <x-filament::icon icon="heroicon-o-users" class="w-6 h-6 text-white"/>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-blue-600 dark:text-blue-400">Total Voters</p>
                            <p class="text-2xl font-bold text-blue-900 dark:text-blue-100">{{ $voters->count() }}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-gradient-to-br from-green-50 to-green-100 dark:from-green-900/20 dark:to-green-800/20 rounded-xl p-4 border border-green-200 dark:border-green-800">
                    <div class="flex items-center gap-3">
                        <div class="p-3 bg-green-500 rounded-lg">
                            <x-filament::icon icon="heroicon-o-check-circle" class="w-6 h-6 text-white"/>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-green-600 dark:text-green-400">First Vote</p>
                            <p class="text-sm font-semibold text-green-900 dark:text-green-100">{{ $voters->last()->created_at->format('M d, Y') }}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-gradient-to-br from-purple-50 to-purple-100 dark:from-purple-900/20 dark:to-purple-800/20 rounded-xl p-4 border border-purple-200 dark:border-purple-800">
                    <div class="flex items-center gap-3">
                        <div class="p-3 bg-purple-500 rounded-lg">
                            <x-filament::icon icon="heroicon-o-clock" class="w-6 h-6 text-white"/>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-purple-600 dark:text-purple-400">Latest Vote</p>
                            <p class="text-sm font-semibold text-purple-900 dark:text-purple-100">{{ $voters->first()->created_at->format('M d, Y') }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Voters Table -->
            <div>
                <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4 flex items-center gap-2">
                    <x-filament::icon icon="heroicon-o-list-bullet" class="w-5 h-5"/>
                    Voter Details
                </h3>

                <div class="border-2 border-gray-300 dark:border-gray-600 rounded-xl shadow-sm overflow-hidden">
                    <div class="max-h-[500px] overflow-y-auto">
                        <table class="w-full border-collapse">
                            <thead class="bg-gray-100 dark:bg-gray-800 sticky top-0 z-10 border-b-2 border-gray-300 dark:border-gray-600">
                                <tr>
                                    <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-700 dark:text-gray-300 uppercase tracking-wider border-r border-gray-300 dark:border-gray-600">
                                        #
                                    </th>
                                    <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-700 dark:text-gray-300 uppercase tracking-wider border-r border-gray-300 dark:border-gray-600">
                                        Member Name
                                    </th>
                                    <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-700 dark:text-gray-300 uppercase tracking-wider border-r border-gray-300 dark:border-gray-600">
                                        Practice ID
                                    </th>
                                    <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-700 dark:text-gray-300 uppercase tracking-wider border-r border-gray-300 dark:border-gray-600">
                                        Email
                                    </th>
                                    <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-700 dark:text-gray-300 uppercase tracking-wider border-r border-gray-300 dark:border-gray-600">
                                        Token
                                    </th>
                                    <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-700 dark:text-gray-300 uppercase tracking-wider">
                                        Vote Date & Time
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-gray-900">
                                @foreach($voters as $index => $vote)
                                    <tr class="border-b border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-800 transition-colors duration-150">
                                        <td class="px-6 py-4 whitespace-nowrap border-r border-gray-200 dark:border-gray-700">
                                            <div class="flex items-center justify-center w-9 h-9 rounded-full bg-primary-100 dark:bg-primary-900/30">
                                                <span class="text-sm font-bold text-primary-600 dark:text-primary-400">{{ $index + 1 }}</span>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap border-r border-gray-200 dark:border-gray-700">
                                            <div class="flex items-center gap-3">
                                                <div class="flex-shrink-0 h-9 w-9 bg-gray-200 dark:bg-gray-700 rounded-full flex items-center justify-center">
                                                    <x-filament::icon icon="heroicon-o-user" class="w-5 h-5 text-gray-500 dark:text-gray-400"/>
                                                </div>
                                                <div class="text-sm font-semibold text-gray-900 dark:text-gray-100">
                                                    {{ $vote->member->first_name ?? 'N/A' }} {{ $vote->member->last_name ?? '' }}
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap border-r border-gray-200 dark:border-gray-700">
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-blue-100 dark:bg-blue-900/30 text-blue-800 dark:text-blue-300">
                                                {{ $vote->member->practice_ID ?? 'N/A' }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600 dark:text-gray-400 border-r border-gray-200 dark:border-gray-700">
                                            <div class="flex items-center gap-2">
                                                <x-filament::icon icon="heroicon-o-envelope" class="w-4 h-4 text-gray-400"/>
                                                {{ $vote->member->email ?? 'N/A' }}
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap border-r border-gray-200 dark:border-gray-700">
                                            <code class="inline-flex items-center gap-2 px-3 py-1.5 bg-gray-100 dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-md text-xs font-mono text-gray-700 dark:text-gray-300">
                                                <x-filament::icon icon="heroicon-o-key" class="w-3.5 h-3.5 text-gray-400"/>
                                                {{ $vote->accreditation->token ?? $vote->token }}
                                            </code>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600 dark:text-gray-400">
                                            <div class="flex flex-col gap-1">
                                                <span class="font-semibold text-gray-900 dark:text-gray-100">{{ $vote->created_at->format('M d, Y') }}</span>
                                                <span class="text-xs text-gray-500 dark:text-gray-400">{{ $vote->created_at->format('h:i A') }}</span>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Export/Print Actions (Optional) -->
            <div class="pt-4 border-t border-gray-200 dark:border-gray-700">
                <p class="text-xs text-gray-500 dark:text-gray-400 text-center">
                    <x-filament::icon icon="heroicon-o-information-circle" class="w-4 h-4 inline"/>
                    All votes are recorded securely and cannot be modified
                </p>
            </div>
        </div>
    @endif
</div>
