@extends('MyForumBuilder::client.layouts.app')
@push('meta')
    <title>{{$setting['title']}}</title>
    <meta name="description" content="{{$setting['description']}}"/>
@endpush
@section('content')
    @include('MyForumBuilder::client.layouts.banner-section')
    <section class="doc_blog_grid_area sec_pad forum-page-content">
        <div class="container">
            <div class="row">
                <div class="col-lg-9">
                    <h1 class="h3">Welcome to {{$forumName}} Community</h1>
                @include('MyForumBuilder::client.layouts.ads')
                {{--<div class="answer-action shadow">
                    <div class="action-content">
                        <div class="image-wrap">
                            <img src="@assets('img/home_support/answer.png')" alt="answer action">
                        </div>
                        <div class="content">
                            <h2 class="ans-title">Can’t find an answer?</h2>
                            <p> Join the discussion and get help! </p>
                        </div>
                    </div>
                    <!-- /.action-content -->
                    <div class="action-button-container">
                        <a href="@route('sign-up')" class="action_btn btn-ans">Ask a Question</a>
                    </div>
                    <!-- /.action-button-container -->
                </div>--}}
                <!-- /.answer-action -->
                    <div class="forum_topic_list_inner">
                        <div class="forum_l_inner mb-5">
                            <div class="forum_head d-flex justify-content-between">
                                <div class="nav left d-flex align-items-center">
                                    <h2 class="py-3 pl-2 h6 text-secondary font-weight-normal mb-0"> Popular
                                        Threads</h2>
                                </div>
                                {{--  <ul class="nav right">
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
                                      </li>
                                  </ul>--}}
                            </div>
                            <div class="forum_body">
                                <ul class="navbar-nav topic_list">
                                    @foreach($popular as $question)
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
                                                    <img class="rounded-circle"
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
                                                    <a class="count" href="@route('question',$question->slug)">
                                                        <ion-icon name="heart-outline"></ion-icon>
                                                        {{$question->likes()->count()}}</a>
                                                    <a class="count" href="@route('question',$question->slug)">
                                                        <ion-icon name="chatbubbles-outline"></ion-icon>
                                                        {{$question->answers()->count()}}</a>
                                                    <a class="count" href="@route('question',$question->slug)">
                                                        <ion-icon name="eye-outline"></ion-icon>
                                                        {{ $question->visitor_count }}</a>
                                                </div>
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                    @include('MyForumBuilder::client.layouts.ads')
                    <div class="forum_topic_list_inner">
                        <div class="forum_l_inner mb-5">
                            <div class="forum_head d-flex justify-content-between">
                                <div class="nav left d-flex align-items-center">
                                    <h2 class="py-3 pl-2 h6 text-secondary font-weight-normal mb-0"> Latest Threads</h2>
                                </div>
                                {{--<ul class="nav right">
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
                                    </li>
                                </ul>--}}
                            </div>
                            <div class="forum_body">
                                <ul class="navbar-nav topic_list">
                                    @foreach($latest as $question)
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
                                                    <img class="rounded-circle"
                                                         src="{{get_gravatar($question->client->email,45)}}"
                                                         alt="{{$question->client->name}}">
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
                                                                $tagsL = $question->tags()->take(3)
                                                            @endphp
                                                            @if($tagsL->count() > 0)
                                                                @foreach($tagsL->get() as $tag)
                                                                    <li class="p-0"><a class="py-0 px-2"
                                                                                       href="@route('tag',$tag->slug)">{{$tag->name}}</a>
                                                                    </li>
                                                                @endforeach
                                                            @endif
                                                        </ul>
                                                    </div>
                                                </div>
                                                <div class="media-right">
                                                    {{--@php
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
                                                                                <img src="{{get_gravatar($client->email,120)}}"
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
                                                    <a class="count" href="@route('question',$question->slug)">
                                                        <ion-icon name="heart-outline"></ion-icon>
                                                        {{$question->likes()->count()}}</a>
                                                    <a class="count" href="@route('question',$question->slug)">
                                                        <ion-icon name="chatbubbles-outline"></ion-icon>
                                                        {{$question->answers()->count()}}</a>
                                                    <a class="count" href="@route('question',$question->slug)">
                                                        <ion-icon name="eye-outline"></ion-icon>
                                                        {{ $question->visitor_count }}</a>
                                                </div>
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                    @include('MyForumBuilder::client.layouts.ads')
                    <div class="post-header forums-header">
                        <div class="col-md-6 col-sm-6 support-info">
                            <h2 class="h6 text-secondary font-weight-normal mb-0"> All Categories</h2>
                        </div>
                        <!-- /.support-info -->
                        <div class="col-md-6 col-sm-6 support-category-menus">
                            <ul class="forum-titles">
                                <li class="forum-topic-count">Topics</li>
                                <li class="forum-reply-count">Posts</li>
                                <li class="forum-freshness">Last Post</li>
                            </ul>
                        </div>
                        <!-- /.support-category-menus -->
                    </div>
                    <!-- /.post-header -->

                    <div class="community-posts-wrapper bb-radius">
                        <!-- Forum Item -->
                        @foreach($categories as $category)
                            <div class="community-post style-two forum-item bug">
                                <div class="col-md-6 post-content">
                                    {{-- <div class="author-avatar forum-icon">
                                         <img src="@assets('img/home_support/rc1.png')" alt="community post">
                                     </div>--}}
                                    <div class="entry-content">
                                        <a href="@route('category',$category->slug)">
                                            <h3 class="post-title"> {{$category->name}} </h3>
                                        </a>
                                        <p>{{$category->description}}</p>
                                    </div>
                                </div>
                                <div class="col-md-6 post-meta-wrapper">
                                    <ul class="forum-titles">
                                        <li class="forum-topic-count">{{$category->questions()->count()}}</li>
                                        <li class="forum-reply-count">{{$category->totalPosts()}}</li>
                                        <li class="forum-freshness">
                                            <div class="freshness-box">
                                                <div class="freshness-top">
                                                    <div class="freshness-link">
                                                        <a href="@route('question',$category->lastQuestion->slug)"
                                                           title="Reply To: {{$category->lastQuestion->question}}">
                                                            {{$category->lastQuestion->created_at->diffForHumans()}}
                                                        </a>
                                                    </div>
                                                </div>
                                                <div class="freshness-btm">
                                                    <a href="@route('question',$category->lastQuestion->slug)"
                                                       title="View {{$category->lastQuestion->client->username}} profile"
                                                       class="bbp-author-link">
                                                        {{--<div class="freshness-name">
                                                            <span href="@route('user',$category->lastQuestion->client->username)"
                                                               title="View {{$category->lastQuestion->client->username}} profile"
                                                               class="bbp-author-link">
                                                                <span
                                                                    class="bbp-author-name">{{$category->lastQuestion->client->username}}</span>
                                                            </span>
                                                        </div>
                                                        <span class="bbp-author-avatar">
                                                            <img alt="{{$category->lastQuestion->client->username}}"
                                                                 src="{{get_gravatar($category->lastQuestion->client->email)}}"
                                                                 class="{{$category->lastQuestion->client->username}}">
                                                        </span>--}}
                                                    </a>
                                                </div>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <!-- /.forum-item  -->
                        @endforeach
                    </div>
                    <!-- /.community-posts-wrapper -->
                </div>
                <!-- /.col-lg-9 -->

                <div class="col-lg-3">
                    <div class="forum_sidebar">
                        {{--<div class="widget status_widget">
                            <h4 class="c_head">Information</h4>
                            <p class="status">Support is <span class="offline">Offline</span></p>

                            <div class="open-hours">
                                <h4 class="title-sm">Our office hours</h4>
                                <p>Monday - Friday / 10am - 6pm (UTC +4) NewYork</p>
                                <ul class="current-time list-unstyled">
                                    <li>
                                        <h4 class="title-sm">Your time</h4>
                                        <p>10:30:15 PM</p>
                                    </li>
                                    <li>
                                        <h4 class="title-sm">Your time</h4>
                                        <p>10:30:15 PM</p>
                                    </li>
                                </ul>
                            </div>
                            <!-- /.open-hours -->

                        </div>--}}

                        {{--<div class="widget ticket_widget">
                            <h4 class="c_head">Categories</h4>

                            <ul class="list-unstyled ticket_categories">
                                @foreach($popularCategories as $category)
                                    <li>
                                        <a href="@route('category',$category->slug)">{{$category->name}}</a> <span
                                            class="count">{{$category->question()->count()}}</span>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
--}}
                        <div class="widget tag_widget">
                            <h4 class="c_head">Popular Tags</h4>
                            <ul class="list-unstyled w_tag_list style-light">
                                @foreach($tags as $tag)
                                    <li><a href="@route('tag',$tag->slug)">{{$tag->name}}</a></li>
                                @endforeach
                            </ul>

                            @include('MyForumBuilder::client.layouts.ads')
                        </div>

                    </div>
                </div>
                <!-- /.col-lg-3 -->
            </div>
        </div>
    </section>

    <div class="call-to-action">
        <div class="overlay-bg"></div>
        <div class="container">
            <div class="action-content-wrapper">
                <div class="action-title-wrap title-img">
                    <img src="@assets('img/home_support/chat-smile.png')" alt="">
                    <h4 class="action-title">New to {{$forumName}} Community?</h4>
                </div>
                <a href="@route('request-to-join')" class="action_btn">Join the community <i
                        class="arrow_right"></i></a>
            </div>
            <!-- /.action-content-wrapper -->
        </div>
        <!-- /.container -->
    </div>
@endsection
