{{ Request::header('Content-Type : text/xml') }}
<?php echo '<?xml version="1.0" encoding="UTF-8"?>';?>
 
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    @foreach ($routes as $route)
        <url>
            <loc>{{ $route }}</loc>
            <changefreq>monthly</changefreq>
            <priority>1</priority>
        </url>
    @endforeach
    @foreach ($residentials as $residential)
        <url>
            <loc>{{ $residential->route }}</loc>
            <lastmod>{{ $residential->updated_at->tz('GMT')->toAtomString() }}</lastmod>
            <changefreq>monthly</changefreq>
            <priority>1</priority>
        </url>
    @endforeach
    @foreach ($developers as $developer)
        <url>
            <loc>{{ $developer->route }}</loc>
            <lastmod>{{ $developer->updated_at->tz('GMT')->toAtomString() }}</lastmod>
            <changefreq>monthly</changefreq>
            <priority>1</priority>
        </url>
    @endforeach
</urlset>