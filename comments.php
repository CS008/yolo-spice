
<?php

include ("site-structure/header.php");

/* debug mode */

$debug = false;

if(isset($_GET["debug"])){ // this just helps me out if you have it
    $debug = true;
}

if ($debug) print "<p>DEBUG MODE IS ON</p>";



/*Reading the data file to post comments*/

$fileExt=".csv";

$myFileName="formData";

$filename = $myFileName . $fileExt;

if ($debug) print "\n\n<p>filename is " . $filename;


$file=fopen($filename, "r");



if($file){
    if($debug) print "<p>File Opened. Begin reading data into an array.</p>\n";

    
    $headers=fgetcsv($file);
    
    
    while(!feof($file)){
        $records[]=fgetcsv($file);
    }
    
   
    fclose($file);
    if($debug) {
        print "<p>Finished reading. File closed.</p>\n";
        print "<p>Contents of my array<p><pre> "; print_r($records); print "</pre></p>";
    }
} else {
    if($debug) print "<p>File Opened Failed.</p>\n";
}


print '<article id="comments">';
foreach($records as $oneRecord){
    if($oneRecord[0]!=""){  //the eof would be a "" 
        print '<p>';
	print $oneRecord[0] . '~' . $oneRecord[1] . '    |Posted on: ' . $oneRecord[2];
        print '</p>';
    }
}
 print '</article>';  
    
    
    
  






//
//  CHANGES NEEDED: create variable for each form element
//                  to set your default values. in the example i set them to me


// comments
$commentsFLAG = false;


$yourURL =  $domain . $phpSelf;

//error flags
$firstNameERROR = false;
$lastNameERROR = false;
$commentsERROR = false;
$colorERROR = false;
$shapeERROR = false;

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
    
    /*
    if(!securityCheck()){
        $msg= "<h1 class=\"securityBreach\">Sorry you cannot access this page. ";
        $msg.= "Security breach detected and reported</h1>";
        echo $msg;
        die();
    }
    */
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
    $comments = htmlentities($_POST["txtComments"],ENT_QUOTES,"UTF-8");

    

    
	
 
    
    
    
    // Test first name for empty and valid characters
    // YOU NEED TO DO THIS

    if($firstName==""){
      
      $firstName="Anonymous";
    }elseif(!verifyName($firstName)){
      $errorMsg[]="Your name appears to be invalid.";
      $firstNameERROR = true;
    }
    
    $dataRecord[]=$firstName;
    
    
    
    

 
    
  //checking comments

     if($comments==""){
        $errorMsg[]="Please enter your comment";
        $commentsERROR = true;
     }elseif(!verifyText($comments)){ 
        $errorMsg[]="Your comment seems to have invalid characters.";
        $commentsERROR = true;
     }

     $dataRecord[]=$comments;
	 
	

     
    //@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
    // 
    // our form data is valid at this point so we can process the data
    if(!$errorMsg){ 
        if ($debug) print "<p>Form is valid</p>";

        //************************************************************
        //
        //
        //
        //  the substr function removes the 3 letter prefix
        //  preg_split('/(?=[A-Z])/',$str) add a space for the camel case
        //  see: http://stackoverflow.com/questions/4519739/split-camelcase-word-into-words-with-php-preg-match-regular-expression
        //
        //  CHANGES: first message line. foreach no changes needed

        $message  = '<article class = "nop"> <h1>Thanks for letting us know what you think.</h1>';
        $message .= '<h3>Your information has been received and posted.</h3>';

        foreach ($_POST as $key => $value){
            
              $message .= "<p>"; 

              $camelCase = preg_split('/(?=[A-Z])/',substr($key,3));

              foreach ($camelCase as $one){
                  $message .= $one . " ";
              }
              $message .= ": " . htmlentities($value,ENT_QUOTES,"UTF-8") . "</p>";
            }
        

        $message .= "</article>";

       


       

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

        $myFileName="formData";

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
   } // ends if form was submitted
 

?>

<article id="main">

<?php
//*****************************************************************************
//
//  In this block  display the information that was submitted and do not 
//  display the form.
//  
//  NO CHANGES NEEDED
//
if (isset($_POST["btnSubmit"]) AND empty($errorMsg)){  // closing of if marked with: end body submit
    echo $message;
    include("site-structure/footer.php");
    die();
} else {


?>

<h1> Comments </h1>

<p> Please feel free to leave a comment. Leave the name field blank to post anonymously.</p>

<p class="instructions">Thank you! Please start by filling out your first name, last name, and email. Read instructions carefully and select your answer</p>


<?php

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

<form action= <?php print '"' . $phpSelf . '"'; ?> 
      method="post"
      id="frmRegister">
			
<fieldset class="wrapper">

<fieldset class="intro">
<legend>Please complete the following form</legend>

<fieldset class="contact">
    <legend>Contact Information</legend>
    
	<label for="txtFirstName" class="required">First Name
  	<input type="text" id="txtFirstName" name="txtFirstName" 
               value= <?php print '"' . $firstName . '"'; ?>
               tabindex="100" maxlength="25" placeholder="First Name" 
               autofocus onfocus="this.select()" <?php if($firstNameERROR) print 'class="mistake"' ?> >
	</label>
        <!-- note for last name i did not use the required attribute, this is 
             only for demonstration purposes. -->
        
	<fieldset>					
    <label for="txtComments" class="required">Comments</label>
    <textarea id="txtComments" name="txtComments" tabindex="271" 
	      onfocus="this.select()" style="width: 25em; height: 4em;" ></textarea>
</fieldset>


<fieldset class="buttons">

	<legend></legend>	

	<input type="submit" id="btnSubmit" name="btnSubmit" value="Submit" tabindex="900" class="button">

	<input type="reset" id="btnReset" name="btnReset" value="Reset" tabindex="910" class="button">

</fieldset>					


</fieldset>
</fieldset>
</form>




<?php }
include("site-structure/footer.php");  
?>
</article>