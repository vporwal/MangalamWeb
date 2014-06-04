<?php include '../html/includes/header.php' ?>


<?php 
	//get the incoming parameters...
	
	
	if (isset($_POST["isMailRequest"]) && $_POST["isMailRequest"] == 'sendMail') {
		//Code to read the email template, replace the placeholder with actual values.
		$templateTokens = array("##salutation##", "##display_name##", "##customer_name##", "##org_name##", "##cust_cell##", "##cust_landline##", "##customer_mail##", "##customer_loc##" );
		$mailValues = array($_POST["salutation"], ucfirst(strtolower($_POST["firstName"])), ucfirst(strtolower($_POST["firstName"]))." ".ucfirst(strtolower($_POST["lastName"])), ucwords(strtolower($_POST["orgName"])), $_POST["mobileNo"], $_POST["landline"], $_POST["emailAddr"], $_POST["address"], $_POST["desc"]);
		$inputfile = file_get_contents("../data/email_enquiry.html");
		$message = str_replace($templateTokens, $mailValues, $inputfile);
		
		//Send Mail using mail() function
		$to = "vinod.porwal@gmail.com;";
		$cc = $_POST["emailAddr"]; 
		$subject = "Business Enquiry by Customer";
		
		$headers = "From: " . "vinod.porwal@gmail.com" . "\r\n";
		$headers .= "Reply-To: ". "vinod.porwal@hotmail.com" . "\r\n";
		//$headers .= "CC: susan@example.com\r\n";
		$headers .= "MIME-Version: 1.0\r\n";
		$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
		
		mail($to, $subject, $message, $headers);
	}
	
?>

		<style>
			td {
				font-size: 12px;
				padding: 0px 0px 2px 0;
			}
			select {
				font-size: 12px;
			}		
		</style>
		
		<div id="content-wrapper" class="clearfix row">
	<div class="content-left twelve columns">
		<div id="subcontent">
			<div id="content-data">
				<div style="margin-left:20px">
					<h3>Enquiry Information</h3><br>
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
						<input type="hidden" name="isMailRequest" id="isMailRequest" value="" />
							<table style="width: 90%;">
								<tr>
									<th width="50%" class="cellunderline">Product(s) Added for Enquiry</th>
									<th width="15%" class="cellunderline">Wt. / Units</th>
									<th class="cellunderline">Comments</th>
									<th class="cellunderline">&nbsp;</th>
								</tr>
								<?php 
									if (isset($_SESSION['prodData'])) {
										$sessionData = $_SESSION["prodData"];
										if (count($sessionData) > 0 ) {
											foreach($sessionData as $x=>$x_value) {
								?>
												
												<tr id="<?php echo $x;?>">															
													<td class="cellunderline"><?php echo $x_value ?></th>
													<td class="cellunderline">
														<select id="prodQty" name="prodQty">
															<option value="1" selected>1</option>
															<option value="2">2</option>
															<option value="3">3</option>
															<option value="4">4</option>
															<option value="5">5</option>
															<option value="6">6</option>
															<option value="7">7</option>
															<option value="8">8</option>
															<option value="9">9</option>
															<option value="10">10</option>
															<option value="11">11</option>
															<option value="12">12</option>
															<option value="13">13</option>
															<option value="14">14</option>
															<option value="15">15</option>
														</select>
													</th>
													<td class="cellunderline"><textarea name="comment" rows="1" cols="50" wrap="on" style='font-family:"Helvetica Neue", Helvetica, Arial, Geneva, sans-serif"'></textarea></th>
													<td class="cellunderline"><a class="removeItem" prodId='<?php echo $x?>' href="#"><img src="../../images/iconDelete.gif" title="" alt=""></img></a></th>
												</tr>
								<?php
											}
										}
									}
								?>
								
								
							</table>
						
						<br />
						<br />
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
									
					        	</td>
							</tr>
							
							
							<tr>
								<td colspan="2" align="right">
									<input type="button" class="button" id="mailOrderRequest" value="Send Enquiry"/>
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
				<p class="subh3 render">Mangalam</p>
				<p style="padding-top:5px;font-size:11px" >
					<p style="padding-top:5px"><b>Mr. Vinod Porwal</b></p>
					<p style="padding-top:5px;font-size:11px">Bhawani Peth, Near Ramoshi Gate,</p>
					<p style="padding-top:5px;font-size:11px">Pune - 411 002, Pune, Maharashtra, India</p>
					<p style="padding-top:3px;"><img align="top" src="../../images/email.jpg" />&nbsp<a href="mailto:vinod.porwal@roofingsolutions.co.in">vinod.porwal@roofingsolutions.co.in</a></p>
					<p style="padding-top:3px;"><img align="top" src="../../images/calling.png" />&nbsp+91 98228 33235 &nbsp;</p>
				</p>
				<div class="line"></div>
				<div id="google_map"> google map.</div>
			</div>
			
		</div>
		
	</div>
</div>

</div>
		
		
		<?php include "../html/includes/footer.php" ?>
		
	</body>

<script>
	
		$("td.cellunderline").delegate('a.removeItem','click', function(event) {
			var productCode = $(this).attr("prodId")
			var tr = $(this).closest('tr');
					eval(tr).remove();
			$.ajax({
				type: 'GET',
				url: "../html/store_session.php?productId="+productCode +"&action=remove",
				dataType: 'json',
				success: function(data){
					
					
				},
				failure: function() {
					
				}
			});
		});

		$(function() {
			$("#mailOrderRequest").on('click', function() {
				document.getElementById("isMailRequest").value = "sendMail";
				document.forms.mailEnquiry.submit();
			});
		});
</script>		
</html>

