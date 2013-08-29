<h2><i class="icon-tasks" style="margin-top:16px;"></i> Log Viewer</h2>

<div class="well">
	<blockquote>
		<h4><i class="icon-filter" style="margin-top:4px;"></i> Select filters for log viewer</h4>
	</blockquote>

	<div style="width:100%;padding-bottom:20px;">
		<div style="width:33%;float:left;">
			<i class="icon-user"></i> User<br/>
			<select id="user">
				<option value="0">All</option>
				<option value="0">-------------------------</option>
				{foreach from=$users item=user}
					<option value="{$user.uid}">{$user.username}</option>
				{/foreach}
			</select>
		</div>
		<div style="width:33%;float:left;">
			<i class="icon-signal"></i> Log level<br/>
			<select id="loglevel">
				<option value="1">Everything</option>
				<option value="0">-------------------------</option>
				<option value="2">rcon</option>
				<option value="3">forbidden</option>
			</select>
		</div>
		<div style="width:33%;float:left;">
			<br/>
			<a class="btn" href="#" id="filters"><i class="icon-search"></i> Search Logs</a> <i><span id="resultcount">0</span> results</i>
		</div>
	</div>
	<div class="clearfix" ></div>
</div>

<h2>
	Logs
	<div style="width:20%; float:right; font-weight:normal; font-size:16px; text-align:right; padding-right:5px;" id="pagescount">
		<i class="icon-chevron-left" style="margin-top:2px;" id="leftarrow"></i> Page <span id="pageno">1</span> of <span id="pagecount">0</span> <i class="icon-chevron-right" id="rightarrow" style="margin-top:2px;"></i>
	</div>
</h2>

<table class="table table-condensed table-striped table-hover">
	<thead>
		<tr>
			<th><i class="icon-cog"></i> ID</th>
			<th><i class="icon-user"></i> User</th>
			<th><i class="icon-road"></i> IP</th>
			<th><i class="icon-time"></i> Time</th>
			<th><i class="icon-leaf"></i> Data</th>
		</tr>
	</thead>
	<tbody id="logentry">

	</tbody>
</table>

{literal}
<center id="loading">
	<h3>Loading logs</h3>
	<img src="./img/loader.gif"/>
</center>

<script type="text/tim" class="logrow"> 
	<tr class="{{class}}">
		<td>{{logid}}</td>
		<td>{{username}}</td>
		<td><img src="./flags/{{ccode}}.png"> {{ip}}</td>
		<td>{{time}}</td>
		<td>{{data}}</td>
	</tr>
</script>

<script src="./js/tim.js"></script>

<script>
	var pages = new Array;
	$(document).ready(function() {
		updatetable(1);
	});

	$("#filters").click(function() {
		pages = [];
		updatetable(1);
	});
  
	$("#leftarrow").click(function() {
		updatetable(parseInt($("#pageno").html())-1);
	});
	$("#rightarrow").click(function() {
		updatetable(parseInt($("#pageno").html())+1);
	});  
  
	function updatetable(page){
		if(page == 0){
			page = 1;
			pages = [];
		}	
	
		disablebuttons();
		$("#loading").show();
		uid	=	$("#user").val();
		level	=	$("#loglevel").val();
		pageappend	=	"&page="+page;
		
		$("#logentry").html("");
		
		if (typeof(pages[page]) != "undefined"){
			parsetable(page);
		}
		else{	
			$.getJSON('./json/logfeed.php?uid='+uid+'&level='+level+pageappend, function(data) {	
				pages[page]	=	data;
				parsetable(page);
			});
		}
	}
	
	function parsetable(page){
		$("#loading").hide();
		data	=	pages[page];
		$("#logentry").html("");
		$("#pageno").html(page);

		$.each(data, function( key, val ) {
			if(key == "count"){
				$("#resultcount").html(val);
				$("#pagecount").html( Math.ceil( val/{/literal}{$logperpage}{literal} ) );
			}
			else{
				val.class	=	"";
				if(typeof(val.prepended) == "undefined"){
					if(val.logtype == "rcon"){
						val.data	=	"rcon command: "+val.data;
					}
					else if(val.logtype == "forbid"){
						val.data	=	"Forbidden rcon attempt: "+val.data;
						val.class	=	"error";
					}
					val.prepended = true;
				}
			
				$("#logentry").append(tim("logrow", val));
			}	
		});
		enablebuttons();
	}
	
	function disablebuttons(){
		$("#filters").attr('disabled','disabled');
		$("#pagescount").hide()
	}
	
	function enablebuttons(){
		$("#filters").removeAttr('disabled');
		if($("#pageno").html() == 1){
			$("#leftarrow").hide();
		}
		else{
			$("#leftarrow").show();
		}
		
		if($("#pageno").html() == $("#pagecount").html()){
			$("#rightarrow").hide();
		}
		else{
			$("#rightarrow").show();
		}
		
		if($("#pagecount").html() == 0){
			$("#pagescount").hide()
		}
		else{
			$("#pagescount").show()
		}
	}	
</script>
{/literal}