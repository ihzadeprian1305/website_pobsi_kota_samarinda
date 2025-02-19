<!DOCTYPE html>
<html lang="en">
    @include('user.layouts.partials.head')
    <body>
        @include('user.layouts.partials.preloader')
        @include('user.layouts.partials.navbar')
        <div class="container">
            <div class="row">
              <div class="col-lg-12">
                <div class="page-content">
                    @yield('container')
                </div>
            </div>
          </div>
        </div>
        @include('user.layouts.partials.footer')
        @include('user.layouts.partials.script')
    </body>
</html>
