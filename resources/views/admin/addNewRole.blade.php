@extends('adminNavBar.master')
@section('content')
<div class="container">
<div class="row">
        <div class="col-md-4 col-md-offset-4">
            <h4>Add a new role</h4>
            <form action="/admin/addNewRole" method="get">
            @if(Session::get('fail'))
            <div class="alert alert-danger">
                {{ Session::get('fail') }}
            </div>
            @endif
            @csrf
                <div class="form-group">
                    <label>Role Name</label>
                    <input type="text" class="form-control" name='roleName' placeholder="Enter name of role">              
                </div>
                <div class="form-group">
                    <label>Can Add User</label>
                    <input type="checkbox" class="form-control" name='canAddUser'>                
                </div>
                <div class="form-group">
                    <label>Can Delete User</label>
                    <input type="checkbox" class="form-control" name='canDeleteUser'>                
                </div>
                <div class="form-group">
                    <label>Can Change Status</label>
                    <input type="checkbox" class="form-control" name='canChangeStatus'>                
                </div>
                <div class="form-group">
                    <label>Can Manage Roles</label>
                    <input type="checkbox" class="form-control" name='canManageRoles'>                
                </div>
                <br>
                <button type="submit" class="btn btn-block btn-primary">Add Role</button>
            </form>
        </div> 

    </div>
</div>
@endsection