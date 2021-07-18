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
                            @if($LoggedUserInfo['isUser'] == 1)
                            <td>User</td>
                            @endif
                            @if($LoggedUserInfo['isUser'] == 0)
                            <td>Admin</td>
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
                    <th>Admin or User?</th>
                    <th>Is Active?</th>
                    <th>Options</th>
                </thead>
                <tbody>
                    @foreach($users as $user)
                    <tr>
                    <td>{{ $user['id'] }}</td>
                    <td>{{ $user['name'] }}</td>
                    <td>{{ $user['email'] }}</td>
                    @if($user['isUser'] == 1)
                    <td>User</td>
                    @endif
                    @if($user['isUser'] == 0)
                    <td>Admin</td>
                    @endif
                    @if($user['isActive'] == 1)
                    <td>Yes</td>
                    @endif
                    @if($user['isActive'] == 0)
                    <td>No</td>
                    @endif
                    <td>
                    <a href={{ "delete/".$user['id'] }}>Delete</a>
                     | 
                    <a href="javascript:void(0)" onclick="toggleActiveStatus({{ $user['id'] }})">Toggle Active Status</a>
                    </td>
                    </tr>
                    @endforeach
                </tbody>
                </table>
            </div>
        </div>
        <script>
            function toggleActiveStatus(id){
                $.get('/admin/'+id, function(user){
                    let name = user.name;
                    let email = user.email;
                    let password = user.password;
                    let isUser = user.isUser;
                    let isActive = user.isActive;
                })
                $.ajax({
                    url: "{{route('activeStatus.update')}}",
                    type:"PUT",
                    data: {
                        name:name,
                        email:email,
                        password:password,
                        isUser:isUser,
                        isActive:isActive,
                    }
                })
            }
        </script>
@endsection