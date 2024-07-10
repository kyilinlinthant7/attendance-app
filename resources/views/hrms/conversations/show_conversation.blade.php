@extends('hrms.layouts.base')

@section('custom_css')
<style type="text/css">
.messages {
    height: 385px;
    overflow-y: scroll;
}

.chat {
    border: 1px solid #e7e7e7;
    padding: 4px;
    display: block;
    vertical-align: bottom;
    height: 395px;
    width: 100%;
    background-color: #fff;
}

.conversation-panel {
    padding: 5px;
    /*background: #f9f9f9;*/
    height: 465px;
}
.converation-panel-name, .converation-panel-message, .converation-panel-member {
    border-right: 2px solid #fff;
    /*background: #f1f1f1;*/
    border: 1px solid #ebebeb;
    /* border-radius: 5px;*/
    height: 452px;
    padding: 5px;
}
.list-group-item {
    border: none;
    margin-bottom: 5px !important;
    color: #333;
}
.converation-panel-name, .converation-panel-member {
	overflow-y: scroll;
}
.list-active {
    background: #f1f1f1;
    border-radius: 5px;
}
.list-group-item:first-child{
	border-top-right-radius: 5px;
	border-top-left-radius: 5px;
}
.list-group a:hover .list-group-item{
	background:#f1f1f1;
}
.list-group a:hover{
	text-decoration: none;
}


/* width */
.converation-panel-name::-webkit-scrollbar {
  width: 5px;
}

/* Track */
.converation-panel-name::-webkit-scrollbar-track {
  background: #f1f1f1;
}

/* Handle */
.converation-panel-name::-webkit-scrollbar-thumb {
  background: #888;
  border-radius: 10px;
}

/* Handle on hover */
.converation-panel-name::-webkit-scrollbar-thumb:hover {
  background: #555;
}


/* Member */
/* width */
.converation-panel-member::-webkit-scrollbar {
  width: 5px;
}

/* Track */
.converation-panel-member::-webkit-scrollbar-track {
  background: #f1f1f1;
}

/* Handle */
.converation-panel-member::-webkit-scrollbar-thumb {
  background: #888;
  border-radius: 10px;
}

/* Handle on hover */
.converation-panel-member::-webkit-scrollbar-thumb:hover {
  background: #555;
}


/* Message */
/* width */
.messages::-webkit-scrollbar {
  width: 5px;
}

/* Track */
.messages::-webkit-scrollbar-track {
  background: #f1f1f1;
}

/* Handle */
.messages::-webkit-scrollbar-thumb {
  background: #888;
  border-radius: 10px;
}

/* Handle on hover */
.messages::-webkit-scrollbar-thumb:hover {
  background: #555;
}
.member-name {
    padding: 5px 10px;
    background: #f1f1f1;
    margin-bottom: 5px;
}
#btn_send {
    position: absolute;
    right: 4px;
    margin-top: -36px;
}
.calna {
  color:#48d425;
}
.message_user {
    padding: 10px;
}
.message_user span {
    background: #ebebeb;
    padding: 7px 15px;
    display: block;
    border-radius: 20px;
}
</style>
@endsection

@section('content')
<div class="content">

    <header id="topbar" class="alt">
        <div class="topbar-left">
            <ol class="breadcrumb">
                <li class="breadcrumb-icon">
                    <a href="/dashboard">
                        <span class="fa fa-home"></span>
                    </a>
                </li>
                <li class="breadcrumb-active">
                    <a href="/dashboard"> Dashboard </a>
                </li>
                <li class="breadcrumb-link">
                    <a href=""> Conversations </a>
                </li>
                <li class="breadcrumb-current-item"> Conversation Listings </li>
            </ol>
        </div>
    </header>


    <!-- -------------- Content -------------- -->
    <section id="content" class="table-layout animated fadeIn">

        <!-- -------------- Column Center -------------- -->
        <div class="chute chute-center">

            <!-- -------------- Products Status Table -------------- -->
            <div class="row">
                <div class="col-xs-12">
                    <div class="box box-success">
	                    <div class="panel">
	                        <div class="panel-heading">
	                            <span class="panel-title hidden-xs"> Conversation Lists </span>
	                        </div>
	                        <div class="panel-body pn">
	                        	<div class="row conversation-panel">
	                        		<div class="col-xs-3 converation-panel-name">
	                        			<ul class="list-group">
	                        				@foreach($groups as $group)
	                        				<a onclick="changeGroup('{{ $group->team_id }}')">
	                        					<li class="list-group-item" id="list-{{ $group->team_id }}">
	                        						{{ $group->name }}
	                        					</li>
	                        				</a>
                                  @endforeach
	                        			</ul>
	                        		</div>

                                <input type="hidden" id="group_hi_id">
	                        		<div class="col-xs-6 converation-panel-message" id="message_panel">



	                        			<!-- <div class="chat">
                                  <div class="messages"></div>
                                </div>
                                <div class="group-control">
                                  <input type="text" disabled placeholder="Please wait..." id="user_message" class="form-control">
                                  <button onclick="sendMessage()" disabled class="btn btn-primary pull-right btn-send" id="btn_send">Initializing</button>
                                </div> -->
	                        		</div>

	                        		<div class="col-xs-3 converation-panel-member" id="member-list">
	                        			<!-- <div class="member-list users">

	                        			</div> -->
	                        		</div>
	                        	</div>
	                        </div>
	                    </div>
                   	</div>
                </div>
            </div>

        </div>
    </section>

