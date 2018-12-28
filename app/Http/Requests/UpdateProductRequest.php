<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateProductRequest extends FormRequest
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
			'title' => [
				'required',
				 //Rule::unique('products')->ignore($id),
			],
			'price' => 'required|numeric|min:0',
			'category_id' => 'required|exists:categories,id',
			'article' => [
				'required',
				//Rule::unique('products')->ignore($id)
			],
			'brand' => 'required',
			'is_new' => 'boolean',
			'is_recommended' => 'boolean',
			'status' => 'boolean',
        ];
    }
}
