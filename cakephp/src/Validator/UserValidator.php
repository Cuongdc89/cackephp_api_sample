<?php
declare(strict_types=1);

namespace App\Validator;

use Cake\Validation\Validator;
use Cake\ORM\TableRegistry;

class UserValidator
{
    private \Cake\ORM\Table $usersTable;

    public function __construct()
    {
        $this->usersTable = TableRegistry::getTableLocator()->get('Users');
    }

    /**
     * @param array $data
     * @return array
     */
    public function validateUser(array $data): array
    {
        $validator = new Validator();

        // Validate Name
        $validator
            ->requirePresence('name', 'create')
            ->notEmptyString('name', 'Name is required')
            ->minLength('name', 3, 'Name must be at least 3 characters long');

        // Validate Email
        $validator
            ->requirePresence('email', 'create')
            ->notEmptyString('email', 'Email is required')
            ->email('email', false, 'Please provide a valid email address')
            ->add('email', 'unique', [
                'rule' => function ($value, $context) {
                    $user = $this->usersTable->find()->where(['email' => $value])->first();
                    return !$user;
                },
                'message' => 'Email is already taken',
            ]);

        return $validator->validate($data);
    }
}
