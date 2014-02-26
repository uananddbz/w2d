t=new Date();
d=t.getDate();
m=t.getMonth()+1;
y=t.getFullYear();
if (d<10)
{
d='0'+d;
}
if (m<10)
{
m='0'+m;
}

//<--Defaults

$(document).ajaxSend(function(){
$("#loading").fadeIn('fast');
});

$(document).ajaxStop(function(){
$("#loading").fadeOut('fast');
});

$(document).ajaxError(function(){
  alert("An error occurred!");
});

//--Defaults--/>

//<-----ALL--FUNCTIONS-----

//update year
function update_year(el,table,id) {
var value=prompt("Enter year - yyyy","");
if (value!=null && value!="" && Number(value))
  {
if (value.length==4)
{
 ajax_update(table,function() {el.replaceWith(value).effect('highlight');},'id='+id,'yy='+value);
}
  }
}

//ajax select
function ajax_select(table,f,where)
{
where=typeof where !== 'undefined' ? where : null;
$.ajax({url:"ajax.php",
	   data:{'task':'select','table':table,'where':where},
	   type:'POST',
	   dataType:'JSON',
	   success:f
  });
}

//ajax update
function ajax_update(table,f,where,data)
{
where=typeof where !== 'undefined' ? where : null;
$.ajax({url:"ajax.php",
	   data:{'task':'update','table':table,'where':where,'data':data},
	   type:'POST',
	   success:f
  });
}

//ajax insert
function ajax_insert(table,f,data)
{
$.ajax({url:"ajax.php",
	   data:data,
	   type:'POST',
	   success:f
  });
}

//ajax delete
function ajax_del(table,f,where)
{
if (typeof where !== 'undefined') {
$.ajax({url:"ajax.php",
	   data:{'task':'delete','table':table,'where':where},
	   type:'POST',
	   success:f
  });
}
}

//Done button function
function done(el,table,id)
{	
el.hide();
ajax_update(table,function(result){
el.parents('li').addClass('success');
},'id='+id,'done=1');
}

//Delete button function
function del(el,table,id) {
ajax_del(table,function() {el.parents('li').remove();},'id='+id);
}


//load birthday rows
function load_birthday() {
	
ajax_select('birthday',function(result){
    for (i in result)
	{
//check if row is done
if (result[i].done === '1') {
	success='success';
	btn='';
	}
	else {
	success='';
	btn='<button class="btn btn-success btn-mini pull-right" onclick="done($(this),\'birthday\','+result[i].id+')"><i class="icon-ok icon-white"></i></button>';
	}
	
//check if year is set
if (result[i].yy === '0000') {
year=' <a onClick="update_year($(this),\'birthday\','+result[i].id+');" href="#">+year</a>';
	}
	else {
year=y-result[i].yy;
	}

	$('#row_list').append('<li class="br '+success+'">'+btn+'<span class="label label-success">Birthday</span> <strong>'+result[i].name+'</strong><span class="muted"> '+year+'</span></li>');
	}
	},'dd='+d+' AND mm='+m);
}


//load anniversary rows
function load_anniversary() {
ajax_select('anniversary',function(result){
    for (i in result)
	{
//check if row is done
if (result[i].done === '1') {
	success='success';
	btn='';
	}
	else {
	success='';
	btn='<button class="btn btn-success btn-mini pull-right" onclick="done($(this),\'anniversary\','+result[i].id+')"><i class="icon-ok icon-white"></i></button>';
	}
	
//check if year is set
if (result[i].yy === '0000') {
year=' <a onClick="update_year($(this),\'anniversary\','+result[i].id+');" href="#">+year</a>';
	}
	else {
year=y-result[i].yy;
	}
	
$('#row_list').append('<li class="an '+success+'">'+btn+'<span class="label label-important">Anniversary</span> <strong>'+result[i].fname+'</strong><span class="muted"> '+year+'</span></li>');
	}
	},'dd='+d+' AND mm='+m);
}

//load rows
function load_rows() {
$("#row_list").html('');
load_birthday();
load_anniversary();
}

//load edit rows
function edit_rows() {
$('#edit_row_list').html('');

ajax_select('birthday',function(result){
    for (i in result)
	{	
	
$('#edit_row_list').append('<li><button class="btn btn-danger btn-mini pull-right" onclick="del($(this),\'birthday\','+result[i].id+')"><i class="icon-remove icon-white"></i></button><span class="label label-success">Birthday</span> <strong>'+result[i].name+'</strong> <a onClick="update_year($(this),\'birthday\','+result[i].id+');" href="#">'+result[i].yy+'</a></li>');
	}
	});

ajax_select('anniversary',function(result){
    for (i in result)
	{	
	
$('#edit_row_list').append('<li><button class="btn btn-danger btn-mini pull-right" onclick="del($(this),\'anniversary\','+result[i].id+')"><i class="icon-remove icon-white"></i></button><span class="label label-important">Anniversary</span> <strong>'+result[i].fname+'</strong> <a onClick="update_year($(this),\'anniversary\','+result[i].id+');" href="#">'+result[i].yy+'</a></li>');
	}
	});

}

//find edit row
function edit_find(v) {
el=$('#edit_row_list');
if (v!='') {
el.find("li:not(:Contains(" + v + "))").slideUp("fast");
el.find("li:Contains(" + v + ")").slideDown("fast");
} 
else {
el.find("li").slideDown("fast");
}
}

//reset select button group
function reset_select() {
$('#select_form').button('reset');
}

//hide and reset add form 
function hide_form() {
$('#b_form').hide();
$('#a_form').hide();
$('#d_form').hide();
$('#save_form').hide().button('reset');
document.getElementById("add_form").reset();
form_table='';
$("#alert").slideUp('fast').html('');
}


//show form
function show_form(el,table) {
hide_form();
document.getElementById("table").value=table;
el.show();
$('#d_form').show();
$('#save_form').show();
}


//submit form
function save_form(el) {
data=$("#add_form").serializeArray();

if (data[5].value=='d' || data[6].value=='m')
{
$("#alert").html('<b>check date of birth</b>').slideDown('fast');
return false;
}
else if (data[1].value=='birthday' && data[2].value=='')
{
$("#alert").html('<b>check name</b>').slideDown('fast');
return false;
}
else if (data[1].value=='anniversary')
{
	if (data[3].value=='' || data[4].value=='') {
$("#alert").html('<b>check name</b>').slideDown('fast');
return false;
	}
}


el.button('loading');
ajax_insert(form_table,function(result) {
hide_form();
reset_select();
$('#save_form').button('reset');
},data);
}

//today button function
function set_today() {
document.getElementById("d").value=d;
document.getElementById("m").value=m;
}

//<-----ALL--FUNCTIONS-----/>



$(document).ready(function() {

//-----BUTTON--FUNCTIONS-----


//-----EVENT--FUNCTIONS-----

//add form modal show event
$('#form_modal').on('show', function () {
hide_form();
reset_select();
});

//add form modal hide event
$('#form_modal').on('hidden', function () {
load_rows();
});

//edit form show event
$('#edit_modal').on('show', function () {
edit_rows();
})

//edit form hide event
$('#edit_modal').on('hidden', function () {
load_rows();
})


//-----AUTORUN--FUNCTIONS-----

load_rows();

});