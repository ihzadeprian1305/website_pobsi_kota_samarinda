<!-- ***** Header Area Start ***** -->
<header class="header-area header-sticky">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <nav class="main-nav">
                    <!-- ***** Logo Start ***** -->
                    <a href="index.html" class="logo">
                        <img src="{{ asset('assets/static/images/logo/logo_pobsi_samarinda_2.png') }}" alt="">
                    </a>
                    <!-- ***** Logo End ***** -->
                    <!-- ***** Search End ***** -->
                    {{-- <div class="search-input">
                      <form id="search" action="#">
                        <input type="text" placeholder="Type Something" id='searchText' name="searchKeyword" onkeypress="handle" />
                        <i class="fa fa-search"></i>
                      </form>
                    </div> --}}
                    <!-- ***** Search End ***** -->
                    <!-- ***** Menu Start ***** -->
                    <ul class="nav">
                        <li><a href="{{ url('/') }}" class="{{ Request::is('/') ? 'active' : '' }}">Beranda</a></li>
                        <li><a href="{{ url('/structures') }}" class="{{ Request::is('structures*') ? 'active' : '' }}">Struktur</a></li>
                        <li><a href="{{ url('/athlete-informations') }}" class="{{ Request::is('athlete-informations*') ? 'active' : '' }}">Info Atlet</a></li>
                        <li><a href="{{ url('/news') }}" class="{{ Request::is('news*') ? 'active' : '' }}">Berita</a></li>
                        <li><a href="{{ url('/documents') }}" class="{{ Request::is('documents*') ? 'active' : '' }}">Dokumen</a></li>
                        <li><a href="streams.html">Agenda</a></li>
                        <li><a href="streams.html">Galeri</a></li>
                        {{-- <li><a href="profile.html">Profile <img src="assets/images/profile-header.jpg" alt=""></a></li> --}}
                        <li>
                            <div class="toggle-container">
                                <i class="fas fa-sun toggle-icon" id="sun-icon"></i>
                                <div class="form-check form-switch m-0">
                                  <input class="form-check-input" type="checkbox" id="iosToggle">
                                </div>
                                <i class="fas fa-moon toggle-icon" id="moon-icon"></i>
                              </div>
                        </li>
                    </ul>
                    <a class='menu-trigger'>
                        <span>Menu</span>
                    </a>
                    <!-- ***** Menu End ***** -->
                </nav>
            </div>
        </div>
    </div>
  </header>
  <!-- ***** Header Area End ***** -->
