<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Message;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
class MessagesController extends Controller
{

  public function __construct(){
    $this->middleware('auth');
  }

  public function index()
  {
    /* the relationship is belongsto so the message belongs to one user
    */
    /*select messages that are not deleted */
    $messages=Message::with('userFrom')->where('user_id_to',Auth::id())->notDeleted()->get();
  //  dd($message);
      return view('home')->with('messages',$messages);
  }

  public function create(int $id= 0,String $subject=''){
if($id===0){
         $users=User::where('id','!=',Auth::id())->get();
       }
       else {
         $users= User::where('id',$id)->get();
       }

       if ($subject !=='') $subject= 'Re '.$subject;
      //   dd($users);
         return view('create')->with(['users'=>$users,'subject'=>$subject]);
  }

  public function send(Request $request){
 $this->validate($request,[
   'subject'=>'required',
   'message'=>'required'
 ]);
//dd($request);
$message=new Message();
$message->user_id_from=Auth::id();
$message->user_id_to=$request->input('to');
$message->subject=$request->input('subject');
$message->body=$request->input('message');
$message->save();

return redirect()->to('/home')->with('status','Message sent successfully!');
  }

public function sent(){
$messages=Message::with('userTo')->where('user_id_from',Auth::id())->orderBy('created_at','desc')->get();

return view('sent')->with('messages',$messages);
}
public function read(int $id){
$message=Message::with('userFrom')->find($id);
$message->read=true;
$message->save();
  return view('read')->with('message',$message);
}

public function delete (int $id)
{
  /*soft delete we are not going to delete it from database*/
  $message=Message::find($id);
  $message->deleted=true;
  $message->save();
  return redirect()->to('/home')->with('status','Message deleted Successfully');
}


public function deleted()
{
  /* the relationship is belongsto so the message belongs to one user
  */
  /*select messages that are not deleted */
  $messages=Message::with('userFrom')->where('user_id_to',Auth::id())->Deleted()->get();
//  dd($message);
    return view('deleted')->with('messages',$messages);
}

public function return(int $id){
  $message=Message::find($id);
  $message->deleted =false;
  $message->save();
  return redirect()->to('/home')->with('status','Message returned to inbox Successfully');

}


}
