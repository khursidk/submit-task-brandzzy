 
 
@extends('layouts.superadminMaster')

@section('title', 'Dashboard')

@section('content')
    <h2>Welcome to the Dashboard</h2>
    <div class="container">
    <h1>Super Admin Dashboard</h1>
    <form action="{{ route('super.admin.addAdmin') }}" method="POST">
        @csrf
        <input type="text" name="name" placeholder="Admin Name" required>
        <input type="email" name="email" placeholder="Admin Email" required>
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit">Add Admin</button>
    </form>

    <form action="{{ route('super.admin.addSuperAdmin') }}" method="POST">
        @csrf
        <input type="text" name="name" placeholder="Super Admin Name" required>
        <input type="email" name="email" placeholder="Super Admin Email" required>
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit">Add Super Admin</button>
    </form>
</div>
@endsection
