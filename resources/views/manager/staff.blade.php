@extends('managerNavBar.master')
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
                        </tr>
                    </tbody>
                </table>
                <h4>Staff</h4>
                <table class="table table-hover">
                <thead>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Roles</th>
                    <th>Is Active?</th>
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

                    </tr>
                    @endforeach
                </tbody>
                </table>
            </div>
        </div>
        
@endsection