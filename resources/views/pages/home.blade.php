@extends('layouts.app')

@section('title')
    Seminkuy Home Page
@endsection

@section('content')
    <div class="page-content page-home">
        <section class="store-carousel">
        <div class="container">
            <div class="row">
            <div class="col-lg-12" data-aos="zoom-in">
                <div
                id="storeCarousel"
                class="carousel slide"
                data-ride="carousel"
                >
                <ol class="carousel-indicators">
                    <li
                    data-target="#storeCarousel"
                    data-slide-to="0"
                    class="active"
                    ></li>
                    <li data-target="#storeCarousel" data-slide-to="1"></li>
                </ol>
                <div class="carousel-inner">
                    <div class="carousel-item active">
                    <img
                        src="images/banner1.jpg"
                        class="d-block w-100"
                        alt="Carousel Image"
                    />
                    </div>
                    <div class="carousel-item">
                    <img
                        src="images/banner2.jpg"
                        class="d-block w-100"
                        alt="Carousel Image"
                    />
                    </div>
                </div>
                </div>
            </div>
            </div>
        </div>
        </section>
        <br>
        <section class="store-new-products">
            <div class="container">
                <div class="row">
                <div class="col-12 text-center" data-aos="fade-up">
                    <h4>Events</h4>
                </div>
                </div>
                <div class="row">
                @php $incrementEvent = 0 @endphp
                @forelse ($events as $event)
                    <div
                        class="col-6 col-md-4 col-lg-3"
                        data-aos="fade-up"
                        data-aos-delay="{{  $incrementEvent += 100 }}">
                        <a class="component-products d-block" href="{{ route('detail', $event->slug) }}">
                            <div class="products-thumbnail">
                                <div
                                class="products-image"
                                style="
                                        @if($event->galleries->count())
                                            background-image: url('{{ Storage::url($event->galleries->first()->photos) }}');
                                        @else
                                            background-color: #eee;
                                        @endif
                                "
                                ></div>
                            </div>
                            <div class="products-text">
                                {{  $event ->name }}
                            </div>
                            <div class="products-price">
                                Rp.{{  $event ->harga }}
                            </div>
                        </a>
                    </div>
                @empty
                    <div class="col-12 text-center py-5"
                         data-aos="fade-up"
                         data-aos-delay="100">
                         No Events Found
                    </div>
                @endforelse
              </div>
          </div>
        </section>
    </div>
    
@endsection