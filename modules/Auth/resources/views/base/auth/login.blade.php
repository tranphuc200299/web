@extends('core::layout.auth.login')

@section('body-inside')
    <div>
        <div class="login_wrapper">
            <div class="animate form login_form">
                <section class="login_content">
                    <form action="{{route('login')}}" method="post">
                        @csrf
                        <h1>Login</h1>
                        <div>
                            <input type="email" name="email" class="form-control" placeholder="Email" required=""/>
                        </div>
                        <div>
                            <input type="password" name="password" class="form-control" placeholder="Password"
                                   required=""/>
                        </div>
                        <div>
                            @if(env('GOOGLE_AUTH'))
                                @include('auth::auth.social.google')
                            @endif
                            <button class="btn btn-default submit" type="submit">Login</button>
                        </div>

                        <div class="clearfix"></div>

                        <div class="separator">
                            <div class="clearfix"></div>
                            <br/>
                            <div>
                                <p>©2020 All Rights Reserved.</p>
                            </div>
                        </div>
                    </form>
                </section>
            </div>
        </div>
    </div>
@endsection
