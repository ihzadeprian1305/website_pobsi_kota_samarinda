@extends('user.layouts.app')
@section('container')
<script src="https://unpkg.com/@popperjs/core@2"></script>
<script src="https://unpkg.com/tippy.js@6"></script>
    <!-- ***** Home Slider Games Start ***** -->
    <div class="row mb-5">
    <div class="col-lg-8">
        <div class="home-sliders header-text">
        <div class="heading-section">
            <h4><em>Hangat</em> dari POBSI</h4>
        </div>
        @if(count($home_sliders) > 0)
        <div class="owl-home-sliders owl-carousel">
                @foreach ($home_sliders as $hs)
                <div class="item">
                    <a href="{{ $hs->link }}">
                        <div class="thumb">
                            <img src="{{ asset('storage/'.$hs->home_slider_images->image) }}" alt="">
                            <div class="hover-effect">
                            <h6>Kunjungi Halaman</h6>
                            </div>
                        </div>
                        <h4>{{ $hs->title }}<br><span>{{ $hs->caption }}</span></h4>
                    </a>
                </div>
                @endforeach
            </div>
            @else
                <h4 class="text-center mb-3">Tidak Ada Slider Beranda</h4>
            @endif
        </div>
    </div>
    <div class="col-lg-4">
        <div class="top-downloaded">
        <div class="heading-section">
            <h4><em>Agenda</em> POBSI</h4>
        </div>
        <div id="calendar" class="mb-3"></div>
        <div class="text-button">
            <a href="{{ url('/agendas') }}">Lihat Semua Agenda</a>
        </div>
        </div>
    </div>
    </div>
    <!-- ***** Home Slider Games End ***** -->

    <!-- ***** Banner Start ***** -->
    <div class="main-banner">
    <div class="row">
        <div class="col-lg-7">
        <div class="header-text">
            <h6>Mau Main Biliar tapi Nggak Tau Lokasi?</h6>
            <h4><em>Cari</em> Sarana Olahraga Biliar di Samarinda</h4>
            <div class="main-button">
            <a href="{{ url('/pool-houses') }}">Klik Disini</a>
            </div>
        </div>
        </div>
    </div>
    </div>
    <!-- ***** Banner End ***** -->

    <!-- ***** Gaming Library Start ***** -->
    <div class="pobsi-trailer">
    <div class="col-lg-12">
        <div class="heading-section">
        <h4><em>Cuplikan</em> POBSI</h4>
        </div>
        <div class="row">
        <div class="col-lg-12">
            <iframe src="https://www.youtube.com/embed/upxAwcIMlbI" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
            </div>
        </div>
    </div>
    {{-- <div class="col-lg-12">
        <div class="main-button">
        <a href="profile.html">View Your Library</a>
        </div>
    </div> --}}
    </div>
    <!-- ***** Gaming Library End ***** -->

    <!-- ***** Live Stream Start ***** -->
    <div class="live-stream">
        <div class="col-lg-12">
            <div class="heading-section">
            <h4><em>Berita Terbaru</em> POBSI</h4>
            </div>
        </div>
        <div class="row">
            @if(count($news) > 0)
                @foreach ($news as $n)
                    <div class="col-lg-4 col-sm-12">
                        <div class="item">
                            <div class="thumb">
                                <img src="{{ asset('storage/'.$n->news_cover_images->image) }}" alt="">
                                <div class="hover-effect">
                                    <div class="content">
                                        <ul>
                                            <li><a href="#"><i class="fa fa-eye"></i> 1.2K</a></li>
                                            <li><a href="{{ url('/news?category=' . $n->news_categories->id) }}"><i class="fa fa-file"></i> {{ $n->news_categories->name }}</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="down-content">
                                <span><i class="fa fa-check"></i><a href="{{ url('/news?author='. $n->user_created_by->id) }}"> {{ $n->user_created_by->user_data->name }} </a>| {{ $n->created_at }}</span>
                                <a href="{{ url('/news/news-details/'. $n->slug) }}">
                                    <h4>{{ $n->title_summary }}</h4>
                                    <p>{{ $n->excerpt }}</p>
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
                    <div class="col-lg-12">
                        <div class="main-button">
                        <a href="{{ url('/news') }}">Lihat Berita Lainnya</a>
                        </div>
                    </div>
            @else
                <h4 class="text-center mb-3">Tidak Ada Berita</h4>
            @endif
        </div>
    </div>
    <!-- ***** Live Stream End ***** -->

    <!-- ***** Start Stream Start ***** -->
    <div class="document">
    <div class="col-lg-12">
        <div class="heading-section">
        <h4><em>Dokumen Terbaru</em> POBSI</h4>
        </div>
    </div>
    <div class="row">
        @if(count($documents) > 0)
            @foreach ($documents as $d)
                <div class="col-lg-3 col-sm-6">
                    <a href="{{ url('/document/'. $d->slug) }}">
                        <div class="item">
                            <img src="assets/static/images/default-image/document-cover-image.png" class="rounded-3" alt="">
                            <h4>{{ $d->title_summary }}<br><span>{{ $d->description_summary }}</span></h4>
                        </div>
                    </a>
                </div>
                {{-- <div class="col-lg-4 col-sm-12">
                    <a href="{{ url('/document/'. $d->slug) }}">
                        <div class="item">
                            <div class="icon">
                                <img src="{{ asset('assets/user/assets/images/document-icon.png') }}" alt="" style="max-width: 60px; border-radius: 50%;">
                            </div>
                            <h4>{{ $d->title_summary }}</h4>
                            <p>{{ $d->description_summary }}</p>
                        </div>
                    </a>
                </div> --}}
            @endforeach
                <div class="col-lg-12">
                    <div class="main-button">
                    <a href="{{ url('documents') }}">Lihat Dokumen Lainnya</a>
                    </div>
                </div>
        @else
            <h4 class="text-center mb-3">Tidak Ada Dokumen</h4>
        @endif
    </div>
    </div>
    <!-- ***** Start Stream End ***** -->

    <!-- ***** Banner Start ***** -->
          {{-- <div class="row">
            <div class="col-lg-12">
              <div class="main-profile ">
                <div class="row">
                  <div class="col-lg-4">
                    <img src="assets/images/profile.jpg" alt="" style="border-radius: 23px;">
                  </div>
                  <div class="col-lg-4 align-self-center">
                    <div class="main-info header-text">
                      <span>Offline</span>
                      <h4>Alan Smithee</h4>
                      <p>You Haven't Gone Live yet. Go Live By Touching The Button Below.</p>
                      <div class="main-border-button">
                        <a href="#">Start Live Stream</a>
                      </div>
                    </div>
                  </div>
                  <div class="col-lg-4 align-self-center">
                    <ul>
                      <li>Games Downloaded <span>3</span></li>
                      <li>Friends Online <span>16</span></li>
                      <li>Live Streams <span>None</span></li>
                      <li>Clips <span>29</span></li>
                    </ul>
                  </div>
                </div>
                <div class="row">
                  <div class="col-lg-12">
                    <div class="clips">
                      <div class="row">
                        <div class="col-lg-12">
                          <div class="heading-section">
                            <h4><em>Your Most Popular</em> Clips</h4>
                          </div>
                        </div>
                        <div class="col-lg-3 col-sm-6">
                          <div class="item">
                            <div class="thumb">
                              <img src="assets/images/clip-01.jpg" alt="" style="border-radius: 23px;">
                              <a href="https://www.youtube.com/watch?v=r1b03uKWk_M" target="_blank"><i class="fa fa-play"></i></a>
                            </div>
                            <div class="down-content">
                              <h4>First Clip</h4>
                              <span><i class="fa fa-eye"></i> 250</span>
                            </div>
                          </div>
                        </div>
                        <div class="col-lg-3 col-sm-6">
                          <div class="item">
                            <div class="thumb">
                              <img src="assets/images/clip-02.jpg" alt="" style="border-radius: 23px;">
                              <a href="https://www.youtube.com/watch?v=r1b03uKWk_M" target="_blank"><i class="fa fa-play"></i></a>
                            </div>
                            <div class="down-content">
                              <h4>Second Clip</h4>
                              <span><i class="fa fa-eye"></i> 183</span>
                            </div>
                          </div>
                        </div>
                        <div class="col-lg-3 col-sm-6">
                          <div class="item">
                            <div class="thumb">
                              <img src="assets/images/clip-03.jpg" alt="" style="border-radius: 23px;">
                              <a href="https://www.youtube.com/watch?v=r1b03uKWk_M" target="_blank"><i class="fa fa-play"></i></a>
                            </div>
                            <div class="down-content">
                              <h4>Third Clip</h4>
                              <span><i class="fa fa-eye"></i> 141</span>
                            </div>
                          </div>
                        </div>
                        <div class="col-lg-3 col-sm-6">
                          <div class="item">
                            <div class="thumb">
                              <img src="assets/images/clip-04.jpg" alt="" style="border-radius: 23px;">
                              <a href="https://www.youtube.com/watch?v=r1b03uKWk_M" target="_blank"><i class="fa fa-play"></i></a>
                            </div>
                            <div class="down-content">
                              <h4>Fourth Clip</h4>
                              <span><i class="fa fa-eye"></i> 91</span>
                            </div>
                          </div>
                        </div>
                        <div class="col-lg-12">
                          <div class="main-button">
                            <a href="#">Load More Clips</a>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div> --}}
          <!-- ***** Banner End ***** -->
          <script>

            document.addEventListener('DOMContentLoaded', function() {
                var calendarEl = document.getElementById('calendar');
                var calendar = new FullCalendar.Calendar(calendarEl, {
                    initialView: 'dayGridDay',
                    locale: 'id',
                    aspectRatio: 1.2,
                    buttonText: {
                        today: 'Hari Ini'
                    },
                    headerToolbar: {
                        left: 'title',
                        center: '',
                        right: ''
                    },
                    footerToolbar: {
                        left: 'prev',
                        center: 'today',
                        right: 'next'
                    },
                    events: [
                        @foreach ($agendas as $a)
                            {
                                title : '{{ $a->activity }}',
                                description : '{{ $a->description }}',
                                time : '{{ $a->time }}',
                                attended_by : '{{ $a->attended_by }}',
                                location : '{{ $a->location }}',
                                start : '{{ $a->date }}',
                                end : '{{ $a->date }}',
                            },
                        @endforeach
                    ],
                    eventDidMount: function(info) {
                        tippy(info.el, {
                            content: 'Deskripsi: ' + info.event.extendedProps.description + '<br>Waktu: ' + info.event.extendedProps.time + '<br>Dihadiri oleh: ' + info.event.extendedProps.attended_by + '<br>Lokasi: ' + info.event.extendedProps.location,
                            allowHTML: true,
                            theme: 'light-border',
                        });
                    },
                    validRange: {
                        start: '{{ $startDate }}',
                        end: '{{ $endDate }}'
                    },
                });

                calendar.render();
            });

        </script>
@endsection








