@extends('auth.layouts')
@section('content')
<table class="table table-stripped">
    <tr>
        <td>Name</td>
        <td>Email</td>
        <td>Photo</td>
        <td>Action</td>
    </tr>
    @foreach ($userss as $user)
    <tr>
    </tr>
    <td>{{ $user->name }}</td>
    <td>{{ $user->email }}</td>
    <!--<td><img src="{{ asset('storage/' . $user->photo) }}"></td> -->
    <td>
        @if($user->photo)
        <img src="{{ asset('storage/' . $user->photo) }}" width="100px">
        @else
        <img src="{{ asset('noimage.jpg') }}" width="100px">
        @endif
    </td>
    <td>
        <a href="{{ route('users.edit', $user->id) }}" class="btn btn-primary btn-sm">Edit</a>
        <form action="{{ route('users.destroy', $user->id) }}" method="POST">
            @method('DELETE')
            {{ csrf_field() }}<br/>
            <button type="submit" class="btn btn-danger">Delete</button>            
        </form>
    </td>
        
    @endforeach
</table>
@endsection