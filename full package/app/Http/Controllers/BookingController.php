<?php

namespace App\Http\Controllers;

use App\Inclusive;
use App\Room;
use App\room_booking;
use App\Rooms_inclusive;
use App\Rooms_img;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use \Spatie\Permission\Models\Role as Role;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserPasswordRequest;

use DB;
use Log;
use Exception;
use Session;
use Hash;
use Illuminate\Support\Facades\Auth;

class BookingController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }
    public function index(){

        try{

            $this->preProcessingCheck('view_user');
            $rooms = Room::with('User')->get();
            return view('admin/rooms/booking/index', compact('rooms'));

        }catch (Exception $e){

            //log what happend
            Log::channel('system_exceptions')->info('Exceptions:', [$e]);
            abort(500);

        }
    }
    public function review(){
        try{
            $this->preProcessingCheck('view_user');
            $booking_reviews = room_booking::where('fromDate','>=',Carbon::now())->where('approved','=','Reviewing')->with('room')->with('client')->with('User')->get();
            return view('admin/rooms/booking/bookingreview', compact('booking_reviews'));
        }catch (Exception $e){
            //log what happend
            Log::channel('system_exceptions')->info('Exceptions:', [$e]);
            abort(500);
        }
    }

    public function upcomingApprovedReview(){
        try{

            $this->preProcessingCheck('view_user');
            $booking_reviews = room_booking::where('fromDate','>=',Carbon::now())->where('approved','=','approved')->with('room')->with('client')->with('User')->get();
            return view('admin/rooms/booking/bookingreview', compact('booking_reviews'));
        }catch (Exception $e){
            //log what happend
            Log::channel('system_exceptions')->info('Exceptions:', [$e]);
            abort(500);

        }
    }

    public function upcomingBusyReview(){
        try{

            $this->preProcessingCheck('view_user');
            $booking_reviews = room_booking::where('fromDate','>=',Carbon::now())->where('approved','=','Busy')->with('room')->with('client')->with('User')->get();
            return view('admin/rooms/booking/bookingreview', compact('booking_reviews'));
        }catch (Exception $e){
            //log what happend
            Log::channel('system_exceptions')->info('Exceptions:', [$e]);
            abort(500);

        }
    }

    public function oldReview(){
        try{

            $this->preProcessingCheck('view_user');
            $booking_reviews = room_booking::where('fromDate','<=',Carbon::now())->with('room')->with('client')->with('User')->get();
            return view('admin/rooms/booking/oldReview', compact('booking_reviews'));
        }catch (Exception $e){
            //log what happend
            Log::channel('system_exceptions')->info('Exceptions:', [$e]);
            abort(500);

        }
    }
    public function create()
    {
        try{

            $this->preProcessingCheck('view_user');
            $rooms = Room::with('User')->get();
            return view('admin/rooms/booking/index', compact('rooms'));

        }catch (Exception $e){

            //log what happend
            Log::channel('system_exceptions')->info('Exceptions:', [$e]);
            abort(500);

        }
    }
    public function store(request $request)
    {
            $user = Auth()->user()->id;
            $room = Room_booking::create($request->except(['user_id'],['approved'],['user_added']) +
                ['user_id' => $user,
                'approved' => 'Reviewing',
                'user_added' => null]
            );
            if($room)
            {

                return redirect()->back()->with( ['msg' => 'StoredSuccessfully'] );
            }
            return redirect()->back()->with( ['msg' => 'admin.FailedStore'] );


    }
    public function show($id)
    {
        try{

            $this->preProcessingCheck('add_user');
            $room = Room::findOrFail($id);
            $roomImages= Rooms_img::where('room_id',$id)->get();
            $roomInclusive = Rooms_inclusive::where('room_id','=',$id)->get();
            return view('admin.rooms.booking.create')
                ->with('room', $room)
                ->with('roomInclusive',$roomInclusive)
                ->with('roomImages',$roomImages);

        }catch (Exception $e){
            //log what happend
            Log::channel('system_exceptions')->info('Exceptions:', [$e]);
            abort(500);
        }
    }
    public function edit($id)
    {

    }
    public function update($id, request $request)
    {

    }

    public function approve($id,$action){

            $this->preProcessingCheck('edit_user');
            $user = Auth()->user()->id;
            $getBooking = Room_booking::findOrfail($id);
            if ($action =='1'){
                $getBooking->approved='Approved';

            }else{
                $getBooking->approved='Busy';
            }
                $getBooking->user_added=$user;
            $getBooking->save();
            return redirect()->back()->with('msg', 'You successfully update the Request.');




    }
    public function roomImages($id,Request $request)
    {
        $roomImages= Rooms_img::where('room_id',$id)->get();
        /* $RoomImages2='Hello World!';
             return response()->json(array('msg' => $RoomImages2), 200);*/
        return view('admin/rooms/images', compact('roomImages','id'));
    }
    public function deleteImages($id)
    {

        $this->preProcessingCheck('delete_user');
        $image = Rooms_img::find($id);
        $image->delete();
        if ($image){
         return redirect()->back()->with( ['msg' => 'DeleteSuccessfully'] );
        }
        return redirect()->back()->with( ['msg' => 'admin.FailedDelete'] );

    }
    public function destroy(User $user)
    {
        if ($user->id==1){return response()->json([
            'state' => 'failed'
        ], 500);}
        try{
            $this->preProcessingCheck('delete_user');
            $user->roles()->detach();
            $user->delete();
            $user->company()->delete();
            return response()->json([
                'state' => 'success'
            ], 200);
        }catch (Exception $e){

            //log what happend
            Log::channel('system_exceptions')->info('Exceptions:', [$e]);
            return response()->json([
                'state' => 'failed'
            ], 500);

        }
    }
}
