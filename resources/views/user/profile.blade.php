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
                    <li> <a href="/user/dashboard">Dashboard</a></li>
                    <li> <a href="/user/profile">Profile</a></li>
                </ul>
            </div>
        </div>
@endsection