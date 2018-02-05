<?php

namespace Botble\Contact\Repositories\Interfaces;

use Botble\Support\Repositories\Interfaces\RepositoryInterface;

interface ContactInterface extends RepositoryInterface
{
    /**
     * @param array $select
     * @return mixed
     * @author Turash Chowdhury
     */
    public function getUnread($select = ['*']);

    /**
     * @return int
     * @author Turash Chowdhury
     */
    public function countUnread();
}
