@extends('layouts.app')

@section('title')
    Seminkuy Detail Event
@endsection

@section('content')
<div class="page-content page-details">
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
                  Event Detail
                </li>
              </ol>
            </nav>
          </div>
        </div>
      </div>
    </section>
    <section class="store-gallery" id="gallery">
      <div class="container">
        <div class="row">
          <div class="col-lg-8" data-aos="zoom-in">
            <transition name="slide-fade" mode="out-in">
              <img
                :key="photos[activePhoto].id"
                :src="photos[activePhoto].url"
                class="w-100 main-image"
                alt=""
              />
            </transition>
          </div>
          <div class="col-lg-2">
            <div class="row">
              <div
                class="col-3 col-lg-12 mt-2 mt-lg-0"
                v-for="(photo, index) in photos"
                :key="photo.id"
                data-aos="zoom-in"
                data-aos-delay="100"
              >
                <a href="#" @click="changeActive(index)">
                  <img
                    :src="photo.url"
                    class="w-100 thumbnail-image"
                    :class="{ active: index == activePhoto }"
                    alt=""
                  />
                </a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
    <div class="store-details-container" data-aos="fade-up">
      <section class="store-heading">
        <div class="container">
          <div class="row">
            <div class="col-lg-8">
              <h1>{{ $event->name }} </h1>
              <div class="pembicara">Pembicara : {{ $event->pembicara }} </div>
              <div class="price">Rp. {{ $event->harga }}</div>
              <div class="rating">
                <span>
                  @if($rating_value > 0) 
                    <b>{{$rating_value}}</b>
                  @else
                    <b>No Rating</b>
                  @endif
                </span>
                  @for($i=1; $i<=$rating_value; $i++)
                    <i class="fa fa-star checked"></i>
                  @endfor          
                <span>                  
                    <i>({{$event_rating->count()}} Participant)</i>
                </span>   
              </div>  
            </div>
            <div class="col-lg-2" data-aos="zoom-in">
              @auth
                    <form action="{{ route('detail-add', $event->id) }}" method="POST" enctype="multipart/form-data">
                      @csrf
                      <button
                        type="submit"
                        class="btn btn-primary px-4 text-white btn-block mb-3"
                      >
                        Add to Cart
                      </button>
                    </form>
                @else
                    <a
                      href="{{ route('login') }}"
                      class="btn btn-primary px-4 text-white btn-block mb-3"
                    >
                      Login to Add
                    </a>
                @endauth
            </div>
          </div>
        </div>
      </section>
      <section class="store-description">
        <div class="container">
          <div class="row">
            <div class="col-12 col-lg-8">
              {!! $event->deskripsi !!}
            </div>
          </div>
          <div class="col-12 col-md-8"> 
            <hr/>
          </div>
              <div class="row">
                <div class="col-md-2">
                  <span>
                    <i>Partipant Rating : </i>
                  </span>        
                </div>
                <div class="col-md-6">
                  @foreach($rating_review as $item)
                    <div class="user-review">
                      <label for="">{{ $item->user->name }}</label>
                      <br>
                      @if ($item)
                      @php $user_rated = $item-> rating @endphp
                        @for($i=1; $i<=$user_rated; $i++)
                          <i class="fa fa-star checked"></i>
                        @endfor
                        @for($j=$user_rated+1; $j<=5; $j++)
                          <i class="fa fa-star"></i> 
                        @endfor   
                      @endif     
                    </div>
                    <br>
                  @endforeach
                </div>
                <div class="col-12 col-md-8"> 
                  <hr/>
                </div>
            </div>
          </div>
        </div>
      </section>
    </div>
  </div>
    
@endsection

@push('addon-script')
    <script src="{{ url ('/vendor/vue/vue.js')}}"></script>
    <script>
       var gallery = new Vue({
        el: "#gallery",
        mounted() {
          AOS.init();
        },
        data: {
          activePhoto: 0,
          photos: [
            @foreach ($event->galleries as $gallery)
            {
              id: {{ $gallery->id }},
              url: "{{ Storage::url($gallery->photos) }}",
            },
            @endforeach
          ],
        },
        methods: {
          changeActive(id) {
            this.activePhoto = id;
          },
        },
      });
    </script>
@endpush