@extends('components.layouts.app')

@section('breadcrumb')
<ol class="breadcrumbs">
    <li>
        <a href="index.html">
            <i class="bx bx-list-ul"></i>
        </a>
    </li>

    <li><span>Activity</span></li>

    <li><span>List</span></li>

</ol>
@endsection

@section('page_title')
Activity List
@endsection

@section('content')
<div class="row">
    <div class="col-lg-12">
        <section class="card">
            <header class="card-header">
                <div class="card-actions">
                </div>

                <h2 class="card-title">
                    Strava Activity
                    <p class="card-subtitle">
                        All your strava activity will be listed here.
                </h2>
            </header>
            <div class="card-body">
                <table class="table table-responsive-md table-striped mb-0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>First Name</th>
                            <th>Last Name</th>
                            <th>Username</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1</td>
                            <td>Mark</td>
                            <td>Otto</td>
                            <td>@mdo</td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td>Jacob</td>
                            <td>Thornton</td>
                            <td>@fat</td>
                        </tr>
                        <tr>
                            <td>3</td>
                            <td>Larry</td>
                            <td>the Bird</td>
                            <td>@twitter</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </section>
    </div>
</div>
@endsection