<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class filterRule implements Rule
{
    protected $words;
    public $filtered = [];
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($words)
    {
        $this->words = $words;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        foreach($this->words as $word){
            if(stripos($value, $word) !== false){
                // it includes one of the bad words
                $this->filtered[] = $word;
            }
        }
        //if filtered array have values return false else return true
        return empty($this->filtered);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        if(in_array('george ayman',$this->filtered)){
            return 'You cannot use "George Ayman" This is the Developer name ya 3ars';
        }
        return 'You cannot use "'.implode(', ', $this->filtered ).'" word in your input';
    }
}
