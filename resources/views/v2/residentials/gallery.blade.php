{{-- <section id="gallery">
    <div class="container">
        <h2 class="title-about-description pad-left-right">Фото@if($residential->video) и видео@endif</h2>

        @if($residential->video)
            <div class="gallery-video">

                <iframe width="720" height="405" src="{{$residential->video}}" frameborder="0" allow="encrypted-media" allowfullscreen></iframe>

            </div>
        @endif
            <div class="gallery-photo-wrapper">
            
                <div id="gallery-main-wrapper">
                    <img id="gallery-main" src="">
                </div>

                <div class="slider-wrapper">
                    <div class="slider-nav slider-nav-box"></div>
                </div>
            </div>

    </div>

    <script>
        var first = true;
        {!! 'var images = '.json_encode($residential->getGallery()).';' !!}
        var mobile = $( window ).width() <= 768;
        $.each(images, function (main, thumb) {
            if (first) {
                $('#gallery-main').attr('src', main);
                first = false;
            }
            $('#gallery .slider-nav').append('<div class="slider-nav-item" data-main-path="' + main + '"><img src="' + (mobile ? main : thumb) + '"></div>');
        });
        $('#gallery .slider-nav-item').on('click', showBigGalleryImage);

        function showBigGalleryImage() {
            $('#gallery-main').attr('src', $(this).data('main-path'));
        }
    </script>
</section> --}}


<section id="gallery">
    <div class="container">
        <h2 class="title-about-description pad-left-right">Фото@if($residential->video) и видео@endif</h2>

        @if($residential->video)
            <div class="gallery-video">

                <iframe width="720" height="405" src="{{$residential->video}}" frameborder="0" allow="encrypted-media" allowfullscreen></iframe>

            </div>
        @endif
        <div class="row">
            <div class="col-md-12 col-xs-12 col-lg-6 slider-main d-none d-md-block">

                {{-- <div id="gallery-main-wrapper"> --}}
                    <img id="gallery-main" src="">
                {{-- </div> --}}

            </div>

            <div class="col-md-12 col-sm-12 col-lg-6 d-none d-sm-block">
                <div>
                    <div class="slider-nav slider-nav-box">
                    </div>
                </div>
            </div>
        </div>

        <div class="row d-block d-sm-none">
            <div class="slider-nav slider-nav-box d-block d-sm-none"></div>
        </div>


    </div>

    <script>
        var first = true;
        {!! 'var images = '.json_encode($residential->getGallery()).';' !!}
        var mobile = $( window ).width() <= 768;
        $.each(images, function (main, thumb) {
            if (first) {
                $('#gallery-main').attr('src', main);
                first = false;
            }
            $('#gallery .slider-nav').append('<div class="slider-nav-item col-md-4 col-xs-12" data-main-path="' + main + '"><img src="' + (mobile ? main : thumb) + '"></div>');
        });
        $('#gallery .slider-nav-item').on('click', showBigGalleryImage);

        function showBigGalleryImage() {
            $('#gallery-main').attr('src', $(this).data('main-path'));
        }
    </script>
</section>