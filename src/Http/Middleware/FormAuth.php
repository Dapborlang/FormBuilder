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
        foreach (Auth::user()->role as $item) {
            array_push($roleKey,$item->role);
        } 

        $compare= array_intersect($roleController,$roleKey);  

        if(sizeof($compare)<1)
        {            
            return redirect('home');
        } 

        if (\Route::current()->getName() == 'formCreate') {
            if(!Auth::user()->role->where('role',$role)->first->create)
            {
                return $role;
                // redirect('home')->with(['message'=> 'You Have No Access Right!!! Please contact your administrator']);
            }
        }

        if (\Route::current()->getName() == 'formIndex') {
            if(!Auth::user()->role->where('role',$role)->first->view)
            {
                return redirect('home')->with(['message'=> 'You Have No Access Right!!! Please contact your administrator']);
            }
         }

        if (\Route::current()->getName() == 'formUpdate') {
            if(!Auth::user()->role->where('role',$role)->first->update)
            {
                return redirect('home')->with(['message'=> 'You Have No Access Right!!! Please contact your administrator']);
            }
         }

        if (\Route::current()->getName() == 'formDelete') {
            if(!Auth::user()->role->where('role',$role)->first->delete)
            {
                return redirect('home')->with(['message'=> 'You Have No Access Right!!! Please contact your administrator']);
            }
         }

        return $next($request);
    }
}
