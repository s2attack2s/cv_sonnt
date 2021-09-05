<div class="col-md-3 left_col">
    <div class="left_col scroll-view">
        <div class="navbar nav_title" style="border: 0;">
            <a href="{{route('Home1')}}" class="site_title" target="_blank">
                <i class="fa fa-paw"></i>
                <span>TOP Loop</span>
            </a>
        </div>

        <div class="clearfix"></div>

        <!-- menu profile quick info -->
        <div class="profile clearfix">
            <div class="profile_pic">
                <img src="/images/common/user.png" alt="{{$user->name}}" class="img-circle profile_img">
            </div>
            <div class="profile_info">
                <span>{{__('Welcome')}},</span>
                <h2>{{$user->name}}</h2>
            </div>
        </div>
        <!-- /menu profile quick info -->

        <br />

        <!-- sidebar menu -->
        <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
            <div class="menu_section">
                <ul class="nav side-menu">
                    <li>
                        <a href="{{route('Home1')}}" target="_blank">
                            <i class="fa fa-home" aria-hidden="true"></i> {{__('Home')}}
                        </a>
                    </li>
                    <li>
                        <a href="{{route('AdminDashboard2')}}">
                            <i class="fa fa-tachometer" aria-hidden="true"></i> {{__('Dashboard')}}
                        </a>
                    </li>
{{--                    <li>--}}
{{--                        <a href="javascript:void(0);">--}}
{{--                            <i class="fa fa-users" aria-hidden="true"></i> {{__('Users Management')}} <span class="fa fa-chevron-down"></span>--}}
{{--                        </a>--}}
{{--                        <ul class="nav child_menu">--}}
{{--                            <li>--}}
{{--                                <a href="{{route('ListOfUsers')}}">--}}
{{--                                    <i class="fa fa-list-ul" aria-hidden="true"></i> {{__('List of users')}}--}}
{{--                                </a>--}}
{{--                            </li>--}}
{{--                            <li>--}}
{{--                                <a href="{{route('CreateUser')}}">--}}
{{--                                    <i class="fa fa-plus" aria-hidden="true"></i>{{__('Add user')}}--}}
{{--                                </a>--}}
{{--                            </li>--}}
{{--                        </ul>--}}
{{--                    <li>--}}
                    <li>
                        <a href="javascript:void(0);">
                            <i class="fa fa-newspaper-o" aria-hidden="true"></i> {{__('News Management')}} <span class="fa fa-chevron-down"></span>
                        </a>
                        <ul class="nav child_menu">
                            <li>
                                <a href="{{route('ListOfNews')}}">
                                    <i class="fa fa-list-ul" aria-hidden="true"></i> {{__('List of News')}}
                                </a>
                            </li>
                            <li>
                                <a href="{{route('CreateNews')}}">
                                    <i class="fa fa-plus" aria-hidden="true"></i>{{__('Add News')}}
                                </a>
                            </li>
                        </ul>
                    <li>

                    <li>
                        <a href="javascript:void(0);">
                            <i class="fa fa-cube" aria-hidden="true"></i> {{__('Client Management')}} <span class="fa fa-chevron-down"></span>
                        </a>
                        <ul class="nav child_menu">
                            <li>
                                <a href="{{route('ListOfClients')}}">
                                    <i class="fa fa-list-ul" aria-hidden="true"></i> {{__('List of Clients')}}
                                </a>
                            </li>
                            <li>
                                <a href="{{route('CreateClient')}}">
                                    <i class="fa fa-plus" aria-hidden="true"></i>{{__('Add Client')}}
                                </a>
                            </li>
                        </ul>
                    <li>

                    <li>
                        <a href="javascript:void(0);">
                            <i class="fa fa-mobile" aria-hidden="true"></i> {{__('Contact Management')}} <span class="fa fa-chevron-down"></span>
                        </a>
                        <ul class="nav child_menu">
                            <li>
                                <a href="{{route('ListOfContacts')}}">
                                    <i class="fa fa-user-tag" aria-hidden="true"></i> {{__('List of Contact')}}
                                </a>
                            </li>

                        </ul>
                    <li>

                    <li>
                        <a href="javascript:void(0);">
                            <i class="fa fa-list" aria-hidden="true"></i> {{__('Career Management')}} <span class="fa fa-chevron-down"></span>
                        </a>
                        <ul class="nav child_menu">
                            <li>
                                <a href="{{route('ListOfCareers')}}">
                                    <i class="fa fa-object-group" aria-hidden="true"></i> {{__('List of Careers')}}
                                </a>
                            </li>
                            <li>
                                <a href="{{route('ListOfCandidates')}}">
                                    <i class="fa fa-list-ul" aria-hidden="true"></i> {{__('List of Candidates')}}
                                </a>
                            </li>
                            <li>
                                <a href="{{route('CreateCareer')}}">
                                    <i class="fa fa-plus" aria-hidden="true"></i>{{__('Add Career')}}
                                </a>
                            </li>
                        </ul>
                    <li>

                    <li>
                        <a href="javascript:void(0);">
                            <i class="fa fa-cogs" aria-hidden="true"></i> {{__('System Management')}} <span class="fa fa-chevron-down"></span>
                        </a>
                        <ul class="nav child_menu">
                            <li>
                                <a href="{{route('ListOfLocations')}}">
                                    <i class="fa fa-location-arrow" aria-hidden="true"></i> {{__('Locations')}}
                                </a>
                            </li>
                            <li>
                                <a href="{{route('ListOfSystemVariables')}}">
                                    <i class="fa fa-star" aria-hidden="true"></i> {{__('System Variables')}}
                                </a>
                            </li>

                            <li>
                                <a href="{{route('ListOfDeliveryModels')}}">
                                    <i class="fa fa-cog" aria-hidden="true"></i> {{__('Global Delivery Models')}}
                                </a>
                            </li>

                            <li>
                                <a href="{{route('ListOfContractTypes')}}">
                                    <i class="fa fa-bars" aria-hidden="true"></i> {{__('Contract Types')}}
                                </a>
                            </li>

                            <li>
                                <a href="{{route('ListOfCompanyProfile')}}">
                                    <i class="fa fa-bars" aria-hidden="true"></i> {{__('Company Profile')}}
                                </a>
                            </li>

                        </ul>
                    <li>

