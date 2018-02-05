<?php

namespace Botble\Support\Services;

use Illuminate\Http\Request;

interface ProduceServiceInterface
{
    /**
     * Execute produce an entity
     *
     * @param Request $request
     * @return mixed
     * @author Turash Chowdhury
     */
    public function execute(Request $request);
}
