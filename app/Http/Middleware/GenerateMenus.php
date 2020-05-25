<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
//use Lavary\Menus\MenuBuilder;


class GenerateMenus
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        //$builder = new MenuBuilder();
        \Menu::make('MyNavBar', function ($menu) {

            /*$menu->group(array('prefix' => 'user'), function($m) use($about){*/
                $wfhuser = $menu->add('Manage WFH User & Group', array('route'=>'page.grouplist','url' => 'user/grouplist','id' => 'usergroup'))->data('permission','Admin');
                //$wfhuser->link->attr(['class' => 'nav-link']);
                $inhouseuser =$menu->add('Manage In-House User', array('url' =>'user/inhouseuser','id' => 'inhouse'))->data('permission','Admin');
                //$overidetkt = $menu->add('Override Ticket Volume', array('url' =>'user/datelist','id' => 'override'))->data('permission','Admin');
             /* });*/  //open for top    side bar active menu is => active

               $menu->group(array('prefix' => 'user'), function($m) use($wfhuser){
            
                $wfhuser->add('User Group List', array('url'=>'grouplist','parent' => $wfhuser->id))->data('permission','Admin');
                $wfhuser->add('Add User Group', array('url'=>'addgroup','parent' => $wfhuser->id))->data('permission','Admin');
                //$wfhuser->add('Add WFH User', array('url'=>'addwfhuser','parent' => $wfhuser->id))->data('permission','Admin');
                //$wfhuser->add('Add User Group', array('url'=>'addgroup','parent' => $wfhuser->id))->data('permission','Admin');
                $wfhuser->add('Overridden Ticket Volume', array('url'=>'alldatelist',$wfhuser->id))->data('permission','Admin');
                //$wfhuser->add('Add Date Ranges', array('url'=>'overridedate',$wfhuser->id))->data('permission','Admin');
              });

               //manage inhouse user
               $menu->group(array('prefix' => 'user'), function($m) use($inhouseuser){
            
                $inhouseuser->add('In-house User List', array('url'=>'inhouseuser',$inhouseuser->id))->data('permission','Admin');
                $inhouseuser->add('Add In-House User', array('url'=>'addhouseuser',$inhouseuser->id))->data('permission','Admin');
                //$inhouseuser->add('Edit In-House User', array('url'=>'addhouseuser',$inhouseuser->id))->data('permission','Admin');
              });

               //manage overriding volumes
               /*$menu->group(array('prefix' => 'user'), function($m) use($overidetkt){
            
             
              });*/



        });
      /*  if (Auth::guard($guard)->guest()) {
            if ($request->ajax() || $request->wantsJson()) {
                return response('Unauthorized.', 401);
            } else {
                return redirect()->guest('login');
            }
        }*/
        return $next($request);
    }
}
