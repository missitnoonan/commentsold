<?php

namespace App\Http\Requests\Inventory;

use App\Library\JsonResponseData;
use App\Library\Message;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;

class InventoryListRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'page' => 'numeric',
            'limit' => 'numeric|max:100',
            'sort' => [Rule::in([
                'id', 'product_name', 'sku', 'quantity', 'color', 'size', 'price_cents', 'cost_cents',
            ])],
            'sort_direction' => [Rule::in(['desc', 'asc'])],
            'search' => 'min:3|max:100|string'
        ];
    }

    protected function failedValidation(Validator $validator) {
        throw new HttpResponseException(response()->json(
            JsonResponseData::formatData(
                $this,
                'Validation Failed',
                Message::MESSAGE_ERROR,
                [
                    'errors' => $validator->errors(),
                    'status' => true,
                ])
            , 422));
    }
}
