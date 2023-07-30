<section class="body-sign body-locked">
    <div class="center-sign">
        <div class="panel card-sign">
            <div class="card-body">
                <form action="index.html">
                    <div class="current-user text-center">
                        <img src="{{$user->avatar}}" alt="John Doe" class="rounded-circle user-image" />
                        <h2 class="user-name text-dark m-0">{{$user->name}}</h2>
                        <p class="user-email m-0">{{$user->username}}</p>
                    </div>
                    <div class="form-group mb-3">
                        <div class="input-group">
                            <input id="pwd" type="password" class="form-control form-control-lg" placeholder="Password" />
                            <span class="input-group-text">
                                <i class="bx bx-lock"></i>
                            </span>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-6">
                            
                        </div>
                        <div class="col-6">
                            <button type="submit" class="btn btn-primary pull-right">Save</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>