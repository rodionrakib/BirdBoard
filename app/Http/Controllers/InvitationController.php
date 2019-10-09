<?php

namespace App\Http\Controllers;

use App\Project;
use Illuminate\Http\Request;
use App\Http\Requests\MemberInvitation;
use App\User;

class InvitationController extends Controller
{
    public function store(Project $project, MemberInvitation $request)
    {

    	$this->authorize('manage',$project);
        
        $validator = $request->validated();


        $invitedTo = User::where('email',$request->get('email'))->first();


        $project->invite($invitedTo);

        return redirect($project->path());



    }
}
