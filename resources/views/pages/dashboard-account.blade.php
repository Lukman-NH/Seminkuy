@extends('layouts.dashboard')

@section('title')
    Dashboard Setting Account
@endsection

@section('content')
      <div
      class="section-content section-dashboard-home"
      data-aos="fade-up"
      >
          <div class="container-fluid">
            <div class="dashboard-heading">
              <h2 class="dashboard-title">My Account</h2>
              <p class="dashboard-subtitle">
                Update your profile
              </p>
            </div>
            <div class="dashboard-content">
              <div class="row">
                <div class="col-12">
                  <form action="{{ route('dashboard-setting-redirect','dashboard-setting-account') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="card">
                      <div class="card-body">
                        <div class="row mb-2">
                          <div class="col-md-12">
                            <div class="form-group">
                              <label for="name">Your Name</label>
                              <input
                                type="text"
                                class="form-control"
                                id="name"
                                aria-describedby="emailHelp"
                                name="name"
                                value="{{ $user->name }}"
                              />
                            </div>
                          </div>
                          <div class="col-md-6">
                            <div class="form-group">
                              <label for="email">Your Email</label>
                              <input
                                type="email"
                                class="form-control"
                                id="email"
                                aria-describedby="emailHelp"
                                name="email"
                                value="{{ $user->email }}"
                              />
                            </div>
                          </div>
                          <div class="col-md-6">
                            <div class="form-group">
                              <label for="phone">Phone</label>
                              <input
                                type="text"
                                class="form-control"
                                id="phone"
                                name="phone"
                                value="{{ $user->phone }}"
                              />
                            </div>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col text-right">
                            <button
                              type="submit"
                              class="btn btn-primary px-5"
                            >
                              Save Now
                            </button>
                          </div>
                        </div>
                      </div>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    
@endsection