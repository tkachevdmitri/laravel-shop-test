<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
			'title' => 'required|unique:products',
			'price' => 'required|numeric|min:0',
			'category_id' => 'required|exists:categories,id',
			'article' => 'required|unique:products',
			'brand' => 'required',
			'image' => 'nullable|image',
			'is_new' => 'boolean',
			'is_recommended' => 'boolean',
			'status' => 'boolean',
		];
    }
}
