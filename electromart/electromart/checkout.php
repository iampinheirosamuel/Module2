<?php 
 // This page displays the contents of the shopping cart.

 // Set the page title and include the HTML header:
 $page_title = 'Check Out';
 session_start();
 include ('includes/header.php');
?>
<div class="container">
<div id="product_spec">
<h1>Check Out</h1>


<div class="panel-group" id="accordion">
    <div class="panel panel-default">
    <div class="panel-heading">
      <h4 class="panel-title"><a href="#step1" data-parent="#accordion" data-toggle="collapse">Step 1: Delivery Method</a></h4>
    </div>
    <div id="step1" class="panel-collapse collapse in">
      <div class="panel-body">
        
        Hey there we're having some php ish here... wanna help out?
      </div>
    </div>
  </div>
    
  <div class="panel panel-default">
    <div class="panel-heading">
      <h4 class="panel-title"><a href="#step2" data-parent="#accordion" data-toggle="collapse">Step 2: Payment Method</a></h4>
    </div>
    <div id="step2" class="panel-collapse collapse">
      <div class="panel-body">
      
      <h3>Write your review for this product</h3>
        <form method="post" action="#step3">
          <div class="input-group">
            <label>Your Name</label>
            <input type="text" name="name" class="form-control"  aria-describedby="entryHelp" placeholder="Enter your name" required>
                    
          </div><br>
          <br>
          <button href="#step3" data-parent="#accordion" data-toggle="collapse" type="submit" name="submit" class="btn btn-primary" >Continue</button>
        </form>
      </div>
    </div>
  </div>

  <div class="panel panel-default">
    <div class="panel-heading">
      <h4 class="panel-title">Step 3: Confirm Order</h4>
    </div>
    <div id="step3" class="panel-collapse collapse">
      <div class="panel-body">
      
      <h3>Write your review for this product</h3>
        <form method="post" action="#Reviews">
          <div class="input-group">
            <label>Your Name</label>
            <input type="text" name="name" class="form-control"  aria-describedby="entryHelp" placeholder="Enter your name" required>
                    
          </div><br>
          <br>
          <input type="submit" name="submit" class="btn btn-primary" value="Submit">
        </form>
      </div>
    </div>
  </div>
 </div>

</div>
</div>
<?php
 include ('includes/footer.html');
 ?>