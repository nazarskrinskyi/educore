<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TestSubmitRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'answers' => ['required', 'array'],
            'answers.*.question_id' => ['required', 'integer', 'exists:questions,id'],
            'answers.*.selected_answer_id' => ['nullable', 'integer', 'exists:answers,id'],
            'answers.*.selected_answer_ids' => ['nullable', 'array'],
            'answers.*.selected_answer_ids.*' => ['integer', 'exists:answers,id'],
            'answers.*.bool' => ['nullable', 'boolean'],
            'answers.*.text' => ['nullable', 'string'],
            'elapsed_seconds' => ['nullable', 'integer', 'min:0'],
            'is_completed' => ['nullable', 'boolean'],
        ];
    }

    protected function prepareForValidation(): void
    {
        if ($this->has('answers')) {
            $answers = collect($this->input('answers'))->map(function ($answer) {
                if (!empty($answer['selected_answer_ids']) && is_string($answer['selected_answer_ids'])) {
                    $decoded = json_decode($answer['selected_answer_ids'], true);
                    $answer['selected_answer_ids'] = is_array($decoded) ? $decoded : [];
                }
                return $answer;
            });

            $this->merge(['answers' => $answers->toArray()]);
        }
    }

    /**
     * Get the validation attributes that apply to the request.
     *
     * @return array
     */
    public function attributes(): array
    {
        return [
            //
        ];
    }

    /**
     * Get the validation messages that apply to the request.
     *
     * @return array
     */
    public function messages(): array
    {
        return [
            //
        ];
    }
}
