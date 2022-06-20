@extends('layouts.app')

@section('title')
    Seminkuy Cart Page
@endsection

@section('content')
  <div class="page-content page-cart">
    <section
      class="store-breadcrumbs"
      data-aos="fade-down"
      data-aos-delay="100"
    >
      <div class="container">
        <div class="row">
          <div class="col-12">
            <nav aria-label="breadcrumb">
              <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">
                  Cart
                </li>
              </ol>
            </nav>
          </div>
        </div>
      </div>
    </section>
    <section class="store-cart">
      <div class="container">
        <div class="row" data-aos="fade-up" data-aos-delay="100">
          <div class="col-12 table-responsive">
            <table
              class="table table-borderless table-cart"
              aria-describedby="Cart"
            >
              <thead>
                <tr>
                  <th scope="col">Image</th>
                  <th scope="col">Event &amp; Pembicara</th>
                  <th scope="col">Price</th>
                  <th scope="col">Menu</th>
                </tr>
              </thead>
              <tbody>
                @php $totalHarga = 0 @endphp
                @foreach ($carts as $cart)
                <tr>
                  <td style="width: 20%;">
                    @if($cart->event->galleries)
                      <img
                        src="{{ Storage::url($cart->event->galleries->first()->photos) }}"
                        alt=""
                        class="cart-image"
                      />
                    @endif
                  </td>
                  <td style="width: 35%;">
                    <div class="product-title">{{ $cart->event->name }}</div>
                    <div class="product-subtitle">by {{ $cart->event->pembicara }}</div>
                  </td>
                  <td style="width: 35%;">
                    <div class="product-title">Rp. {{ $cart->event->harga }}</div>
                    <div class="product-subtitle">Rupiah</div>
                  </td>
                  <td style="width: 20%;">
                    <form action="{{ route('cart-delete', $cart->id) }}" method="POST">
                      @method('DELETE')
                      @csrf
                      <button class="btn btn-remove-cart" type="submit">
                        Remove
                      </button>
                    </form>                     
                  </td>
                </tr>
                @php $totalHarga += $cart->event->harga @endphp
              @endforeach
              </tbody>
            </table>
          </div>
        </div>
        <div class="row" data-aos="fade-up" data-aos-delay="150">
        </div>
        <form action="{{ route('checkout') }}" method="POST" enctype="multipart/form-data">
          @csrf
          <input type="hidden" name="total_harga" value="{{ $totalHarga }}">
        <div class="row" data-aos="fade-up" data-aos-delay="150">
          <div class="col-12">
            <hr />
          </div>
          <div class="col-12">
            <h2>Payment Informations</h2>
          </div>
        </div>
        <div class="row" data-aos="fade-up" data-aos-delay="200">
          <div class="col-6 col-md-6">
            <div class="product-title text-success">Rp. {{ $totalHarga ?? 0 }}</div>
            <div class="product-subtitle">Total</div>
          </div>
          <div class="col-6 col-md-6">
            <button
              type="submit"
              class="btn btn-primary mt-4 px-4 btn-block">
                  Checkout Now
            </button>
          </div>
        </div>
       </form>
      </div>
    </section>
  </div>
    
@endsection