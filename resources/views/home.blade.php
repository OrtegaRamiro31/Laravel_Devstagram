@extends('layouts.app')

@section('titulo')
    {{ $titulo }}
@endsection

@section('contenido')
    <x-listar-post :posts="$posts" /> 
@endsection

