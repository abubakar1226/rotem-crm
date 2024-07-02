@extends('backend.layouts.app')

@section('title', '| Edit Lead')

@section('breadcrumb')
    <div class="page-header">
        <h1 class="page-title">Leads List</h1>
        <div>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('leads.index') }}">Leads</a></li>
                <li class="breadcrumb-item active" aria-current="page">Edit Lead</li>
            </ol>
        </div>
    </div>
@endsection

@section('content')
    <div class="card">
        <div class="card-header justify-content-between">
            <h3 class="card-title font-weight-bold">Edit Lead</h3>
            <a href="{{ route('leads.index') }}" class="btn btn-sm dark-icon btn-primary" data-method="get"
               data-title="Back">
                <i class="fe fe-arrow-left"></i> Back
            </a>
        </div>
        <div class="card-body">
            @include('backend.leads.form')
        </div>
    </div>
@endsection