</div>

@endsection

@section('custom_js')

<script src="//js.pusher.com/3.0/pusher.min.js"></script>

<script type="text/javascript">
// get_online_user();



var team_id = '';

var user_name = '';


// Declare Pusher Object
var pusher = new Pusher('c9ab3a1c6d7927be2313', {
    cluster: 'ap1',
    authEndpoint: '{{url("conversationauth")}}',
    auth: {
        headers: {
            'X-CSRF-TOKEN': '{{csrf_token()}}'
        }
    }
});

Pusher.log = function(msg){
    console.log(msg);
}


// Define channel
var channel = pusher.subscribe('presence-chat');

channel.bind('pusher:subscription_succeeded', function() {
var me = channel.members.me;
   user_name = me.info.name;

});


channel.bind('pusher:member_added', function(member) {
    $('#user_ico-'+member.id).addClass('calna');
});

channel.bind('pusher:member_removed', function(member) {
  $('#user_ico-'+member.id).removeClass('calna');
});


var chanl = channel.members;
// console.log(chanl);

function changeGroup(group_id = null)
{
  $('#group_hi_id').val('');
  $('#group_hi_id').val(group_id);
  $('.list-group-item').removeClass('list-active');
  $('#list-'+group_id).addClass('list-active');
  $('#message_panel').empty();
  $('#message_panel').append('<div class="chat"><div class="messages"></div></div><div class="group-control"><input type="text" placeholder="Enter Your Message ..." id="user_message" class="form-control user_message"><button onclick="sendMessage()" class="btn btn-primary pull-right btn-send" id="btn_send"><i class="fa fa-send"></i></button></div>');
  $('#member-list').empty();
  $('#member-list').append(' <div class="member-list users"></div>');

  // For Member list
  $.ajax({
    type:     "POST",
    url:      "{{ url('getmember') }}",
    data:     {'team_id': group_id, _token: '{{ csrf_token() }}'},
    success: function(data){
        var u_id = [];
        $.each(chanl.members, function(index2, item2){
            u_id.push(item2.user_id);
        });
        $.each(data, function(index, item){
          var n = u_id.includes(item.id);
          var calName = '';
          if(n === true)
          {
            calName = "calna";
          }

            $('.users').append('<div id="user-'+item.id+'" class="member-name"><i class="fa fa-user '+calName+'" id="user_ico-'+item.id+'"></i> '+item.name+'</div>');
        });
      console.log(data);
    },
    error: function(){
      console.log('get member fail');
    }

  });

  // For Message Reload
  $.ajax({
    type:       "POST",
    url:        "{{ url('getmessage') }}",
    data:       {'team_id': group_id , _token: '{{ csrf_token() }}'},
    success: function(data){
          $.each(data, function(index, item){
            $('.messages').append('<div class="message_user"><strong>'+ item.name + ': </strong><span>'+ item.message +'</span></div>');
          $(".messages").animate({ scrollTop: $('.messages')[0].scrollHeight}, 1000);
            });
    },
    error: function(){
          console.log('false');
    }
  });

  team_id = group_id;

var input = document.getElementById('user_message');
if(input){
input.addEventListener("keyup", function(event) {
  event.preventDefault();
  if(event.keyCode === 13){
    $('#btn_send').click();
  }
});
}


}

channel.bind('client-new-message', function(data) {
  if(data.group == team_id){
    $('.messages').append(data.message);
    $(".messages").animate({ scrollTop: $('.messages')[0].scrollHeight}, 1000);
  }else{

  }
})

function sendMessage() {
    var gp_id = $('#group_hi_id').val();
    var userMessage = $('#user_message').val();

    if(userMessage != ''){
      $.ajax({
          type:       "POST",
          url:        "{{ url('setmessage') }}",
          data:       {'message': userMessage, 'user_id': '{{ auth()->user()->id }}' ,'team_id': gp_id , _token: '{{ csrf_token() }}'},
          success: function(data){
              console.log(data);
          },
          error: function(){
              console.log('false');
          }
      });
    }


   var userMessage = '<div class="message_user"><strong>'+user_name+': </strong><span>'+userMessage+'</span></div>'
   channel.trigger('client-new-message', { message : userMessage , group : gp_id });
   $('#user_message').val('').focus();
   $('.messages').append(userMessage);
   $(".messages").animate({ scrollTop: $('.messages')[0].scrollHeight}, 1000);
}



// $('#user_message').keypress(function(e){
//    if(e.which == 13){
//      $('#btn_send').click();
//    }
// });




</script>
@endsection