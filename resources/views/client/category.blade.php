@extends('MyForumBuilder::client.layouts.app')
@push('meta')
    <title>{{$setting['title']}}</title>
    <meta name="description" content="{{$setting['description']}}"/>
@endpush
@section('content')
    @include('MyForumBuilder::client.layouts.banner-section')
    <!--================Forum Body Area =================-->
    <section class="forum_sidebar_area page-start" id="sticky_doc">
        <div class="container-fluid pl-60 pr-60">
            <h1 class="h3">{{$heading}}</h1>
            <span class="fw-bold">{{$totalContributors}} Contributors . {{$totalTopics}} Topics . {{$totalPosts}} Posts </span>
            @include('MyForumBuilder::client.layouts.ads')

            <div class="row">
                <div class="col-xl-2 d-none d-xl-block">
                    <div class="left_side_forum">
                        {{-- <aside class="l_widget forum_list">
                             <h3 class="wd_title">Forums</h3>
                             <ul class="navbar-nav">
                                 <li class="active nav-item">
                                     <a href="#"><i class="social_tumbleupon"></i>View all</a>
                                 </li>
                                 <li class="nav-item">
                                     <a href="#"><i class="icon_lightbulb_alt"></i>General</a>
                                 </li>
                                 <li class="nav-item">
                                     <a href="#"><i class="icon_lightbulb_alt"></i>Ideas</a>
                                 </li>
                                 <li class="nav-item">
                                     <a href="#"><i class="fa fa-user-o"></i>User Feedback</a>
                                 </li>
                             </ul>
                         </aside>--}}
                        @isset($subCategories)
                            @if($subCategories->isNotEmpty())
                                <aside class="l_widget forum_list">
                                    <h4 class="wd_title">Sub Category</h4>
                                    <ul class="navbar-nav">
                                        @foreach($subCategories as $subCat)
                                            <li class="nav-item">
                                                <a class="nav-link"
                                                   href="@route('sub-category',['category'=>$category->slug,'subCategory'=>$subCat->slug])">
                                                    {{$subCat->name}}
                                                </a>
                                            </li>
                                        @endforeach
                                    </ul>
                                </aside>
                            @endif
                        @endisset
                        @isset($tags)
                            @if($tags->isNotEmpty())
                                <aside class="l_widget l_tags_wd">
                                    <h4 class="wd_title">Popular Tags</h4>
                                    <ul class="list-unstyled w_tag_list style-light">
                                        @foreach($tags as $tag)
                                            <li><a class="text-capitalize"
                                                   href="@route('tag',$tag->slug)">{{$tag->name}}</a></li>
                                        @endforeach
                                    </ul>
                                </aside>
                            @endif
                        @endisset
                        @include('MyForumBuilder::client.layouts.ads')
                        @isset($recent)
                            @if($recent->isNotEmpty())
                                <aside class="l_widget comment_list">
                                    <h4 class="wd_title">Recent Topics</h4>
                                    <ul class="navbar-nav">
                                        @foreach($recent as $topic)
                                            <li>
                                                <div class="media">
                                                    <div class="d-flex">
                                                        <i class="icon_chat_alt"></i>
                                                    </div>
                                                    <div class="media-body">
                                                        <a href="@route('question',$topic->slug)">
                                                            <span class="text-dark h4-replacement">{{$topic->question}}</span>
                                                        </a>
                                                        <span  class="d-block" {{--href="@route('user',$topic->client->username)"--}}>
                                                            <img src="{{get_gravatar($topic->client->email,'16')}}"
                                                                     alt="{{$topic->client->username}}"> {{$topic->client->username}}

                                                        </span>
                                                        <p>{{$topic->created_at->diffForHumans()}}</p>
                                                    </div>
                                                </div>
                                            </li>
                                        @endforeach
                                    </ul>
                                </aside>
                            @endif
                        @endisset
                        @include('MyForumBuilder::client.layouts.ads')
                    </div>
                </div>
                <div class="col-xl-7 col-lg-8">
                    <div class="forum_topic_list_inner">
                        {{--<div class="topics-filter d-xl-none">
                            <ul class="nav">
                                <li class="nav-item">
                                    <a class="nav-link active" href="#">
                                        <ion-icon name="earth-outline"></ion-icon>
                                        View all
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="#" class="nav-link">
                                        <ion-icon name="swap-horizontal-outline"></ion-icon>
                                        General
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="#" class="nav-link">
                                        <ion-icon name="bulb-outline"></ion-icon>
                                        Ideas
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="#" class="nav-link">
                                        <ion-icon name="bulb-outline"></ion-icon>
                                        User Feedback
                                    </a>
                                </li>
                            </ul>
                        </div>--}}
                        @isset($subCategories)
                            @if($subCategories->isNotEmpty())
                                <div class="topics-filter d-xl-none">
                                    <ul class="nav">
                                        @foreach($subCategories as $subCat)
                                            <li class="nav-item">
                                                <a class="nav-link"
                                                   href="@route('sub-category',['category'=>$category->slug,'subCategory'=>$subCat->slug])">
                                                    {{$subCat->name}}
                                                </a>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                        @endisset
                        <div class="forum_l_inner">
                            <div class="forum_head d-flex justify-content-start py-3 ps-2">
                                <h2 class="h6 text-secondary m-0"> Topics</h2>
                                {{--<ul class="nav left">
                                    <li><i class="icon_error-circle_alt"></i> 15 Open</li>
                                    <li><a href="#"><i class=" icon_check"></i> 202 Closed</a></li>
                                    <li><a href="#"><i class="icon_refresh"></i> Reset</a></li>
                                </ul>--}}
                                <ul class="nav right">
                                    {{--<li>
                                        <div class="dropdown">
                                            <button class="btn dropdown-toggle" type="button" data-toggle="dropdown"
                                                    aria-haspopup="true" aria-expanded="false">
                                                Author <i class="arrow_carrot-down"></i>
                                            </button>
                                            <div class="dropdown-menu">
                                                <h3 class="title">Filter by author</h3>
                                                <form action="#" class="cate-search-form">
                                                    <input type="text" placeholder="Search users">
                                                </form>
                                                <div class="all_users scroll">
                                                    <a class="dropdown-item" href="#"><img
                                                            src="img/forum/filter-user-1.png" alt=""> Donny
                                                        Peters</a>
                                                    <a class="dropdown-item" href="#"><img
                                                            src="img/forum/filter-user-2.png" alt="">Linh Knapp</a>
                                                    <a class="dropdown-item" href="#"><img
                                                            src="img/forum/filter-user-3.png" alt="">Albert
                                                        Roach</a>
                                                    <a class="dropdown-item" href="#"><img
                                                            src="img/forum/filter-user-4.png" alt="">Kristin
                                                        Larsen</a>
                                                    <a class="dropdown-item" href="#"><img
                                                            src="img/forum/filter-user-5.png" alt="">Ernest
                                                        Patton</a>
                                                    <a class="dropdown-item" href="#"><img
                                                            src="img/forum/filter-user-2.png" alt="">Linh Knapp
                                                        Patton</a>
                                                    <a class="dropdown-item" href="#"><img
                                                            src="img/forum/filter-user-1.png" alt="">Donny
                                                        Peters</a>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="dropdown right_dir">
                                            <button class="btn dropdown-toggle" type="button" data-toggle="dropdown"
                                                    aria-haspopup="true" aria-expanded="false">
                                                Label <i class="arrow_carrot-down"></i>
                                            </button>
                                            <div class="dropdown-menu">
                                                <h3 class="title">Filter by label</h3>
                                                <form action="#" class="cate-search-form">
                                                    <input type="text" placeholder="Search Users">
                                                </form>
                                                <div class="all_users scroll">
                                                    <a class="dropdown-item" href="#"><span
                                                            class="color red"></span>
                                                        bugs</a>
                                                    <a class="dropdown-item" href="#"><span
                                                            class="color blue"></span>
                                                        request/feature</a>
                                                    <a class="dropdown-item" href="#"><span
                                                            class="color dark_blue"></span> Developer
                                                        Edition</a>
                                                    <a class="dropdown-item" href="#"><span
                                                            class="color green"></span>help wanted</a>
                                                    <a class="dropdown-item" href="#"><span
                                                            class="color pink"></span>question</a>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="dropdown right_dir">
                                            <button class="btn dropdown-toggle" type="button" data-toggle="dropdown"
                                                    aria-haspopup="true" aria-expanded="false">
                                                Sort <i class="arrow_carrot-down"></i>
                                            </button>
                                            <div class="dropdown-menu">
                                                <h3 class="title">Filter by author</h3>
                                                <form action="#" class="cate-search-form">
                                                    <input type="text" placeholder="Search users">
                                                </form>
                                                <div class="all_users short-by scroll">
                                                    <a class="dropdown-item active-short" href="#">
                                                        <ion-icon name="checkmark-outline"></ion-icon>
                                                        Newest
                                                    </a>
                                                    <a class="dropdown-item" href="#"> Oldest </a>
                                                    <a class="dropdown-item" href="#"> Most commented </a>
                                                    <a class="dropdown-item" href="#"> Least commented </a>
                                                    <a class="dropdown-item" href="#"> Recently updated </a>
                                                    <a class="dropdown-item" href="#"> Recently updated </a>
                                                </div>
                                            </div>
                                        </div>
                                    </li>--}}
                                </ul>
                            </div>
                            <div class="forum_body">
                                <ul class="navbar-nav topic_list">
                                    @foreach($pagination as $question)
                                        <li>
                                            <div class="media">

                                                <div class="position-relative">
                                                    <div
                                                        class="up-down-arrow d-flex flex-column justify-content-center align-items-center mx-3 p-0">
                                                        <a href="@route('sign-in')">
                                                            <svg aria-hidden="true" class="svg-icon iconArrowUpLg"
                                                                 width="36" height="36" viewBox="0 0 36 36">
                                                                <path d="M2 25h32L18 9 2 25Z"></path>
                                                            </svg>
                                                        </a>
                                                        <span>{{$question->likes()->count()}}</span>
                                                        <a href="@route('sign-in')">
                                                            <svg aria-hidden="true" class="svg-icon iconArrowDownLg"
                                                                 width="36" height="36" viewBox="0 0 36 36">
                                                                <path d="M2 11h32L18 27 2 11Z"></path>
                                                            </svg>
                                                        </a>
                                                    </div>
                                                </div>
                                                <div class="d-flex">
                                                    <img
                                                            class="rounded-circle"
                                                            src="{{get_gravatar($question->client->email,45)}}"
                                                            alt="{{$question->client->username}}">
                                                </div>
                                                <div class="media-body">
                                                    <div class="t_title">
                                                        <a href="@route('question',$question->slug)">
                                                            <h3 class="question">{{$question->question}}</h3>
                                                        </a>
                                                    </div>
                                                    {{--<a href="#">
                                                        <h6><img src="img/svg/hashtag.svg" alt=""> General
                                                        </h6>
                                                    </a>--}}
                                                    <h6>
                                                        <i class="icon_clock_alt"></i> {{$question->created_at->diffForHumans()}}
                                                    </h6>
                                                    <div class="widget tag_widget mt-3">
                                                        <ul class="list-unstyled w_tag_list style-light">
                                                            @php
                                                                $tagsP = $question->tags()->take(3)
                                                            @endphp
                                                            @if($tagsP->count() > 0)
                                                                @foreach($tagsP->get() as $tag)
                                                                    <li class="p-0"><a class="py-0 px-2"
                                                                                       href="@route('tag',$tag->slug)">{{$tag->name}}</a>
                                                                    </li>
                                                                @endforeach
                                                            @endif
                                                        </ul>
                                                    </div>
                                                </div>
                                                <div class="media-right">
                                                    {{-- @php
                                                        $answers = $question->answers()->orderBy('id','DESC')->take(3);
                                                    @endphp
                                                   @if($answers->exists())
                                                        <ul class="nav">
                                                            @foreach($answers->get() as $answer)
                                                                @php
                                                                    $client = $answer->client
                                                                @endphp
                                                                <li class="dropdown">
                                                                    <a class="dropdown-toggle" href="#" role="button"
                                                                       id="dropdownMenuLink" data-toggle="dropdown"
                                                                       aria-haspopup="true" aria-expanded="false">
                                                                        <img
                                                                            src="{{get_gravatar($client->email,25)}}"
                                                                            alt="{{$client->username}}">
                                                                    </a>
                                                                    <div class="dropdown-menu"
                                                                         aria-labelledby="dropdownMenuLink">
                                                                        <div class="media">
                                                                            <div class="d-flex">
                                                                                <img
                                                                                    src="{{get_gravatar($client->email,120)}}"
                                                                                    alt="{{$client->username}}">
                                                                            </div>
                                                                            <div class="media-body">
                                                                                <a href="@route('user',$client->username)">
                                                                                    <h4>{{$client->username}}</h4>
                                                                                </a>
                                                                                --}}{{--<a class="follow_btn"
                                                                                   href="#">Follow</a>--}}{{--
                                                                            </div>
                                                                        </div>
                                                                        <div class="row answere_items">
                                                                            <div class="col-6">
                                                                                <a href="@route('user',$client->username)">
                                                                                    <h4>Answers</h4>
                                                                                </a>
                                                                                <h6>{{$client->answers()->count()}}</h6>
                                                                            </div>
                                                                            <div class="col-6">
                                                                                <a href="@route('user',$client->username)">
                                                                                    <h4>Question</h4>
                                                                                </a>
                                                                                <h6>{{$client->questions()->count()}}</h6>
                                                                            </div>
                                                                            --}}{{--<div class="col-4">
                                                                                <a href="#">
                                                                                    <h4>Followers</h4>
                                                                                </a>
                                                                                <h6>30</h6>
                                                                            </div>--}}{{--
                                                                        </div>
                                                                    </div>
                                                                </li>
                                                            @endforeach
                                                        </ul>
                                                    @endif--}}
                                                    <span class="count" >
                                                        <ion-icon name="heart-outline"></ion-icon>
                                                        {{$question->likes()->count()}}</span>
                                                    <span class="count">
                                                        <ion-icon name="chatbubbles-outline"></ion-icon>
                                                        {{$question->answers()->count()}}</span>
                                                    <span class="count">
                                                        <ion-icon name="eye-outline"></ion-icon>
                                                        {{ $question->visitor_count }}</span>
                                                </div>
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                        <div class="row pagination_inner">
                            <div class="col-lg-2">
                                <h6>Total: <span> {{ $pagination->total() }} </span></h6>
                            </div>
                            <div class="col-lg-8">
                                {{ $pagination->links('MyForumBuilder::client.layouts.paginator') }}
                            </div>
                            {{--<div class="col-lg-2">
                                <div class="input-group go_btn">
                                    <input type="number" class="form-control" aria-label="Recipient's username">
                                    <div class="input-group-append">
                                        <button class="btn btn-outline-secondary" type="button">Go</button>
                                    </div>
                                </div>
                            </div>--}}
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-4">
                    <div class="right_side_forum">
                        <aside class="r_widget qustion_wd">
                            <button onclick="window.location.assign('{{route("sign-in")}}')" class="btn" type="button">
                                <img src="@assets('img/forum/helpful-user/question-1.png')" alt="">
                                Ask Question
                                <i class="arrow_carrot-right"></i>
                            </button>
                        </aside>
                        {{--  <aside class="r_widget user_list_wd">
                              <div class="r_heading d-flex justify-content-between">
                                  <h3>Most Helpful</h3>
                                  <h5>Last 30 days</h5>
                              </div>
                              <ul class="navbar-nav">
                                  <li>
                                      <a href="#">
                                          <div class="media">
                                              <div class="d-flex">
                                                  <img class="rounded-circle"
                                                       src="img/forum/helpful-user/h-user-1.png" alt="">
                                              </div>
                                              <div class="media-body">
                                                  <h4>cleo-parra</h4>
                                              </div>
                                              <div class="media-right">
                                                  <div class="count">
                                                      10
                                                  </div>
                                                  <i class="icon_check_alt"></i>
                                              </div>
                                          </div>
                                      </a>
                                  </li>
                                  <li>
                                      <a href="#">
                                          <div class="media">
                                              <div class="d-flex">
                                                  <img class="rounded-circle"
                                                       src="img/forum/helpful-user/h-user-2.png" alt="">
                                              </div>
                                              <div class="media-body">
                                                  <h4>roy_marin</h4>
                                              </div>
                                              <div class="media-right">
                                                  <div class="count">
                                                      08
                                                  </div>
                                                  <i class="icon_check_alt"></i>
                                              </div>
                                          </div>
                                      </a>
                                  </li>
                                  <li>
                                      <a href="#">
                                          <div class="media">
                                              <div class="d-flex">
                                                  <img class="rounded-circle"
                                                       src="img/forum/helpful-user/h-user-3.png" alt="">
                                              </div>
                                              <div class="media-body">
                                                  <h4>hellen.austin</h4>
                                              </div>
                                              <div class="media-right">
                                                  <div class="count">
                                                      05
                                                  </div>
                                                  <i class="icon_check_alt"></i>
                                              </div>
                                          </div>
                                      </a>
                                  </li>
                                  <li>
                                      <a href="#">
                                          <div class="media">
                                              <div class="d-flex">
                                                  <img class="rounded-circle"
                                                       src="img/forum/helpful-user/h-user-4.png" alt="">
                                              </div>
                                              <div class="media-body">
                                                  <h4>erna.may</h4>
                                              </div>
                                              <div class="media-right">
                                                  <div class="count">
                                                      03
                                                  </div>
                                                  <i class="icon_check_alt"></i>
                                              </div>
                                          </div>
                                      </a>
                                  </li>
                                  <li>
                                      <a href="#">
                                          <div class="media">
                                              <div class="d-flex">
                                                  <img class="rounded-circle"
                                                       src="img/forum/helpful-user/h-user-5.png" alt="">
                                              </div>
                                              <div class="media-body">
                                                  <h4>jacobson</h4>
                                              </div>
                                              <div class="media-right">
                                                  <div class="count">
                                                      02
                                                  </div>
                                                  <i class="icon_check_alt"></i>
                                              </div>
                                          </div>
                                      </a>
                                  </li>
                                  <li>
                                      <a href="#">
                                          <div class="media">
                                              <div class="d-flex">
                                                  <img class="rounded-circle"
                                                       src="img/forum/helpful-user/h-user-6.png" alt="">
                                              </div>
                                              <div class="media-body">
                                                  <h4>van.mays</h4>
                                              </div>
                                              <div class="media-right">
                                                  <div class="count">
                                                      01
                                                  </div>
                                                  <i class="icon_check_alt"></i>
                                              </div>
                                          </div>
                                      </a>
                                  </li>
                                  <li>
                                      <a href="#">
                                          <div class="media">
                                              <div class="d-flex">
                                                  <img class="rounded-circle"
                                                       src="img/forum/helpful-user/h-user-7.png" alt="">
                                              </div>
                                              <div class="media-body">
                                                  <h4>steve_barr</h4>
                                              </div>
                                              <div class="media-right">
                                                  <div class="count">
                                                      01
                                                  </div>
                                                  <i class="icon_check_alt"></i>
                                              </div>
                                          </div>
                                      </a>
                                  </li>
                              </ul>
                          </aside>--}}
                        @isset($popularTopics)
                            @if($popularTopics->isNotEmpty())
                                <aside class="l_widget comment_list">
                                    <h4 class="wd_title">Popular Topics</h4>
                                    <ul class="navbar-nav">
                                        @foreach($popularTopics as $topic)
                                            <li>
                                                <div class="media">
                                                    <div class="d-flex">
                                                        <i class="icon_chat_alt"></i>
                                                    </div>
                                                    <div class="media-body">
                                                        <a href="@route('question',$topic->slug)">
                                                            <span class="text-dark h4-replacement">{{$topic->question}}</span>
                                                        </a>
                                                        <span class="d-block" {{--href="@route('user',$topic->client->username)"--}}>
                                                            <img src="{{get_gravatar($topic->client->email,'16')}}"
                                                                     alt="{{$topic->client->username}}"> {{$topic->client->username}}

                                                        </span>
                                                        <p>{{$topic->created_at->diffForHumans()}}</p>
                                                    </div>
                                                </div>
                                            </li>
                                        @endforeach
                                    </ul>
                                </aside>
                            @endif
                        @endisset

                        @include('MyForumBuilder::client.layouts.ads')
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--================End Forum Body Area =================-->
@endsection
