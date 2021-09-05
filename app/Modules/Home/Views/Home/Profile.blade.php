<section id="cv" class="cv">
   <div class="container">
   <div class="transtlate">
            <a href="{{route('home.lang', ['lang' => 'vi'])}}"><img src="./images/common/vi-color.png" alt="VI" /></a>
            <a href="{{route('home.lang', ['lang' => 'en'])}}"><img src="./images/common/en-color.png" alt="EN" /></a>
        </div>
      <div class="cv-group profile">
         @foreach($Profile as $key => $profile)
         <div class="cv-profile-header cv-profile-img">
            <img src="{{$profile->image}}" />
         </div>
         <div class="cv-profile-header cv-profile-info">
            <h2>{{$profile->name}}</h2>
            <h3>{{$profile->position}}</h3>
            <div class="info-group">
               <p>{{__('profile.birthday')}}:</p>
               <p class="birthday">
               {!! date('d/m/Y', strtotime($profile->birthday)) !!}
               </p>
            </div>
            <div class="info-group">
               <p>{{__('profile.sex')}}:</p>
               <p class="sex">{{$profile->sex}}</p>
            </div>
            <div class="info-group">
               <p>{{__('profile.phone')}}:</p>
               <p class="phone"><a href="tel:{{$profile->phone}}">{{$profile->phone}}</a></p>
            </div>
            <div class="info-group">
               <p>{{__('profile.email')}}:</p>
               <p class="email"><a href="mailto:{{$profile->email}}">{{$profile->email}}</a> </p>
            </div>
            <div class="info-group">
               <p>{{__('profile.address')}}:</p>
               <p class="address">{{$profile->address}}</p>
            </div>
            <div class="info-group">
               <p>{{__('profile.website')}}:</p>
               <p class="facebook"><a href="{{$profile->website}}" target="_blank" rel="noopener noreferrer">{{$profile->website}}</a></p>
            </div>
         </div>
         @endforeach
      </div>
      <div class="cv-group objective">
         <h3>{{__('objective.title')}}</h3>
         <hr>
         @foreach($Objective as $key => $objective)
        {!!$objective->text!!}
         @endforeach
      </div>
      <div class="cv-group education">
         <h3> {{__('education.title')}} </h3>
         <hr>
         @foreach($Education as $key => $education)
         <div class="education-group">
         <div class="article education-time">
            <p class="start-at"> {!! date('d/m/Y', strtotime($education->start_at)) !!}</p> -
            <p class="finish-at">{!! date('d/m/Y', strtotime($education->finish_at)) !!}</p>
         </div>
         <div class="article education-content">
            <h6>{!!$education->title!!}</h6>
            {!!$education->text!!}
         </div>
         </div>
         @endforeach
      </div>
      <div class="cv-group work-ex">
         <h3>{{__('work.title')}}</h3>
         <hr>
         @foreach($Work as $key => $work)
         <div class="work-ex-group">
            <div class="article work-ex-time">
               <p class="start-at">{!! date('d/m/Y', strtotime($work->start_at)) !!}</p> -
               <p class="finish-at">{!! date('d/m/Y', strtotime($work->finish_at)) !!}</p>
            </div>
            <div class="article work-ex-content">
               <h6>{!!$work->title!!}</h6>
               {!!$work->position!!}
               {!!$work->text!!}
            </div>
         </div>
         @endforeach
      </div>
      <div class="cv-group skill">
         <h3> {{__('skill.title')}} </h3>
         <hr>
         @foreach($Skill as $key => $skill)
         {!!$skill->text!!}
         @endforeach
      </div>
      <div class="cv-group certificate">
         <h3> {{__('certification.title')}} </h3>
         <hr>
         @foreach($Certification as $key => $certification)
         <div class="cer-group">
            <div class="article cer-time">
               <p class="start-at">{!! date('d/m/Y', strtotime($certification->start_at)) !!}</p>
            </div>
            <div class="article cer-content">
            {!!$certification->text!!}
            </div>
         </div>
        @endforeach

      </div>
      <div class="cv-group awards">
         <h3> {{__('awards.title')}} </h3>
         <hr>
         @foreach($Awards as $key => $awards)
         <div class="awards-group">
            <div class="article awards-time">
               <p class="start-at">{!! date('d/m/Y', strtotime($awards->start_at)) !!}</p>
            </div>
            <div class="article awards-content">
            {!!$awards->text!!}
            </div>
         </div>
        @endforeach
      </div>
      <canvas id="canvas">
      </canvas>
      <!-- Messenger Plugin chat Code -->
   </div>
   <!-- Messenger Plugin chat Code -->
   <div id="fb-root"></div>

<!-- Your Plugin chat code -->
<div id="fb-customer-chat" class="fb-customerchat">
</div>

<script>
  var chatbox = document.getElementById('fb-customer-chat');
  chatbox.setAttribute("page_id", "100645599031179");
  chatbox.setAttribute("attribution", "biz_inbox");

  window.fbAsyncInit = function() {
    FB.init({
      xfbml            : true,
      version          : 'v11.0'
    });
  };

  (function(d, s, id) {
    var js, fjs = d.getElementsByTagName(s)[0];
    if (d.getElementById(id)) return;
    js = d.createElement(s); js.id = id;
    js.src = 'https://connect.facebook.net/vi_VN/sdk/xfbml.customerchat.js';
    fjs.parentNode.insertBefore(js, fjs);
  }(document, 'script', 'facebook-jssdk'));
</script>
</section>
