<?php $con = mysqli_connect("localhost","root","","gn_db"); ?>
<?php  mysqli_set_charset($con ,'utf8');?>
<?php
//====================================================counter============================================================
  $emptyerr = "";
 if (isset($_POST['my_counter']) && $_POST['my_counter'] != 1) 
          { 
			 $counter = substr($_POST['my_counter'] , 0,1);
		  }
		  else
		  {
			  $counter = 1; 
		  }
		  
		  if (isset ($_GET['deltemppic']))
		  {
			$id = $_GET['deltemppic'];
			$sql = "DELETE FROM temppic WHERE `id` = '".$id."'";
		    mysqli_query($con , $sql); 
		  }
		  
			 
			  
		  
		  function download_remote($url, $save_path) 
		  {

					set_time_limit (0);
					
						$f = fopen($save_path, 'w+');
					
						$handle = fopen($url, "rb");
					
						while (!feof($handle)) {
					
							$contents = fread($handle, 8192);
					
							fwrite($f, $contents);
					
						}
					
						fclose($handle);
					
						fclose($f);
					
			}
//=======================================================================================================================
       $pic_source = "images/img_avatar2.png";
//======================================================pic resource=======================================================
                  if(isset($_POST['tb_temp']))
				  {
				  if ($_FILES["ff_pic"]["name"] != NULL)
		           {
						$target_dir = "images/ppic/";
						$target_file = $target_dir.basename($_FILES["ff_pic"]["name"]);
						move_uploaded_file($_FILES["ff_pic"]["tmp_name"] , $target_file);
						$sql = "UPDATE picsource SET `picsource` = '".$target_file."' WHERE id=2";
						mysqli_query($con , $sql);
						$sql = "SELECT picsource FROM picsource WHERE id = 2";
					    $result =  mysqli_query($con , $sql);
					    $row = mysqli_fetch_assoc($result);
						$pic_source = $row["picsource"];
				   }
				   else
				   {
					   $sql = "SELECT picsource FROM picsource WHERE id = 2";
					   $result =  mysqli_query($con , $sql);
					   $row = mysqli_fetch_assoc($result);
					  if ( $row["picsource"] != "non" ) 
					   {
						  $pic_source = $row["picsource"];
					   }
					  else
					   {
						  $pic_source = "images/img_avatar2.png";
					   }
								   
				   }			     }
	
