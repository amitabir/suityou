<?php
include('header.php');
if(isset($_SESSION['sign_up_message']))
{
    $message=$_SESSION['sign_up_message'];
    if(!empty($message))
    {
        echo '<div class="alert alert-danger alert-dismissible" role="alert">';
        echo '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>';
        echo $message;
        echo '</div>';
        unset($_SESSION['sign_up_message']);
    }
}
if(isset($_SESSION['checkoutMessage']) && $_SESSION['checkoutMessage']=="1")
{
    echo '<div class="alert alert-warning alert-dismissible" role="alert">';
    echo '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>';
    echo "You must sign up before checkout";
    echo '</div>';
}
?>
<script type="text/javascript" src="sign_up_validate.js"></script>
<div class="container">
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <form class="form-horizontal" id="sign_up_form" action="sign_up.php" method="post" role="form">
            <h3>Please fill the following form to sign up:</h3>
                <div class="form-group">
                    <label class="control-label" for="email">Email:</label>            
                    <input class="form-control" type="email" name="email" value="<?php if(isset($_SESSION['email'])){echo htmlentities($_SESSION['email'], ENT_QUOTES, 'UTF-8');} ?>" />
                </div>
                <div class="form-group">
                    <label class="control-label" for="first_name">First name:</label>
                    <input class="form-control" type="text" name="first_name" id="first_name" />
                </div>
                <div class="form-group">
                    <label class="control-label"  for="last_name">Last name:</label>
                    <input class="form-control" type="text" name="last_name" id="last_name" />
                </div>
                <div class="form-group">
                    <label class="control-label" for="address">Address:</label>
                    <input class="form-control" type="text" name="address" id='address' /><br />   
                </div>           
                <div class="form-group">
                    <label class="control-label" for="gender">Gender:</label>
                    <select class="form-control" name="gender">
                        <option selected="selected" value="FEMALE">FEMALE</option>
                        <option value="MALE">MALE</option>
                    </select>
                </div> 
                <div class="form-group">
                    <label class="control-label" for="birth_date">Birth Date:</label>
                    <input class="form-control" type="date" name="birth_date" id="birth_date"  /><br />
                </div>
                <div class="form-group">
                    <label class="control-label">Designer: </label>
                    <label class="radio-inline"><input type="radio" name="is_designer" value="1">Yes</label>
                    <label class="radio-inline"><input type="radio" name="is_designer" value="0" checked="checked">No</label>
                </div>
                <div class="form-actions">    
                    <button class="btn btn-default btn-block" type="submit">Sign up</button>
                </div>
            </form>
        </div>
    </div>
</div>