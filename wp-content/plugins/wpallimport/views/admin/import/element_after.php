<form class="choose-elements no-enter-submit" method="post">
<h2><?php _e('Import XML/CSV - Step 2: Select Elements', 'pmxi_plugin') ?></h2>

<h3><?php _e('<b>Double-click on an element below to select it and its siblings.</b>', 'pmxi_plugin') ?></h3>

<div class="ajax-console">
	<?php if ($this->errors->get_error_codes()): ?>
		<?php $this->error() ?>
	<?php endif ?>
</div>
<table class="layout">
	<tr>
		<td class="left">
			<fieldset class="widefat">
				<legend>Current XML tree</legend>
				<div class="action_buttons">
					<a href="javascript:void(0);" id="prev_element" class="ui-button ui-widget ui-state-default ui-corner-all ui-button-text-only large_button" style="float:left;">&lang;&lang;</a>
					<a href="javascript:void(0);" id="next_element" class="ui-button ui-widget ui-state-default ui-corner-all ui-button-text-only large_button" style="float:left; margin-right:15px;">&rang;&rang;</a>
					<div style="float:left;">
						<span style="font-size:18px; padding-top:15px; float:left; margin-right:10px;">Go to: </span><input type="text" id="goto_element" value="1"/>
					</div>
				</div>
				<div class="xml" style="min-height:400px;">
					<?php //$this->render_xml_element($dom->documentElement) ?>
				</div>
			</fieldset>
		</td>
		<td class="right">
			<fieldset class="widefat">
				<legend>Advanced</legend>
				<p>Current XPath:</p>
				<div>
					<input type="text" name="xpath" value="<?php echo esc_attr($post['xpath']) ?>" style="max-width:none;" />					
					<input type="hidden" id="root_element" name="root_element" value="<?php echo $_SESSION['pmxi_import']['source']['root_element']; ?>"/>
					<?php
					if (!empty($elements_cloud)){
						?>
						&nbsp; <br/><label>What element are you looking for?</label>&nbsp; <br/>
						<?php
						$root_elements = array();
						foreach ($elements_cloud as $tag => $count) 						
							$root_elements[] = '<a href="javascript:void(0);" rel="'. $tag .'" class="change_root_element">' . $tag . '</a>';						
						echo implode(', ', $root_elements);
					}
					?>
					&nbsp; <br/><br/>or <a href="javascript:void(0);" rel="<?php echo esc_attr($post['xpath']) ?>" root="<?php echo $_SESSION['pmxi_import']['source']['root_element']; ?>" id="get_default_xpath">get default xPath</a>
				</div> <br><br>				
				<a href="http://www.w3schools.com/xpath/default.asp" target='_blank'>XPath Tutorial</a> - For further help, <a href="http://www.wpallimport.com/support" target='_blank'>contact us</a>.
			</fieldset>
			<p class="submit-buttons" style="text-align:right;">
				<a href="<?php echo $this->baseUrl ?>" class="back">Back</a>
				&nbsp;
				<input type="hidden" name="is_submitted" value="1" />
				<?php wp_nonce_field('choose-elements', '_wpnonce_choose-elements') ?>
				<input type="submit" class="ui-button ui-widget ui-state-default ui-corner-all ui-button-text-only large_button" value="<?php _e('Next', 'pmxi_plugin') ?>" />
			</p>
		</td>
	</tr>
</table>
</form>
