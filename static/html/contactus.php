<?php include '../html/includes/header.php'; 
	require_once('./recaptcha/recaptchalib.php');
	
	//get the incoming parameters...
	
	if (isset($_POST["isSubmitted"]) && $_POST["isSubmitted"] == 'true') {
		$errormessage = "";	
		//validating the input data... 
		/** Validating Recaptcha.*/
		$privatekey = "6LcCXegSAAAAAN1PZSHJgvgXvt_yWxqj4uIjDeI0";
	  	$resp = recaptcha_check_answer ($privatekey, $_SERVER["REMOTE_ADDR"], 
	  		$_POST["recaptcha_challenge_field"], $_POST["recaptcha_response_field"]);
	    $isValid = true;
	  	if (!$resp->is_valid) {
	    	// What happens when the CAPTCHA was entered incorrectly
	    	$errormessage = "The reCAPTCHA wasn't entered correctly. Go back and try it again." . "(reCAPTCHA said: " .$resp->error;
	    	$isValid = false;
			//die ("The reCAPTCHA wasn't entered correctly. Go back and try it again." . "(reCAPTCHA said: " . $resp->error . ")");
	  	} else {
	    	// Your code here to handle a successful verification
	  	}
		/***/
		if ($isValid == true) {
			//Code to read the email template, replace the placeholder with actual values.
			$templateTokens = array("##salutation##", "##display_name##", "##customer_name##", "##org_name##", "##cust_cell##", "##cust_landline##", "##customer_mail##", "##customer_addr##","##customer_desc##" );
			$mailValues = array($_POST["salutation"], ucfirst(strtolower($_POST["firstName"])), ucfirst(strtolower($_POST["firstName"]))." ".ucfirst(strtolower($_POST["lastName"])), ucwords(strtolower($_POST["orgName"])), $_POST["mobileNo"], $_POST["landline"], $_POST["emailAddr"], $_POST["address"], $_POST["desc"]);
			$inputfile = file_get_contents("../data/email_contactus.html");
			$message = str_replace($templateTokens, $mailValues, $inputfile);
			
			//Send Mail using mail() function
			$to = "mangalamsteel@roofingsolutions.co.in";
			//$cc = $_POST["emailAddr"]; 
			$subject = "Business Enquiry by Customer";
			$headers = "From: " . "vinod.porwal@roofingsolutions.co.in" . "\r\n";
			$headers .= "Reply-To: ". "vinod.porwal@roofingsolutions.co.in" . "\r\n";
			$headers .= "MIME-Version: 1.0\r\n";
			$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
			$headers .= "Cc: ".$_POST["emailAddr"]."\r\n";
			ini_set("SMTP","mail.roofingsolutions.co.in" ); 
			ini_set('sendmail_from', 'vinod.porwal@roofingsolutions.co.in'); 
		
			mail($to, $subject, $message, $headers);
			$successmessage = "Email Sent successfully.";	
		}
			
	} else {
		//echo 'not submitted';
	}
		
	
	
?>

