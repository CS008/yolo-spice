<?
include ("site-structure/header.php"); 
  
 ?>

<article id="cool">
 
    
         
 <form action="<? print $phpSelf; ?>" 
       method="post"
       id="frmOrder">
 
     
<?php  $debug = false;

if(isset($_GET["debug"])){ // this just helps me out if you have it
    $debug = true;
}

if ($debug) print "<p>DEBUG MODE IS ON</p>";

//
//  CHANGES NEEDED: create variable for each form element
//                  to set your default values. in the example i set them to me

$firstName="";
$lastName="";
$email="";
$pizza = true;
$pasta = false;
$special = false;
$dessert = false;
$other = false;
$gender = "Male";
$food="Cook";

// this would be the full url of your form
// See top.php for variable declartions
$yourURL =  $domain . $phpSelf;



//initialize flags for errors, one for each item
$firstNameERROR = false;
$lastNameERROR = false;
$emailERROR = false;

if (isset($_POST["btnSubmit"])){

    //******************************************************************
    // is the refeering web page the one we want or is someone trying 
    // to hack in. this is not 100% reliable but ok for our purposes   */
    //
    // Security check block one, no changes needed
    if(!securityCheck()){
        $msg= "<p>Sorry you cannot access this page. ";
        $msg.= "Security breach detected and reported</p>";
        die($msg);
    }


   include ("lib/validationFunctions.php"); // you need to create this file (see link in lecture notes)
    $errorMsg=array();

//************************************************************
$dataRecord=array();  
     
    $firstName = htmlentities($_POST["txtFirstName"],ENT_QUOTES,"UTF-8");
    $lastName = htmlentities($_POST["txtLastName"],ENT_QUOTES,"UTF-8");
    $email = htmlentities($_POST["txtEmail"],ENT_QUOTES,"UTF-8");
    
        if(isset($_POST["chkPizza"])) {
        $pizza  = true;
    }else{
        $pizza  = false;
    }
    
    if(isset($_POST["chkPasta"])) {
        $pasta  = true;
    }else{
        $pasta  = false;
    }
       
    if(isset($_POST["chkSpecial"])) {
        $special  = true;
    }else{
        $special = false;
    }
   
     if(isset($_POST["chkDessert"])) {
        $dessert  = true;
    }else{
        $dessert = false;
    } 
    
    if(isset($_POST["chkOther"])) {
        $other  = true;
    }else{
        $other = false;
    }
    
    $gender = htmlentities($_POST["radGender"],ENT_QUOTES,"UTF-8");
    
    $food = htmlentities($_POST["lstSize"],ENT_QUOTES,"UTF-8");
     
  //NOTE: i removed required attribute and set this input type=text instead 
  // of type=email so i can check my php code.
    
    
    if($email==""){
     $errorMsg[]="Please enter your email address";
     $emailERROR = true;
}elseif(!verifyEmail($email)){ 
     $errorMsg[]="Your email address appears to be incorrect.";
     $emailERROR = true;
}
    

    $dataRecord[]=$email;




// our form data is valid at this point so we can process the data
if(!$errorMsg){	
    if ($debug) print "<p>Form is valid</p>";

    //####################################################################
    // Begin processing data
 $fileExt=".csv";
 
         $myFileName="formData";
 
         $filename = $myFileName . $fileExt;
 
         if ($debug) print "\n\n<p>filename is " . $filename;
 
         // now we just open the file for append
         $file = fopen($filename, 'a');    
 
         // write the forms informations
         fputcsv($file, $dataRecord);
 
         // close the file
        fclose($file);


    //************************************************************
    //
    //  In this block I am just putting all the forms information
    //  into a variable so I can print it out on the screen
    //
    //  the substr function removes the 3 letter prefix
    //  preg_split('/(?=[A-Z])/',$str) add a space for the camel case
    //  see: http://stackoverflow.com/questions/4519739/split-camelcase-word-into-words-with-php-preg-match-regular-expression
    //
    //  CHANGES: first message line. foreach no changes needed

    $message  = '<h2>Hey there.</h2>';

    foreach ($_POST as $key => $value){

        $message .= "<p>"; 

        $camelCase = preg_split('/(?=[A-Z])/',substr($key,3));

        foreach ($camelCase as $one){
            $message .= $one . " ";
        }
        $message .= " = " . htmlentities($value,ENT_QUOTES,"UTF-8") . "</p>";
    }

 


include_once('mailMessage.php');
        $mailed = sendMail($email, $message);
} // ends form is valid
} // ends form is submitted

//*****************************************************************************
//
//  In this block  display the information that was submitted and do not 
//  display the form.
//  
//  NO CHANGES NEEDED
//

