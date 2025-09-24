<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreTransactionRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        return [
            'type'  => ['required', Rule::in(['Pembelian','Penjualan'])],
            'date'  => ['required','date','date_format:Y-m-d'],  
            'qty'   => ['required','numeric','not_in:0'],
            'price' => [
                'nullable','numeric','gte:0',
                Rule::requiredIf(fn () => $this->input('type') === 'Pembelian'),
            ],
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($v) {
            $type = $this->input('type');
            $qty  = (float) $this->input('qty');

            if ($type === 'Pembelian' && $qty <= 0) {
                $v->errors()->add('qty', 'Qty pembelian harus lebih dari 0.');
            }
        });
    }
}
