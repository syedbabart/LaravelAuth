@extends('layouts.master')
@section('content')
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/2.0.0/jquery.min.js"></script>
        <script type="text/javascript" src="./javascript.js"></script>
        <script
        src="http://maps.googleapis.com/maps/api/js?key=AIzaSyCJnj2nWoM86eU8Bq2G4lSNz3udIkZT4YY&sensor=false">
        </script>
        <script>
            function toggleActiveStatus(id){
                console.log('inside toggle function');
                $.get('/admin/'+id, function(user){
                    let id=user.id;
                    let name = user.name;
                    let email = user.email;
                    let password = user.password;
                    let isActive = user.isActive;
                
                 $.ajax({
                    url: "{{route('activeStatus.update')}}",
                    type:"PUT",
                    data: {
                        id:id,
                        name:name,
                        email:email,
                        password:password,
                        isActive:isActive,
                        _token: "{{ csrf_token() }}"
                    },
                    success:function(response){
                        console.log(response);
                    }
                })
                 });
            }
        </script>
        <div class="row">
            <div class="col-md-6 col-md-offset-3">
                <h4>Dashboard</h4><hr>
                <table class="table table-hover">
                    <thead>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Role</th>
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
                    <th>Roles</th>
                    <th>Is Active?</th>
                    <th>Options</th>
                    <th>Edit Roles</th>
                </thead>
                <tbody>
                    @foreach($users as $user)
                    @php
                        $isManager = False;
                        $isAdmin = False;
                    @endphp
                    @foreach($user_roles as $users_roles)
                    @php
                    if($user['id'] == $users_roles['user_id']){
                        if($users_roles['role_id'] == 2){
                            $isManager = True;
                        }
                        if($users_roles['role_id'] == 1){
                            $isAdmin = True;                           
                        }
                    }
                    @endphp
                    @endforeach
                    @php
                    if($isAdmin){
                        if($isManager){
                            $roles = "User, Admin, Manager";
                            $is_admin_and_manager = true;
                        }else{
                            $roles = "User, Admin";
                        }
                    }else{
                        if($isManager){
                            $roles = "User, Manager";
                        }else{
                            $roles = "User";
                        }
                    }
                    @endphp
                    <tr>
                    <td>{{ $user['id'] }}</td>
                    <td>{{ $user['name'] }}</td>
                    <td>{{ $user['email'] }}</td>
                    <td>{{$roles}} </td>
                    @if($user['isActive'] == 1)
                    <td>Yes</td>
                    @endif
                    @if($user['isActive'] == 0)
                    <td>No</td>
                    @endif

                    <td>
                    <a href={{ "delete/".$user['id'] }}>Delete</a>
                     | 
                    <a href="javascript:void(0)" onclick="toggleActiveStatus({{$user['id']}})">Toggle Active Status</a>
                    </td>

                    @if(!$isAdmin && !$isManager)
                    <td><a href={{ "makeManager/".$user['id'] }}>Make Manager</a> | <a href={{ "makeAdmin/".$user['id'] }}>Make Admin</a></td>
                    @endif

                    @if($isAdmin && !$isManager)
                    <td><a href={{ "makeManager/".$user['id'] }}>Make Manager</a> | <a href={{ "revokeAdmin/".$user['id'] }}>Revoke Admin</a></td>
                    @endif

                    @if($isManager && !$isAdmin)
                    <td><a href={{ "makeAdmin/".$user['id'] }}>Make Admin</a> | <a href={{ "revokeManager/".$user['id'] }}>Revoke Manager</a></td>
                    @endif

                    @if($isManager && $isAdmin)
                    <td><a href={{ "revokeAdmin/".$user['id'] }}>Revoke Admin</a> | <a href={{ "revokeManager/".$user['id'] }}>Revoke Manager</a></td>
                    @endif
                    </tr>
                    @endforeach
                </tbody>
                </table>
            </div>
        </div>
        
@endsection