<?php

namespace Database\Seeders;

use App\Models\candidate;
use App\Models\candidateBio;
use App\Models\category;
use App\Models\election;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ElectionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Categories
        $categoriesData = [
            [
                'title' => 'Executive Council',
                'slug' => 'executive-council',
                'description' => 'Principal leadership elections for the FCT chapter.',
                'is_active' => true,
            ],
            [
                'title' => 'Branch Leadership',
                'slug' => 'branch-leadership',
                'description' => 'Elections for branch administrative officers.',
                'is_active' => true,
            ],
            [
                'title' => 'Standing Committees',
                'slug' => 'standing-committees',
                'description' => 'Elections for committee heads and representatives.',
                'is_active' => true,
            ],
        ];

        $categories = [];
        foreach ($categoriesData as $data) {
            $categories[$data['slug']] = category::updateOrCreate(
                ['slug' => $data['slug']],
                $data
            );
        }

        // 2. Candidates
        $candidatesData = [
            // Category: Executive Council
            [
                'category_slug' => 'executive-council',
                'first_name' => 'Amina',
                'last_name' => 'Bello',
                'other_name' => 'Fatima',
                'email' => 'amina.bello@fct-evote.ng',
                'phone_number' => '+2348031110001',
                'bio' => [
                    'biography' => 'Over 15 years of distinguished leadership in public administration and corporate governance.',
                    'date_of_birth' => '1982-04-15',
                    'education_background' => 'LL.B (Hons), BL, LL.M in Corporate Law',
                    'professional_background' => 'Senior Partner at Bello & Associates, Former Chapter Secretary',
                    'campaign_promises' => '1. Digital transformation of all member services. 2. Transparent resource management. 3. Enhanced professional development programmes.',
                    'achievements' => 'Led the FCT legal aid initiative providing support to over 2,000 members.',
                ],
            ],
            [
                'category_slug' => 'executive-council',
                'first_name' => 'Chukwuemeka',
                'last_name' => 'Okafor',
                'other_name' => 'David',
                'email' => 'chukwuemeka.okafor@fct-evote.ng',
                'phone_number' => '+2348031110002',
                'bio' => [
                    'biography' => 'Dedicated advocate for institutional accountability and member welfare.',
                    'date_of_birth' => '1979-09-22',
                    'education_background' => 'B.Sc Economics, MBA, FCIB',
                    'professional_background' => 'Managing Director, Capital Apex Consultants; 18 years in finance.',
                    'campaign_promises' => '1. Sustainable member welfare fund. 2. National representation and advocacy. 3. Youth empowerment schemes.',
                    'achievements' => 'Facilitated over 500M in member cooperative financing schemes.',
                ],
            ],
            [
                'category_slug' => 'executive-council',
                'first_name' => 'Olufemi',
                'last_name' => 'Adeyemi',
                'other_name' => 'Babatunde',
                'email' => 'olufemi.adeyemi@fct-evote.ng',
                'phone_number' => '+2348031110003',
                'bio' => [
                    'biography' => 'Seasoned administrator with a proven track record of reform and team cohesion.',
                    'date_of_birth' => '1985-01-10',
                    'education_background' => 'B.Eng Civil Engineering, PMP, FNSE',
                    'professional_background' => 'Chief Operations Officer, Infrastructure Development Group',
                    'campaign_promises' => '1. State-of-the-art branch Secretariat. 2. Streamlined CPD certifications.',
                    'achievements' => 'Managed 12 major infrastructure projects across the Federal Capital Territory.',
                ],
            ],
            // Category: Branch Leadership
            [
                'category_slug' => 'branch-leadership',
                'first_name' => 'Ngozi',
                'last_name' => 'Eze',
                'other_name' => 'Grace',
                'email' => 'ngozi.eze@fct-evote.ng',
                'phone_number' => '+2348031110004',
                'bio' => [
                    'biography' => 'Champion of gender inclusion and digital voting modernization.',
                    'date_of_birth' => '1988-11-05',
                    'education_background' => 'B.Sc Computer Science, M.Sc Cybersecurity',
                    'professional_background' => 'Head of IT Strategy, Federal Capital Development Agency',
                    'campaign_promises' => '1. Complete automation of meeting minutes and resolutions. 2. Real-time member portal.',
                    'achievements' => 'Pioneered the online membership directory and verification system.',
                ],
            ],
            [
                'category_slug' => 'branch-leadership',
                'first_name' => 'Ibrahim',
                'last_name' => 'Mohammed',
                'other_name' => 'Shehu',
                'email' => 'ibrahim.mohammed@fct-evote.ng',
                'phone_number' => '+2348031110005',
                'bio' => [
                    'biography' => 'Experienced financial strategist with passion for transparency.',
                    'date_of_birth' => '1984-06-18',
                    'education_background' => 'B.Sc Accounting, ACA, ACTI',
                    'professional_background' => 'Lead Auditor, Mohammed & Co. Chartered Accountants',
                    'campaign_promises' => '1. Quarterly published financial reports. 2. Zero-tolerance for financial irregularities.',
                    'achievements' => 'Received branch Award of Excellence for Treasury Stewardship in 2024.',
                ],
            ],
            [
                'category_slug' => 'branch-leadership',
                'first_name' => 'Khadijah',
                'last_name' => 'Usman',
                'other_name' => 'Aisha',
                'email' => 'khadijah.usman@fct-evote.ng',
                'phone_number' => '+2348031110006',
                'bio' => [
                    'biography' => 'Dynamic communicator and grassroots mobilization specialist.',
                    'date_of_birth' => '1990-03-30',
                    'education_background' => 'B.A Mass Communication, M.A Public Relations',
                    'professional_background' => 'Director of Corporate Communications, Horizon Media',
                    'campaign_promises' => '1. Monthly member newsletter and podcast. 2. Proactive public affairs response.',
                    'achievements' => 'Increased branch public visibility and media coverage by 200%.',
                ],
            ],
        ];

        $candidates = [];
        foreach ($candidatesData as $cData) {
            $cat = $categories[$cData['category_slug']];
            $cand = candidate::updateOrCreate(
                ['email' => $cData['email']],
                [
                    'category_id' => $cat->id,
                    'first_name' => $cData['first_name'],
                    'last_name' => $cData['last_name'],
                    'other_name' => $cData['other_name'],
                    'phone_number' => $cData['phone_number'],
                    'is_active' => true,
                ]
            );

            candidateBio::updateOrCreate(
                ['candidate_id' => $cand->id],
                array_merge($cData['bio'], ['is_active' => true])
            );

            $candidates[] = $cand;
        }

        // 3. Elections
        $electionsData = [
            [
                'category_slug' => 'executive-council',
                'title' => 'FCT Chapter Chairman Election 2026',
                'description' => 'Election of the Executive Chairman for the FCT Chapter governing period 2026–2028.',
                'start_date' => now()->subDays(2),
                'end_date' => now()->addDays(5),
                'status' => 'active',
                'is_public' => true,
                'is_active' => true,
                'organization_name' => 'FCT Professional Association',
                'contact_email' => 'elections@fct-evote.ng',
                'contact_phone' => '+2348000000001',
                'candidate_indices' => [0, 1, 2], // Amina, Chukwuemeka, Olufemi
            ],
            [
                'category_slug' => 'branch-leadership',
                'title' => 'FCT Branch Secretary General Election 2026',
                'description' => 'Election of the Branch Secretary General for the 2026–2028 term.',
                'start_date' => now()->subDays(2),
                'end_date' => now()->addDays(5),
                'status' => 'active',
                'is_public' => true,
                'is_active' => true,
                'organization_name' => 'FCT Professional Association',
                'contact_email' => 'elections@fct-evote.ng',
                'contact_phone' => '+2348000000002',
                'candidate_indices' => [3, 4, 5], // Ngozi, Ibrahim, Khadijah
            ],
        ];

        foreach ($electionsData as $eData) {
            $cat = $categories[$eData['category_slug']];
            $election = election::updateOrCreate(
                ['title' => $eData['title']],
                [
                    'category_id' => $cat->id,
                    'title' => $eData['title'],
                    'description' => $eData['description'],
                    'start_date' => $eData['start_date'],
                    'end_date' => $eData['end_date'],
                    'status' => $eData['status'],
                    'is_public' => $eData['is_public'],
                    'is_active' => $eData['is_active'],
                    'organization_name' => $eData['organization_name'],
                    'contact_email' => $eData['contact_email'],
                    'contact_phone' => $eData['contact_phone'],
                ]
            );

            // Attach candidates via pivot
            $candidateIds = [];
            foreach ($eData['candidate_indices'] as $idx) {
                if (isset($candidates[$idx])) {
                    $candidateIds[] = $candidates[$idx]->id;
                }
            }
            $election->candidates()->sync($candidateIds);
        }
    }
}
