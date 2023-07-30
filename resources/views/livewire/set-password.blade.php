<section class="body-sign body-locked">
    <div class="center-sign">
        <div class="panel card-sign">
            <div class="card-body">
                <form wire:submit="save">
                    <div class="current-user text-center">
                        <img src="{{$user->avatar}}" alt="John Doe" class="rounded-circle user-image" />
                        <h2 class="user-name text-dark m-0">{{$user->name}}</h2>
                        <p class="user-email m-0">{{$user->username}}</p>
                    </div>
                    @if ($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong>Error!</strong> {{ $errors->first() }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-hidden="true" aria-label="Close"></button>
                    </div>
                    @endif
                    <div class="form-group mb-3">
                        <div class="input-group">
                            <input id="pwd" type="password" wire:model="password" name="password" class="form-control form-control-lg" placeholder="Password" />
                            <span class="input-group-text">
                                <i class="bx bx-lock"></i>
                            </span>
                        </div>
                        </br>
                        <div class="input-group">
                            <input type="password" wire:model="password_confirmation" name="password_confirmation" class="form-control form-control-lg" placeholder="Re-type Password">
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