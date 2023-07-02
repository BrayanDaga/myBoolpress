<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class PostRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            //campos de post
            'title' => 'required|max:150',
            'subtitle' => 'required|max:100',
            'text' => 'required|max:150',
            'user_id' => 'required|exists:users,id',
            'publication_date' => 'required|date',
            //campos de InfoPost 
            'post_id' => 'nullable', //Supongo que no es neceario ya que se agrega como $post->infoPost()->create($data);
            'post_status' => ['required', Rule::in(['public', 'private', 'draft'])],
            'comment_status' => ['required', Rule::in(['open', 'closed', 'private'])],
            'tags' => 'nullable'
        ];
    }
}
