<?php echo '<?xml version="1.0" encoding="UTF-8"?>'; ?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    @foreach ($statics as $k => $static)
        <url>
            <loc>{{$static}}</loc>
            <lastmod>{{ $date }}</lastmod>
            <changefreq>weekly</changefreq>
            <priority>{{($k == 0?'1.0':'0.9')}}</priority>
        </url>
    @endforeach
    @foreach ($categories as $category)
        <url>
            <loc>{{route('category',$category->slug)}}</loc>
            <lastmod>{{ $date }}</lastmod>
            <changefreq>weekly</changefreq>
            <priority>0.9</priority>
        </url>
        @if($category->subCategories)
            @foreach ($category->subCategories as $subcategory)
                <url>
                    <loc>{{route('sub-category',['category'=>$category->slug,'subCategory'=>$subcategory->slug])}}</loc>
                    <lastmod>{{ $date }}</lastmod>
                    <changefreq>weekly</changefreq>
                    <priority>0.9</priority>
                </url>
            @endforeach
        @endif
    @endforeach
    @foreach ($questions as $question)
        <url>
            <loc>{{route('question',$question->slug)}}</loc>
            <lastmod>{{ $date }}</lastmod>
            <changefreq>weekly</changefreq>
            <priority>0.9</priority>
        </url>
    @endforeach
    {{--@foreach ($tags as $tag)
        <url>
            <loc>{{route('tag',$tag->slug)}}</loc>
            <lastmod>{{ $date }}</lastmod>
            <changefreq>weekly</changefreq>
            <priority>0.5</priority>
        </url>
    @endforeach--}}
</urlset>
