@extends('partial.app')

@section('content')
<section class="ec-page-content section-space-p sticky-header-next-sec">
    <div class="container">
        <div class="row">
            <div class="ec-blogs-rightside col-lg-8 order-lg-last col-md-12 order-md-first">

                <!-- Blog content Start -->
                <div class="ec-blogs-content">
                    <div class="ec-blogs-inner">
                        <div class="ec-blog-main-img">
                            <img class="blog-image" src="{{ 'https://solaristamandatakom.com/commerce/ecom_admin/public/' . $banner->url_image }}" alt="Blog" />
                        </div>
                        <div class="ec-blog-date">
                            <p class="date"> {{ $banner->created_at->diffForHumans() }} </p>
                        </div>
                        <div class="ec-blog-detail">
                            <h3 class="ec-blog-title">{{ $banner->title }}</h3>
                            <br>
                            {!! $banner->deskripsi !!}
                        </div>
                    </div>
                </div>
                <!--Blog content End -->
            </div>
            <!-- Sidebar Area Start -->
            <div class="ec-blogs-leftside col-lg-4 order-lg-first col-md-12 order-md-last">
                <div class="ec-sidebar-wrap">
                    <!-- Sidebar Recent Blog Block -->
                    <div class="ec-sidebar-block ec-sidebar-recent-blog">
                        <div class="ec-sb-title">
                            <h3 class="ec-sidebar-title">Detail Pengumuman</h3>
                        </div>
                        <div class="ec-sb-block-content">
                            <div class="ec-sidebar-block-item">
                                <h5 class="ec-blog-title">Dibuat Pada Tanggal</h5>
                                <div class="ec-blog-date">{{ $banner->created_at->isoFormat('dddd, D MMMM Y'); }}</div>
                                <h5 class="ec-blog-title">Waktu</h5>
                                <div class="ec-blog-date">{{ $banner->created_at->isoFormat('HH:mm:ss'); }}</div>
                            </div>
                        </div>
                    </div>
                    <!-- Sidebar Recent Blog Block -->
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
