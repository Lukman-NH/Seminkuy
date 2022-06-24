@extends('layouts.dashboard')

@section('title')
    Dashboard Transactions Details
@endsection

<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <form action="{{ route ('rating-add') }}" method="POST">
        @csrf
        <input type="hidden" name="event_id" value="{{ $transaction->event->id }}"> 
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Webinar {{$transaction->event -> name}}</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="false">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="rating-css">
              <div class="star-icon">
                  <input type="radio" value="1" name="event_rating" checked id="rating1">
                  <label for="rating1" class="fa fa-star"></label>
                  <input type="radio" value="2" name="event_rating" id="rating2">
                  <label for="rating2" class="fa fa-star"></label>
                  <input type="radio" value="3" name="event_rating" id="rating3">
                  <label for="rating3" class="fa fa-star"></label>
                  <input type="radio" value="4" name="event_rating" id="rating4">
                  <label for="rating4" class="fa fa-star"></label>
                  <input type="radio" value="5" name="event_rating" id="rating5">
                  <label for="rating5" class="fa fa-star"></label>
              </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Submit</button>
        </div>
      </form>
    </div>
  </div>
</div>

@section('content')
@include('sweetalert::alert')

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
                      <div class="col-12 col-md-6">
                        <div class="product-title">Email</div>
                        <div class="product-subtitle">
                          {{ $transaction->transaction->user->email }}
                        </div>
                      </div>
                      <div class="col-12 col-md-6">
                        <div class="product-title">Phone</div>
                        <div class="product-subtitle">
                          {{ $transaction->transaction->user->phone }}
                        </div>
                      </div>  
                      <div class="col-12 col-md-12">
                        <hr />
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
                          Rate This Event
                        </button>
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