<section id="rc-main-description">
    <div class="container">
        <h2>Подробно о жилом комплексе</h2>
        <div class="rc-main-description">
            <div class="row">
                <div class="col-md-6">
                    <div class="rc-main-description-wrapper-img">
                        <img src="{{ $residential->main_image }}">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="rc-main-description-text">
                        {!! $residential->text !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>