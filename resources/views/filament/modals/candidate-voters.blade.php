<div style="padding: 1.25rem; font-family: inherit;">
    {{-- Candidate Profile Header Banner --}}
    <div style="background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%); border-radius: 1rem; padding: 1.25rem; margin-bottom: 1.5rem; color: #ffffff; box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);">
        <div style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 1rem;">
            <div style="display: flex; align-items: center; gap: 1rem;">
                <div style="width: 3.5rem; height: 3.5rem; border-radius: 9999px; overflow: hidden; border: 2px solid #10b981; flex-shrink: 0; background-color: #334155; display: flex; align-items: center; justify-content: center;">
                    @if($candidate->photo)
                        <img src="{{ asset('storage/' . $candidate->photo) }}" alt="{{ $candidate->full_name }}" style="width: 100%; height: 100%; object-fit: cover;">
                    @else
                        <span style="font-size: 1.25rem; font-weight: 700; color: #10b981;">
                            {{ substr($candidate->first_name, 0, 1) }}{{ substr($candidate->last_name, 0, 1) }}
                        </span>
                    @endif
                </div>
                <div>
                    <h2 style="font-size: 1.25rem; font-weight: 700; margin: 0; color: #f8fafc;">
                        {{ $candidate->full_name }}
                    </h2>
                    <p style="font-size: 0.875rem; color: #94a3b8; margin: 0.15rem 0 0 0;">
                        {{ $candidate->category->title ?? 'Candidate' }}
                    </p>
                </div>
            </div>
            <div style="display: flex; align-items: center; gap: 0.75rem;">
                <div style="text-align: right; background: rgba(255, 255, 255, 0.08); padding: 0.5rem 1rem; border-radius: 0.75rem; border: 1px solid rgba(255, 255, 255, 0.1);">
                    <div style="font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.05em; color: #cbd5e1;">Total Votes</div>
                    <div style="font-size: 1.5rem; font-weight: 800; color: #10b981;">{{ $voters->count() }}</div>
                </div>
            </div>
        </div>
    </div>

    @if($voters->isEmpty())
        <div style="text-align: center; padding: 3.5rem 1rem; background: rgba(243, 244, 246, 0.5); border-radius: 1rem; border: 2px dashed #d1d5db;">
            <div style="margin: 0 auto 1rem auto; width: 4rem; height: 4rem; border-radius: 9999px; background: #e5e7eb; display: flex; align-items: center; justify-content: center; color: #6b7280;">
                <svg style="width: 2rem; height: 2rem;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                </svg>
            </div>
            <h3 style="font-size: 1.125rem; font-weight: 700; color: #1f2937; margin-bottom: 0.25rem;">No Votes Recorded Yet</h3>
            <p style="font-size: 0.875rem; color: #6b7280; max-width: 20rem; margin: 0 auto;">No voters have cast their ballots for this candidate in this election.</p>
        </div>
    @else
        {{-- Quick Stats Row --}}
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(180px, 1fr)); gap: 1rem; margin-bottom: 1.5rem;">
            <div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 0.75rem; padding: 1rem; display: flex; align-items: center; gap: 0.75rem;">
                <div style="width: 2.5rem; height: 2.5rem; border-radius: 0.5rem; background: #ecfdf5; color: #059669; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                    <svg style="width: 1.25rem; height: 1.25rem;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div>
                    <div style="font-size: 0.75rem; color: #64748b; font-weight: 500;">First Vote</div>
                    <div style="font-size: 0.875rem; font-weight: 700; color: #0f172a;">{{ $voters->last()->created_at->format('M d, Y h:i A') }}</div>
                </div>
            </div>

            <div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 0.75rem; padding: 1rem; display: flex; align-items: center; gap: 0.75rem;">
                <div style="width: 2.5rem; height: 2.5rem; border-radius: 0.5rem; background: #eff6ff; color: #2563eb; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                    <svg style="width: 1.25rem; height: 1.25rem;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div>
                    <div style="font-size: 0.75rem; color: #64748b; font-weight: 500;">Latest Vote</div>
                    <div style="font-size: 0.875rem; font-weight: 700; color: #0f172a;">{{ $voters->first()->created_at->format('M d, Y h:i A') }}</div>
                </div>
            </div>
        </div>

        {{-- Voters List Table --}}
        <div style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 0.875rem; overflow: hidden; box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.05);">
            <div style="padding: 1rem 1.25rem; border-bottom: 1px solid #f1f5f9; display: flex; align-items: center; justify-content: space-between; background: #fafafa;">
                <div style="display: flex; align-items: center; gap: 0.5rem;">
                    <svg style="width: 1.25rem; height: 1.25rem; color: #10b981;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                    <span style="font-size: 0.95rem; font-weight: 700; color: #1e293b;">Verified Voter Records ({{ $voters->count() }})</span>
                </div>
            </div>

            <div style="max-height: 480px; overflow-y: auto;">
                <table style="width: 100%; border-collapse: collapse; text-align: left; font-size: 0.875rem;">
                    <thead>
                        <tr style="background: #f8fafc; border-bottom: 2px solid #e2e8f0; color: #475569; font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.05em;">
                            <th style="padding: 0.75rem 1rem; width: 40px;">#</th>
                            <th style="padding: 0.75rem 1rem;">Voter Name</th>
                            <th style="padding: 0.75rem 1rem;">Staff / Practice ID</th>
                            <th style="padding: 0.75rem 1rem;">Token</th>
                            <th style="padding: 0.75rem 1rem;">Timestamp</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($voters as $index => $vote)
                            <tr style="border-bottom: 1px solid #f1f5f9; transition: background-color 0.15s ease;" onmouseover="this.style.backgroundColor='#f8fafc'" onmouseout="this.style.backgroundColor='transparent'">
                                <td style="padding: 0.85rem 1rem; color: #94a3b8; font-weight: 600; font-size: 0.8rem;">
                                    {{ $index + 1 }}
                                </td>
                                <td style="padding: 0.85rem 1rem;">
                                    <div style="display: flex; align-items: center; gap: 0.65rem;">
                                        <div style="width: 2rem; height: 2rem; border-radius: 9999px; background: #e0e7ff; color: #4338ca; display: flex; align-items: center; justify-content: center; font-size: 0.75rem; font-weight: 700; flex-shrink: 0;">
                                            {{ substr($vote->member->first_name ?? 'V', 0, 1) }}
                                        </div>
                                        <div>
                                            <div style="font-weight: 700; color: #0f172a;">
                                                {{ $vote->member->first_name ?? 'N/A' }} {{ $vote->member->last_name ?? '' }}
                                            </div>
                                            <div style="font-size: 0.75rem; color: #64748b;">
                                                {{ $vote->member->email ?? 'No email' }}
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td style="padding: 0.85rem 1rem;">
                                    <span style="display: inline-block; padding: 0.2rem 0.6rem; border-radius: 9999px; background: #e0f2fe; color: #0369a1; font-size: 0.75rem; font-weight: 600;">
                                        {{ $vote->member->staff_ID ?? 'N/A' }}
                                    </span>
                                </td>
                                <td style="padding: 0.85rem 1rem;">
                                    <code style="display: inline-flex; align-items: center; gap: 0.35rem; padding: 0.2rem 0.5rem; background: #fef3c7; color: #92400e; border: 1px solid #fde68a; border-radius: 0.375rem; font-family: monospace; font-size: 0.75rem; font-weight: 600;">
                                        {{ $vote->accreditation->token ?? $vote->token ?? 'N/A' }}
                                    </code>
                                </td>
                                <td style="padding: 0.85rem 1rem; color: #64748b; font-size: 0.8rem; white-space: nowrap;">
                                    <div style="font-weight: 600; color: #334155;">{{ $vote->created_at->format('M d, Y') }}</div>
                                    <div style="font-size: 0.75rem; color: #94a3b8;">{{ $vote->created_at->format('h:i:s A') }}</div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Footer Security Note --}}
        <div style="margin-top: 1.25rem; display: flex; align-items: center; justify-content: center; gap: 0.5rem; color: #94a3b8; font-size: 0.75rem;">
            <svg style="width: 0.875rem; height: 0.875rem; color: #10b981;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
            </svg>
            <span>All ballots are cryptographically verified and recorded irrevocably.</span>
        </div>
    @endif
</div>

