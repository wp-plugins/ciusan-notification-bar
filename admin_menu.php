<?php function CiusanNotificationBar_Settings() { global $options; $options = get_option('ciusan_notification_bar'); ?>
<form method="post" id="mainform" action="">
<table class="ciusan-plugin widefat" style="margin-top:50px;">
	<thead>
		<tr>
			<th scope="col">Settings</th>
			<th scope="col">&nbsp;</th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td class="titledesc">Show Notification Bar</td>
			<td class="forminp">
				<select name="CNB_Showing" id="CNB_Showing" style="min-width:125px;">
					<?php if ($options[CNB_Showing] == 'yes'){ ?>
						<option value="yes" selected="selected">Yes</option>
						<option value="no">No</option>
					<?php } else { ?>
						<option value="yes">Yes</option>
						<option value="no" selected="selected">no</option>
					<?php } ?>
				</select>
			</td>
		</tr><tr>
			<td class="titledesc">Fixed</td>
			<td class="forminp">
				<select name="CNB_FixedBar" id="CNB_FixedBar" style="min-width:125px;">
					<?php if ($options[CNB_FixedBar] == ''){ ?>
						<option value="" selected="selected">Please Select</option>
						<option value="yes">Yes</option>
						<option value="no">no</option>
					<?php } else if ($options[CNB_FixedBar] == 'yes'){ ?>
						<option value="">Please Select</option>
						<option value="yes" selected="selected">Yes</option>
						<option value="no">no</option>
					<?php } else if ($options[CNB_FixedBar] == 'no'){ ?>
						<option value="">Please Select</option>
						<option value="yes">Yes</option>
						<option value="no" selected="selected">no</option>
					<?php } else { ?>
						<option value="" selected="selected">Please Select:</option>
						<option value="yes">Yes</option>
						<option value="no">no</option>
					<?php } ?>
				</select>
			</td>
		</tr>
	</tbody>
</table><table id="CNB" class="ciusan-plugin CNB_Hidden widefat" style="margin-top:25px;">
	<thead>
		<tr>
			<th scope="col">Body Content</th>
			<th scope="col">&nbsp;</th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td class="titledesc">Messages</td>
			<td class="forminp">
				<?php wp_editor($options[CNB_Content],'CNB_Content',$settings=array('media_buttons'=>false,'textarea_rows'=>5,'teeny'=>true,) ); ?>
			</td>
		</tr></tr>
			<td class="titledesc">Button Name</td>
			<td class="forminp">
				<input name="CNB_BName" id="CNB_BName" style="width:250px;" value="<?php echo $options[CNB_BName]; ?>" type="text" class="required" placeholder="eg: &quot;Get Now!&quot;">
			</td>
		<tr></tr>
			<td class="titledesc">Button Link</td>
			<td class="forminp">
				<input name="CNB_BLink" id="CNB_BLink" style="width:250px;" value="<?php echo $options[CNB_BLink]; ?>" type="text" class="required" placeholder="please use: &quot;http://&quot;">
			</td>
		<tr>
	</tbody>
</table>
<input type="hidden" name="action" value="update" />
<input type="hidden" name="page_options" value="<?php get_option($options) ?>" />
<p class="submit"><input type="submit" name="save" id="submit" class="button button-primary" value="Save Changes"/></p>
</form>
</div>

<?php } ?>