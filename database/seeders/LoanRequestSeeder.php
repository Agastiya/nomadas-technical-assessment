<?php

namespace Database\Seeders;

use App\Models\LoanRequest;
use Illuminate\Database\Seeder;

class LoanRequestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        LoanRequest::factory(10)->create();
    }
}
