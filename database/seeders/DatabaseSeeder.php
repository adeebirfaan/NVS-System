<?php

namespace Database\Seeders;

use App\Models\Agency;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        $agency1 = Agency::create([
            'name' => 'Polis Malaysia',
            'code' => 'POLIS',
            'description' => 'Royal Malaysia Police - handles crime-related news verification',
            'contact_email' => 'info@polis.gov.my',
            'contact_phone' => '+603-2266 1222',
            'address' => 'Bukit Aman, Kuala Lumpur',
            'is_active' => true,
        ]);

        $agency2 = Agency::create([
            'name' => 'Kementerian Kesihatan Malaysia',
            'code' => 'KKM',
            'description' => 'Ministry of Health Malaysia - handles health-related news verification',
            'contact_email' => 'enquiry@moh.gov.my',
            'contact_phone' => '+603-8881 0400',
            'address' => 'Putrajaya',
            'is_active' => true,
        ]);

        $agency3 = Agency::create([
            'name' => 'Bank Negara Malaysia',
            'code' => 'BNM',
            'description' => 'Central Bank of Malaysia - handles financial/news verification',
            'contact_email' => 'info@bnm.gov.my',
            'contact_phone' => '+603-2698 8044',
            'address' => 'Kuala Lumpur',
            'is_active' => true,
        ]);

        User::create([
            'name' => 'MCMC Admin',
            'email' => 'admin@mcmc.gov.my',
            'password' => bcrypt('password'),
            'phone' => '+603-2500 8000',
            'role' => User::ROLE_MCMC,
            'is_active' => true,
            'must_change_password' => true,
        ]);

        User::create([
            'name' => 'Polis Staff',
            'email' => 'staff@polis.gov.my',
            'password' => bcrypt('password'),
            'phone' => '+603-2266 1222',
            'role' => User::ROLE_AGENCY,
            'agency_id' => $agency1->id,
            'is_active' => true,
            'must_change_password' => true,
        ]);

        User::create([
            'name' => 'KKM Staff',
            'email' => 'staff@moh.gov.my',
            'password' => bcrypt('password'),
            'phone' => '+603-8881 0400',
            'role' => User::ROLE_AGENCY,
            'agency_id' => $agency2->id,
            'is_active' => true,
            'must_change_password' => true,
        ]);

        User::create([
            'name' => 'BNM Staff',
            'email' => 'staff@bnm.gov.my',
            'password' => bcrypt('password'),
            'phone' => '+603-2698 8044',
            'role' => User::ROLE_AGENCY,
            'agency_id' => $agency3->id,
            'is_active' => true,
            'must_change_password' => true,
        ]);
    }
}
