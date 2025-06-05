@php
    use App\Models\Visitor;

    $totalVisitors = Visitor::distinct('ip_address')->count('ip_address');
    $todayVisitors = Visitor::whereDate('visited_at', today())->distinct('ip_address')->count('ip_address');
@endphp
<footer>
    <div class="container">
      <div class="row">
        <div class="col-lg-6 col-12">
          <p>Copyright © 2024 <a href="#">POBSI Kota Samarinda</a>. All rights reserved.
          <br>Template by <a href="https://templatemo.com" target="_blank" title="free CSS templates">TemplateMo</a> and Edited by ja</p>
        </div>
        <div class="col-lg-6 col-12">
          <p>Pengunjung Hari Ini: {{ $todayVisitors }}<br>Total Pengunjung: {{ $totalVisitors }}</p>
        </div>
      </div>
    </div>
  </footer>
