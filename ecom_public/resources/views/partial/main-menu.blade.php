@php
    use App\Helpers\App;
@endphp

<div class="d-none d-lg-block sticky-nav category-list">
    <div class="container position-relative">
        <div class="row">
            <div class="col-md-12 align-self-center">
                <div class="ec-main-menu">
                    <ul>
                        @foreach (App::get_master_package() as $item)
                            <li class=" @if(Request::segment(1) == $item->package_slug || request()->get('package') == $item->package_slug) active @endif "><a href="/produk?{{http_build_query(['package' => $item->package_slug, 'filter' => 'all'])}}">{{ $item->package }}</a></li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
