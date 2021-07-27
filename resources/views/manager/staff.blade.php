@extends('layouts.master')
@section('content')
        <div class="row">
            <div class="col-md-6 col-md-offset-3">
                <h4>Dashboard</h4><hr>
                <table class="table table-hover">
                    <thead>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Admin or User?</th>
                        <th></th>
                    </thead>
                    <tbody>
                        <tr>
                        <td>{{ $LoggedUserInfo['name'] }}</td>
                            <td>{{ $LoggedUserInfo['email'] }}</td>
                            @php
                                $r = 10;
                            @endphp
                            @foreach($user_roles as $users_roles)
                                @if($LoggedUserInfo['id'] == $users_roles['user_id'])
                                @php
                                    if($r > $users_roles['role_id']){
                                    $r = $users_roles['role_id'];
                                    }
                                @endphp
                                @endif
                            @endforeach
                            @if($r == 1)
                            <td>Admin</td>
                            @endif
                            @if($r == 2)
                            <td>Manager</td>
                            @endif
                            @if($r == 3)
                            <td>User</td>
                            @endif
                            <td><a href="{{ route('auth.logout') }}">Logout</a></td>
                        </tr>
                    </tbody>
                </table>
                <ul>
                    <li> <a href="/admin/dashboard">Dashboard</a></li>
                    <li> <a href="/admin/profile">Profile</a></li>
                    <li> <a href="/admin/settings">Settings</a></li>
                    <li> <a href="/admin/staff">Staff</a></li>

                </ul>
                <h4>Staff</h4>
                <table class="table table-hover">
                <thead>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Is Active?</th>
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
                </table>
            </div>
        </div>
        
@endsection