if (isset($_POST["btnSubmit"]) AND empty($errorMsg)){  // closing of if marked with: end body submit
   
//$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$
    print "<h1>Your Request has ";

    if (!$mailed) {
        echo "not ";
    }
    
    echo "been processed</h1>";

    print "<p>A copy of this message has ";
    if (!$mailed) {
        echo "not ";
    }
    print "been sent</p>";
    print "<p>To: " . $email . "</p>";
    print "<p>Mail Message:</p>";
    echo $message; 
 
   } else {

 //*****************************************************************************
     
//***************************************************************************** 
     
      
print '<div id="errors">';

if($errorMsg){
    echo "<ol>\n";
    foreach($errorMsg as $err){
        echo "<li>" . $err . "</li>\n";
    }
    echo "</ol>\n";
} 

print '</div>';



// display the form, notice the closing } bracket at the end just before the 
// closing body tag

?>
     
     
     
 <fieldset class="wrapper">
   <legend>Order Today</legend>
   <p>Please fill out the following registration form. <span class='required'></span>.</p>
 
 <fieldset class="intro">
 <legend>Please complete the following form</legend>
 
 <fieldset class="contact">
     <legend>Contact Information</legend>
    
 	<label for="txtFirstName" class="required">First Name
   	<input type="text" id="txtFirstName" name="txtFirstName" 
               value="<?php echo $firstName; ?>"
                tabindex="100" maxlength="25" placeholder="enter your first name" 
                autofocus onfocus="this.select()" required>
 	</label>
         <!-- note for last name i did not use the required attribute, this is 
              only for demonstration purposes. -->
         
        <label for="txtLastName" class="required">Last Name
   	<input type="text" id="txtLastName" name="txtLastName" 
                value="<?php echo $lastName; ?>"
                tabindex="110" maxlength="25" placeholder="enter your last name" 
                autofocus onfocus="this.select()" required>
        </label>
         
 	<label for="txtEmail" class="required">Email
   	<input type="text" id="txtEmail" name="txtEmail" 
                value="<?php echo $email; ?>"
                tabindex="120" maxlength="45" placeholder="enter a valid email address" 
                <?php if($emailERROR) echo 'class="mistake"'; ?>
                onfocus="this.select()" required >
        </label>
 </fieldset>					
 
  <fieldset class="radio">
 	<legend>What is your gender?</legend>
 	<label><input type="radio" id="radGenderMale" name="radGender"
                       <?php if($gender=="Male") echo ' checked="checked" ';?>
                       value="Male" tabindex="300">Male</label>
             
 	<label><input type="radio" id="radGenderFemale" name="radGender"
                      <?php if($gender=="Female") echo ' checked="checked" ';?>
                       value="Female" tabindex="310">Female</label>
 </fieldset>
 
 
 <fieldset class="checkbox">
 	<legend>What is your favorite food?</legend>
   	
         <label><input type="checkbox" id="chkPizza" name="chkPizza"
                        <?php if($pizza) echo ' checked="checked" ';?>
                       value="Pizza" tabindex="200"> Pizza</label>
             
 	<label><input type="checkbox" id="chkPasta" name="chkPasta" 
                       <?php if($pasta) echo ' checked="checked" ';?>
                       value="Pasta" tabindex="210"> Pasta</label>
        
        <label><input type="checkbox" id="chkSpecial" name="chkSpecial" 
                       <?php if($special) echo ' checked="checked" ';?>
                       value="Special" tabindex="220"> Special</label>
        
        <label><input type="checkbox" id="chkDessert" name="chkDessert" 
                       <?php if($dessert) echo ' checked="checked" ';?>
                       value="Dessert" tabindex="220"> Dessert</label>
         
        <label><input type="checkbox" id="chkOther" name="chkOther" 
                       <?php if($dessert) echo ' checked="checked" ';?>
                      value="Other" tabindex="220"> Other</label>
        
 </fieldset>
 
 
 <fieldset class="lists">	
	<legend>Your Favorite Dining Halls</legend>
 	<select id="lstFood" name="lstFood" tabindex="400" size="1">
 		
                <option <?php if($food=="Cook") echo ' selected="selected" ';?>
                    value="Cook">Cook</option>
                
                <option <?php if($food=="The Grundle") echo ' selected="selected" ';?>
                    value="The Grundle">The Grundle</option>            
                
                <option <?php if($food=="Northside") echo ' selected="selected" ';?>
                    value="Northside">Northide</option>
 		
                <option <?php if($food=="Other") echo ' selected="selected" ';?>
                    value="Other">Other</option>
 	
                
 	</select>
 </fieldset>
 
 <fieldset class="buttons">
 	<legend></legend>				
 	<input type="submit" id="btnSubmit" name="btnSubmit" value="Register" tabindex="900" class="button">
        <input type="reset" id="btnReset" name="btnReset" value="Reset Form" tabindex="910" class="button">
 </fieldset>					
 
 </fieldset>
 </fieldset>
 </form>
   
    
   </article>

 
     
     <?php
} // end body submit NO CHANGE NEEDED

if ($debug) print "<p>END OF PROCESSING</p>";

 include ("site-structure/footer.php"); 

?>

 </body>
 </html>
 fi

