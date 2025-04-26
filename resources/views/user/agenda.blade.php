@extends('user.layouts.app')
@section('container')
<!-- ***** Gaming Library Start ***** -->
<div class="agenda-detail header-text">
    <div class="col-lg-12">
        <div class="heading-section">
            <h4><em>Agenda</em> POBSI Kota Samarinda</h4>
        </div>
        <div class="agenda-detail-container mt-3">
            <div id="calendar"></div>
        </div>
    </div>
</div>
<!-- ***** Gaming Library End ***** -->
<script>

    document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('calendar');
        var calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            locale: 'id',
            buttonText: {
                today: 'Hari Ini'
            },
            events: [
                @foreach ($agendas as $a)
                    {
                        title : '{{ $a->activity }}',
                        start : '{{ $a->date }}',
                        end : '{{ $a->date }}',
                    },
                @endforeach
            ],
            eventDidMount: function(info) {
                info.el.setAttribute('title', 'Deskripsi: {{ $a->description }} Waktu: {{ $a->time }}')
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
