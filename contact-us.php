<?

include ("site-structure/header.php");

//%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%
// 
// Initialize variables
//  
//  Here we set the default values that we want our form to display

$debug = false;

if(isset($_GET["debug"])){ // this just helps me out if you have it
    $debug = true;
}

if ($debug) print "<p>DEBUG MODE IS ON</p>";

//
//  CHANGES NEEDED: create variable for each form element
//                  to set your default values. in the example i set them to me


//UNIVERSITY
    $ClarksonFlag = true;
    $SUNYPotsdamFlag = false;
    $SLUFlag = false;
    $otherFlag = false;

    //GENDER
    $genderMale = true;
    $genderFemale = false;

// this would be the full url of your form
// See top.php for variable declartions
$yourURL =  $domain . $phpSelf;

//initialize flags for errors, one for each item
$firstNameERROR = false;
$lastNameERROR = false;
$emailERROR = false;
$univerityERROR = false;

//%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%
// 
// This if statement is how we can check to see if the form has been submitted
// 
// NO CHANGES: but VERFIY your forms submit button is named btnSubmit

if (isset($_POST["btnSubmit"])){

    //******************************************************************
    // is the refeering web page the one we want or is someone trying 
    // to hack in. this is not 100% reliable but ok for our purposes   */
    //
    // Security check block one, no changes needed
    if(!securityCheck()){
        $msg= "<h1 class=\"securityBreach\">Sorry you cannot access this page. ";
        $msg.= "Security breach detected and reported</h1>";
        echo '<br>';
        echo $msg;
        echo '<br>';
        include("footer.php");
        die();
    }
    
    //check for errors
    include ("lib/validationFunctions.php"); // you need to create this file (see link in lecture notes)
    $errorMsg=array();
    $dataRecord = array();
     
    //************************************************************
    // we need to make sure there is no malicious code so we do 
    // this for each element we pass in. Be sure your names match
    // your objects
    // 
    // Security check block two
    // 
    // What this does is take things like <script> and replace it
    // with &lt;script&gt; so that hackers cannot send malicous 
    // code to you.
    //   
    // You will notice i have set radio buttons, list box and the 
    // check boxes just in case someone tries something funky.
    // 
    // CHANGES NEEDED: match PHP variables with form elements
    // 
    // */

    $checked = "checked='checked'";
    
    $firstName = htmlentities($_POST["txtFirstName"],ENT_QUOTES,"UTF-8");
    $lastName = htmlentities($_POST["txtLastName"],ENT_QUOTES,"UTF-8");
    $email = htmlentities($_POST["txtEmail"],ENT_QUOTES,"UTF-8");

    //GENDER
    
    if($gender = htmlentities($_POST["radGender"],ENT_QUOTES,"UTF-8") == "Male"){
      $genderMale = true;
    }elseif($gender = htmlentities($_POST["radGender"],ENT_QUOTES,"UTF-8") == "Female"){
      $genderFemale = true;
      $genderMale = false;
    }

    //UNIVERSIY

    if(isset($_POST["chkClarkson"])) {
      $ClarksonFlag = true;
    }else{
      $ClarksonFlag = false;
    }

    if(isset($_POST["chkSUNYPotsdam"])) {
       $SUNYPotsdamFlag = true;
    }else{
      $SUNYPotsdamFlag = false;
    }

    if(isset($_POST["chkSLU"])) {
         $SLUFlag = true;
    }else{
      $SLUFlag = false;
    }

    if(isset($_POST["chkOther"])) {
      $otherFlag = true;
    }else{
      $otherFlag = false;
    }

    //RESTURAUNT

    $HotTomlesSelected = false;
    $SergiesSelected = false;
    $MamaLuciasSelected = false;

    $Resturaunt = htmlentities($_POST["lstResturaunt"]);
    if($Resturaunt == "Hot Tomales"){
      $HotTomlesSelected = true;
    }elseif($Resturaunt == "Sergies"){
      $SergiesSelected = true;
    }elseif ($Resturaunt == "Mama Lucias"){
      $MamaLuciasSelected = true;
    }else{ //Just so that one is selected Automatically
      $HotTomlesSelected = true;
    }
    
    
    
    
    // Test first name for empty and valid characters
    // YOU NEED TO DO THIS

    if($firstName==""){
      $errorMsg[]="Please enter your first name.";
      $firstNameERROR = true;
    }elseif(!verifyName($firstName)){
      $errorMsg[]="Your first name appears to be invalid.";
      $firstNameERROR = true;
    }

    $dataRecord[]=$firstName;
    
    
    
    // Test last name for empty and valid characters
    // YOU NEED TO DO THIS
   if($lastName==""){
      $errorMsg[]="Please enter your last name.";
      $lastNameERROR=true;
   }elseif(!verifyName($lastName)){
      $errorMsg[]="Your last name appears to be invalid.";
      $lastNameERROR=true;
   }

   $dataRecord[] = $lastName;
    
   // TODO: get form set up to validate email address instead of first name
    
    // test email for empty and valid format
    
    // NOTE: i removed required attribute and set this input type=text instead 
    // of type=email so i can check my php code.

     // Test anything else
    // YOU NEED TO DO THIS

     if($email==""){
        $errorMsg[]="Please enter your email address";
        $emailERROR = true;
     }elseif(!verifyEmail($email)){ 
        $errorMsg[]="Your email address appears to be incorrect.";
        $emailERROR = true;
     }

     //UNIVERSITY

     if(!($ClarksonFlag)){if(!($SUNYPotsdamFlag)){if(!($SLUFlag)){if(!($otherFlag)){ $univerityERROR = true; $errorMsg[] = "You must choose a school.";}}}}

     $ClarksonFlag_res = ($ClarksonFlag) ? 'true' : 'false';
     $SUNYPotsdamFlag_res = ($SUNYPotsdamFlag) ? 'true' : 'false';
     $SLUFlag_res = ($SLUFlag) ? 'true' : 'false';
     $otherFlag_res = ($otherFlag) ? 'true' : 'false';

     $dataRecord[] =  $ClarksonFlag_res;
     $dataRecord[] =  $SUNYPotsdamFlag_res;
     $dataRecord[] =  $SLUFlag_res;
     $dataRecord[] =  $otherFlag_res;

     //Add the gender
     if($genderMale){ $gender_res = "Male";}elseif($genderFemale){ $gender_res = "Female"; }
     $dataRecord[] =  $gender_res;

     //Add resturaunt
     $dataRecord[] = $Resturaunt;

     
    //@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
    // 
    // our form data is valid at this point so we can process the data
    if(!$errorMsg){ 
        if ($debug) print "<p>Form is valid</p>";

        //####################################################################
        // Begin processing data



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

        $message  = '<div class = "thing"> <h1>Thank you for filling out our form!</h1>';
        $message .= '<h3>Your information has been recorded and sent in an email to you.</h3>';

        foreach ($_POST as $key => $value){
            if($key != "btnSubmit"){
              if($key == "chkOther"){ $key = "chkSchool ";} 
              elseif($key == "chkClarkson"){ $key = "chkSchool ";}
              elseif($key == "chkSLU"){ $key = "chkSchool ";}
              elseif($key == "chkSUNYPotsdam "){ $key = "chkSchool ";}
              $message .= "<p>"; 

              $camelCase = preg_split('/(?=[A-Z])/',substr($key,3));

              foreach ($camelCase as $one){
                  $message .= $one . " ";
              }
              $message .= ": " . htmlentities($value,ENT_QUOTES,"UTF-8") . "</p>";
            }
        }

        $message .= "</div>";

        include_once('lib/mailMessage.php');
        $mailed = sendMail($email, $message);

        //########################################################
        // Begin processing data

        //########################################################
        // Save Forms data to a csv file on the cloud

        // NOTE: When you save the forms information to a file, the file
        // permissions can cause problems

        //NOTE: my file is in a folder called data

        // Step one in netbeans create new file, name it formData.csv
        // Step two delete the contents of this csv file and save it
        // Step three use fugu or winscp to set the permissions on this
        // file to 666 (rw- for everyone)
        // Now try your form and see if it saves.

        //Saves the date to the CSV
        $date = Date("F d Y H:i:s");
        $dataRecord[] = $date;

        $fileExt=".csv";

        $myFileName="data/formData";

        $filename = $myFileName . $fileExt;

        if ($debug) print "\n\n<p>filename is " . $filename;

        // now we just open the file for append
        $file = fopen($filename, 'a');

        // write the forms informations
        fputcsv($file, $dataRecord);

        // close the file
        fclose($file);

        //####################################################################


    } // ends form is valid
    
} // ends if form was submitted. We will be adding more information ABOVE this

