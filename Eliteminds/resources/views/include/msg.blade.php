@if(session('error'))
    <div class="alert alert-danger fade show mb-5" role="alert">
        <div class="alert-icon"><i class="flaticon-warning"></i></div>
        <div class="alert-text" style="font-weight: bold;">{{session('error')}}</div>
    </div>
@endif
@if(isset($error))
    <div class="alert alert-danger fade show mb-5" role="alert">
        <div class="alert-icon"><i class="flaticon-warning"></i></div>
        <div class="alert-text" style="font-weight: bold;">{{$error}}</div>
    </div>
@endif

@if(isset($success))
    <div class="alert alert-success fade show mb-5" role="alert">
        <div class="alert-icon"><i class="flaticon-interface-5"></i></div>
        <div class="alert-text" style="font-weight: bold;">{{$success}}</div>
    </div>
@endif
@if(session('success'))
    <div class="alert alert-success fade show mb-5" role="alert">
        <div class="alert-icon"><i class="flaticon-interface-5"></i></div>
        <div class="alert-text" style="font-weight: bold;">{{session('success')}}</div>
    </div>
@endif

@if(count($errors) > 0)
    @foreach($errors->all() as $errors)
        <div class="alert alert-danger fade show mb-5" role="alert">
            <div class="alert-icon"><i class="flaticon-warning"></i></div>
            <div class="alert-text">{{$errors}}</div>
        </div>
        @break
    @endforeach
@endif
