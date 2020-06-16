
<?php
include'dbconnection.php';
// checking session is valid for not 
if (strlen($_SESSION['id']==0)) {
  header('location:logout.php');
  } else{

// for deleting user
if(isset($_GET['id']))
{
$adminid=$_GET['id'];
$msg=mysqli_query($con,"DELETE FROM user where id='$adminid'");
if($msg)
{
echo "<script>alert('Data deleted');
window.location.href='index.php';
</script>";
}

}
}
?>
<!-- Generate report pane starts -->
<div role="tabpanel" class="tab-pane unactive" id="user-type">
  <section id="container" >        
      </aside>
      <section id="main-content">
          <section class="wrapper">
		<div class="col-md-12">
            <div class="content-panel">
				<table class="table table-striped table-advance table-hover">
          			<h4><p style=" text-align: center;;
	text-transform: uppercase;
	background: linear-gradient(to right, #30CFD0 0%, red 30%, purple 50%, green 75%, pink 100%);-webkit-background-clip:text;-webkit-text-fill-color: transparent;}"> -- All User Details --</p> </h4>
					<hr>       	             
          	            <thead>
                        <tr>
                             <th>id</th>
                             <th class="hidden-phone">First Name</th>
                             <th> Last Name</th>
                             <th> E-mail</th>
                             <th> Phone Number</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php $ret=mysqli_query($con,"SELECT * from user");
						  $cnt=1;
					  while($row=mysqli_fetch_array($ret))
							  {?>
                              <tr>
                              <td><?php echo $cnt;?></td>
                                  <td><?php echo $row['first_name'];?></td>
                                  <td><?php echo $row['last_name'];?></td>
                                  <td><?php echo $row['email'];?></td>
                                  <td><?php echo $row['phone_number'];?></td>
                                  
                                  <td>
                                     
                                     <a href="index.php?id=<?php echo $row['id'];?>"> 
                                     <button class="btn btn-danger btn-xs" onClick="return confirm('Do you really want to delete');">DELETE  <i class="fa fa-trash-o" style="font-size:24px"></i></button></a>
                                  
                                  </td>
                              </tr>
                              <?php $cnt=$cnt+1; }?>
                             
                              </tbody>
                          </table>
                      </div>

                  </div>
              </div>


		</section>
      </section
  ></section>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</div>