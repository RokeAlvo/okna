<section id="gallery">
    <div class="container">
        <h2>Фото объекта</h2>
        <div class="row">
            <div class="col-md-8">
                <div class="slider-main">
                    <div id="gallery-main-wrapper">
                        <img id="gallery-main" src="">
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="slider-nav row">
                </div>
            </div>
        </div>
    </div>
    <script>
        var first = true;
        {!! 'var images = '.json_encode($residential->getGallery()).';' !!}
        $.each(images, function (main, thumb) {
            if (first) {
                $('#gallery-main').attr('src', main);
                first = false;
            }
            $('#gallery .slider-nav').append('<div class="col-md-6 col-sm-3 col-xs-4 p10"><div class="slider-nav-item" data-main-path="' + main + '"><img src="' + thumb + '"></div></div>');
        });
        $('#gallery .slider-nav-item').on('click', showBigGalleryImage);

        function showBigGalleryImage() {
            $('#gallery-main').attr('src', $(this).data('main-path'));
        }
    </script>
</section>