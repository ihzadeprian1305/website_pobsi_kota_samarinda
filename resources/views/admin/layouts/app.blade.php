<!DOCTYPE html>
<html lang="en">
    @include('admin.layouts.partials.head')
    <body>
        <div id="app">
            @include('admin.layouts.partials.sidebar')
            <div id="main" class='layout-navbar'>
                @include('admin.layouts.partials.navbar')
                <div id="main-content">
                    @yield('container')
                    @include('admin.layouts.partials.footer')
                </div>
            </div>
        </div>
        @include('admin.layouts.partials.script')
    </body>
</html>
