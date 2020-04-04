<?php
	$user_detail = $this->db->get_where('user',array('user_id'=>$edit_user_id))->row();
?>
<div class="row">
    <div class="col-md-2"></div>
    <div class="col-md-8">
        <div class="panel panel-primary">
        	<div class="panel-heading">
				<div class="panel-title">
					<?php echo get_phrase('users'); ?>
				</div>
			</div>
            <div class="panel-body">
				<form method="post" action="<?php echo base_url();?>index.php?admin/user_edit/<?php echo $edit_user_id;?>">
					<div class="form-group mb-3">
	                    <label for="name">User's Name</label>
	                    <input type="text" class="form-control" id = "name" name="name" value="<?php echo $user_detail->name; ?>">
	                </div>

					<div class="form-group mb-3">
	                    <label for="email">User's Email</label>
	                    <input type="email" class="form-control" id = "email" name="email" value="<?php echo $user_detail->email; ?>">
					</div>

					<!-- IF ANY ACTIVE SUBSCRIPTION IS FOUND -->
					<?php
						if ( $this->crud_model->get_active_plan_of_user($edit_user_id) != false) {
							$current_plan_id			=	$this->crud_model->get_current_plan_id_custom($edit_user_id);
							$current_plan_name			=	$this->db->get_where('plan', array('plan_id'=> $current_plan_id))->row()->name;
							$current_plan_screens		=	$this->db->get_where('plan', array('plan_id'=> $current_plan_id))->row()->screens;
							$current_subscription_upto_timestamp
														=	$this->db->get_where('subscription', array('plan_id'=> $current_plan_id))->row()->timestamp_to;
						}
					?>
					<div class="form-group mb-3">
						<label for="email">User's Subscription</label>
						<select class="form-control" name="plan_id">
							<option class="form-control" value="0">No Subscription</option>
							<?php
								$plans = $this->crud_model->get_active_plans();
							
								foreach ($plans as $row):
							?>

								<option class="form-control" value="<?php echo $row['plan_id'];?>" <?php if($row['plan_id'] == $current_plan_id) { echo 'selected'; } ?>><?php echo $row['name'];?></option>							

							<?php endforeach;?>
						</select>
					</div>


					<div class="form-group">
						<input type="submit" class="btn btn-success" value="Update">
						<a href="<?php echo base_url();?>index.php?admin/user_list" class="btn btn-black">Go back</a>
					</div>
				</form>
            </div>
        </div>
    </div>
</div>
