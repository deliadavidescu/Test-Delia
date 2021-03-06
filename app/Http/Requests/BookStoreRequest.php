<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BookStoreRequest extends FormRequest {

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize() {
        return TRUE;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules() {
        return [
            'authorName' => 'required|min:3',
            'bookTitle' => 'required|min:3',
            'age' => 'required|max:3|integer',
            'address' => 'required|min:5',
            'date' => 'required',
        ];
    }
}
