<?php

namespace Botble\CustomField\Http\Requests;

use Botble\Support\Http\Requests\Request;

class CreateFieldGroupRequest extends Request
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     * @author Turash Chowdhury
     */
    public function rules()
    {
        return [
            'field_group.order' => 'integer|min:0|required',
            'field_group.rules' => 'json|required',
            'field_group.title' => 'string|required|max:255',
            'field_group.status' => 'required',
        ];
    }
}
