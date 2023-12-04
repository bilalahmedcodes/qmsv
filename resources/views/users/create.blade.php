@extends('layouts.user')

@section('title', 'Add User')


@section('content')

    <div class="back-area mb-3">
        <a href="{{ route('users.index') }}" class="btn btn-secondary btn-sm"><i class="fas fa-arrow-left mr-2"></i> Go
            Back</a>
    </div>

    <!-- Default box -->
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">User Detail</h3>
        </div>

        <form action="{{ route('users.store') }}" method="post" autocomplete="off">
            @csrf
            <div class="card-body">
                <div class="form-group">
                    <label for="exampleInputEmail1">HRMS</label>
                    <input type="text" class="form-control" name="hrms_id" placeholder="Enter HRMS" required>
                </div>
                @error('hrms_id')
                    <div class="validate-error">{{ $message }}</div>
                @enderror
                <div class="form-group">
                    <label for="exampleInputEmail1">Name</label>
                    <input type="text" class="form-control" name="name" placeholder="Enter Name" required>
                </div>
                @error('name')
                    <div class="validate-error">{{ $message }}</div>
                @enderror
                <div class="form-group">
                    <label for="exampleInputEmail1">Email </label>
                    <input type="email" class="form-control" name="email" placeholder="Enter Email">
                </div>
                @error('email')
                    <div class="validate-error">{{ $message }}</div>
                @enderror
                <div class="form-group">
                    <label for="exampleInputEmail1">Password</label>
                    <input type="password" class="form-control" name="password" placeholder="Enter Password">
                </div>
                @error('password')
                    <div class="validate-error">{{ $message }}</div>
                @enderror
                <div class="form-group">
                    <label for="exampleInputEmail1">Password Text</label>
                    <input type="text" class="form-control" name="password_text" placeholder="Enter Password">
                </div>
                <div class="form-group">
                    <label for="exampleInputPassword1">Select Status</label>
                    <select name="status" class="form-control select2" required>
                        <option value="Active">Active</option>
                        <option value="InActive">Inactive</option>
                    </select>
                </div>
                @error('status')
                    <div class="validate-error">{{ $message }}</div>
                @enderror
                <div class="form-group">
                    <label for="exampleInputEmail1">Role</label>
                    <select name="role" class="form-control select2">
                        <option value="">Select Option</option>
                        @foreach ($roles as $role)
                            <option value="{{ $role->name }}">{{ $role->name ?? '' }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">Reporting To</label>
                    <select name="reporting_to" class="form-control select2">
                        <option value="">Select Option</option>
                        @foreach ($reporting_to as $reporting)
                            <option value="{{ $reporting->id }}">{{ $reporting->name ?? '' }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">Campaign</label>
                    <select name="campaign_id" class="form-control select2">
                        <option value="">Select Option</option>
                        @foreach ($campaigns as $campaign)
                            <option value="{{ $campaign->id }}">{{ $campaign->name ?? '' }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
            <!-- /.card-footer-->

        </form>

    </div>
    <!-- /.card -->

@endsection
