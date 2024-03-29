<?php

namespace App\Models;

use CodeIgniter\Model;

class CommentModel extends Model
{
    protected $table = 'comments';
    protected $allowedFields = ['text', 'user_id', 'date'];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $deletedField  = 'deleted_at';
    protected $updatedField = '';


    protected $validationRules = [
        'text' => 'required',
    ];

    protected $validationMessages = [
        'text' => [
            'required' => 'Необходимо заполнить поле с текстом.'
        ],
    ];}