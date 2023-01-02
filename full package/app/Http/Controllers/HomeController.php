<?php

namespace App\Http\Controllers;

use App\Documentation;
use App\Events\WebMessage;
use App\ServicesRequests;
use Illuminate\Http\Request;

use App\Company;
use App\Service;
use App\User;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $user = auth()->user();
        if ($user->hasanyRole('Admin|Editor|Manager'))
            return view('admin.dashboard');
        elseif ($user->hasRole('Registered|Page Manager|Pages Editor')) {
            return view('admin.clients.dashboard');
        } elseif ($user->hasRole('Mentor')) {
            return view('admin.clients.mentor');
        } elseif ($user->hasRole('Judger')) {
            return view('admin.clients.judge');
        } elseif ($user->hasRole('Disabled')) {
            return view('admin.clients.disabled');
        } else
            abort(401);
    }

    private function getInterstedinServices($user)
    {

        return null;
    }

    public function directory(Request $request)
    {
        $t = $request->input('type');
        $find = $request->input('find');
        $services = Service::whereNotNull('id');
        if ($t) {
        $services = $services->where('service_category_id',$t);
        }
        if ($find) {
                $services = $services->where(function ($query) use ($find) {
                    $query->where('services.name_en', 'like', '%' . $find . '%')
                        ->orWhere('services.name_ar', 'like', '%' . $find . '%');
                });
        }
        $services = $services->get();
        return view('admin.clients.directory')->with('services', $services);
    }
    public function rateservice($id,Request $request){
        if ($request && $id){
            $request->done?$done=1:$done=null;
            ServicesRequests::updateOrInsert(['id'=>$id],['rate'=>$request->rate,'rate_comment'=>$request->comment,'done'=>$done]);
            return back();
        }
        return back();
    }
    public function showone($id,Request $request) {
        if ($request && $id){
            $service = Service::findOrFail($id);
            $rate=(int)$service->myRate();
            $service->rate=$rate;
            return response()->json($service);
        }
        return response()->json(['state' => 'failed'], 500);
    }

    public function servicereq(Request $request)
    {
        if ($request){
            ServicesRequests::create(['service_id'=>$request->id, 'user_id'=>Auth::id(), 'comment'=>$request->comment,'date_time'=>$request->datetime]);
            event(new WebMessage('NewServ', Auth::user()->first_name_en .' '. Auth::user()->last_name_en));
            return response()->json(['state'=> 'success']);
        }
        return response()->json(['state' => 'failed'], 500);
    }
    public function dark(Request $request)
    {
        $request->l=='dark' ? session(['layout' =>'light','icon'=>'bxs-sun']) : ($request->l=='light' ? session(['layout' =>'semi-dark','icon'=>'bx-moon']) : session(['layout' =>'dark','icon'=>'bx-sun']));
        return back();
    }
    public function help($id=1)
    {
        if (Auth::user()->hasanyRole('Admin|Manager')) {
            $role = 'admin';
        } elseif (Auth::user()->hasRole('Mentor')) {
            $role = 'mentor';
        } elseif (Auth::user()->hasRole('Judger')){$role = 'judge';} else {$role = 'user';}
            $role = ['all',$role];
        $doc = Documentation::whereIn('role',array_values($role))->where('id',$id)->first();
        $menu = Documentation::whereIn('role',array_values($role))->orderBy('arr','ASC')->get(['id','menu_ar','menu_en','icon']);
        if (count($menu)==0 or !$doc) {abort(404);}
        return view('admin.documentation', compact('doc','menu'));
    }
}
