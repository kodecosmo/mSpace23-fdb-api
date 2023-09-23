@extends('layouts.app')

@section('content')

<x-api-link 
    method="get"
    url="{{ route('faqs.index') }}"
    description="List all the faqs inside the database as a json response."
/>


<x-api-link 
    method="get"
    url="{{ route('faqs.paginate') }}"
    description="List all the faqs inside the database as a json response with the pagination feature."
/>
    
@endsection