<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DB;
use App\Slider;
use Carbon\Carbon;
use Redirect;

class SlidersController extends Controller
{
    public function add_slide(){
        $this->preProcessingCheck('add_slide');
        return view('admin.settings.sliders.add_new_slide');
    }
    public function store_slide(Request $request)
    {
            $this->preProcessingCheck('add_slide');
if(in_array($request->file('image')->getClientMimeType(),["image/png","image/jpeg","image/gif"])){
            $file = $request->file('image');
            $path = 'images/slider/';
            $fileExtension = $request->file('image')->getClientOriginalExtension();
            $filename = \Illuminate\Support\Str::random(10).\Illuminate\Support\Str::limit(Carbon::today().Carbon::now(),10,'slide');
            $filename2 =$filename.'.'.$fileExtension;
            $file->move($path, $filename.'.'.$fileExtension);
            $newslider = new Slider();
            $newslider->img_path = $filename2;
            $newslider->title = $request->input('title');
            $newslider->ar_title = $request->input('ar_title');
			$newslider->img_desc = $request->input('img_desc');
            $newslider->ar_img_desc = $request->input('ar_img_desc');
			$newslider->img_url = $request->input('img_url');
            $newslider->url_title = $request->input('url_title');
			$newslider->ar_url_title = $request->input('ar_url_title');
			$newslider->slideorder = $request->input('slideorder');
            $newslider->user_added = Auth::user()->id;
            $newslider->Save();
            return redirect('admin/slides')->with('message', 'StoredSuccessfully');
			}else{
			return redirect()->back()->with('message2', 'FailedStore');
						};
    }
    public function slides(){
        $this->preProcessingCheck('view_slide');
        $getSliders = Slider::orderBy('slideorder','ASC')->get();
        return view('admin.settings.sliders.sliders')
            ->with('getSliders',$getSliders);
    }
    public function editslide($id,Request $request){
            $this->preProcessingCheck('edit_slide');
            $getslider = Slider::findOrfail($id);
            return view('admin.settings.sliders.edit_slide')
                ->with('getslider',$getslider);
    }
    public function updateslide($id,Request $request){
            $this->preProcessingCheck('edit_slide');
			$updateslider = Slider::findOrfail($id);
	if($request->file('image')){
	if(in_array($request->file('image')->getClientMimeType(),["image/png","image/jpeg","image/gif"])){
            $file = $request->file('image');
            $path = 'images/slider/';
            $fileExtension = $request->file('image')->getClientOriginalExtension();
            $filename = \Illuminate\Support\Str::random(10).\Illuminate\Support\Str::limit(Carbon::today().Carbon::now(),10,'slide');
            $filename2 =$filename.'.'.$fileExtension;
            $file->move($path, $filename.'.'.$fileExtension);
 			$updateslider->img_path = $filename2;
			}}
            $updateslider->title = $request->input('title');
            $updateslider->ar_title = $request->input('ar_title');
			$updateslider->img_desc = $request->input('img_desc');
            $updateslider->ar_img_desc = $request->input('ar_img_desc');
			$updateslider->img_url = $request->input('img_url');
            $updateslider->url_title = $request->input('url_title');
			$updateslider->ar_url_title = $request->input('ar_url_title');
			$updateslider->slideorder = $request->input('slideorder');
            $updateslider->user_added = Auth::user()->id;
            $updateslider->Save();
         return redirect('admin/slides')->with('message', 'StoredSuccessfully');
    }
    public function deleteslide($id)
    {
            $this->preProcessingCheck('delete_slide');
            slider::Destroy($id);
            return redirect()->back()->with('message', 'DeletedSuccessfully');
    }
}
