<?php

namespace Database\Seeders;

use App\Models\Spend;
use App\Models\Tag;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Database\Seeder;

class SpendSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::all()->each(function (User $user) {
            Spend::factory(5)
                ->state(new Sequence(
                    fn (Sequence $sequence) => ['date' => $this->getMonthRandomDay(Carbon::now()->subMonths(2))],
                ))
                ->create([
                    'created_by' => $user->id,
                ]);

            Spend::factory(5)
                ->state(new Sequence(
                    fn (Sequence $sequence) => ['date' => $this->getMonthRandomDay(Carbon::now()->subMonth())],
                ))
                ->create([
                    'created_by' => $user->id,
                ]);

            Spend::factory(5)
                ->state(new Sequence(
                    fn (Sequence $sequence) => ['date' => $this->getMonthRandomDay(Carbon::now())],
                ))
                ->create([
                    'created_by' => $user->id,
                ]);

            Spend::factory(5)
                ->state(new Sequence(
                    fn (Sequence $sequence) => ['date' => $this->getMonthRandomDay(Carbon::now()->addMonth())],
                ))
                ->create([
                    'created_by' => $user->id,
                ]);
        });

        Spend::all()->each(function (Spend $spend) {
            $spend->tags()->sync(
                Tag::where('created_by', $spend->created_by)
                    ->inRandomOrder()
                    ->limit(rand(1, 5))
                    ->pluck('id')
            );
        });
    }

    public function getMonthRandomDay($date)
    {
        return $date->startOfMonth()->addDays(rand(1, 25));
    }
}
