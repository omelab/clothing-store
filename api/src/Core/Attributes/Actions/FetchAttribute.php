<?php

namespace GetCandy\Api\Core\Attributes\Actions;

use GetCandy\Api\Core\Attributes\Models\Attribute;
use GetCandy\Api\Core\Scaffold\AbstractAction;
use Illuminate\Http\JsonResponse;

class FetchAttribute extends AbstractAction
{
    /**
     * Determine if the user is authorized to make this action.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the action.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'encoded_id' => 'string|required_without:handle',
            'handle' => 'string|required_without:encoded_id',
        ];
    }

    /**
     * Execute the action and return a result.
     *
     * @return bool
     */
    public function handle()
    {
        return Attribute::whereHandle($this->handle)->first();
    }

    /**
     * Returns the response from the action.
     *
     * @param   bool $result
     * @param   \Illuminate\Http\Request  $request
     *
     * @return  JsonResponse
     */
    public function response($result, $request)
    {
        return $this->respondWithNotContent();
    }
}
