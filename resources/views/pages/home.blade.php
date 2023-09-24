@extends('layouts.app')

@section('content')

@include('components.api-link', [
    'method' => 'post', 
    'url' => route('login'), 
    'description' => 'User login.', 
    'data' => [
        'email' => 'required|email|exists:users', 
        'password' => 'required', 
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
        'email' => 'email:rfc,dns|required|unique', 
        'password' => 'required|max:8|letters|mixed_case|numbers|symbols|uncompromised', 
        'password_confirmation' => 'required|same_as_password',
        'whatsapp_number' => 'required',
        'description' => 'string|nullable',
        'gender_id' => 'exists:genders,id',
        'asset_id' => 'exists:assets,id',
        'remember_me' => 'boolean|required',
    ] 
])

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
    'method' => 'get', 
    'url' => route('contact-details'), 
    'description' => 'List all the contact details inside the config file as a json response.'
])

@include('components.api-link', [
    'method' => 'get', 
    'url' => route('assets.index'), 
    'description' => 'Get all assets(files and folders).', 
])

@include('components.api-link', [
    'method' => 'put', 
    'url' => route('assets.store'), 
    'description' => 'Upload assets(files and folders).', 
    'data' => [
        'asset' => 'required|mimes:jpg,bmp,png,jpeg,gif,svg,pdf,zip,7z,gz|max:5120 (5MB)', // 5MB
    ] 
])

@include('components.api-link', [
    'method' => 'put', 
    'url' => route('assets.index').'/{id}', 
    'description' => 'Update assets(files and folders).', 
    'data' => [
        'asset' => 'required|mimes:jpg,bmp,png,jpeg,gif,svg,pdf,zip,7z,gz|max:5120 (5MB)', // 5MB
    ] 
])

@include('components.api-link', [
    'method' => 'delete', 
    'url' => route('assets.index').'/{id}', 
    'description' => 'Delete assets(files and folders).',
])
@endsection