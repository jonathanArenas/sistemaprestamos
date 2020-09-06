@extends('layouts.dashboard')
@section('title', 'Otras configuraciones')
@section('content')
<div class="row">
@hasrole('SuperUser|Prestamista')
    <div class="col-lg-3 col-xs-3">
        <div class="info-box">
            <span class="info-box-icon bg-info elevation-1">
                <i class="fas fa-money-check-alt"></i>
            </span>
            <div class="info-box-content">
            <a href="{{route('catalogo.index')}}">
                <span class="info-box-text text-center"><h3>CATALOGO</h3></span>
                </a>
            </div>
        </div>
    </div>
@endhasrole
@hasrole('SuperUser|Prestamista|Administrador')
    <div class="col-lg-3 col-xs-3">
        <a href="{{route('user.index')}}">
        <div class="info-box">
            <span class="info-box-icon bg-info elevation-1">
                <i class="fas fa-user-friends"></i>
            </span>
            <div class="info-box-content">
                <span class="info-box-text text-center"><h3>USUARIOS</h3></span>
            </div>
        </div>
        </a>
    </div>
@endhasrole
@hasrole('SuperUser|Prestamista')
    <div class="col-lg-3 col-xs-3">
        <a href="{{route('empresa.index')}}">
        <div class="info-box">
            <span class="info-box-icon bg-info elevation-1">
                <i class="fas fa-city"></i>
            </span>
            <div class="info-box-content">
                <span class="info-box-text text-center"><h3>EMPRESA</h3></span>
            </div>
        </div>
        </a>
    </div>
@endhasrole
</div>

@endsection