?>

<article id="main">

<? 
//*****************************************************************************
//
//  In this block  display the information that was submitted and do not 
//  display the form.
//  
//  NO CHANGES NEEDED
//
if (isset($_POST["btnSubmit"]) AND empty($errorMsg)){  // closing of if marked with: end body submit
    echo $message;
    include("footer.php");
    die();
} else {


?>

<h1> Questionaire </h1>

<p> Greetings! Thank you for visiting Potsdam. If you would be so kind as to fill out this following form, the municipal government of Potsdam would really appreciate it. (Note, this site is not under the supervision of the Government of Potsdam. It is merely a class assignment. To find the actual Potsdam Home Page, click on the logo at the top.) </p>

<p> The aim of this survey is to guage what parts of Potsdam tourists and residents find most charming. From the movie theatre to local eating establishments, Potsdam is always a fun place. </p>
<p>Instructions to fill out the form:</p>

<p class="instructions">Thank you for taking a few moments to fill out this form! Please start by filling out your first name, last name, and email. Then, check the respective boxes you'd wish in regards to University. Then, select your gender and then tell us your favroite resturaunt!</p>

<p>Have a wonderful day, everyone!</p>
<? 

// display the form, notice the closing } bracket at the end just before the 
// closing body tag

//@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
//
// Here we display any errors that were on the form
//
    
print '<div id="errors">';

if($errorMsg){
    echo "<ul>\n";
    foreach($errorMsg as $err){
        echo "<li>" . $err . "</li>\n";
    }
    echo "</ul>\n";
} 

print '</div>';


?>

<form action= <? print '"' . $phpSelf . '"'; ?> 
      method="post"
      id="frmRegister">
			
<fieldset class="wrapper">

<fieldset class="intro">
<legend>Please complete the following form</legend>

<fieldset class="contact">
    <legend>Contact Information</legend>
    
	<label for="txtFirstName" class="required">First Name
  	<input type="text" id="txtFirstName" name="txtFirstName" 
               value= <? print '"' . $firstName . '"'; ?>
               tabindex="100" maxlength="25" placeholder="enter your first name" 
               autofocus onfocus="this.select()" <? if($firstNameERROR) print 'class="mistake"' ?> >
	</label>
        <!-- note for last name i did not use the required attribute, this is 
             only for demonstration purposes. -->
        <label for="txtLastName" class="required">Last Name
  	<input type="text" id="txtLastName" name="txtLastName" 
               value=<? print '"' . $lastName . '"'; ?>
               tabindex="110" maxlength="25" placeholder="enter your last name" 
               autofocus onfocus="this.select()" <? if($lastNameERROR) print 'class="mistake"' ?> >
        </label>
	<label for="txtEmail" class="required">Email
  	<input type="text" id="txtEmail" name="txtEmail" 
               value=<? print '"' . $email . '"'; ?>
               tabindex="120" maxlength="45" placeholder="Enter a valid email address" 
               onfocus="this.select()" <? if($emailERROR) print 'class="mistake"' ?> >
        </label>
</fieldset>					

<fieldset class="checkbox">
	<legend>What local Universities have you applied to?</legend>
  	
  <label><input type="checkbox" id="chkClarkson" name="chkClarkson" value="Clarkson" tabindex="200" <? if($ClarksonFlag){ echo "checked=\"checked\""; }?>>Clarkson</label>
            
	<label><input type="checkbox" id="chkSUNYPotsdam" name="chkSUNYPotsdam" value="SUNY Potsdam" tabindex="210" <?if($SUNYPotsdamFlag){ echo "checked=\"checked\"";} ?> >SUNY Potsdam</label>

  <label><input type="checkbox" id="chkSLU" name="chkSLU" value="SLU" tabindex="220" <?if($SLUFlag){ echo "checked=\"checked\"";} ?> >SLU</label>

  <label><input type="checkbox" id="chkOther" name="chkOther" value="Other" tabindex="230" <?if($otherFlag){ echo "checked=\"checked\"";} ?> >Other</label>


</fieldset>

<fieldset class="radio">
	<legend>What is your gender?</legend>

	<label><input type="radio" id="radGenderMale" name="radGender" value="Male" <? if($genderMale){ echo "checked=\"checked\"";} ?> tabindex="300">Male</label>

  <label><input type="radio" id="radGenderFemale" name="radGender" value="Female" <? if($genderFemale) echo "checked=\"checked\"" ?> tabindex="310">Female</label>

</fieldset>



<fieldset class="lists">

	<legend>Favourite Potsdam Resturaunt</legend>

	<select id="lstResturaunt" name="lstResturaunt" tabindex="400" size="1">

		<option value="Hot Tomales" <?if($HotTomlesSelected){ echo "selected=\"selected\"";} ?> >Hot Tomales</option>

		<option value="Sergies" <?if($SergiesSelected){ echo "selected=\"selected\"";} ?> >Sergies</option>

		<option value="Mama Lucias" <?if($MamaLuciasSelected){ echo "selected=\"selected\"";} ?> >Mama Lucias</option>

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

<br>

<?} include("site-structure/footer.php"); ?>
