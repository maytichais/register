<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>
                
                <div class="card-body">
                    <p>{{ __('Welcome') }}, {{ $user->name }}!</p>

                    <div id="app">
                        
                        <div class="btn-group" role="group">
                            <form method="GET" action="{{ route('edit_profile') }}">
                                <button type="submit" class="btn btn-danger">{{ __('Edit Profile') }}</button>
                            </form>
                        </div>
                        <div class="btn-group" role="group">
                            <form method="GET" action="{{ route('logout') }}">
                                <button type="submit" class="btn btn-danger">{{ __('Logout') }}</button>
                            </form>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="{{ mix('js/app.js') }}"></script>