{{--                        <a href="{{route('ListOfChallenges')}}">--}}
{{--                            <i class="fa fa-envelope" aria-hidden="true"></i> {{__('Challenges Management')}}--}}
{{--                            <span id="countNew">{{$countNew=1}}</span>--}}
{{--                        </a>--}}
{{--                        --}}
{{--                    </li>--}}
{{--                    <li>--}}
{{--                        <a href="javascript:void(0);">--}}
{{--                            <i class="fa fa-object-ungroup" aria-hidden="true"></i> {{__('Slides Management')}} <span class="fa fa-chevron-down"></span>--}}
{{--                        </a>--}}
{{--                        <ul class="nav child_menu">--}}
{{--                            <li>--}}
{{--                                <a href="{{route('ListOfSlides')}}">--}}
{{--                                    <i class="fa fa-list-ul" aria-hidden="true"></i> {{__('List of slides')}}--}}
{{--                                </a>--}}
{{--                            </li>--}}
{{--                            <li>--}}
{{--                                <a href="{{route('CreateSlide')}}">--}}
{{--                                    <i class="fa fa-plus" aria-hidden="true"></i>{{__('Add slide')}}--}}
{{--                                </a>--}}
{{--                            </li>--}}
{{--                        </ul>--}}
{{--                    </li>--}}
{{--                    <li>--}}
{{--                        <a href="javascript:void(0);">--}}
{{--                            <i class="fa fa-list-ol" aria-hidden="true"></i> {{__('Process Management')}} <span class="fa fa-chevron-down"></span>--}}
{{--                        </a>--}}
{{--                        <ul class="nav child_menu">--}}
{{--                            <li>--}}
{{--                                <a href="{{route('ListOfProcess')}}">--}}
{{--                                    <i class="fa fa-list-ul" aria-hidden="true"></i> {{__('List of process')}}--}}
{{--                                </a>--}}
{{--                            </li>--}}
{{--                            <li>--}}
{{--                                <a href="{{route('CreateProcess')}}">--}}
{{--                                    <i class="fa fa-plus" aria-hidden="true"></i>{{__('Add process')}}--}}
{{--                                </a>--}}
{{--                            </li>--}}
{{--                        </ul>--}}
{{--                    </li>--}}
{{--                    <li>--}}
{{--                        <a href="javascript:void(0);">--}}
{{--                            <i class="fa fa-book" aria-hidden="true"></i> {{__('Our stories Management')}} <span class="fa fa-chevron-down"></span>--}}
{{--                        </a>--}}
{{--                        <ul class="nav child_menu">--}}
{{--                            <li>--}}
{{--                                <a href="{{route('ListOfOurStories')}}">--}}
{{--                                    <i class="fa fa-list-ul" aria-hidden="true"></i> {{__('List of stories')}}--}}
{{--                                </a>--}}
{{--                            </li>--}}
{{--                            <li>--}}
{{--                                <a href="{{route('CreateOurStories')}}">--}}
{{--                                    <i class="fa fa-plus" aria-hidden="true"></i>{{__('Add story')}}--}}
{{--                                </a>--}}
{{--                            </li>--}}
{{--                        </ul>--}}
{{--                    </li>--}}

