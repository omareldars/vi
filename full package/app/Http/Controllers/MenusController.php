<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DB;
use App\Menu;
use Redirect;

class MenusController extends Controller
{
    public function add_Menu() {
        $this->preProcessingCheck('manage_menus');
        return view('admin.settings.menus.add_new_menu');
    }
    public function store_Menu(Request $request)
    {
            $this->preProcessingCheck('manage_menus');
            $newMenu = new Menu();
            $newMenu->menu_type = $request->input('menu_type');
            $newMenu->parent_id = $request->input('parent_id');
            $newMenu->title = $request->input('title');
			$newMenu->ar_title = $request->input('ar_title');
            $newMenu->url = $request->input('url');
			$newMenu->order = $request->input('order');
			$newMenu->target = $request->input('target');
            $newMenu->user_added = Auth::user()->id;
            $newMenu->Save();
            return redirect('admin/menus')->with('message', 'StoredSuccessfully');
    }
    public function myMenus(){
        $this->preProcessingCheck('manage_menus');
        $getMenus = Menu::orderBy('order','ASC')->get();
        return view('admin.settings.menus.menus')
            ->with('getMenus',$getMenus);
    }
    public function editMenu($id,Request $request){
            $this->preProcessingCheck('manage_menus');
            $getMenu = Menu::findOrfail($id);
            return view('admin.settings.menus.edit_menu')
                ->with('getMenu',$getMenu);
    }
    public function updatemenu($id,Request $request){
            $this->preProcessingCheck('manage_menus');
            $updateMenu = Menu::findOrfail($id);
           	$updateMenu->menu_type = $request->input('menu_type');
           	$updateMenu->parent_id = $request->input('parent_id');
            $updateMenu->title = $request->input('title');
			$updateMenu->ar_title = $request->input('ar_title');
            $updateMenu->url = $request->input('url');
			$updateMenu->order = $request->input('order');
			$updateMenu->target = $request->input('target');
            $updateMenu->user_added = Auth::user()->id;
            $updateMenu->Save();
         return redirect('admin/menus')->with('message', 'StoredSuccessfully');
    }
    public function deleteMenu($id)
    {
            $this->preProcessingCheck('manage_menus');
            Menu::Destroy($id);
            return redirect()->back()->with('message', 'DeletedSuccessfully');
    }
}
