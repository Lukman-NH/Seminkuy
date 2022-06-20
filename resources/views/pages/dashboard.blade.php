@extends('layouts.dashboard')

@section('title')
    Seminkuy Dashboard
@endsection

@section('content')
<div
class="section-content section-dashboard-home"
data-aos="fade-up"
>
<div class="container-fluid">
  <div class="dashboard-heading">
    <h2 class="dashboard-title">Dashboard</h2>
    <p class="dashboard-subtitle">
      Seminkuy
    </p>
  </div>
  <div class="dashboard-content">
    <div class="row">
      <div class="col-md-12">
        <div class="card mb-12">
          <div class="card-body">
            Hi {{ Auth::user()->name }}, Selamat datang di dashboard Seminkuy <br>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
</div>
</div>   
    
@endsection