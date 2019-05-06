<?php

namespace IRMA\WP\GravityForms;

use GFAddOn;

class IrmaAddOn extends GFAddOn
{
	protected $_version = IRMA_WP_VERSION;
	protected $_min_gravityforms_version = '1.9';
	protected $_slug = 'irma-addon';
	protected $_path = 'irma-wp/plugin.php';
	protected $_full_path = __FILE__;
	protected $_title = 'GravityForms IRMA Add-On';
	protected $_short_title = 'IRMA Add-On';

	private static $_instance = null;

	public static function get_instance()
	{
		if (self::$_instance == null) {
			self::$_instance = new self();
		}

		return self::$_instance;
	}

	public function init_admin()
	{
		parent::init_admin();
		// add_filter('gform_tooltips', [$this, 'tooltips']);
		add_action('gform_field_standard_settings', [$this, 'field_appearance_settings'], 10, 2);
		add_action('gform_editor_js', [$this, 'editor_script']);
	}

	/**
	 * Add the custom setting to the appearance tab.
	 *
	 * @param int $position The position the settings should be located at.
	 * @param int $formId The ID of the form currently being edited.
	 */
	public function field_appearance_settings($position, $formId)
	{
		if ($position == 350) {
			?>
		<li class="irma_attribute field_setting">
			<label class="section_label" for="irma_attribute_list_label">
				<?php esc_html_e('IRMA Attribute', 'irma-wp'); ?>
				<?php gform_tooltip('irma_attributes') ?>
			</label>
			<div class="irma_attribute_list">
				<input type="text" class="irma_attribute_field" onchange="SetFieldProperty('irmaAttribute', this.value);" />
			</div>
		</li>
	<?php
}
}

public function editor_script()
{
	?>
	<script type='text/javascript'>
		fieldSettings["IRMA-attribute"] += ', .irma_attribute';

		jQuery(document).bind("gform_load_field_settings", function(event, field, form) {
			setTimeout(function() {
				jQuery("#field_" + field.id + " .irma_attribute_field").val(field["irmaAttribute"]);
			}, 0);
		});
	</script>
<?php
}
}