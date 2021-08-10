@extends('adminNavBar.master')
@section('content')
        <div class="row">
            <div class="col-md-6 col-md-offset-3">
                <h4>Settings</h4><hr>
                <table class="table table-hover">
                    <thead>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Roles</th>
                        <th></th>
                    </thead>
                    <tbody>
                    <tr>
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
                <h4>Options</h4>
                <ul>
                    @if($user_priveleges['canAddUser'])
                    <li> <a href="/admin/addUsers">Add New Users</a>
                    @endif

                    @if($user_priveleges['canManageRoles'])
                    <li> <a href="/admin/addRole">Add New Role</a>
                    @endif
                </ul>
            </div>
        </div>
@endsection