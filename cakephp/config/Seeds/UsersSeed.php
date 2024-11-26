<?php
declare(strict_types=1);

use Migrations\AbstractSeed;

class UsersSeed extends AbstractSeed
{
    public function run(): void
    {
        $data = [
        ];

        for ($i = 1; $i <= 100; $i++) {
            $data[] = [
                'name' => "User $i",
                'email' => "user$i@example.com",
                'created' => date('Y-m-d H:i:s'),
                'modified' => date('Y-m-d H:i:s'),
            ];
        }

        $table = $this->table('users');
        $table->insert($data)->save();
    }
}
