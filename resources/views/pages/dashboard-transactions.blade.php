@extends('layouts.dashboard')

@section('title')
    Dashboard Transactions
@endsection

@section('content')
<div
class="section-content section-dashboard-home"
data-aos="fade-up"
>
    <div class="container-fluid">
      <div class="dashboard-heading">
        <h2 class="dashboard-title">Transactions</h2>
        <p class="dashboard-subtitle">
          Seminkuy Dashboard Transactions
        </p>
      </div>
      <div class="dashboard-content">
        <div class="tab-content" id="myTabContent">
          <div
            class="tab-pane fade show active"
            id="sell"
            role="tabpanel"
            aria-labelledby="sell-tab"
          >
            <div class="row mt-3">
              <div class="col-12 mt-2">
                @foreach ($buyTransactions as $transaction)
                <a
                  href="{{ route('dashboard-transactions-details', $transaction->id) }}"
                  class="card card-list d-block"
                >
                  <div class="card-body">
                    <div class="row">
                      <div class="col-md-1">
                        <img
                          src="{{ Storage::url($transaction->event->galleries->first()->photos ?? '') }}"
                          class="w-100"
                        />
                      </div>
                      <div class="col-md-2">
                        {{ $transaction->transaction->kode }}
                      </div>
                      <div class="col-md-3">
                        {{ $transaction->event->name }}
                      </div>
                      <div class="col-md-3">
                        {{ $transaction->event->pembicara }}
                      </div>
                      <div class="col-md-2">
                        {{ $transaction->transaction->status }}
                      </div>
                      <div class="col-md-1 d-none d-md-block">
                        <img
                          src="/images/dashboard-arrow-right.svg"
                          alt=""
                        />
                      </div>
                    </div>
                  </div>
                </a>
               @endforeach
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- /#page-content-wrapper -->
</div>
</div>  
    
@endsection