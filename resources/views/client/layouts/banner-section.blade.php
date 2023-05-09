<!--================Forum Breadcrumb Area =================-->
<section class="doc_banner_area search-banner-light">
    <div class="container">
        <div class="doc_banner_content">
            <form action="#" class="header_search_form">
                <div class="header_search_form_info">
                    <div class="form-group">
                        <div class="input-wrapper">
                            <i class="icon_search"></i>
                            <input type='search' id="searchbox" autocomplete="off" name="search"
                                   placeholder="Search for Topics...."/>
                        </div>
                    </div>
                </div>
                <div class="header_search_keyword">
                    <span class="header-search-form__keywords-label">Popular Searches:</span>
                    <ul class="list-unstyled">
                        @php
                            $totalTagsShown = 5;
                              $tags = popularTag($totalTagsShown);
                        @endphp
                        @if($tags)
                            @foreach($tags as $index => $tag)
                                <li class="wow fadeInUp" data-wow-delay="0.2s">
                                    <a href="@route('tag',$tag->slug)"
                                       class="text-capitalize">{{$tag->name}}</a>@if($index != ($totalTagsShown - 1))
                                        , @endif
                                </li>
                            @endforeach
                        @endif
                    </ul>
                </div>
            </form>
        </div>
    </div>
</section>
@isset($breadcrumbs)
    <section class="page_breadcrumb">
        <div class="container">
            <div class="row">
                <div class="col-sm-7">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            @foreach($breadcrumbs as $breadcrumb)
                                @if($breadcrumb['href'] == '#')
                                    <li class="breadcrumb-item active"><span>{{ucfirst($breadcrumb['label'])}}</span></li>
                                @else
                                    <li class="breadcrumb-item"><a
                                            href="{{$breadcrumb['href']}}">{{ucfirst($breadcrumb['label'])}}</a></li>
                                @endif
                            @endforeach
                        </ol>
                    </nav>
                </div>
                <div class="col-sm-5">
                    <span class="date"><i class="icon_clock_alt"></i>Updated on {{date('F d, Y')}}</span>
                </div>
            </div>
        </div>
    </section>
@endisset
<!--================End Forum Breadcrumb Area =================-->
