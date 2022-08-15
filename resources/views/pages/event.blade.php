@extends('layouts.app')

@section('title')
    Seminkuy Event Page
@endsection

@section('content')
<div class="page-content page-categories">
  
  <div class="page-content page-categories">
    <section class="store-trend-categories">
      <div class="container">
        <div class="row">
          <div class="col-12" data-aos="fade-up">
            <h4>Categories</h4>
          </div>
        </div>
        <div class="row">
        
          @php $incrementCategory = 0 @endphp
          @forelse ($categories as $category)
              <div
                  class="col-6 col-md-3 col-lg-2"
                  data-aos="fade-up"
                  data-aos-delay="{{ $incrementCategory+= 100 }}"
              >
                  <a href="{{ route('categories-detail', $category->slug) }}" class="component-categories d-block">
                      <p class="categories-text">
                          {{ $category->name }}
                      </p>
                  </a>
              </div>
          @empty
              <div class="col-12 text-center py-5" 
                    data-aos="fade-up"
                    data-aos-delay="100">
                    No Categories Found
              </div>
          @endforelse
          
        </div>
      </div>
  </section>
  <section class="store-new-products">
    <div class="container">
      <div class="row">
        <div class="col-12" data-aos="fade-up">
          <h4>Events</h4>
        </div>
      </div>
      <div class="row">
        @php $incrementEvent = 0 @endphp
        @if (!session()->get('recommender'))
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
                        Rp.{{ number_format($event ->harga, 0, ',', '.') }}
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
         @endif


        @php $incrementEvent = 0 @endphp
        @if (session()->get('recommender'))
          @forelse ($events as $event)
            @if ($event['rating_prediction'] >= 3) 
               <div
                class="col-6 col-md-4 col-lg-3"
                data-aos="fade-up"
                data-aos-delay="{{  $incrementEvent += 100 }}">
                <a class="component-products d-block" href="{{ route('detail', $event['slug']) }}">
                    <div class="products-thumbnail">
                        <div
                        class="products-image"
                        style="background-image: url('{{ Storage::url($event['image']) }}');"
                        ></div>
                    </div>
                    <div class="products-text">
                        {{  $event['name'] }}
                    </div>
                    <div class="products-price">
                        Rp.{{ number_format($event['harga'], 0, ',', '.') }}
                    </div>
                </a>
            </div>
            @endif 
          @empty
            <div class="col-12 text-center py-5"
                 data-aos="fade-up"
                 data-aos-delay="100">
                 No Events Found
            </div>
          @endforelse
         @endif

    </div>
      <div class="row">
        <div class="col-12 mt-4">
       
        </div>
      </div>
  </div>
</section>
</div>
     
    
@endsection