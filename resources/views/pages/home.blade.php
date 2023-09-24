@extends('layouts.app')

@section('content')

@include('components.api-link', [
    'method' => 'get', 
    'url' => route('faqs.index'), 
    'description' => 'List all the faqs inside the database as a json response.'
])

@include('components.api-link', [
    'method' => 'get', 
    'url' => route('faqs.paginate'), 
    'description' => 'List all the faqs inside the database as a json response with the pagination feature.'
])

@include('components.api-link', [
    'method' => 'post', 
    'url' => route('login'), 
    'description' => 'User login.', 
    'data' => [
        'email' => 'string|required', 
        'password' => 'string|required', 
        'remember_me' => 'boolean|required', 
        'token' => 'exclude_if:remember_me,false|uuid',
    ] 
])

@include('components.api-link', [
    'method' => 'post', 
    'url' => route('register'), 
    'description' => 'User registration.', 
    'data' => [
        'first_name' => 'string|required',
        'last_name' => 'string|required',
        'email' => 'string|required', 
        'password' => 'string|required', 
        'whatsapp_number' => 'required',
        'description' => 'string|nullable',
        'gender_id' => 'exists:genders,id',
        'asset_id' => 'exists:assets,id',
        'remember_me' => 'boolean|required',
    ] 
])

@endsection