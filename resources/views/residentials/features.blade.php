<section id="features">
    <div class="container">
        <h2>Особенности жилого комплекса</h2>
        <div class="row">
            @foreach ($residential->features as $features)
                <div class="col-md-3 col-sm-6">
                    <div class="feature-item block-shadow">
                        <h3>{{ $features->title }}
                            <span>{{ ($features->subtitle) ? $features->subtitle : "&nbsp;" }}</span>
                        </h3>
                        <p>{{ $features->text }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>