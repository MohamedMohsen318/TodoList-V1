<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class AdminRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user('admin')?->can('create-admin') || $this->user('admin')?->can('edit-admin');
    }

    public function rules(): array
    {
        $adminId = optional($this->route('admin'))->id;
        $passwordRule = $adminId ? 'nullable' : 'required';

        return [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:100|unique:admins,email,'.$adminId,
            'phone' => 'nullable|string|max:20|unique:admins,phone,'.$adminId,
            'password' => [$passwordRule, 'string', 'min:6'],
            'roles' => 'required|array|min:1',
            'roles.*' => 'exists:roles,name',
        ];
    }
}
