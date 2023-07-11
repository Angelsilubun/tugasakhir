@extends('layouts_admin.main')

@section('title', 'Profile')

@section('container')
    <main id="main" class="main">
        <div class="pagetitle">
            <h1>Profile</h1>
        </div>

        <section class="section profile">
            <div class="row">
                <div class="col-xl-4">

                    <div class="card">
                        <div class="card-body profile-card pt-4 d-flex flex-column align-items-center">

                            {{-- <img src="assets/admin/img/profile-img.jpg" alt="Profile" class="rounded-circle"> --}}
                            @if (empty(Auth::user()->image))
                                <img src="{{ url('assets/admin/img/upload/noimage.jpg') }}" class="rounded-circle">
                            @else
                                {{-- <img src="{{ url('/storage/' . Auth::user()->image) }}" alt="Profile" --}}
                                {{-- class="rounded-circle" style="width: 200px; height: 120px"> --}}
                                <img src="{{ Storage::url(Auth::user()->image) }}" alt="profile"
                                    style="width: 200px; height: 120px" class="rounded-circle">
                            @endif
                            <h2>{{ Auth::user()->name }}</h2>
                            <h3>
                                {{ Auth::user()->role }}
                            </h3>
                        </div>
                    </div>

                </div>

                <div class="col-xl-8">

                    <div class="card">
                        <div class="card-body pt-3">
                            <!-- Bordered Tabs -->
                            <ul class="nav nav-tabs nav-tabs-bordered">

                                <li class="nav-item">
                                    <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#profile-edit">Edit
                                        Profile</button>
                                </li>

                            </ul>
                            <div class="tab-content pt-2">

                                <div class="tab-pane fade show active profile-edit pt-3" id="profile-edit">

                                    <!-- Profile Edit Form -->
                                    <form action="{{ url('admin/profile/' . Auth::user()->id) }}" method="POST"
                                        enctype="multipart/form-data">
                                        @method('PUT')
                                        @csrf
                                        <input type="hidden" name="gambarLama" value="{{ Auth::user()->image }}">
                                        <div class="row mb-3">
                                            <label for="fullName" class="col-md-4 col-lg-3 col-form-label">Username</label>
                                            <div class="col-md-8 col-lg-9">
                                                <input name="name" type="text" class="form-control" id="name"
                                                    value="{{ empty(Auth::user()->name) ? '' : Auth::user()->name }}">
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <label for="company" class="col-md-4 col-lg-3 col-form-label">Email</label>
                                            <div class="col-md-8 col-lg-9">
                                                <input name="email" type="text" class="form-control" id="email"
                                                    value="{{ empty(Auth::user()->email) ? '' : Auth::user()->email }}">
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <label for="currentPassword" class="col-md-4 col-lg-3 col-form-label">Password
                                                Baru</label>
                                            <div class="col-md-8 col-lg-9">
                                                <input name="password" type="password" class="form-control"
                                                    placeholder="Masukan password baru">
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <label for="inputGroupFile02" class="col-md-4 col-lg-3 col-form-label">Upload
                                                Gambar</label>
                                            <div class="col-md-8 col-lg-9">
                                                <input type="file" class="form-control" id="image" name="image">
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <label for="company" class="col-md-4 col-lg-3 col-form-label"></label>
                                            <img id="showImage"
                                                src="{{ !empty($profil_admin->image) ? asset('/storage/' . $profil_admin->image) : asset('assets/admin/img/upload/noimage.jpg') }}"
                                                alt="Profile" class="rounded-circle" style="width: 180px; height: 100px">
                                        </div>

                                        <div class="text-center">
                                            <button type="submit" class="btn btn-primary">Save Changes</button>
                                        </div>
                                    </form><!-- End Profile Edit Form -->

                                </div>

                                <div class="tab-pane fade pt-3" id="profile-change-password">
                                    <!-- Change Password Form -->
                                    <form>

                                        <div class="row mb-3">
                                            <label for="currentPassword" class="col-md-4 col-lg-3 col-form-label">Current
                                                Password</label>
                                            <div class="col-md-8 col-lg-9">
                                                <input name="password" type="password" class="form-control"
                                                    id="currentPassword">
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <label for="newPassword" class="col-md-4 col-lg-3 col-form-label">New
                                                Password</label>
                                            <div class="col-md-8 col-lg-9">
                                                <input name="newpassword" type="password" class="form-control"
                                                    id="newPassword">
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <label for="renewPassword" class="col-md-4 col-lg-3 col-form-label">Re-enter New
                                                Password</label>
                                            <div class="col-md-8 col-lg-9">
                                                <input name="renewpassword" type="password" class="form-control"
                                                    id="renewPassword">
                                            </div>
                                        </div>

                                        <div class="text-center">
                                            <button type="submit" class="btn btn-primary">Change Password</button>
                                        </div>
                                    </form><!-- End Change Password Form -->

                                </div>

                            </div><!-- End Bordered Tabs -->

                        </div>
                    </div>

                </div>
            </div>
        </section>
    </main>
@endsection

@section('js')
    <script src="https://code.jquery.com/jquery-3.6.1.min.js"
        integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ=" crossorigin="anonymous"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('#image').change(function(e) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#showImage').attr('src', e.target.result);
                }
                reader.readAsDataURL(e.target.files[0]);
            });
        });
    </script>
@endsection