//=========================================================ثبت نهایی===============================================================
  if (isset($_POST['tb_final'])) 
  {
	  if ($counter == 2) 
	  {
//======================================================================================================================
							$total = count($_FILES['ff_ppic1']['name']);
								  for ($i=0; $i<$total; $i++)
									  {
										 $tmpFilePath = $_FILES['ff_ppic1']['tmp_name'][$i];
										 if ($tmpFilePath != "") 
										 {
										   $newFilePath = 	 "images/temppic/".$_FILES['ff_ppic1']['name'][$i];
										   $sql = "INSERT INTO `temppic` (`counter`, `tempaddr`, `newaddr`) VALUES ('1', '".$tmpFilePath."', '".$newFilePath."')";	
													  mysqli_query($con , $sql);
													  move_uploaded_file($tmpFilePath , $newFilePath);
										 }
									  }

									  
//======================================================================================================================									  
								$target_file = "images/ppic/img_avatar2.png";									  
								  if ($_FILES["ff_pic"]["name"] != NULL)
								  {
										$target_dir = "images/ppic/";
										$target_file = $target_dir.basename($_FILES["ff_pic"]["name"]);
										move_uploaded_file($_FILES["ff_pic"]["tmp_name"] , $target_file);
								  }
								  else
								   {
											   $sql = "SELECT picsource FROM picsource WHERE id = 2";
											   $result =  mysqli_query($con , $sql);
											   $row = mysqli_fetch_assoc($result);
											  if ( $row["picsource"] != "non" ) 
											   {
												  $target_file = $row["picsource"];
											   }
											  else
											   {
												  $target_file = "images/img_avatar2.png";
											   }
														   
									}
//=========================================================================================================================									
				//%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%	
				if ($_POST['tb_name'] != NULL && $_POST['tb_family'] != NULL) 
				{		
		         $sql = "INSERT INTO `tbinfo` (`name`, `family`, `fname`, `code`, `city`, `hometown`, `license`, `ltown`, `lastjob`, `job`, `jobtown`, `tel`, `mobile`, `email`, `pic`) VALUES ('".$_POST['tb_name']."', '".$_POST['tb_family']."', '".$_POST['tb_father']."', '".$_POST['tb_code']."', '".$_POST['tb_bb']."', '".$_POST['tb_home']."', '".$_POST['tb_degree']."', '".$_POST['tb_univercity']."', '".$_POST['tb_state']."', '".$_POST['tb_job']."', '".$_POST['tb_jobp']."', '".$_POST['tb_phone']."','".$_POST['tb_mobile']."' ,'".$_POST['tb_email']."', '".$target_file."')";	
		              mysqli_query($con , $sql);
					  $sql = "SELECT id FROM tbinfo ORDER BY id DESC LIMIT 1";
					  $result =  mysqli_query($con , $sql);
					  $row = mysqli_fetch_assoc($result);
					  $id = $row["id"];
						 $title = $_POST["tb_sub1"];
						 $text  = $_POST["textarea1"];
						 if ($title != "" && $text != "" ) 
						 {
						 $sql = "INSERT INTO `tbcases` (`title`, `text`, `perid`) VALUES ('".$title."', '".$text."', '".$id."')";	
		                      mysqli_query($con , $sql);
							  
							  $sql = "SELECT id FROM tbcases ORDER BY id DESC LIMIT 1";
							  $result =  mysqli_query($con , $sql);
					          $row = mysqli_fetch_assoc($result);
						      $caseid = $row["id"];
							  
							  $sql = "SELECT * FROM temppic WHERE `counter` = '1'";
							  $result =  mysqli_query($con , $sql) or die(mysqli_error());
							  foreach ($result as $row1)
							  {
								  $newaddr = $row1["newaddr"];
								  $sql = "INSERT INTO `tbpic` (`caseid`, `pic`) VALUES ('".$caseid."', '".$newaddr."')";	
		                          mysqli_query($con , $sql);
							  }  
						 }
//========================================================================================================================
                              $sql = "SELECT * FROM temppic";
							  $result =  mysqli_query($con , $sql); 
							  if (!is_dir("images/anex/$id"))
							   {
									 mkdir("images/anex/$id"); 
							   }
							  foreach ($result as $row1)
							  {
								    $newaddr = $row1["newaddr"];
									$newaddr2 = substr($newaddr , 15);
									//echo $newaddr2;
									//echo "<br/>";
									 if (is_file($newaddr))
									    {
											$target_dir = "images/anex/$id/$newaddr2";
											download_remote($newaddr , $target_dir); 
										}
							  }  
							  
							  
//========================================================================================================================					 
	
				}
				else 
				{
					//empty submit
					$emptyerr = "درج نام و نام خانوادگی الزامی می باشد!";
				}
	  }
	  else 
	  {
	      $target_file = "images/ppic/img_avatar2.png";
		  if ($_FILES["ff_pic"]["name"] != NULL)
		  {
				$target_dir = "images/ppic/";
				$target_file = $target_dir.basename($_FILES["ff_pic"]["name"]);
				move_uploaded_file($_FILES["ff_pic"]["tmp_name"] , $target_file);
		  }
		  else
		   {
					   $sql = "SELECT picsource FROM picsource WHERE id = 2";
					   $result =  mysqli_query($con , $sql);
					   $row = mysqli_fetch_assoc($result);
					  if ( $row["picsource"] != "non" ) 
					   {
						  $target_file = $row["picsource"];
					   }
					  else
					   {
						  $target_file = "images/img_avatar2.png";
					   }
								   
			}
		if ($_POST['tb_name'] != NULL && $_POST['tb_family'] != NULL ) 
				{		
		          $sql = "INSERT INTO `tbinfo` (`name`, `family`, `fname`, `code`, `city`, `hometown`, `license`, `ltown`, `lastjob`, `job`, `jobtown`, `tel`, `mobile`, `email`, `pic`) VALUES ('".$_POST['tb_name']."', '".$_POST['tb_family']."', '".$_POST['tb_father']."', '".$_POST['tb_code']."', '".$_POST['tb_bb']."', '".$_POST['tb_home']."', '".$_POST['tb_degree']."', '".$_POST['tb_univercity']."', '".$_POST['tb_state']."', '".$_POST['tb_job']."', '".$_POST['tb_jobp']."', '".$_POST['tb_phone']."','".$_POST['tb_mobile']."' ,'".$_POST['tb_email']."', '".$target_file."')";	
		                      mysqli_query($con , $sql);
							  $sql = "SELECT id FROM tbinfo ORDER BY id DESC LIMIT 1";
							  $result =  mysqli_query($con , $sql);
					          $row = mysqli_fetch_assoc($result);
						      $id = $row["id"];
					 for ($y = 1 ; $y < $counter ; $y++) 
					 {
						 $title = $_POST["tb_sub".$y];
						 $text  = $_POST["textarea".$y];
						 if ($title != "" && $text != "" ) 
						 {
						 $sql = "INSERT INTO `tbcases` (`title`, `text`, `perid`) VALUES ('".$title."', '".$text."', '".$id."')";	
		                      mysqli_query($con , $sql);
							  
							  $sql = "SELECT id FROM tbcases ORDER BY id DESC LIMIT 1";
							  $result =  mysqli_query($con , $sql);
					          $row = mysqli_fetch_assoc($result);
						      $caseid = $row["id"];
							  
							  $sql = "SELECT * FROM temppic WHERE `counter` = '".$y."'";
							  $result =  mysqli_query($con , $sql) or die(mysqli_error());
							  foreach ($result as $row1)
							  {
								  $newaddr = $row1["newaddr"];
								  $sql = "INSERT INTO `tbpic` (`caseid`, `pic`) VALUES ('".$caseid."', '".$newaddr."')";	
		                          mysqli_query($con , $sql);
							  }  
						 }

					 }
//========================================================================================================================
                              $sql = "SELECT * FROM temppic";
							  $result =  mysqli_query($con , $sql); 
							  if (!is_dir("images/anex/$id"))
							   {
									 mkdir("images/anex/$id"); 
							   }
							  foreach ($result as $row1)
							  {
								    $newaddr = $row1["newaddr"];
									$newaddr2 = substr($newaddr , 15);
									//echo $newaddr2;
									//echo "<br/>";
									 if (is_file($newaddr))
									    {
											$target_dir = "images/anex/$id/$newaddr2";
											download_remote($newaddr , $target_dir); 
										}
							  }  
							  
							  
//========================================================================================================================					 
				}
				else 
				{
					$emptyerr = "درج نام و نام خانوادگی الزامی می باشد!";
					//empty submit
				}
    }
  
                               $files = glob('images/temppic/*');
							   foreach ($files as $file)
							   {
								   if (is_file($file))
								   unlink($file);
							   }



//==========================================================================================================================					 					 
					  $sql = "DELETE FROM temppic";
							  mysqli_query($con , $sql);
							  $counter =1;
							  
							  $sql = "UPDATE picsource SET `picsource` = 'non' WHERE id=2";
						      mysqli_query($con , $sql);
							  unset($_POST);
							  	 
     }
