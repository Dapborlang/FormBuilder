<?php

namespace Rdmarwein\Formbuilder\Http\Middleware;

use Closure;
use Auth;
class FormAuth
{
   
    public function handle($request, Closure $next, $role)
    {
        $roleKey=[];
        $roleController=explode('|', $role);
        foreach (Auth::user()->formRole as $item) {
            array_push($roleKey,$item->role);
        } 

        $compare= array_intersect($roleController,$roleKey);  

        if(sizeof($compare)<1)
        {            
            return redirect('home');
        } 

        if ($request->route()->named('formCreate')) {
            if(!Auth::user()->formRole->where('role',$role)->first->create)
            {
                return redirect('home')->with(['message'=> 'You Have No Access Right!!! Please contact your administrator']);
            }
        }

        if ($request->route()->named('formIndex')) {
            if(!Auth::user()->formRole->where('role',$role)->first->view)
            {
                return redirect('home')->with(['message'=> 'You Have No Access Right!!! Please contact your administrator']);
            }
         }

        if ($request->route()->named('formUpdate') ||  $request->route()->named('formEdit')) {
            if(!Auth::user()->formRole->where('role',$role)->first->update)
            {
                return redirect('home')->with(['message'=> 'You Have No Access Right!!! Please contact your administrator']);
            }
         }

        if ($request->route()->named('formDelete')) {
            if(!Auth::user()->formRole->where('role',$role)->first->delete)
            {
                return redirect('home')->with(['message'=> 'You Have No Access Right!!! Please contact your administrator']);
            }
         }

        return $next($request);
    }
}
