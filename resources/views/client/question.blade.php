@extends('MyForumBuilder::client.layouts.app')
@push('meta')
    <title>{{$question->question}}</title>
    <meta name="description" content="{{\Illuminate\Support\Str::words($question->description,30)}}"/>

    <script type="application/ld+json">
        @json([
            '@context'=>'https://schema.org',
            '@type'=>'DiscussionForumPosting',
            '@id'=>route('question',$question->slug),
            'headline'=>$question->question,
            'author'=>[
                '@type'=>'Person',
                'name'=>$client->username
            ],
            'interactionStatistic'=>[
                '@type'=>'InteractionCounter',
                'interactionType'=>'https://schema.org/CommentAction',
                'userInteractionCount'=>$question->answers()->count()
            ]
        ],JSON_PRETTY_PRINT)

    </script>
@endpush
@push('style')
    <link rel="stylesheet" href="@assets('plugins/niceselectpicker/nice-select.css')">
    <link rel="stylesheet" href="@assets('plugins/slick/slick.css')">
    <link rel="stylesheet" href="@assets('plugins/slick/slick-theme.css')">
@endpush
@section('content')
    @include('MyForumBuilder::client.layouts.banner-section')


    <section class="doc_blog_grid_area sec_pad forum-single-content page-start">
        <div class="container">
            <div class="row">
                <div class="col-lg-9">
                    <!-- Forum post top area -->
                    <div class="row">
                        <div class="col-lg-9">
                            <div class="forum-post-top">
                                <a class="author-avatar" href="@route('user',$client->username)">
                                    <img src="{{get_gravatar($client->email,'50')}}" alt="">
                                </a>
                                <div class="forum-post-author">
                                    <a class="author-name"
                                       href="@route('user',$client->username)"> {{$client->username}} </a>
                                    <div class="forum-author-meta">
                                        <div class="author-badge">
                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                 xmlns:xlink="http://www.w3.org/1999/xlink" width="16px" height="15px">
                                                <path fill-rule="evenodd" fill="rgb(131, 135, 147)"
                                                      d="M11.729,12.136 L11.582,12.167 C11.362,12.415 11.125,12.645 10.869,12.857 L14.999,12.857 C15.134,12.857 15.255,12.944 15.307,13.077 C15.359,13.211 15.331,13.365 15.235,13.467 L14.488,14.268 C14.053,14.733 13.452,15.000 12.838,15.000 L2.495,15.000 C1.872,15.000 1.286,14.740 0.845,14.268 L0.098,13.467 C0.002,13.365 -0.026,13.211 0.026,13.077 C0.077,12.944 0.199,12.857 0.334,12.857 L4.463,12.857 C2.928,11.585 2.000,9.630 2.000,7.499 L2.000,6.785 C2.000,6.194 2.449,5.713 3.000,5.713 L12.333,5.713 C12.885,5.713 13.333,6.194 13.333,6.785 L13.333,7.343 C13.869,7.160 14.736,6.973 15.355,7.400 C15.783,7.696 16.000,8.209 16.000,8.928 C16.000,11.239 11.903,12.100 11.729,12.136 ZM14.994,8.002 C14.557,7.698 13.715,7.941 13.294,8.113 C13.197,9.261 12.837,10.339 12.255,11.269 C13.480,10.911 15.333,10.116 15.333,8.928 C15.333,8.462 15.223,8.158 14.994,8.002 ZM10.261,4.419 C10.376,4.573 10.353,4.798 10.209,4.921 C10.148,4.974 10.074,4.999 10.001,4.999 C9.903,4.999 9.807,4.954 9.740,4.865 C9.198,4.139 9.198,3.002 9.741,2.277 C10.086,1.816 10.086,1.040 9.742,0.580 C9.627,0.426 9.650,0.201 9.794,0.078 C9.937,-0.044 10.146,-0.020 10.263,0.134 C10.805,0.860 10.805,1.996 10.263,2.722 C9.917,3.183 9.917,3.959 10.261,4.419 ZM8.259,4.419 C8.373,4.573 8.350,4.798 8.207,4.921 C8.145,4.974 8.071,4.999 7.999,4.999 C7.901,4.999 7.804,4.954 7.738,4.865 C7.195,4.139 7.195,3.002 7.738,2.277 C8.082,1.816 8.082,1.040 7.739,0.580 C7.624,0.426 7.647,0.201 7.791,0.078 C7.935,-0.045 8.145,-0.020 8.259,0.134 C8.802,0.860 8.802,1.996 8.259,2.722 C7.915,3.183 7.915,3.959 8.259,4.419 ZM6.261,4.418 C6.376,4.572 6.353,4.797 6.210,4.920 C6.148,4.973 6.074,4.999 6.001,4.999 C5.903,4.999 5.807,4.953 5.741,4.865 C5.198,4.139 5.198,3.002 5.741,2.276 C6.085,1.815 6.085,1.039 5.742,0.580 C5.627,0.426 5.650,0.201 5.794,0.078 C5.937,-0.046 6.147,-0.020 6.262,0.133 C6.804,0.859 6.804,1.996 6.262,2.721 C5.918,3.182 5.918,3.959 6.261,4.418 Z"/>
                                            </svg>
                                            <span>Conversation Starter</span>
                                        </div>
                                        <div class="author-badge">
                                            <i class="icon_calendar"></i>
                                            <span href="">{{$question->created_at->format('F d Y \a\t h:i A')}}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="action-button-container">
                                <a href="@route('sign-in')" class="action_btn btn-ans ask-btn">Ask Question</a>
                            </div>
                        </div>
                    </div>

                    <!-- Forum post content -->
                    <div class="q-title">
                        <div class="position-relative">
                            <div
                                class="up-down-arrow d-flex flex-column justify-content-center align-items-center mr-3">
                                <a href="@route('sign-in')">
                                    <svg aria-hidden="true" class="svg-icon iconArrowUpLg" width="36" height="36"
                                         viewBox="0 0 36 36">
                                        <path d="M2 25h32L18 9 2 25Z"></path>
                                    </svg>
                                </a>
                                <span>{{$question->likes()->count()}}</span>
                                <a href="@route('sign-in')">
                                    <svg aria-hidden="true" class="svg-icon iconArrowDownLg" width="36" height="36"
                                         viewBox="0 0 36 36">
                                        <path d="M2 11h32L18 27 2 11Z"></path>
                                    </svg>
                                </a>
                            </div>
                        </div>
                        <span class="question-icon" title="Question">Q:</span>
                        <h1>{{$question->question}}</h1>
                    </div>
                    <div class="forum-post-content">
                        <div class="content">
                            {!! nl2p($question->description) !!}
                        </div>
                        @php($tagsQ = $question->tags()->active())
                        @if($tagsQ->count() > 0)
                            <div class="forum-post-btm">
                                <div class="taxonomy forum-post-tags">
                                    <i class="icon_tags_alt"></i>
                                    @foreach($tagsQ->get() as $index=>$t)
                                        @if($index != 0)
                                            ,
                                        @endif
                                        <a href="@route('tag',$t->slug)">{{$t->name}}</a>
                                    @endforeach
                                </div>
                                {{-- <div class="taxonomy forum-post-cat">
                                     <img src="img/forum/logo-favicon.png" alt=""><a href="#">Docy Support</a>
                                 </div>--}}
                            </div>
                        @endif
                        {{-- <div class="action-button-container action-btns">
                             <a href="#" class="action_btn btn-ans ask-btn reply-btn">Reply</a>
                             <a href="#" class="action_btn btn-ans ask-btn too-btn">I have this question too (20)</a>
                         </div>--}}
                    </div>

                {{--  <!-- Best answer -->
                  <div class="best-answer">
                      <div class="row">
                          <div class="col-lg-9">
                              <div class="forum-post-top">
                                  <a class="author-avatar" href="#">
                                      <img src="img/forum/author-avatar.png" alt="">
                                  </a>
                                  <div class="forum-post-author">
                                      <a class="author-name" href="#"> Eh Jewel </a>
                                      <div class="forum-author-meta">
                                          <div class="author-badge">
                                              <svg xmlns="http://www.w3.org/2000/svg"
                                                   xmlns:xlink="http://www.w3.org/1999/xlink" width="16px"
                                                   height="15px">
                                                  <path fill-rule="evenodd" fill="rgb(131, 135, 147)"
                                                        d="M11.729,12.136 L11.582,12.167 C11.362,12.415 11.125,12.645 10.869,12.857 L14.999,12.857 C15.134,12.857 15.255,12.944 15.307,13.077 C15.359,13.211 15.331,13.365 15.235,13.467 L14.488,14.268 C14.053,14.733 13.452,15.000 12.838,15.000 L2.495,15.000 C1.872,15.000 1.286,14.740 0.845,14.268 L0.098,13.467 C0.002,13.365 -0.026,13.211 0.026,13.077 C0.077,12.944 0.199,12.857 0.334,12.857 L4.463,12.857 C2.928,11.585 2.000,9.630 2.000,7.499 L2.000,6.785 C2.000,6.194 2.449,5.713 3.000,5.713 L12.333,5.713 C12.885,5.713 13.333,6.194 13.333,6.785 L13.333,7.343 C13.869,7.160 14.736,6.973 15.355,7.400 C15.783,7.696 16.000,8.209 16.000,8.928 C16.000,11.239 11.903,12.100 11.729,12.136 ZM14.994,8.002 C14.557,7.698 13.715,7.941 13.294,8.113 C13.197,9.261 12.837,10.339 12.255,11.269 C13.480,10.911 15.333,10.116 15.333,8.928 C15.333,8.462 15.223,8.158 14.994,8.002 ZM10.261,4.419 C10.376,4.573 10.353,4.798 10.209,4.921 C10.148,4.974 10.074,4.999 10.001,4.999 C9.903,4.999 9.807,4.954 9.740,4.865 C9.198,4.139 9.198,3.002 9.741,2.277 C10.086,1.816 10.086,1.040 9.742,0.580 C9.627,0.426 9.650,0.201 9.794,0.078 C9.937,-0.044 10.146,-0.020 10.263,0.134 C10.805,0.860 10.805,1.996 10.263,2.722 C9.917,3.183 9.917,3.959 10.261,4.419 ZM8.259,4.419 C8.373,4.573 8.350,4.798 8.207,4.921 C8.145,4.974 8.071,4.999 7.999,4.999 C7.901,4.999 7.804,4.954 7.738,4.865 C7.195,4.139 7.195,3.002 7.738,2.277 C8.082,1.816 8.082,1.040 7.739,0.580 C7.624,0.426 7.647,0.201 7.791,0.078 C7.935,-0.045 8.145,-0.020 8.259,0.134 C8.802,0.860 8.802,1.996 8.259,2.722 C7.915,3.183 7.915,3.959 8.259,4.419 ZM6.261,4.418 C6.376,4.572 6.353,4.797 6.210,4.920 C6.148,4.973 6.074,4.999 6.001,4.999 C5.903,4.999 5.807,4.953 5.741,4.865 C5.198,4.139 5.198,3.002 5.741,2.276 C6.085,1.815 6.085,1.039 5.742,0.580 C5.627,0.426 5.650,0.201 5.794,0.078 C5.937,-0.046 6.147,-0.020 6.262,0.133 C6.804,0.859 6.804,1.996 6.262,2.721 C5.918,3.182 5.918,3.959 6.261,4.418 Z"/>
                                              </svg>
                                              <span>Conversation Starter</span>
                                          </div>
                                          <div class="author-badge">
                                              <i class="icon_calendar"></i>
                                              <a href="">January 16 at 10:32 PM</a>
                                          </div>
                                      </div>
                                  </div>
                              </div>
                          </div>
                          <div class="col-lg-3">
                              <p class="accepted-ans-mark">
                                  <i class="icon_check"></i> <span>Accepted Solution</span>
                              </p>
                          </div>
                      </div>
                      <div class="best-ans-content d-flex">
                          <span class="question-icon" title="The Best Answer">A:</span>
                          <p>
                              Hi,
                              You can edit the service pages with Elementor. To enable Elementor on Service post type,
                              follow the bellow steps<br>
                              Step 1 - Navigate to your website's WordPress Dashbord>Elementor>Settings<br>
                              Step 2 - Tick the post you went to edit with Elementor in the post typs section and
                              click the save<br>
                              changes button<br>
                              Step 3 - Now you can click edit with Elementor button and start working<br><br>
                              Thanks!
                          </p>
                      </div>
                  </div>
--}}
                <!-- All answer -->
                    @include('MyForumBuilder::client.layouts.ads')
                    <div class="all-answers">
                        <h2 class="title">All Replies</h2>
                        <div class="filter-bar d-flex justify-content-end py-4">
                            {{--<div class="sort">
                               <select class="custom-select" id="sortBy">
                                   <option selected>Sort By</option>
                                   <option value="1">ASC</option>
                                   <option value="2">Desc</option>
                               </select>
                           </div>--}}
                        </div>

                        @if($answers->exists())
                            @php($rand = rand(1,$answers->count()))
                            @foreach($answers->get() as $index=>$answer)
                                @if($related && $index == $rand)
                                    <div class="forum-comment">
                                        <div class="comment-content">
                                            <h2 class="h6">Related Topics</h2>
                                            <ul class="list-group">
                                                @foreach($related as $relate)
                                                    <li class="list-group-item">
                                                        <a href="@route('question',$relate->slug)">{{$relate->question}}</a>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </div>
                                        @include('MyForumBuilder::client.layouts.ads')
                                    </div>
                                @endif

                                <div class="forum-comment">
                                    <div class="forum-post-top">
                                        <a class="author-avatar" href="@route('user',$answer->client->username)">
                                            <img src="{{get_gravatar($answer->client->email,'50')}}"
                                                 alt="{{$answer->client->username}}">
                                        </a>
                                        <div class="forum-post-author">
                                            <a class="author-name"
                                               href="@route('user',$answer->client->username)">{{$answer->client->username}}</a>
                                            <div class="forum-author-meta">

                                                <div class="author-badge">
                                                    <i class="icon_calendar"></i>
                                                    <span>{{$answer->created_at->format('F d Y \a\t h:i A')}}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="comment-content">
                                        @if($answer->answer_html)
                                            {!! $answer->answer_html !!}
                                        @else
                                            {!! nl2p($answer->answer) !!}
                                        @endif
                                        <div class="action-button-container action-btns">
                                            {{--                                            <a href="@route('sign-in')" class="action_btn btn-ans ask-btn reply-btn">Reply</a>--}}
                                            <a href="@route('sign-in')" class="action_btn btn-ans ask-btn too-btn">Helpful
                                                ({{$answer->likes()->count()}})</a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @endif
                        <div class="row mt-3">
                            <div class="col-6">
                                @if($previous)
                                    <a href="@route('question',$previous->slug)" class="h4">
                                        <i class="arrow_left_alt"></i>
                                        <span class="d-block h6 mt-2 font-weight-normal">
                                        {{$previous->question}}
                                   </span>
                                    </a>
                                @endif
                            </div>
                            <div class="col-6 text-right">
                                @if($next)
                                    <a href="@route('question',$next->slug)" class="h4">
                                        <i class="arrow_right_alt"></i>
                                        <span class="d-block h6 mt-2 font-weight-normal">
                                        {{$next->question}}
                                   </span>
                                    </a>
                                @endif
                            </div>
                        </div>
                        @php($tagsR = $question->tags()->active())
                        @if($tagsR)
                            @php($tagsR = $tagsR->take(3))
                            @foreach($tagsR->get() as $index=>$t)
                                @if($t->questions()->count() > 0)
                                    <div class="forum-comment">
                                        <div class="comment-content">
                                            <h2 class="h6">More Topics Related to {{$t->name}}</h2>
                                            <ul class="list-group">
                                                @foreach($t->questions()->take(5)->get() as $q)
                                                    <li class="list-group-item">
                                                        <a href="@route('question',$q->slug)">{{$q->question}}</a>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>
                                    @include('MyForumBuilder::client.layouts.ads')
                                @endif
                            @endforeach
                        @endif

                    </div>
                </div>
                <!-- /.col-lg-8 -->

                <div class="col-lg-3">
                    <div class="forum_sidebar">
                        @isset($tags)
                            @if($tags->isNotEmpty())
                                <div class="r_widget tag_widget">
                                    <h4 class="wd_title">Popular Tags</h4>
                                    <ul class="list-unstyled w_tag_list style-light">
                                        @foreach($tags as $tag)
                                            <li><a class="text-capitalize"
                                                   href="@route('tag',$tag->slug)">{{$tag->name}}</a>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                        @endisset
                        @include('MyForumBuilder::client.layouts.ads')
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
                                                            <span
                                                                class="text-dark h4-replacement">{{$topic->question}}</span>
                                                        </a>
                                                        <span class="d-block">
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
                                                            <span
                                                                class="text-dark h4-replacement">{{$topic->question}}</span>
                                                        </a>
                                                        <span class="d-block">
                                                            <span class="d-block"><img
                                                                    src="{{get_gravatar($topic->client->email,'16')}}"
                                                                    alt="{{$topic->client->username}}"> {{$topic->client->username}}
                                                            </span>
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
                <!-- /.col-lg-4 -->
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
    <!-- /.call-to-action -->
@endsection

@push('script')

    <script src="@assets('plugins/niceselectpicker/jquery.nice-select.min.js')"></script>
    <script src="@assets('plugins/slick/slick.min.js')"></script>

@endpush
