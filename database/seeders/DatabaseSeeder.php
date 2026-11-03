<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Accounts (all use the password "password")
        User::create(['name' => 'Site Admin', 'email' => 'admin@example.com', 'password' => 'password', 'role' => 'admin']);
        User::create(['name' => 'Priya Candidate', 'email' => 'candidate@example.com', 'password' => 'password', 'role' => 'candidate']);

        $categories = collect(['Software Development', 'Design', 'Marketing', 'Sales', 'Finance', 'Customer Support', 'Human Resources', 'Operations'])
            ->map(fn ($n) => Category::create(['name' => $n, 'slug' => Str::slug($n)]));

        $employers = [
            ['Acme Hiring Lead', 'employer@example.com', 'Acme Technologies', 'Bengaluru'],
            ['Nova Recruiter', 'nova@example.com', 'Nova Labs', 'Delhi'],
        ];

        $samples = [
            ['Laravel Backend Developer', 0, 'Full-time', 'Mid', 900000, 1500000, true],
            ['Senior React Engineer', 0, 'Full-time', 'Senior', 1800000, 2800000, true],
            ['UI/UX Designer', 1, 'Full-time', 'Mid', 700000, 1200000, false],
            ['Digital Marketing Executive', 2, 'Full-time', 'Entry', 300000, 500000, false],
            ['Customer Support Associate', 5, 'Part-time', 'Entry', 200000, 320000, false],
            ['Finance Analyst', 4, 'Full-time', 'Mid', 600000, 950000, false],
            ['Remote QA Engineer', 0, 'Remote', 'Mid', 800000, 1300000, false],
            ['Software Engineering Intern', 0, 'Internship', 'Entry', null, null, false],
        ];

        foreach ($employers as $i => [$name, $email, $company, $city]) {
            $user = User::create(['name' => $name, 'email' => $email, 'password' => 'password', 'role' => 'employer']);
            $co = $user->company()->create([
                'name' => $company, 'location' => $city, 'website' => 'https://example.com',
                'description' => "{$company} builds products used by thousands of customers and hires people who like owning their work.",
            ]);

            foreach ($samples as $k => [$title, $cat, $type, $level, $min, $max, $featured]) {
                if ($k % 2 !== $i) { continue; } // split sample jobs between the two employers
                $co->jobs()->create([
                    'category_id' => $categories[$cat]->id,
                    'title' => $title,
                    'slug' => Str::slug($title).'-'.Str::lower(Str::random(5)),
                    'description' => "We are looking for a {$title} to join {$company}.\n\nYou will work with a small, friendly team, ship things that matter, and grow your skills.",
                    'requirements' => "• Relevant experience for a {$level}-level role\n• Clear written communication\n• Comfortable working in a team",
                    'location' => $city,
                    'type' => $type,
                    'level' => $level,
                    'salary_min' => $min,
                    'salary_max' => $max,
                    'deadline' => now()->addDays(30),
                    'status' => 'published',
                    'is_featured' => $featured,
                ]);
            }
        }
    }
}
