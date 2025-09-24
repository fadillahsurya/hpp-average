<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateTransactionRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        return [
            'type'  => ['sometimes', Rule::in(['Pembelian','Penjualan'])], 
            'date'  => ['sometimes','date','date_format:Y-m-d'],          
            'qty'   => ['sometimes','numeric','not_in:0'],                 
            'price' => [
                'sometimes','nullable','numeric','gte:0',
                Rule::requiredIf(fn () => $this->input('type') === 'Pembelian'),
            ],
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($v) {
            if ($this->input('type') === 'Pembelian' && $this->filled('qty')) {
                $qty = (float) $this->input('qty');
                if ($qty <= 0) {
                    $v->errors()->add('qty', 'Qty pembelian harus lebih dari 0.');
                }
            }
        });
    }
}
