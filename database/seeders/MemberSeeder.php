<?php

namespace Database\Seeders;

use App\Models\member;
use Illuminate\Database\Seeder;

class MemberSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $membersData = [
            ['first_name' => 'Abubakar', 'last_name' => 'Suleiman', 'email' => 'abubakar.s@example.com', 'phone_number' => '+2348021000001', 'practice_ID' => '015701', 'grade' => 'Fellow'],
            ['first_name' => 'Chiamaka', 'last_name' => 'Nwosu', 'email' => 'chiamaka.n@example.com', 'phone_number' => '+2348021000002', 'practice_ID' => '015702', 'grade' => 'Associate'],
            ['first_name' => 'Tunde', 'last_name' => 'Bakare', 'email' => 'tunde.b@example.com', 'phone_number' => '+2348021000003', 'practice_ID' => '015703', 'grade' => 'Full Member'],
            ['first_name' => 'Fatima', 'last_name' => 'Aliyu', 'email' => 'fatima.a@example.com', 'phone_number' => '+2348021000004', 'practice_ID' => '015704', 'grade' => 'Fellow'],
            ['first_name' => 'Emeka', 'last_name' => 'Anyanwu', 'email' => 'emeka.a@example.com', 'phone_number' => '+2348021000005', 'practice_ID' => '015705', 'grade' => 'Full Member'],
            ['first_name' => 'Zainab', 'last_name' => 'Garba', 'email' => 'zainab.g@example.com', 'phone_number' => '+2348021000006', 'practice_ID' => '015706', 'grade' => 'Associate'],
            ['first_name' => 'Kehinde', 'last_name' => 'Ogunleye', 'email' => 'kehinde.o@example.com', 'phone_number' => '+2348021000007', 'practice_ID' => '015707', 'grade' => 'Full Member'],
            ['first_name' => 'Ifeoma', 'last_name' => 'Okoli', 'email' => 'ifeoma.o@example.com', 'phone_number' => '+2348021000008', 'practice_ID' => '015708', 'grade' => 'Fellow'],
            ['first_name' => 'Usman', 'last_name' => 'Danladi', 'email' => 'usman.d@example.com', 'phone_number' => '+2348021000009', 'practice_ID' => '015709', 'grade' => 'Associate'],
            ['first_name' => 'Blessing', 'last_name' => 'Etim', 'email' => 'blessing.e@example.com', 'phone_number' => '+2348021000010', 'practice_ID' => '015710', 'grade' => 'Full Member'],
            ['first_name' => 'Yakubu', 'last_name' => 'Gowon', 'email' => 'yakubu.g@example.com', 'phone_number' => '+2348021000011', 'practice_ID' => '015711', 'grade' => 'Fellow'],
            ['first_name' => 'Adaobi', 'last_name' => 'Eze', 'email' => 'adaobi.e@example.com', 'phone_number' => '+2348021000012', 'practice_ID' => '015712', 'grade' => 'Graduate Member'],
            ['first_name' => 'Segun', 'last_name' => 'Oladipo', 'email' => 'segun.o@example.com', 'phone_number' => '+2348021000013', 'practice_ID' => '015713', 'grade' => 'Associate'],
            ['first_name' => 'Hauwa', 'last_name' => 'Mustapha', 'email' => 'hauwa.m@example.com', 'phone_number' => '+2348021000014', 'practice_ID' => '015714', 'grade' => 'Full Member'],
            ['first_name' => 'Obinna', 'last_name' => 'Kalu', 'email' => 'obinna.k@example.com', 'phone_number' => '+2348021000015', 'practice_ID' => '015715', 'grade' => 'Fellow'],
            ['first_name' => 'Folashade', 'last_name' => 'Balogun', 'email' => 'folashade.b@example.com', 'phone_number' => '+2348021000016', 'practice_ID' => '015716', 'grade' => 'Full Member'],
            ['first_name' => 'Musa', 'last_name' => 'Ibrahim', 'email' => 'musa.i@example.com', 'phone_number' => '+2348021000017', 'practice_ID' => '015717', 'grade' => 'Associate'],
            ['first_name' => 'Nkemdilim', 'last_name' => 'Onyeka', 'email' => 'nkemdilim.o@example.com', 'phone_number' => '+2348021000018', 'practice_ID' => '015718', 'grade' => 'Graduate Member'],
            ['first_name' => 'Ayodele', 'last_name' => 'Fashola', 'email' => 'ayodele.f@example.com', 'phone_number' => '+2348021000019', 'practice_ID' => '015719', 'grade' => 'Full Member'],
            ['first_name' => 'Maryam', 'last_name' => 'Abacha', 'email' => 'maryam.a@example.com', 'phone_number' => '+2348021000020', 'practice_ID' => '015720', 'grade' => 'Fellow'],
            ['first_name' => 'Chinedu', 'last_name' => 'Opara', 'email' => 'chinedu.o@example.com', 'phone_number' => '+2348021000021', 'practice_ID' => '015721', 'grade' => 'Associate'],
            ['first_name' => 'Bolanle', 'last_name' => 'Adekunle', 'email' => 'bolanle.a@example.com', 'phone_number' => '+2348021000022', 'practice_ID' => '015722', 'grade' => 'Full Member'],
            ['first_name' => 'Haruna', 'last_name' => 'Sanusi', 'email' => 'haruna.s@example.com', 'phone_number' => '+2348021000023', 'practice_ID' => '015723', 'grade' => 'Graduate Member'],
            ['first_name' => 'Uchechi', 'last_name' => 'Nnamdi', 'email' => 'uchechi.n@example.com', 'phone_number' => '+2348021000024', 'practice_ID' => '015724', 'grade' => 'Associate'],
            ['first_name' => 'Olawale', 'last_name' => 'Gbadamosi', 'email' => 'olawale.g@example.com', 'phone_number' => '+2348021000025', 'practice_ID' => '015725', 'grade' => 'Full Member'],
            ['first_name' => 'Halima', 'last_name' => 'Balarabe', 'email' => 'halima.b@example.com', 'phone_number' => '+2348021000026', 'practice_ID' => '015726', 'grade' => 'Fellow'],
            ['first_name' => 'Kelechi', 'last_name' => 'Maduka', 'email' => 'kelechi.m@example.com', 'phone_number' => '+2348021000027', 'practice_ID' => '015727', 'grade' => 'Full Member'],
            ['first_name' => 'Simisola', 'last_name' => 'Ajayi', 'email' => 'simisola.a@example.com', 'phone_number' => '+2348021000028', 'practice_ID' => '015728', 'grade' => 'Associate'],
            ['first_name' => 'Farouk', 'last_name' => 'Dahiru', 'email' => 'farouk.d@example.com', 'phone_number' => '+2348021000029', 'practice_ID' => '015729', 'grade' => 'Graduate Member'],
            ['first_name' => 'Nneka', 'last_name' => 'Chukwuma', 'email' => 'nneka.c@example.com', 'phone_number' => '+2348021000030', 'practice_ID' => '015730', 'grade' => 'Fellow'],
        ];

        foreach ($membersData as $mData) {
            member::updateOrCreate(
                ['practice_ID' => $mData['practice_ID']],
                $mData
            );
        }
    }
}
