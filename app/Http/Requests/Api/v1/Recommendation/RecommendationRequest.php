<?php

namespace App\Http\Requests\Api\v1\Recommendation;

use App\Services\RecommendationService\Dto\RecommendationDto;
use Illuminate\Foundation\Http\FormRequest;

class RecommendationRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'limit' => ['sometimes', 'integer', 'min:10'],
            'offset' => ['sometimes', 'integer', 'min:1'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }

    public function toDto(): RecommendationDto
    {
        $data = $this->validated();

        return new RecommendationDto([
            'user_id' => $this->user()->id,
            'limit' => intval($data['limit'] ?? null),
            'offset' => intval($data['offset'] ?? null),
        ]);
    }
}
