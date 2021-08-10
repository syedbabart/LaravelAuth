@extends('adminNavBar.master')
@section('content')
<div class="row">
            <div class="col-md-6 col-md-offset-3">
                <h4>Profile</h4><hr>
                <table class="table table-hover">
                    <thead>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Roles</th>
                        <th></th>
                    </thead>
                    <tbody>
                    <tr>
                            <td>{{ $LoggedUserInfo['name'] }}</td>
                            <td>{{ $LoggedUserInfo['email'] }}</td>
                            @php
                                $r=" ";
                                $x=" ";
                            @endphp
                            @foreach($user_roles as $users_roles)
                                @if($LoggedUserInfo['id'] == $users_roles['user_id'])
                                @php
                                    foreach($roles as $roless){
                                        if($roless['id'] == $users_roles['role_id']){
                                            $r = $r.$x.$roless['roleName'];
                                        }
                                    }
                                @endphp
                                @endif
                            @endforeach
                            <td>{{$r}} </td>
                            
                        </tr>
                    </tbody>
                </table>
                
            </div>
        </div>
@endsection
    
 