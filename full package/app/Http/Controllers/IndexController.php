<?php
namespace App\Http\Controllers;
use App\Events\WebMessage;
use App\Messages;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Closure;
use App;
use Illuminate\Support\Facades\Route;

class IndexController extends Controller
{
    private $t; // Front title
    private $SocialIcons; // Social media icons
    private $contact; // Footer contact details

    public function __construct()
    {
        $this->t = App\Settings::where('type', '1')->first(['ar_title', 'title']);
        $this->SocialIcons = App\settings::where('type', 2)->whereNotNull('url')->orderBy('set_order')->get();
        $this->contact = App\Settings::findorfail('11');

    }

    public function lang($locale)
    {
        $availLocale=['ar'=>'ar','en'=>'en'];
        if(array_key_exists($locale,$availLocale)) {
            App::setLocale($locale);
            session()->put('locale', $locale);
        }
        return redirect()->back();
    }

    public function home()
    {
        $CR = Route::getFacadeRoot()->current()->uri();
        if ($CR == "about") {
            $about = App\Settings::findorfail('10');
            return view('pages.about')->with('t', $this->t)->with('about', $about)->with('SocialIcons', $this->SocialIcons)->with('contact', $this->contact);
        }
        elseif ($CR == "contact") {
            return view('pages.contact')->with('t', $this->t)->with('contact', $this->contact)->with('SocialIcons', $this->SocialIcons);
        }
        elseif ($CR == "events") {
            return view('pages.events')->with('t', $this->t)->with('contact', $this->contact)->with('SocialIcons', $this->SocialIcons)->with('CR',$CR);
        }
        elseif ($CR == "faqs") {
            $faqs = App\Faq::whereNotNull('Published')->get();
            return view('pages.faqs')->with('t', $this->t)->with('contact', $this->contact)->with('SocialIcons', $this->SocialIcons)->with('CR',$CR)->with('faqs',$faqs);
        }
        elseif ($CR == "/") {
            $CR = 'pages.home';
        } else {
            $CR = 'pages.' . $CR;
        }
        return view($CR)->with('t', $this->t)->with('SocialIcons', $this->SocialIcons)->with('contact', $this->contact);
    }

    public function post($id)
    {
        $post = App\Posts::where('published','on')->where('id', $id)->first();
        if ($post) {
            return view('pages.blog-details')
                ->with('t', $this->t)
                ->with('SocialIcons', $this->SocialIcons)->with('contact', $this->contact)->with('post', $post);
        } else {
            return abort(404);
        }
    }

    public function page($id)
    {
        $page = App\Pages::where('published','on')->where('url', $id)->first();
        if ($page) {
            return view('pages.page')
                ->with('t', $this->t)->with('SocialIcons', $this->SocialIcons)->with('contact', $this->contact)->with('page',$page);
        } else {
            return abort(404);
        }
    }

    public function event($id)
    {
        $event = App\Event::whereNotNull('published')->where('id', $id)->first();
        if ($event) {
            return view('pages.event')
                ->with('t', $this->t)->with('SocialIcons', $this->SocialIcons)->with('contact', $this->contact)->with('event', $event);
        } else {
            return abort(404);
        }
    }

    public function message(Request $message)
    {
        $Email = $message->input('email');
        $setmail = App\Settings::where('id', '11')->first(['title']);
        // Send Mail
        if ($Email = filter_var($Email, FILTER_VALIDATE_EMAIL)) {
            $user = new App\User();
            $user->email = $setmail->title;
            $MSG = new App\Notifications\TemplateEmail;
            $MSG->Message = ["New subscribe to Newsletter ",
                "Add my Email to your newsletter list: ", $Email, "subscribe from VI website"];
            $user->notify($MSG);
            return redirect()->back()->with('message', 'Done');
        } else {
            return redirect()->back()->with('message', 'Fail');
        }
    }

    public function sendmsg(Request $request)
    {
        $Email = $request->input('Email');
        if ($Email == filter_var($Email, FILTER_VALIDATE_EMAIL)) {
            $new = new Messages();
            $new->name = $request->input('Name');
            $new->internal_id = $request->internal_id ?? null ;
            $new->phone = $request->input('Phone');
            $new->email = $Email;
            $new->subject = $request->input('Subject');
            $new->message = $request->input('Comment');
            $new->userip = $request->getClientIp();
            $new->Save();
            event(new WebMessage('mymsg', $request->input('Name')));
            return redirect()->back()->with('message', 'Done');
        } else {
            return redirect()->back()->with('message', 'Fail');
        }
    }

    public function search(Request $request)
    {
        $term = $request->input('find');
        if (isset($term)) {
            $post = App\Posts::where('published', 'on')->where(function ($query) use ($term) {
                $query->where('title', 'like', '%' . $term . '%');
                $query->orWhere('ar_title', 'like', '%' . $term . '%');
            })->get();
        } else {
            $post = [];
            $term = null;
        }
        return view('pages.search')
            ->with('t', $this->t)
            ->with('SocialIcons', $this->SocialIcons)
            ->with('contact', $this->contact)->with('post', $post)->with('term', $term);
    }

    public function eventregister(Request $request)
    {
        $Email = $request->input('Email');
        $ChkReg = App\EventsUser::where('email',$Email)->where('event_id',$request->input('eventid'))->get('id');
        if ($Email = filter_var($Email, FILTER_VALIDATE_EMAIL)) {
            $ChkReg = App\EventsUser::where('email',$Email)->where('event_id',$request->input('eventid'))->first('id');
            if ($ChkReg) {return redirect()->back()->with('message', 'already');}
            $new = new App\EventsUser();
            $new->name = $request->input('Name');
            $new->phone = $request->input('Phone');
            $new->email = $Email;
            $new->employer = $request->input('employer');
            $new->jobtitle = $request->input('jobtitle');
            $new->event_id = $request->input('eventid');
            $new->Save();
            // event(new App\Events\WebMessage($request->input('Name')));
            return redirect()->back()->with('message', 'Done');
        } else {
            return redirect()->back()->with('message', 'Fail');
        }
    }

}
