<?php

namespace App\Services\Comment;

use App\Models\CommentModel;

class Service
{
    public function getPagination(
        string $orderFilter = 'id',
        string $sortMethod = 'ASC',
        int $perPage = 10,
        int $pageNum = 1
    ): array
    {
        $commentModel = new CommentModel();
        $commentModel->builder()
            ->select('
                comments.id AS id,
                comments.text AS text,
                comments.date AS date,
                users.email AS email
            ')
            ->join('users', 'comments.user_id = users.id')
            ->orderBy($orderFilter, $sortMethod);
        $commentsData = $commentModel->paginate($perPage, 'groupComments', $pageNum);

        return [
            'comments'      => $commentsData,
            'pageCount'     => $commentModel->pager->getPageCount('groupComments'),
            'currentPage'   => $commentModel->pager->getCurrentPage('groupComments')
        ];
    }

    public function delete(int $commentId)
    {
        $commentModel = new CommentModel();
        $commentModel->delete($commentId);
    }
}