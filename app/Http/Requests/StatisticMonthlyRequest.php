<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StatisticMonthlyRequest extends FormRequest
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
            'year'  => ['required', 'numeric', 'digits:4', 'min:1900', 'max:'.date("Y")],
            'month' => ['required', 'numeric', 'min:1', 'max:12']
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            if ($this->input('year') === date("Y") && $this->input('month') > date("m")) {
                $validator->errors()->add('month', 'You should select an older month');
            }
        });
    }
}
