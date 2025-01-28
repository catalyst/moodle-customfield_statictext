<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

namespace customfield_statictext;

/**
 * Class field
 *
 * @package customfield_statictext
 * @copyright 2024 Catalyst IT
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class field_controller extends \core_customfield\field_controller {
    /**
     * Type of plugin data
     */
    const TYPE = 'text';

    /**
     * Add fields for editing a date field.
     *
     * @param \MoodleQuickForm $mform
     */
    public function config_form_definition(\MoodleQuickForm $mform) {
        $config = $this->get('configdata');

        // Add headers.
        $mform->addElement('header', 'header_specificsettings', get_string('specificsettings', 'customfield_statictext'));
        $mform->setExpanded('header_specificsettings');

        // Add default value - make it as static text.
        $mform->addElement('editor', 'configdata[defaultvalue]', get_string('text', 'customfield_statictext'));
        $mform->setType('configdata[defaultvalue]', PARAM_RAW);

        // Add yes/no select config to show label or not.
        $mform->addElement('selectyesno', 'configdata[showlabel]',
            get_string('showlabel', 'customfield_statictext'));
        $mform->setDefault('configdata[showlabel]', $config['showlabel'] ?? 1);
        $mform->addHelpButton('configdata[showlabel]', 'showlabel', 'customfield_statictext');

        // Make it required.
        $mform->addRule('configdata[defaultvalue]', null, 'required');
    }

    /**
     * Does this custom field type support being used as part of the block_myoverview
     * custom field grouping?
     * @return bool
     */
    public function supports_course_grouping(): bool {
        return true;
    }

    /**
     * If this field supports course grouping, then this function needs overriding to
     * return the formatted values for this.
     * @param array $values the used values that need formatting
     * @return array
     */
    public function course_grouping_format_values($values): array {
        $ret = [];
        foreach ($values as $value) {
            $ret[$value] = format_string($value);
        }
        $ret[BLOCK_MYOVERVIEW_CUSTOMFIELD_EMPTY] = get_string('nocustomvalue', 'block_myoverview',
            $this->get_formatted_name());
        return $ret;
    }

    /**
     * Return the name of the field where the information is stored
     *
     * @return string
     */
    public function get_formatted_name() : string {
        $config = $this->get('configdata');
        // Return empty string if we don't want to show label.
        if ($config['showlabel'] == 0) {
            return '';
        }
        return parent::get_formatted_name();
    }
}
