@extends('layouts.admin')

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
    <h2 class="dashboard-title">Admin Dashboard</h2>
    <p class="dashboard-subtitle">
      Admin Seminkuy
    </p>
  </div>
  <div class="dashboard-content">
    <div class="row">
      <div class="col-md-4">
        <div class="card mb-2">
          <div class="card-body">
            <div class="dashboard-card-title">
              User
            </div>
            <div class="dashboard-card-subtitle">
              {{ $user }}
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="card mb-2">
          <div class="card-body">
            <div class="dashboard-card-title">
              Event
            </div>
            <div class="dashboard-card-subtitle">
              {{ $event }}
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="card mb-2">
          <div class="card-body">
            <div class="dashboard-card-title">
              Transaction
            </div>
            <div class="dashboard-card-subtitle">
              {{ $transaction }}
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
</div>
</div>   
    
@endsection