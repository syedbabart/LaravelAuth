@extends('layouts.master')
@section('content')
        <div class="row">
            <div class="col-md-6 col-md-offset-3">
                <h4>Dashboard</h4><hr>
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
                                $is_admin = false;
                                $is_manager = false;
                            @endphp
                            @foreach($user_roles as $users_roles)
                                @if($LoggedUserInfo['id'] == $users_roles['user_id'])
                                @php
                                    if($users_roles['role_id'] == 1){
                                    $is_admin = true;
                                    }
                                    if($users_roles['role_id'] == 2){
                                    $is_manager = true;
                                    }
                                @endphp
                                @endif
                            @endforeach
                           @php
                                if($is_admin){
                                    if($is_manager){
                                        $r = "User, Admin, Manager";
                                    }else{
                                        $r = "User, Admin";
                                    }
                                }else{
                                    if($is_manager){
                                        $r = "User, Manager";
                                    }else{
                                        $r = "User";
                                    }
                                }
                           @endphp
                            <td>{{$r}} </td>
                            <td><a href="{{ route('auth.logout') }}">Logout</a></td>
                        </tr>
                    </tbody>
                </table>
                <ul>
                    <li> <a href="/manager/dashboard">Dashboard</a></li>
                    <li> <a href="/manager/profile">Profile</a></li>
                    <li> <a href="/manager/staff">Staff</a></li>
                </ul>
            </div>
        </div>
@endsection
 