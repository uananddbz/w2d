<!DOCTYPE html>
<html lang="en">
<head><title>whats2day</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="css/bootstrap-responsive.min.css">
<style>
.row_list {
list-style:none;
margin:0;
padding:0;
}

.row_list li {
color: rgb(51, 51, 51);
padding:.8em;
border-bottom: 1px solid rgb(221, 221, 221);
}

.row_list li:hover {
background-color: rgb(245, 245, 245);
}

.row_list li.success {
background-color: rgb(223, 240, 216);
}

#loading {
position:fixed;
top:0;
left:0;
z-index:2000;
}
</style>
</head>
<body>

<!--LOGO-->

<div class="hero-unit" style="padding:2em;margin-bottom:20px;background:transparent;">
<h2>What's Today <small><span id="loading" class="label label-warning">please wait ...</span></small></h2>
</div>


<!--CONTAINER-->

<div class="container-fluid">

<div class="btn-group">
<button class="btn" title="ADD" data-toggle="modal" data-target="#form_modal"><i class="icon-plus"></i></button>
<button class="btn btn-inverse" title="EDIT" data-toggle="modal" data-target="#edit_modal"><i class="icon-pencil icon-white" ></i></button>
</div>

<p>
<ul id="row_list" class="row_list">
</ul>
</p>


	
</div>

<!--Add modal-->

<div class="modal hide" id="form_modal" >
  
    <div class="modal-header">
    <div class="btn-group" id="select_form" data-toggle="buttons-radio">
    <button type="button" onClick="show_form($('#b_form'),'birthday');" class="btn">Birthday</button>
    <button type="button" onClick="show_form($('#a_form'),'anniversary');" class="btn">Anniversary</button>
    </div>

    </div>
	
    <div class="modal-body">

          <div id="alert" class="alert"></div>

      <form method="post" id="add_form" class="form-horizontal">
	  
        <input type="hidden" id="task" name="task" value="submit" />
		<input type="hidden" id="table" name="table" value="" />
		
        <div id="b_form" class="control-group">
          <label class="control-label" for="name">Name</label>
          <div class="controls">
            <input placeholder="Name" class="input-block-level" type="text" id="name" name="name" />
          </div>
        </div>
        <div id="a_form">
          <div class="control-group">
            <label class="control-label" for="mname">Husband</label>
            <div class="controls">
              <input placeholder="Husband" class="input-block-level" type="text" id="mname" name="mname" />
            </div>
          </div>
          <div class="control-group">
            <label class="control-label" for="fname">Wife</label>
            <div class="controls">
              <input placeholder="Wife" class="input-block-level" type="text" id="fname" name="fname" />
            </div>
          </div>
        </div>
		
        <div class="control-group" id="d_form">
          <label class="control-label">DOB</label>
          <div class="controls">
            <select id="d" class="input-mini"  name="dd">
              <option selected="selected">d</option>
              <?php
for ($i=1; $i<=9; $i++)
  {
  echo"<option>0$i</option>";
  }
  for ($i=10; $i<=31; $i++)
  {
  echo"<option>$i</option>";
  }
?>
            </select>
            <select class="input-mini" id="m" name="mm">
              <option selected="selected">m</option>
              <?php
for ($i=1; $i<=9; $i++)
  {
  echo"<option>0$i</option>";
  }
  for ($i=10; $i<=12; $i++)
  {
  echo"<option>$i</option>";
  }
?>
            </select>
            <select class="input-mini" name="yy">
              <option selected="selected">y</option>
              <?php
for ($i=1940; $i<=2014; $i++)
  {
  echo"<option>$i</option>";
  }
?>
            </select>

<button type="button" onClick="set_today();" class="btn-link btn"><i class="icon-arrow-left"></i> Today</button>
</div>
        </div>
      </form>
    </div>
	
    <div class="modal-footer">
      <div class="btn-group">
        <button class="btn btn-primary" type="button" onClick="save_form($(this));" data-loading-text="SAVING..." id="save_form">SAVE</button>
        <button id="close" class="btn" data-dismiss="modal"><i class="icon-ok"></i>DONE</button>
      </div>
	  
    </div>

</div>

<!--edit modal-->
<div id="edit_modal" class="modal hide" role="dialog">
<div class="modal-header">
<div class="input-append">
<input type="text" onKeyUp="edit_find(this.value);" class="input-medium" placeholder="search" />
<span class="add-on"><i class="icon-search"></i></span>
</div>

</div>
<div class="modal-body">
<ul id="edit_row_list" class="row_list"></ul>
</div>

    <div class="modal-footer">
      <div class="btn-group">
        <button id="close" class="btn" data-dismiss="modal"><i class="icon-ok"></i> <b>DONE</b></button>
      </div>
    </div>

</div>


<script type="text/javascript" src="js/jquery.min.js"></script>
<script type="text/javascript" src="js/bootstrap.min.js"></script>
<script type="text/javascript" src="js/main.js"></script>
</body>
</html>
