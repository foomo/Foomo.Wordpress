<?php

/*
 * This file is part of the foomo Opensource Framework.
 *
 * The foomo Opensource Framework is free software: you can redistribute it
 * and/or modify it under the terms of the GNU Lesser General Public License as
 * published  by the Free Software Foundation, either version 3 of the
 * License, or (at your option) any later version.
 *
 * The foomo Opensource Framework is distributed in the hope that it will
 * be useful, but WITHOUT ANY WARRANTY; without even the implied warranty
 * of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public License along with
 * the foomo Opensource Framework. If not, see <http://www.gnu.org/licenses/>.
 */

namespace Foomo\Wordpress\Settings;

/**
 * @link www.foomo.org
 * @license www.gnu.org/licenses/lgpl.txt
 * @author franklin <franklin@weareinteractive.com>
 */
class Toolkit extends \Foomo\Wordpress\Settings\AbstractSetting
{
	//---------------------------------------------------------------------------------------------
	// ~ Constants
	//---------------------------------------------------------------------------------------------

	const ID = 'foomo-toolkit';
	const NAME = 'Foomo Toolkit';
	const TITLE = 'Foomo Toolkit';

	//---------------------------------------------------------------------------------------------
	// ~ Public methods
	//---------------------------------------------------------------------------------------------

    /**
     * Registeres the menu
     */
	public function init()
    {
		register_setting(self::getId(), self::getId(), array(&$this, 'validate'));

		$adminSection = \Foomo\Wordpress\Settings\Section::create('foomo-toolkit-admin', self::ID, __('Admin Settings'));
		$adminSection->addSettingsField('disableCoreUpdates', __('Disable Core Updates'), array(&$adminSection, 'input_checkbox'));
		$adminSection->addSettingsField('disablePluginUpdates', __('Disable Plugin Updates'), array(&$adminSection, 'input_checkbox'));
		$adminSection->addToMetaBox();

		$editorSection = \Foomo\Wordpress\Settings\Section::create('foomo-toolkit-editor', self::ID, __('Shortcode Settings'));
		$editorSection->addSettingsField('enableShortcodeFoomoRun', __('Enable: foomo_run'), array(&$adminSection, 'input_checkbox'));
		$editorSection->addSettingsField('enableShortcodeGithub', __('Enable: github'), array(&$adminSection, 'input_checkbox'));
		$editorSection->addSettingsField('enableShortcodeGist', __('Enable: gist'), array(&$adminSection, 'input_checkbox'));
		$editorSection->addSettingsField('enableShortcodeGeshi', __('Enable: geshi'), array(&$adminSection, 'input_checkbox'));
		$editorSection->addSettingsField('enableShortcodeBbcode', __('Enable: bbcode'), array(&$adminSection, 'input_checkbox'));
		$editorSection->addSettingsField('enableShortcodeYoutube', __('Enable: youtube'), array(&$adminSection, 'input_checkbox'));
		$editorSection->addSettingsField('enableShortcodeGvideo', __('Enable: gvideo'), array(&$adminSection, 'input_checkbox'));
		$editorSection->addSettingsField('enableShortcodeVimeo', __('Enable: vimeo'), array(&$adminSection, 'input_checkbox'));
		$editorSection->addToMetaBox();
	}


	/**
	 * @param mixd $input
	 * @return mixed
	 */
	public function validate($input)
	{
		$options = array();
		$options['disableCoreUpdates'] = (isset($input['disableCoreUpdates']) && $input['disableCoreUpdates'] == 'on');
		$options['disablePluginUpdates'] = (isset($input['disablePluginUpdates']) && $input['disablePluginUpdates'] == 'on');
		$options['enableShortcodeFoomoRun'] = (isset($input['enableShortcodeFoomoRun']) && $input['enableShortcodeFoomoRun'] == 'on');
		$options['enableShortcodeGithub'] = (isset($input['enableShortcodeGithub']) && $input['enableShortcodeGithub'] == 'on');
		$options['enableShortcodeGist'] = (isset($input['enableShortcodeGist']) && $input['enableShortcodeGist'] == 'on');
		$options['enableShortcodeGeshi'] = (isset($input['enableShortcodeGeshi']) && $input['enableShortcodeGeshi'] == 'on');
		$options['enableShortcodeBbcode'] = (isset($input['enableShortcodeGeshi']) && $input['enableShortcodeGeshi'] == 'on');
		$options['enableShortcodeYoutube'] = (isset($input['enableShortcodeYoutube']) && $input['enableShortcodeYoutube'] == 'on');
		$options['enableShortcodeGvideo'] = (isset($input['enableShortcodeGvideo']) && $input['enableShortcodeGvideo'] == 'on');
		$options['enableShortcodeVimeo'] = (isset($input['enableShortcodeVimeo']) && $input['enableShortcodeVimeo'] == 'on');
		return $options;
	}

	//---------------------------------------------------------------------------------------------
	// ~ Public static methods
	//---------------------------------------------------------------------------------------------

	/**
	 *
	 * @return type
	 */
	public static function setDefaults()
	{
		if (get_option(self::ID) != false) return;
		update_option(\Foomo\Wordpress\Settings\Toolkit::ID, array(
			'disableCoreUpdates' => true,
			'disablePluginUpdates' => true,
			'enableShortcodeFoomoRun' => false,
			'enableShortcodeGithub' => false,
			'enableShortcodeGist' => false,
			'enableShortcodeGeshi' => false,
			'enableShortcodeBbcode' => false,
			'enableShortcodeYoutube' => false,
			'enableShortcodeGvideo' => false,
			'enableShortcodeVimeo' => false,
		));
	}
}