{{--                    </li>--}}
{{--                    <li>--}}
{{--                        <a href="javascript:void(0);">--}}
{{--                            <i class="fa fa-cogs" aria-hidden="true"></i> {{__('Settings')}} <span class="fa fa-chevron-down"></span>--}}
{{--                        </a>--}}
{{--                       <ul class="nav child_menu">--}}
{{--                            <li>--}}
{{--                                <a href="{{route('EditSetting')}}">--}}
{{--                                    <i class="fa fa-cog" aria-hidden="true"></i> {{__('Base settings')}}--}}
{{--                                </a>--}}
{{--                            </li>--}}
{{--                            <li>--}}
{{--                                <a href="{{route('EditEmailSetting')}}">--}}
{{--                                    <i class="fa fa-envelope" aria-hidden="true"></i> {{__('Email settings')}}--}}
{{--                                </a>--}}
{{--                            </li>--}}
{{--                            <li>--}}
{{--                                <a href="javascript:void(0);">--}}
{{--                                    <i class="fa fa-window-close-o" aria-hidden="true"></i>{{__('System messages')}}--}}
{{--                                </a>--}}
{{--                            </li>--}}
{{--                        </ul>--}}
{{--                    </li>--}}
                </ul>
            </div>
        </div>
        <!-- /sidebar menu -->
        <!-- /menu footer buttons -->
        <div class="sidebar-footer hidden-small">
{{--            <a data-toggle="tooltip" data-placement="top" href="javascript:void(0);" title="{{__('Settings')}}">--}}
{{--                <span class="glyphicon glyphicon-cog" aria-hidden="true"></span>--}}
{{--            </a>--}}
{{--            <a data-toggle="tooltip" data-placement="top" title="Tiếng Việt" class="language-vi" lang="vi" href="javascript:void(0);">--}}
{{--                VI--}}
{{--            </a>--}}
            <a data-toggle="tooltip" data-placement="top" title="English" class="language-e" lang="en" href="javascript:void(0);">
                EN
            </a>
            <a data-toggle="tooltip" data-placement="top" title="{{__('Logout')}}" href="javascript:void(0);" id="btn-logout" link="{{route('AdminLogout')}}">
                <span class="glyphicon glyphicon-off" aria-hidden="true"></span>
            </a>
        </div>
        <!-- /menu footer buttons -->
    </div>
</div>
