Dear {{$data['name']}}, <br>
Thanks for registering through our webiste.<br>
In order to get started on {{env('APP_NAME')}}, please confirm your email by clicking on the link below: <br>
<a href="{{route('activateAccount',$data['id'])}}?hash={{$data['hash']}}"> Click Here to Confirm You Account</a>

<br><br>

Warm regards,
