@extends('layouts.dashboard')

@section('title')
    Dashboard Transactions Details
@endsection

@section('content')
<div
  class="section-content section-dashboard-home"
  data-aos="fade-up"
  >
    <div class="container-fluid">
      <div class="dashboard-heading">
        <h2 class="dashboard-title">{{ $transaction->transaction->kode }}</h2>
        <p class="dashboard-subtitle">
          Transaction Details
        </p>
      </div>
      <div class="dashboard-content" id="transactionDetails">
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-body">
                <div class="row">
                  <div class="col-12 col-md-6">
                    <img
                      src="{{ Storage::url($transaction->event->galleries->last()->photos ?? '') }}"
                      alt=""
                      class="w-100 mb-3"
                    />
                  </div>
                  <div class="col-12 col-md-6">
                    <div class="row">
                      <div class="col-12 col-md-12">
                        <div class="product-title">
                          Tanggal Transaction
                        </div>
                        <div class="product-subtitle">
                          {{ $transaction->created_at }}
                        </div>
                      </div>  
                      <div class="col-12 col-md-6">
                        <div class="product-title">Nama Event</div>
                        <div class="product-subtitle">
                          {{ $transaction->event->name }}
                        </div>
                      </div>
                      <div class="col-12 col-md-6">
                        <div class="product-title">Pembicara</div>
                        <div class="product-subtitle">
                          {{ $transaction->event->pembicara }}
                        </div>
                      </div>
                      <div class="col-12 col-md-6">
                        <div class="product-title">Harga</div>
                        <div class="product-subtitle">Rp. {{ $transaction->event->harga }}</div>
                      </div>
                      <div class="col-12 col-md-6">
                        <div class="product-title">Status Pembayaran</div>
                        <div class="product-subtitle text-danger">
                          {{ $transaction->transaction->status }}
                        </div>
                      </div>                 
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-12 mt-4">
                    <h5>
                      Participant Informations
                    </h5>
                    <div class="row">
                      <div class="col-12 col-md-8">
                        <div class="product-title">Nama Participant</div>
                        <div class="product-subtitle">
                          {{ $transaction->transaction->user->name }}
                        </div>
                      </div>
                      <div class="col-12 col-md-8">
                        <div class="product-title">Email</div>
                        <div class="product-subtitle">
                          {{ $transaction->transaction->user->email }}
                        </div>
                      </div>
                      <div class="col-12 col-md-8">
                        <div class="product-title">Phone</div>
                        <div class="product-subtitle">
                          {{ $transaction->transaction->user->phone }}
                        </div>
                      </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
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

@push('addon-script')
<script src="{{ url ('/vendor/vue/vue.js') }}"></script>
<script>
  var transactionDetails = new Vue({
    el: "#transactionDetails",
    data: {
      status: "SUCCESS",
      resi: "BDO12308012132",
    },
  });
</script>
@endpush