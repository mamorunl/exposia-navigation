<?php echo '<?xml version="1.0" encoding="UTF-8" ?>'; ?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
        @foreach($pages as $page)
            <url>
                <loc>{{ route('pages.show', $page->node->slug) }}</loc>
                <lastmod>{{ date('Y-m-d', $page->updated_at->timestamp) }}</lastmod>
                <changefreq>monthly</changefreq>
                <priority>0.8</priority>
            </url>
        @endforeach
</urlset>