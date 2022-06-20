@extends('layouts.success')

@section('title')
    Seminkuy Success Page 
@endsection

@section('content')
  <div class="page-content page-success">
    <div class="section-success" data-aos="zoom-in">
      <div class="container">
        <div class="row align-items-center row-login justify-content-center">
          <div class="col-lg-6 text-center">
            <h2>
              Welcome to Seminkuy
            </h2>
            <p>
              Kamu sudah berhasil terdaftar <br />
              bersama kami.
            </p>
            <div>
              <a class="btn btn-primary w-50 mt-4" href="/dashboard.html">
                My Dashboard
              </a>
              <a class="btn btn-signup w-50 mt-2" href="/index.html">
                Go To Home
              </a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>  
@endsection