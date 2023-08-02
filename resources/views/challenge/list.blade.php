@extends('components.layouts.app')

@section('breadcrumb')
<ol class="breadcrumbs">
    <li>
        <a href="index.html">
            <i class="bx bxs-hot"></i>
        </a>
    </li>

    <li><span>Challenge</span></li>

    <li><span>List</span></li>

</ol>
@endsection

@section('page_title')
Challenge List
@endsection

@section('content')
<div class="row">
    <livewire:challenge-list>
</div>
@endsection