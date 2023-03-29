@extends('layouts.admin')
@section('head-title','Dashboard  | ')
@section('content')
<div class="container-fluid mt-4">
    <div class="row justify-content-center gy-4">

        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>
                <div class="card-body">
                    @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                    @endif

                    {{ __('You are logged in!') }}
                </div>
            </div>
            
        </div>
        <div class="col-md-8">
            <div class="card">
                
                <div class="card-header">Users 
                    {{-- <i class="fa-solid fa-heart fa-beat" style="--fa-animation-duration: 0.5s;" ></i> --}}
                </div>
                <div class="card-body">
                    <ul class="list-group">
                        <li class="list-group-item {{ $countUsers >0 ? 'list-group-item-success' : 'list-group-item-danger' }} ">
                            Totale Utenti Registrati: {{ $countUsers }}
                        </li>
                      </ul>
                    
                </div>
            </div>
            
        </div>
        @if(isset($countProjects))
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Projects</div>
                <div class="card-body">
                    <ul class="list-group">
                        <li class="list-group-item {{ $countProjects >0 ? 'list-group-item-success' : 'list-group-item-danger' }}">
                            Totale Progetti: {{ $countProjects }}
                        </li>
                      </ul>
                    
                </div>
            </div>
            
        </div>
        @endif
        @if(isset($countTypes))
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Types</div>
                <div class="card-body">
                    <ul class="list-group">
                        <li class="list-group-item {{ $countTypes >0 ? 'list-group-item-success' : 'list-group-item-danger' }}">
                            Totale Tipologie: {{ $countTypes }}
                        </li>
                      </ul>
                    
                </div>
            </div>
            
        </div>
        @endif
        @if(isset($countTechnologies))
       
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Technologies</div>
                <div class="card-body">
                    <ul class="list-group">
                        <li class="list-group-item {{ $countTechnologies >0 ? 'list-group-item-success' : 'list-group-item-danger' }}">
                            Totale Tecnologie: {{ $countTechnologies }}
                        </li>
                      </ul>
                    
                </div>
            </div>
            
        </div>
        @endif
        
    </div>
</div>
@endsection