//=========================================================================================================================		   
		
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" type="text/css" href="mystyle.css">
<title>ثبت گزارش</title>
<!-- Make sure the path to CKEditor is correct. -->
<script src="ckeditor/ckeditor.js"></script>
</head>
<body>
<div id="up">
  <p>
    <label>بسمه تعالی</label>
  </p>
</div>
<div id="all">
  <div class="left" id="left"> </div>
  <div class="center" id="center">
    <label>اطلاعات اولیه</label>
    <p> >>>>>>>>>>>>>>>>>>>>>>>>>>>>> </p>
    <br/>
    <form action="index.php" method="POST" enctype="multipart/form-data" name="form1" id="form1"  accept-charset="utf-8">
      <table class="table" width="807" border="0" cellspacing="1" cellpadding="1">
        <tr>
          <td height="30" colspan="4" align="right"><p style="font-family:Tahoma, Geneva, sans-serif; color:#F00; font-style:italic;"><?php echo $emptyerr;?></p></td>
          <td  align="center" width="2" rowspan="7">&nbsp;</td>
          <td  align="center" width="228" rowspan="7"><img id="perpic" src="<?php echo $pic_source; ?>" alt="" name="img" width="150" height="150" /></td>
        </tr>
        <tr>
          <td width="110" height="20" align="right">نام :</td>
          <td width="172" height="30"><label for="tb_name2"></label>
            <input class="textbox" type="text" name="tb_name" id="tb_name2" value="<?php if (isset($_POST["tb_name"])){ echo $_POST["tb_name"]; }else {echo "";}?>" /></td>
          <td width="120" height="30" align="right">محل تحصیل : </td>
          <td height="30"><label for="tb_univercity"></label>
            <input class="textbox" type="text" name="tb_univercity" id="tb_univercity" value="<?php if (isset($_POST["tb_univercity"])){ echo $_POST["tb_univercity"]; }else {echo "";}?>"/></td>
        </tr>
        <tr>
          <td width="110" height="20" align="right">نام خانوادگی :</td>
          <td width="172" height="30"><label for="tb_family" ></label>
            <input class="textbox" type="text" name="tb_family" id="tb_family" value="<?php if (isset($_POST["tb_family"])){ echo $_POST["tb_family"];}else {echo "";}?>"  /></td>
          <td width="120" height="30" align="right">آخرین سمت : </td>
          <td width="156" height="30"><label for="tb_state"></label>
            <input class="textbox" type="text" name="tb_state" id="tb_state"  value="<?php if (isset($_POST["tb_state"])){ echo $_POST["tb_state"];}else {echo "";}?>"/></td>
        </tr>
        <tr>
          <td width="110" height="20" align="right">نام پدر :</td>
          <td width="172" height="30"><label for="tb_father" ></label>
            <input class="textbox" type="text" name="tb_father" id="tb_father" value="<?php if (isset($_POST["tb_father"])){ echo $_POST["tb_father"];}else {echo "";}?>"/></td>
          <td width="120" height="30" align="right">شغل :</td>
          <td width="156" height="30"><label for="tb_job"></label>
            <input class="textbox" type="text" name="tb_job" id="tb_job" value="<?php if (isset($_POST["tb_job"])){ echo $_POST["tb_job"];}else {echo "";}?>" /></td>
        </tr>
        <tr>
          <td width="110" height="20" align="right">شماره کد ملی : </td>
          <td width="172" height="30"><label for="tb_code"></label>
            <input class="textbox" type="text" name="tb_code" id="tb_code" value="<?php if (isset($_POST["tb_code"])){ echo $_POST["tb_code"];}else {echo "";}?>" /></td>
          <td width="120" height="30" align="right">محل اشتغال : </td>
          <td width="156" height="30"><label for="tb_jobp"></label>
            <input class="textbox" type="text" name="tb_jobp" id="tb_jobp" value="<?php if (isset($_POST["tb_jobp"])){ echo $_POST["tb_jobp"];}else {echo "";}?>"/></td>
        </tr>
        <tr>
          <td width="110" height="20" align="right">محل تولد : </td>
          <td width="172" height="30"><label for="tb_bb"></label>
            <input class="textbox" type="text" name="tb_bb" id="tb_bb" value="<?php if (isset($_POST["tb_bb"])){ echo $_POST["tb_bb"];}else {echo "";}?>" /></td>
          <td width="120" height="30" align="right">شماره تلفن (ثابت) :</td>
          <td width="156" height="30"><label for="tb_phone"></label>
            <input class="textbox" type="text" name="tb_phone" id="tb_phone" value="<?php if (isset($_POST["tb_phone"])){ echo $_POST["tb_phone"];}else {echo "";}?>"/></td>
        </tr>
        <tr>
          <td width="110" height="20" align="right">محل سکونت :</td>
          <td width="172" height="30"><label for="tb_home"></label>
            <input class="textbox" type="text" name="tb_home" id="tb_home" value="<?php if (isset($_POST["tb_home"])){ echo $_POST["tb_home"];}else {echo "";}?>"/></td>
          <td width="120" height="30" align="right">شماره تلفن (همراه) :</td>
          <td width="156" height="30"><label for="tb_mobile"></label>
            <input class="textbox" type="text" name="tb_mobile" id="tb_mobile" value="<?php if (isset($_POST["tb_mobile"])){ echo $_POST["tb_mobile"];}else {echo "";}?>"/></td>
        </tr>
        <tr>
          <td width="110" height="20" align="right">میزان تحصیلات : </td>
          <td width="172" height="30"><label for="tb_degree"></label>
            <input class="textbox" type="text" name="tb_degree" id="tb_degree" value="<?php if (isset($_POST["tb_degree"])){ echo $_POST["tb_degree"];}else {echo "";}?>" /></td>
          <td width="120" height="30" align="right">پست الکترونیک :</td>
          <td width="156" height="30"><label for="tb_email"></label>
            <input name="tb_email" type="text" class="textbox" id="tb_email" value="<?php if (isset($_POST["tb_email"])){ echo $_POST["tb_email"];}else {echo "";}?>"/></td>
          <td align="center">&nbsp;</td>
          <td align="center"><input type="file" name="ff_pic" id="ff_pic" accept="image/jpeg" onChange="loadFile(event)" /></td>
          <script>
		  var loadFile = function(event){
			  var reader = new FileReader();
			  reader.onload = function(){
				  var output = document.getElementById('perpic');
				  output.src = reader.result;
			  };
			  reader.readAsDataURL(event.target.files[0]);
		  };
		  </script> 
        </tr>
      </table>
      <div id="cases"> <br/>
        <br/>
        <p>========================================================================================</p>
        <label>ثبت موارد</label>
        <p> >>>>>>>>>>>>>>>>>>>>>>>>>>>>> </p>
        <br/>
        <?php
         if(isset($_POST['tb_refuse']))
		 {
			unset($_POST);
			$counter = 1;
         } 
          if ($counter == 1) {?>
        <label id="lblall<?php echo $counter; ?>">مورد <?php echo $counter; ?></label>
        <p>****************************** </p>
        <table class="table" width="739" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="101">عنوان</td>
            <td width="638"><label id="lblsub<?php echo $counter; ?>" for="tb_sub<?php echo $counter; ?>"></label>
              <input  class="tb_sub" name="tb_sub<?php echo $counter; ?>" type="text" id="tb_sub<?php echo $counter; ?>" value="<?php if (isset($_POST["tb_sub".$counter])){echo $_POST["tb_sub".$counter];}?>" /></td>
          </tr>
          <tr>
            <td height="133">متن</td>
            <td valign="top"><p>&nbsp;</p>
              <textarea name="textarea<?php echo $counter; ?>" id="textarea<?php echo $counter; ?>" ></textarea>
              <script> 
						     CKEDITOR.replace( 'textarea<?php echo $counter; ?>' );
						 </script></td>
          </tr>
          <tr align="center" height="50">
            <td> پیوست ها</td>
            <td><input type="file" name="ff_ppic<?php echo $counter; ?>[]" id="ff_ppic<?php echo $counter; ?>" accept="image/jpeg" multiple/></td>
          </tr>
        </table>
        <?php
						$counter = $counter + 1;
	          }
			  else 
			  {
//======================================================ثبت موقت=============================================================================
				  if(isset($_POST['tb_temp']) or isset($_POST['tb_del']))
				  {			 
				  for ($x = 1 ; $x <= $counter ; $x++)
				   { 
				   ?>
        <label id="lblall<?php echo $x; ?>">مورد <?php echo $x; ?></label>
        <p>****************************** </p>
        <table class="table" width="739" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="101">عنوان</td>
            <td width="638"><label id="lblsub<?php echo $x; ?>" for="tb_sub<?php echo $x; ?>"></label>
              <input  class="tb_sub" name="tb_sub<?php echo $x; ?>" type="text" id="tb_sub<?php echo $x; ?>" value="<?php if (isset($_POST["tb_sub".$x])){ echo $_POST["tb_sub".$x];}?>" /></td>
          </tr>
          <tr>
            <td height="133">متن</td>
            <td valign="top"><p>&nbsp;</p>
              <textarea name="textarea<?php echo $x; ?>" id="textarea<?php echo $x; ?>" > 
						 <?php if (isset($_POST["textarea".$x])){echo $_POST["textarea".$x];} ?>
						 </textarea>
              <script> 
						      CKEDITOR.replace( 'textarea<?php echo $x; ?>');
						 </script></td>
          </tr>
          <tr align="center" height="50" >
            <td> پیوست ها</td>
            <td><?php
//=======================================================================================================================
			if(isset($_FILES['ff_ppic'.$x]))
			{				
     			  $total = count($_FILES['ff_ppic'.$x]['name']);
				  
  			         for ($i=0; $i<$total; $i++)
    					  {
								 $tmpFilePath = $_FILES['ff_ppic'.$x]['tmp_name'][$i];
								 if ($tmpFilePath != "") 
    								 {
										 $newFilePath = "images/temppic/".$_FILES['ff_ppic'.$x]['name'][$i];
										 $sql = "SELECT * FROM temppic WHERE `newaddr` = '".$newFilePath."' AND `counter` = '".$x."'";
							             $result =  mysqli_query($con , $sql);
                                         $result_num = mysqli_num_rows($result);
                                             if ($result_num <= 0) 
                        						   {
													 $sql = "INSERT INTO `temppic` (`counter`, `tempaddr`, `newaddr`) VALUES ('".$x."', '".$tmpFilePath."', '".$newFilePath."')";	
											         mysqli_query($con , $sql);
											         move_uploaded_file($tmpFilePath , $newFilePath);

												   }
									 }
						  }						  
			}
//=================================نمایش موارد انتخاب شده در صورت وجود در بانک============================================
			$sql = "SELECT * FROM temppic WHERE `counter` = '".$x."'";
							               $result =  mysqli_query($con , $sql);
                                           $result_num = mysqli_num_rows($result);
                                             if ($result_num > 0) 
                        						   {
													     foreach ($result as $row1)
							                              {
															   $newaddr = $row1["newaddr"];
															   $tp_id = $row1["id"];
															   $newaddr2 = substr($newaddr , 15);
															   //echo $newaddr2." ".'<a href="del.php?deltemppic='.$tp_id.'" target="new">حذف<a/>'."<br/>";  //$tp_id.">>>".
															   //echo $newaddr2." ".'<input type="submit" name="tb_del" value="حذف"/>'.'<br/>';
															   echo $newaddr2."<a href='javascript: deleteMe(".$tp_id.")'>حذف</a><br />";
                                                          }
												   }
//========================================================================================================================
			?>
              <script type="text/javascript">
  function deleteMe(id)
  {
	var answer = confirm("آیا می خواهید این مورد را حذف نمایید?");
	if (answer == true)
	{
		//window.location.href='del.php?deltemppic=' + id;
	
	  window.open(
	  'del.php?deltemppic=' + id,
	  '_blank',
	  'menubar=no,location=no,scrollbars=no,width=100,height=100,status=no,resizable=no,top=0,left=0,dependent=yes,alwaysRaised=yes' );
   }
}
</script>
              <input type="file" name="ff_ppic<?php echo $x; ?>[]" id="ff_ppic<?php echo $x; ?>" accept="image/jpeg" multiple /></td>
          </tr>
        </table>
        <?php	
					}
					if(isset($_POST['tb_temp'])){$counter = $counter + 1;}
			     } 
				  
			  }
      ?>
      </div>
      <div >
        <table width="784">
          <tr> <a name="hr" id="hr"></a>
            <td width="270" align="left"><input class="buttons" type="submit" name="tb_refuse" id="tb_refuse" value="انصراف" /></td>
            <td align="center" width="232"><input class="buttons" type="submit" name="tb_temp" id="tb_temp" value="ثبت موقت"/></td>
            <td align="right" width="266"><input class="buttons" type="submit" name="tb_final" id="tb_final" value="ثبت نهایی" /></td>
          </tr>
        </table>
      </div>
      <input type="hidden" name="my_counter" value= <?php echo $counter; ?>/>
    </form>
  </div>
  <div id="right">
    <ul>
      <li class="li"><a class="a" href="">ثبت گزارش</a></li>
      <li class="li"><a class="a" href="">اصلاح گزارش</a></li>
      <li class="li"><a class="a" href="">چاپ آخرین گزارش</a></li>
    </ul>
  </div>
</div>
<script>
 function showAlert()
  { 
    var name = document.getElementById("tb_name2").value;
	var family = document.getElementById("tb_family").value;
	if (name == "" && family == "") 
	{
	alert('درج نام و نام خانوادگی الزامی است!');
    return true;
	}
  }
</script>
</body>
</html>