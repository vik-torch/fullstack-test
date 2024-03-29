<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table = 'users';
    protected $allowedFields = ['email'];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField = '';
    protected $deletedField = '';

    protected $validationRules = [
        'email' => 'required|max_length[254]|valid_email',
    ];

    protected $validationMessages = [
        'email' => [
            'required'        => 'Необходимо заполнить email',
            'max_length[254]' => 'Длина email не должна превышать 254 символа',
            'valid_email'     => 'Некорректный email адрес',
        ],
    ];

}