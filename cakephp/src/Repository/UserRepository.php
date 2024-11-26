<?php
declare(strict_types=1);

namespace App\Repository;

use App\Repository\Interfaces\UserRepositoryInterface;
use Cake\ORM\TableRegistry;

class UserRepository implements UserRepositoryInterface
{
    private \Cake\ORM\Table $usersTable;

    public function __construct()
    {
        $this->usersTable = TableRegistry::getTableLocator()->get('Users');
    }

    /**
     * @param $email
     * @return array|\Cake\Datasource\EntityInterface|null
     */
    public function getUserByEmail($email)
    {
        return $this->usersTable->find()->where(['email' => $email])->first();
    }

    /**
     * @param array $data
     * @return bool
     */
    public function createUser(array $data): bool
    {
        $user = $this->usersTable->newEntity($data);
        return (bool)$this->usersTable->save($user);
    }


    /**
     * @param int $page
     * @param int $limit
     * @return array
     */
    public function getAllUsers(int $page = 1, int $limit = 20): array
    {
        $query = $this->usersTable->find('all');
        return $this->usersTable->find('all')
            ->limit($limit)
            ->page($page)
            ->toArray();
    }

    /**
     * @return int
     */
    public function getTotalUsers(): int
    {
        return $this->usersTable->find()->count();
    }
}
