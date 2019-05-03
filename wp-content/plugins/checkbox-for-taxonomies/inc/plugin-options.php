<div class="wrap">
	<!-- Display Header, and Description -->
	<style scoped="scoped">
		fieldset {
			font-size: 1.5em;
			margin: 1em 0 .5em;
		}
	</style>

	<h2><?php _e( 'Checkbox for Taxonomies', 'checkbox-for-taxonomies' ); ?></h2>

	<!-- Beginning of the Plugin Options Form -->
	<form method="post" action="<?php echo admin_url( 'options.php' ); ?>">
		<?php settings_fields( 'checkbox_for_taxonomies_options' ); ?>
		<?php $options = get_option( 'checkbox_for_taxonomies_options' ); ?>

		<fieldset>
			<legend><?php esc_html_e( 'Select taxonomies to convert to checkbox', 'checkbox-for-taxonomies' ); ?></legend>

			<?php
			$taxonomies = checkbox_s_for_Taxonomies()->get_all_taxonomies();

			if ( ! empty ( $taxonomies ) ) {

				foreach ( $taxonomies as $i => $taxonomy ) {
					$checked = checked(
						isset( $options[ 'taxonomies' ] ) && is_array( $options[ 'taxonomies' ] ) && in_array( $i, $options[ 'taxonomies' ] ),
						1,
						false
					);
					$id = "rbt_$i";
					?>
					<p>
						<label for="<?php echo $id; ?>">
							<input type="checkbox"
								   name="checkbox_for_taxonomies_options[taxonomies][]"
								   value="<?php echo $i; ?>" <?php echo $checked; ?>
								   id="<?php echo $id; ?>"/>
							<?php printf( '%s <small>(%s)</small>', $taxonomy->labels->name, $i ); ?>
						</label>
					</p>
				<?php
				}
			}
			?>
		</fieldset>
		<fieldset>
			<legend><?php esc_html_e( 'Options', 'checkbox-for-taxonomies' ); ?></legend>
			<p>
				<label for="rbt_delete">
					<input type="checkbox"
						   name="checkbox_for_taxonomies_options[delete]"
						   id="rbt_delete"
						   value="1" <?php checked( ! empty ( $options[ 'delete' ] ), 1 ); ?> />
					<?php esc_html_e( 'Completely remove options on plugin removal', 'checkbox-for-taxonomies' ); ?>
				</label>
			</p>
		</fieldset>

		<p class="submit">
			<input type="submit" class="button-primary"
				   value="<?php _e( 'Save Changes', 'checkbox-for-taxonomies' ) ?>"/>
		</p>
	</form>
</div>