@extends('layouts.app')

@section('content')


                   @if (count($messages) >0)
                   <ul class="list-group">
                   @foreach($messages as $message)

                    <li class="list-group-item">
                      <strong>From:{{$message->userFrom->name}} ,{{$message->userFrom->email}}</strong>
                       |subject:{{$message->subject}}
                     </li>
 <a href="{{route('return',$message->id)}}" class="btn btn-info float-right btn-sm">Return message to inbox</a>
                   @endforeach
                 </ul>
                   @else
                   No messages!
                   @endif

@endsection
