<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Project;

class MemberInvitation extends FormRequest
{

    protected $errorBag = 'invitation';

    // /**
    //  * Determine if the user is authorized to make this request.
    //  *
    //  * @return bool
    //  */
    // public function authorize()
    // {
        

    //     $project = Project::find($this->route('project'))->first();
       
    //     return $this->user()->is($project->owner);
        
    // }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {

        
        return [
            'email' => ['required','exists:users,email']
        ];
    }

    public function messages()
    {
        return [
            'email.exists' => 'User must have account'
        ];
    }

}
