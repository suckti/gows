<div class="col-lg-12">
        <section class="card">
            <header class="card-header">
                <div class="card-actions">
                    <button type="button" class="mb-1 mt-1 me-1 btn btn-primary"><i class="fas fa-plus"></i> </button>
                </div>

                <h2 class="card-title">
                    Challenge
                    <p class="card-subtitle">
                        Join or add new challenge
                </h2>
            </header>
            <div class="card-body">
                <table class="table table-responsive-md table-striped mb-0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Type</th>
                            <th>Sport Type</th>
                            <th>Duration</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($challenges as $key => $challenge)
                            <tr>
                                <td>{{$key+1}}</td>
                                <td>{{$challenge->name}}</td>
                                <td>{{$challenge->type}}</td>
                                <td>{{$challenge->sport_type}}</td>
                                <td>{{$challenge->start_date}}</td>
                                <td>{{$challenge->status}}</td>
                                <td></td>
                            </tr>
                        @endforeach

                    </tbody>
                </table>
            </div>
        </section>
    </div>