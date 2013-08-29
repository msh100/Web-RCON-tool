{if !empty($access)}
<div style="height:60px;">
	<div style="float:left; width:700px;">
		<h2 id="servertitle">
			<b>Javascript is required for this system to work</b>
		</h2>
	</div>

	<div style="float:right; width:160px;">
		<ul class="nav nav-pills pull-right" style="margin-top:14px; padding-right:15px;">
			<li class="dropdown">
				<a class="dropdown-toggle" id="drop5" role="button" data-toggle="dropdown" href="#"><i class="icon-hdd"></i> Select Server <b class="caret"></b></a>
				<ul id="switch" class="dropdown-menu pull-right" role="menu" aria-labelledby="drop5">
					{foreach from=$access item=serverlist}
						<li id="{$serverlist.sid}">
							<a href="#" id="servername-{$serverlist.sid}"><img src="./img/{$serverlist.type}.gif" style="margin-top:-3px; padding-right:3px;"/><span id="name-{$serverlist.sid}">{$serverlist.name|q3cols}</span></a>
						</li>	
					{/foreach}
				</ul>
			</li>
		</ul>
	</div>
</div>

<div class="alert alert-info clearfix" style="min-height:400px; padding:8px; margin-bottom:-35px;">
	<tt style="margin-top:-75px">
		<input type="hidden" id="serverid" name="serverid" value="">
		<input type="hidden" id="lastinput" name="lastinput" value="">
		<div style="height:370px; overflow-y:scroll; white-space:pre; " id="overflow">
			<b>Javascript is required for this system to work</b>
		</div>
	</tt>
</div>

<script>
(function($){
    $.fn.setCursorToTextEnd = function() {
        $initialVal = this.val();
        this.val('');
        this.val($initialVal);
    };
})(jQuery);
$("#overflow").html("");
function scrolloverflow(){
	var objDiv = document.getElementById("overflow");
	objDiv.scrollTop = objDiv.scrollHeight;
}
scrolloverflow();

function changeserver(sid){
	$("#servertitle").html( $("#servername-"+sid).html() );
	$("#overflow").append( $("#name-"+sid).html() + " ready for input<br/>");
	scrolloverflow();
	$("#serverid").val(sid);
	$("#command").focus();
}
changeserver(1);

$("#switch li").click(function() {
	changeserver($(this).attr('id'));
});

$(function(){
	$('#command').keydown(function(e){
		if(e.keyCode == 13){
			callajax();
			e.preventDefault();
		}
		else if(e.keyCode == 38){
			$('#command').val( $('#lastinput').val() );
			e.preventDefault();
		}
	});
});

function callajax(){
	var	cmd = $('#command').val();
	var sid	= $("#serverid").val();
	
	$('#lastinput').val( $('#command').val() );
	$('#command').val("");
	$("#command").prop('disabled', true);

	$("#overflow").append("> "+cmd+"<br/>");
	$("#overflow").append("<span id='loadingshit'><img src='./img/loader.gif'/></span>");
	scrolloverflow();

	$.getJSON('./json/sendrcon.php?sid='+sid+'&cmd='+cmd,
	
	function(data) {	
		if(data.success){
			$("#overflow").append(data.rcon);
			scrolloverflow();
		}
		else{
		// forbidden empty nologin invalidsid
			if(data.error == "forbidden"){
				$("#overflow").append("You can not run the command '"+data.forbid+"'<br/>");
			}
			else if(data.error == "empty"){
				$("#overflow").append("String is empty, not sending command<br/>");
			}
			else if(data.error == "nologin"){
				$("#overflow").append("You are not logged in, your session may have expired<br/>");
			}
			else if(data.error == "invalidsid"){
				$("#overflow").append("Invalid server<br/>");
			}
			scrolloverflow();		
		}
		
		$("#command").prop('disabled', false);
		$("#loadingshit").remove();
		
	});
	
}
</script>

<input type="text" placeholder="Enter rcon command and hit return to send" style="width:100%;height:35px;" id="command" data-provide="typeahead" data-items="4" data-source='["{$typeahead|implode:"\",\""}"]'>
{else}
<h2>No Access!</h2>
You have access to no servers on this rcon tool.
{/if}