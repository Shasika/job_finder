<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreJobDetail extends FormRequest
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
        $rules = [
            'subject' => ['required','max:255'],
            'description' => ['required'],
            'requirements' => ['required'],
            'education_and_experience' => ['required'],
            'location' => ['required'],
            'vacancy_count' => ['required'],
            'salary' => ['nullable', 'string','max:255'],
            'vacancy_end_date' => ['nullable', 'date_format:Y-m-d'],
            'job_type' => ['required'],
        ];

        return $rules;
    }

    public function messages()
    {
        return [

        ];
    }
}
