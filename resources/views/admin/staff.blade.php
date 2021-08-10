@extends('adminNavBar.master')
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
                <h4>Staff</h4><hr>
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
                <h4>List:</h4>
                <table class="table table-hover">
                <thead>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Roles</th>
                    <th>Is Active?</th>
                    <th>Options</th>
                </thead>
                <tbody>
                    @foreach($users as $user)
                    @php
                                $rol=" ";
                                $x=" ";
                            @endphp
                            @foreach($user_roles as $users_roles)
                                @if($user['id'] == $users_roles['user_id'])
                                @php
                                    foreach($roles as $roless){
                                        if($roless['id'] == $users_roles['role_id']){
                                            $rol = $rol.$x.$roless['roleName'];
                                        }
                                    }
                                @endphp
                                @endif
                            @endforeach
                    <tr>
                    <td>{{ $user['id'] }}</td>
                    <td>{{ $user['name'] }}</td>
                    <td>{{ $user['email'] }}</td>
                    <td>{{$rol}} </td>
                    @if($user['isActive'] == 1)
                    <td>Yes</td>
                    @endif
                    @if($user['isActive'] == 0)
                    <td>No</td>
                    @endif

                    @if($user_priveleges['canDeleteUser'])
                    <td>
                    <a href={{ "delete/".$user['id'] }}>Delete</a>
                     | 
                    @endif

                    @if($user_priveleges['canChangeStatus'])
                    <a href="javascript:void(0)" onclick="toggleActiveStatus({{$user['id']}})">Toggle Active Status</a>
                    </td>
                    @endif
                    
                    
                    @endforeach
                </tbody>
                </table>
            </div>
        </div>
        
@endsection