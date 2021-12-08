<?php

namespace App\Http\Requests;

use App\Rules\filterRule;
use Illuminate\Foundation\Http\FormRequest;

class CategoryRequest extends FormRequest
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
        // to get the value of parameter from route (id) to ignore it from unique cause update func
        $id = $this->route('id');
        return [
            'name' =>[
                'required',
                'string',
                'max:255',
                'min:3',
                'unique:categories,id,'. $id,
                //'filter:php,laravel'
                //i can use rule once like that 
                // function($attribute, $value, $fail){
                //     if(stripos($value, 'god') !== false){
                //         $fail('You cannot use "god" word in your input');
                //     }
                // }
                // or using rule class as filterRule we created
                 new filterRule(['george ayman','god','mimi','php','laravel']),

            ], 
            'parent_id' => 'nullable|int|exists:categories,id',
            'description' => [
                'nullable',
                'min:10',
                new filterRule(['george ayman','god','mimi','php','laravel']),
            ],
            'status' => 'required|in:active,draft',
            'image' => 'image|max:1024000|dimensions:min_width=300,min_height=300'
        ];
    }
    public function messages(){
        return [
            'name.required' => 'Category name is required',
            'description.min' => 'Please write more details ya ksmk',
            'status.required' => 'e5tar :attribute ya 5wal'
        ];
    }
}
