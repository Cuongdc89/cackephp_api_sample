<?php
declare(strict_types=1);

namespace App\Controller\Api;

use App\Controller\AppController;
use App\Repository\UserRepository;
use App\Validator\UserValidator;
use Cake\Log\Log;

class UsersController extends AppController
{
    private UserRepository $userRepository;
    private UserValidator $userValidator;


    /**
     * @throws \Exception
     */
    public function initialize(): void
    {
        parent::initialize();
        // init JSON response
        $this->loadComponent('RequestHandler');
        $this->userRepository   = new UserRepository();
        $this->userValidator    = new UserValidator();
    }

    // GET /api/users
    public function index()
    {
        try {
            $page   = (int) $this->request->getQuery('page', 1);
            $limit  = (int) $this->request->getQuery('limit') > 0 ? (int) $this->request->getQuery('limit') : 20;

            $users = $this->userRepository->getAllUsers($page, $limit);
            $total = $this->userRepository->getTotalUsers();
            $nextPage = ($page * $limit < $total) ? $page + 1 : null;

            $this->set([
                'status' => 'success',
                'data' => $users,
                'pagination' => [
                    'total' => $total,
                    'next_page' => $nextPage,
                    'per_page' => $limit,
                ],
                '_serialize' => ['status', 'data', 'pagination'],
            ]);
        } catch (\Exception $exception) {
            $this->set([
                'status' => 'error',
                'message' => 'Failed to get user list data',
                '_serialize' => ['status', 'message'],
            ]);
            Log::error($exception->getMessage());
        }

    }

    // POST /api/users
    public function add()
    {
        try {
            $data = $this->request->getData();
            $errors = $this->userValidator->validateUser($data);
            if (!empty($errors)) {
                $this->set([
                    'status' => 'error',
                    'message' => 'Validation failed',
                    'errors' => $errors,
                    '_serialize' => ['status', 'message', 'errors'],
                ]);
                return;
            }

            if ($this->userRepository->createUser($data)) {
                $this->set([
                    'status' => 'success',
                    'message' => 'User created successfully',
                    '_serialize' => ['status', 'message'],
                ]);
            } else {
                $this->set([
                    'status' => 'error',
                    'message' => 'Failed to create user',
                    '_serialize' => ['status', 'message'],
                ]);
            }
        } catch (\Exception $exception) {
            $this->set([
                'status' => 'error',
                'message' => 'Failed to create new user',
                '_serialize' => ['status', 'message'],
            ]);
            Log::error($exception->getMessage());
        }

    }
}