<script type="text/javascript">
 var RecaptchaOptions = {
    theme : 'clean'
 };
 </script>
    <div id="content-wrapper" class="clearfix row">
	<div class="content-left twelve columns">
		<div id="subcontent">
			<div id="content-data">
				<div style="margin-left:20px">
					<h3>General Email Enquiry</h3><br/>
					<div class="line"></div>
					<p class="mandatorynote">* = Fields are required.</p>
					<div class="line"></div>
					<div id="errormessage" style="padding:10px 0 5px 0">
						<?php
							if (isset($successmessage)) {
								echo '<font weight="bold">'.$successmessage.'</font>';
								unset ($successmessage);
							} else if (isset($errormessage)) {
								echo '<font color="red">'.$errormessage.'</font>';
								unset ($errormessage);
							}
						?>
					</div>
					
					<h4 style="font-size: 12px;padding: 5px 0 0 0">Please Fill Your Contact Information</h4><br>
					<form name="contactusemailform" action="../html/contactus.php" method="post">
						<input type="hidden" id="isSubmitted" name="isSubmitted" value="false" />
						<table>
							<tr>
								<th>Contact Person*&nbsp;&nbsp;</th>
								<td>
									<select class="textfield" id="salutation" name="salutation">
										<option value="">Mr.</option>
										<option value="">Mrs.</option>
										<option value="">Dear</option>
									</select>
									<input type="text" name="firstName" id="firstName" size="15" class="textfield" /> 
									<input type="text" name="lastName" id="lastName" size="15" class="textfield" />
								</td>
							</tr>
							<tr>
								<th>Company Name</th>
								<td> <input type="text" name="orgName" id="orgName" class="textfield" size="30"/></td>
							</tr>
							<!-- <tr>
								<td>Last Name</td>
								<td> <input type="text" name="" id=""  class="textfield" /></td>
							</tr> -->
							<tr>
								<th>Phone Number (LL)</th>
								<td> <input type="text" name="landline" id="landline"  class="textfield" size="15"/></td>
							</tr>
							<tr>
								<th>Phone Number (Cell)&nbsp;&nbsp;&nbsp;&nbsp;<!-- show icon of mobile and landline. --></th>
								<td> <input type="text" name="mobileNo" id="mobileNo"  class="textfield" size="15"/></td>
							</tr>
							<tr>
								<th>Email</th>
								<td> <input type="text" name="emailAddr" id="emailAddr"  class="textfield" size="30"/></td>
							</tr>
							<tr>
								<th valign="top">Address</th>
								<td><textarea rows="2" cols="30" class="textfield" id="address" name="address"></textarea></td>
							</tr>
							<tr>
								<th valign="top">Description</th>
								<td><textarea rows="3" cols="60" class="textfield" id="desc" name="desc"></textarea></td>
							</tr>
							<!--<tr>
								<td>&nbsp;</td>
								<td>&nbsp;</td>
							</tr>
							-->
							<tr>
								<td>&nbsp;</td>
								<td>
									<?php
							          
							          $publickey = "6LcCXegSAAAAABuWFFHt7ikE-PTWRGxvrWgOaN-6"; // you got this from the signup page
							          echo recaptcha_get_html($publickey);
							        ?>
					        	</td>
							</tr>
							
							
							<tr>
								<td colspan="2" align="right">
									<input id="contactDealer" type="button" class="button" value="Post Enquiry"/>
								</td>
							</tr>
							
						</table>
					</form>
					<div id="map-canvas">
					</div>
				</div>
			</div>
		</div>
		<div id="searchbar" class="widget-area" style="height: 100%;width:23%">
			
			<div>
				<p class="subh3 render">Mangalam Tech Solutions</p>
				<p style="padding-top:5px;font-size:11px" >
					<p style="padding-top:5px"><b>Mr. Vinod Porwal</b></p>
					<p style="padding-top:5px;font-size:11px">Bhawani Peth, Near Ramoshi Gate,</p>
					<p style="padding-top:5px;font-size:11px">Pune - 411 002, Pune, Maharashtra, India</p>
					<p style="padding-top:3px;"><img align="top" src="../../images/email.jpg" />&nbsp<a href="mailto:vinod.porwal@roofingsolutions.co.in">vinod.porwal@roofingsolutions.co.in</a></p>
					<p style="padding-top:3px;"><img align="top" src="../../images/calling.png" />&nbsp+91 98228 33235 &nbsp;</p>
				</p>
				<div class="line"></div>
			</div>
			
		</div>
		
	</div>
</div>

</div>


<?php include "../html/includes/footer.php" ?>
</body>

<script>
	
	$(function() {
		$("#contactDealer").on('click', function() {
			if (document.getElementById("isSubmitted").value == 'false') {
				document.getElementById("isSubmitted").value = 'true';
			} else {
				document.getElementById("isSubmitted").value = 'false';
			}
			document.contactusemailform.submit();
		});
	});
	
	//Google Map Coding.
	/*var mapDiv = document.getElementById('google_map');
	var latlng = new google.maps.LatLng(-3.09, -2);
	var options = {   center: latlng,   zoom: 4,   mapTypeId: google.maps.MapTypeId.ROADMAP }; 
	var map = new google.maps.Map(mapDiv, options); */
</script>


</html>




