<?php

namespace App\Controllers;

use App\Models\CommentModel;
use App\Models\UserModel;
use CodeIgniter\API\ResponseTrait;
use CodeIgniter\I18n\Time;
use App\Services\Comment\Service as CommentService;

class CommentController extends BaseController
{
    use ResponseTrait;

    protected $service;
    protected int $pagination = 3;

    public function __construct()
    {
        $this->service = new CommentService();
    }

    public function index()
    {
        return view('comments/index');
    }

    public function getCollect()
    {
        // TODO предусмотреть варианты числа <= 0
        $pageNumber = (int) $this->request->getPost('page') ?? 1;
        $orderBy    = $this->request->getPost('order') ?? 'date';
        $sortMethod = $this->request->getPost('sort') ?? 'ASC';

        if (
            strlen($pageNumber) !== strlen((string)$this->request->getPost('page')) ||
            false == in_array($orderBy, ['date', 'id']) ||
            false == in_array($sortMethod, ['ASC', 'DESC'])
        ) {
            return json_encode([
                'status'    => 400,
                'messages'  => ['error' => 'Невозможно обработать запрос']
            ]);
        }

        $comments = $this->service->getPagination($orderBy, $sortMethod, $this->pagination, $pageNumber);

        return json_encode([
            'status' => 200,
            'data'   => $comments
        ]);
    }

    public function store()
    {
        $userModel = new UserModel();
        $commentModel = new CommentModel();

        $rawEmail = (string) $this->request->getPost('email');
        $rawText = (string) $this->request->getPost('text');
        $email = htmlspecialchars($rawEmail);
        $text = htmlspecialchars($rawText);


        $isValidEmail = $userModel->validate(['email' => $email]);
        $isValidText = $commentModel->validate(['text' => $text]);
        if ($isValidEmail == false || $isValidText == false) {
            $errorMsg = $commentModel->errors();
            return $this->failValidationErrors($errorMsg);
        }

        $userId = $userModel->firstOrCreateByEmail($email);

        $commentData = [
            'text'      => $rawText,
            'user_id'   => $userId,
            'date'      => Time::now('Europe/Moscow')
        ];
        $commentModel->insert($commentData);
        
        return json_encode([
            'status'    => 201,
            'messages'  => []
        ]);
    }

    public function delete(int $commentId)
    {
        $this->service->delete($commentId);
        return json_encode($this->respondDeleted());
    }
}
