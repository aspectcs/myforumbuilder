<footer class="doc_footer_area">
    {{-- <div class="doc_footer_top">
         <div class="container">
             <div class="row">
                 <div class="col-lg-4 col-sm-6">
                     <div class="f_widget doc_about_widget wow fadeInUp" data-wow-delay="0.2s">
                         <a href="#">
                             <img src="@assets('img/logo.png')" srcset="@assets('img/logo-2x.png') 2x" alt="">
                         </a>
                         <p>I’m available for commissions and collaborations, and i’m excited to hear from you
                             about
                             new projects.!!</p>
                         <ul class="list-unstyled">
                             <li><a href="#"><i class="social_facebook"></i></a></li>
                             <li><a href="#"><i class="social_twitter"></i></a></li>
                             <li><a href="#"><i class="social_vimeo"></i></a></li>
                             <li><a href="#"><i class="social_linkedin"></i></a></li>
                         </ul>
                     </div>
                 </div>
                 <div class="col-lg-2 col-sm-6">
                     <div class="f_widget doc_service_list_widget pl-30 wow fadeInUp" data-wow-delay="0.3s">
                         <h3 class="f_title_two">Solutions</h3>
                         <ul class="list-unstyled">
                             <li><a href="#"><img src="@assets('img/new/smile2.png')" alt="">Help Docs</a></li>
                         </ul>
                     </div>
                 </div>
                 <div class="col-lg-3 col-sm-6">
                     <div class="f_widget doc_service_list_widget pl-100 wow fadeInUp" data-wow-delay="0.4s">
                         <h3 class="f_title_two">Support</h3>
                         <ul class="list-unstyled">
                             <li><a href="#">Help Desk</a></li>
                         </ul>
                     </div>
                 </div>
                 <div class="col-lg-3 col-sm-6">
                     <div class="f_widget doc_service_list_widget pl-70 wow fadeInUp" data-wow-delay="0.5s">
                         <h3 class="f_title_two">Company</h3>
                         <ul class="list-unstyled">
                             <li><a href="#">About Us</a></li>
                         </ul>
                     </div>
                 </div>
             </div>
         </div>
     </div>--}}
    <div class="doc_footer_bottom">
        <div class="container d-flex justify-content-between">
            <p class="wow fadeInUp" data-wow-delay="0.3s">© {{date('Y')}} All Rights Reserved.
                <span>{{$forumName??''}}</span>
            </p>
            @isset($forumFooter)
                <ul class="doc_footer_menu list-unstyled wow fadeInUp" data-wow-delay="0.2s">
                    @foreach($forumFooter as $nav)
                        <li>
                            <a href="{{$nav['href']}}" class="nav-link">{{$nav['label']}}</a>
                        </li>
                    @endforeach
                    {{--<li class="nav-item dropdown submenu">
                        <a href="#" class="nav-link dropdown-toggle">Categories</a>
                        <i class="arrow_carrot-down_alt2 mobile_dropdown_icon" aria-hidden="false" data-toggle="dropdown"></i>
                        <ul class="dropdown-menu">
                            <li class="nav-item"><a href="" class="nav-link">Creative Helpdesk</a></li>
                        </ul>
                    </li>--}}
                </ul>
            @endisset
        </div>
    </div>
</footer>
