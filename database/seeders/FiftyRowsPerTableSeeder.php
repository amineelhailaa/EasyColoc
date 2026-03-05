<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Colocation;
use App\Models\Expense;
use App\Models\Invitation;
use App\Models\Membership;
use App\Models\Split;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class FiftyRowsPerTableSeeder extends Seeder
{
    public function run(): void
    {
        $faker = fake();
        $seedTag = now()->format('YmdHis');

        DB::transaction(function () use ($faker, $seedTag) {
            $users = collect();
            for ($i = 1; $i <= 50; $i++) {
                $users->push(User::query()->create([
                    'name' => "Seed User {$i}",
                    'email' => "seed_{$seedTag}_{$i}@example.com",
                    'email_verified_at' => now(),
                    'password' => 'password',
                    'avatar' => null,
                    'reputation' => $faker->numberBetween(-5, 100),
                    'ban' => false,
                ]));
            }

            $colocations = collect();
            for ($i = 1; $i <= 50; $i++) {
                $colocation = new Colocation();
                $colocation->name = "Seed Colocation {$i}";
                $colocation->description = $faker->sentence(10);
                $colocation->status = 'active';
                $colocation->avatar = null;
                $colocation->save();
                $colocations->push($colocation);
            }

            // Use 10 colocations for relational data so splits can always pick debtor/creditor.
            $relationalColocations = $colocations->take(10)->values();

            $memberships = collect();
            $ownerAssigned = [];
            for ($i = 0; $i < 50; $i++) {
                $colocation = $relationalColocations[$i % $relationalColocations->count()];
                $status = $faker->boolean(85) ? 'active' : 'inactive';
                $isOwner = !isset($ownerAssigned[$colocation->id]);
                $ownerAssigned[$colocation->id] = true;

                $memberships->push(Membership::query()->create([
                    'user_id' => $users[$i]->id,
                    'colocation_id' => $colocation->id,
                    'left_at' => $status === 'inactive' ? now()->subDays($faker->numberBetween(1, 120)) : null,
                    'balance' => $faker->numberBetween(-100000, 100000) / 100,
                    'status' => $status,
                    'role' => $isOwner ? 'owner' : 'member',
                ]));
            }

            $categories = collect();
            for ($i = 1; $i <= 50; $i++) {
                $colocation = $relationalColocations[($i - 1) % $relationalColocations->count()];

                $category = new Category();
                $category->name = "Category {$i}";
                $category->colocation_id = $colocation->id;
                $category->save();
                $categories->push($category);
            }

            for ($i = 1; $i <= 50; $i++) {
                Invitation::query()->create([
                    'colocation_id' => $colocations[($i - 1) % $colocations->count()]->id,
                    'email' => "invite_{$seedTag}_{$i}@example.com",
                    'token' => Str::random(40),
                    'status' => $faker->randomElement(['pending', 'accepted', 'declined']),
                ]);
            }

            $membershipsByColocation = $memberships->groupBy('colocation_id');
            $categoriesByColocation = $categories->groupBy('colocation_id');

            for ($i = 1; $i <= 50; $i++) {
                $colocation = $relationalColocations[($i - 1) % $relationalColocations->count()];
                $groupMembers = $membershipsByColocation->get($colocation->id, collect());
                $groupCategories = $categoriesByColocation->get($colocation->id, collect());

                $membership = $groupMembers->random();
                $category = $groupCategories->random();

                $expense = new Expense();
                $expense->title = $faker->randomElement([
                    'Groceries',
                    'Electricity Bill',
                    'Internet Subscription',
                    'Cleaning Supplies',
                    'Dinner',
                    'Transport',
                ]) . " #{$i}";
                $expense->amount = $faker->numberBetween(500, 50000) / 100;
                $expense->date = now()->subDays($faker->numberBetween(0, 120))->toDateString();
                $expense->category_id = $category->id;
                $expense->membership_id = $membership->id;
                $expense->colocation_id = $colocation->id;
                $expense->save();
            }

            for ($i = 1; $i <= 50; $i++) {
                $colocation = $relationalColocations[($i - 1) % $relationalColocations->count()];
                $groupMembers = $membershipsByColocation->get($colocation->id, collect())->values();

                $debuteur = $groupMembers->random();
                $crediteurPool = $groupMembers->where('id', '!=', $debuteur->id)->values();
                $crediteur = $crediteurPool->isNotEmpty() ? $crediteurPool->random() : $debuteur;

                $split = new Split();
                $split->part = $faker->numberBetween(100, 30000) / 100;
                $split->status = $faker->randomElement(['paid', 'unpaid']);
                $split->colocation_id = $colocation->id;
                $split->debuteur_id = $debuteur->id;
                $split->crediteur_id = $crediteur->id;
                $split->save();
            }
        });
    }
}

