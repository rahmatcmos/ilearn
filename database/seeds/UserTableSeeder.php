<?php

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\Exception\UnsatisfiedDependencyException;
use Faker\Factory as Faker;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();

        $staff = Role::create(['name' => 'staff']);
        $teacher = Role::create(['name' => 'teacher']);
        $student = Role::create(['name' => 'student']);

        $role = [$staff, $teacher, $student];

        for ($i=0; $i < 100 ; $i++) {
            $user = User::create([
                'id' => Uuid::uuid4(),
                'identitynumber' => $faker->unique()->randomNumber,
                'username'  => strtolower($faker->unique()->userName),
                'firstname' => $faker->firstName,
                'lastname' => $faker->lastName,
                'email' => strtolower($faker->unique()->freeEmail),
                'status' => 'banned',
                'password' => bcrypt('secret')
            ]);

            $user->assignRole($role[rand(0, 2)]);

            $this->command->info('User ke-' . $i);
        }

        $user = User::create([
            'id' => Uuid::uuid4(),
            'identitynumber' => $faker->unique()->randomNumber,
            'username'  => 'admin',
            'firstname' => 'Administrator',
            'lastname' => 'SMK Wira Harapan',
            'email' => 'admin@domain.com',
            'status' => 'active',
            'password' => bcrypt('secret')
        ]);
        $user->assignRole($staff);

        $this->command->info('Finished!');
    }
}
