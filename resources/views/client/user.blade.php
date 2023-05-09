@extends('MyForumBuilder::client.layouts.app')
@push('meta')
    <title>{{$setting['title']}}</title>
    <meta name="description" content="{{$setting['description']}}"/>
    <meta name="robots" content="noindex, follow">
@endpush
@section('content')
    <section class="doc_banner_area single_breadcrumb search-banner-light">
        {{--<ul class="list-unstyled banner_shap_img">
            <li><img src="@assets('img/new/banner_shap1.png')" alt=""></li>
            <li><img src="@assets('img/new/banner_shap4.png')" alt=""></li>
            <li><img src="@assets('img/new/banner_shap3.png')" alt=""></li>
            <li><img src="@assets('img/new/banner_shap2.png')" alt=""></li>
            <li><img data-parallax='{"x": -180, "y": 80, "rotateY":2000}' src="@assets('img/new/plus1.png')" alt="">
            </li>
            <li><img data-parallax='{"x": -50, "y": -160, "rotateZ":200}' src="@assets('img/new/plus2.png')" alt="">
            </li>
            <li></li>
            <li></li>
            <li></li>
        </ul>--}}
        <div class="container">
            <div class="doc_banner_content">
                <h2 class="">{{$client->username}}</h2>
                <ul class="breadcrumb justify-content-center">
                    <li class="breadcrumb-item"><a href="@route('home')">Home</a></li>
                    <li class="breadcrumb-item"><a class="active" href="#">Profile Member</a></li>
                </ul>
            </div>
        </div>
    </section>

    <!--================Forum Content Area =================-->
    <section class="forum-user-wrapper">
        <div class="container">
            <div class="row forum_main_inner">
                <div class="col-lg-3">
                    <div class="author_option">
                        <div class="author_img">
                            <img class="img-fluid" src="{{get_gravatar($client->email,'256')}}" alt="">
                        </div>
                        <ul class="nav nav-tabs flex-column" id="myTab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab"
                                   aria-controls="home" aria-selected="true">
                                    <i class="icon_profile"></i> Profile
                                </a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab"
                                   aria-controls="profile" aria-selected="false">
                                    <i class="icon_documents"></i> Topics Started
                                </a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link" id="contact-tab" data-toggle="tab" href="#contact" role="tab"
                                   aria-controls="contact" aria-selected="false">
                                    <i class="icon_chat"></i> Replies Created
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-9">
                    <div class="forum_body_area">
                        <div class="forum_topic_list">
                            <div class="tab-content" id="myTabContent">
                                <div class="tab-pane fade show active" id="home" role="tabpanel"
                                     aria-labelledby="home-tab">
                                    <div class="profile_info">
                                        <div class="row p_info_item_inner">
                                            <div class="col-sm-4">
                                                <div class="p_info_item active" data-go-to="#home">
                                                    <img src="@assets('img/icon/p-icon-1.png')" alt="">
                                                    <a href="#">
                                                        <h4>Forum Role</h4>
                                                    </a>
                                                    <a class="info_btn" href="#">User</a>
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <div class="p_info_item" data-go-to="#profile">
                                                    <img src="@assets('img/icon/p-icon-2.png')" alt="">
                                                    <a href="#">
                                                        <h4>Topics Started</h4>
                                                    </a>
                                                    <a class="info_number"
                                                       href="#">{{$client->questions()->count()}}</a>
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <div class="p_info_item" data-go-to="#contact">
                                                    <img src="@assets('img/icon/p-icon-3.png')" alt="">
                                                    <a href="#">
                                                        <h4>Replies Created</h4>
                                                    </a>
                                                    <a class="info_number" href="#">{{$client->answers()->count()}}</a>
                                                </div>
                                            </div>
                                        </div>
                                        <ul class="navbar-nav info_list">
                                            {{--                                            <li><span>Name:</span><a href="#">{{$client->name}}</a></li>--}}
                                            <li><span>Username:</span><a href="#">{{$client->username}}</a></li>
                                            <li><span>City:</span><a href="#">{{$client->city}}</a></li>
                                            <li><span>State:</span><a href="#">{{$client->state}}</a></li>
                                            <li><span>Country:</span><a href="#">{{$client->country}}</a></li>
                                            {{--                                            <li><span>Email:</span><a href="#">{{$client->email}}</a></li>--}}
                                            <li><span>Registered:</span><a
                                                    href="#">{{$client->created_at->diffForHumans()}}</a></li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="profile" role="tabpanel"
                                     aria-labelledby="profile-tab">
                                    {{-- <div class="input-group search_forum">
                                         <input type="text" class="form-control" placeholder="Recipient's username"
                                                aria-label="Recipient's username" aria-describedby="button-addon2">
                                         <div class="input-group-append">
                                             <button class="btn btn-outline-secondary" type="button"
                                                     id="button-addon2"><i class="icon_search"></i></button>
                                         </div>
                                     </div>--}}
                                    <h2>Topics Started By {{$client->username}}</h2>
                                    <div class="forum_l_inner">
                                        <div class="forum_body">
                                            <ul class="navbar-nav topic_list">
                                                @foreach($topicStarted as $topic)
                                                    <li>
                                                        <div class="media">
                                                            {{--    <div class="d-flex">
                                                                    <img class="rounded-circle"
                                                                         src="{{get_gravatar($topic->client->email,45)}}"
                                                                         alt="{{$topic->client->username}}">
                                                                </div>--}}
                                                            <div class="media-body">
                                                                <div class="t_title">
                                                                    <a href="@route('question',$topic->slug)">
                                                                        <h4>{{$topic->question}}</h4>
                                                                    </a>
                                                                    <h6 class="text-dark">{!! nl2p($topic->description) !!}</h6>
                                                                </div>
                                                                <a href="@route('category',$topic->category->slug)">
                                                                    <h6>{{$topic->category->name}} </h6>
                                                                </a>
                                                                <h6>
                                                                    <i class="icon_calendar"></i> {{$topic->created_at->diffForHumans()}}
                                                                </h6>
                                                            </div>
                                                            <div class="media-right">
                                                                <span class="count"><i
                                                                        class="icon_chat_alt"></i> {{$topic->answers()->count()}}
                                                                </span>
                                                                <span class="count rate"><i
                                                                        class="icon_heart_alt"></i> {{$topic->likes()->count()}}
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="list_pagination d-flex justify-content-between">
                                        <div class="left">
                                            <p>Viewing {{ $topicStarted->total() }} topics</p>
                                        </div>
                                        <div class="right">
                                            {{ $topicStarted->links('client.layouts.paginator') }}
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="contact" role="tabpanel"
                                     aria-labelledby="contact-tab">
                                    <h2>Replies Created By {{$client->username}}</h2>
                                    <div class="forum_l_inner comment_l">
                                        <div class="forum_body">
                                            <ul class="navbar-nav topic_comment_list">
                                                @foreach($repliesCreated as $reply)
                                                    <li>
                                                        <div class="media">
                                                            {{-- <div class="d-flex">
                                                                 <img class="rounded-circle"
                                                                      src="{{get_gravatar($reply->client->email,45)}}"
                                                                      alt="{{$reply->client->username}}">
                                                             </div>--}}
                                                            <div class="media-body">
                                                                <div class="t_title">
                                                                    <a href="@route('question',$reply->question->slug)">
                                                                        <h4>{{$reply->question->question}}</h4>
                                                                    </a>
                                                                </div>

                                                                <h6>
                                                                    <i class="icon_calendar"></i> {{$reply->created_at->diffForHumans()}}
                                                                </h6>
                                                                <p>{!! nl2p($reply->answer) !!}</p>
                                                            </div>
                                                        </div>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="list_pagination d-flex justify-content-between">
                                        <div class="left">
                                            <p>Viewing {{ $repliesCreated->total() }} topics</p>
                                        </div>
                                        <div class="right">
                                            {{ $repliesCreated->links('client.layouts.paginator') }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--================End Forum Content Area =================-->

    <!--================Doc Subscribe Area =================-->
   {{-- <section class="doc_subscribe_area doc_subs_full">
        <div class="doc_subscribe_inner">
            <img class="one" src="@assets('img/new/subscribe_shap.png')" alt="">
            <img class="two" src="@assets('img/new/subscribe_shap_two.png')" alt="">
            <div class="container">
                <div class="d-flex">
                    <div class="text wow fadeInLeft" data-wow-delay="0.2s">
                        <h2>Great Customer <br>Relationships start here</h2>
                    </div>
                    <form action="#" class="doc_subscribe_form wow fadeInRight" data-wow-delay="0.4s"
                          method="post">
                        <div class="form-group">
                            <div class="input-fill">
                                <input type="email" name="EMAIL" id="email" class="memail"
                                       placeholder="Your work email">
                            </div>
                            <a href="@route('request-to-join')" type="submit" class="submit_btn">Get started</a>
                        </div>
                        <ul class="list-unstyled">
                            <li><a href="#">Messenger</a></li>
                            <li><a href="#">Product Tours</a></li>
                            <li><a href="#">Inbox and more</a></li>
                        </ul>

                    </form>
                </div>
            </div>
        </div>
    </section>--}}
    <!--================End Doc Subscribe Area =================-->
@endsection
@push('script')
    <script>
        $('[data-go-to]').click(function (e) {
            $('.nav-tabs a[href="' + $(this).data('go-to') + '"]').tab('show')
        });
    </script>
@endpush
