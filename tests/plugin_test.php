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

use core_customfield_generator;

/**
 * Functional test for customfield_statictext
 *
 * @package   customfield_statictext
 * @copyright 2024 Catalyst IT
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class plugin_test extends \advanced_testcase {
    /** @var \core_customfield\category_controller */
    private $cfcat;
    /** @var \core_customfield\field_controller[] */
    private $cfields;
    /** @var \core_customfield\data_controller[] */

    /**
     * Tests set up.
     */
    public function setUp(): void {
        $this->resetAfterTest();

        $this->cfcat = $this->get_generator()->create_category();

        // The default value is an array with a text key, as the same data save by editor.
        $this->cfields[1] = $this->get_generator()->create_field(
            ['categoryid' => $this->cfcat->get('id'), 'shortname' => 'myfield1', 'type' => 'statictext',
                'configdata' => ['defaultvalue' => ['text' => "<h1>This is a static text field 1.</h1>"]]]);

        // There is no instance data for this field.
        // Create a user to test with.
        $this->setUser($this->getDataGenerator()->create_user());
    }

    /**
     * Get generator
     * @return core_customfield_generator
     */
    protected function get_generator() : core_customfield_generator {
        return $this->getDataGenerator()->get_plugin_generator('core_customfield');
    }

    /**
     * Test for initialising field and data controllers
     */
    public function test_initialise() {
        $f = \core_customfield\field_controller::create($this->cfields[1]->get('id'));
        $this->assertTrue($f instanceof field_controller);

        $f = \core_customfield\field_controller::create(0, (object)['type' => 'statictext'], $this->cfcat);
        $this->assertTrue($f instanceof field_controller);

        $d = \core_customfield\data_controller::create(0, null, $this->cfields[1]);
        $this->assertTrue($d instanceof data_controller);
    }

    /**
     * Test for configuration form functions
     *
     * Create a configuration form and submit it with the same values as in the field
     */
    public function test_config_form() {
        $this->setAdminUser();
        $submitdata = (array)$this->cfields[1]->to_record();
        $submitdata['configdata'] = $this->cfields[1]->get('configdata');

        $submitdata = \core_customfield\field_config_form::mock_ajax_submit($submitdata);
        $form = new \core_customfield\field_config_form(null, null, 'post', '', null, true,
            $submitdata, true);
        $form->set_data_for_dynamic_submission();
        $this->assertTrue($form->is_validated());
        $form->process_dynamic_submission();
    }

    /**
     * Test for data_controller::get_value and export_value
     */
    public function test_get_export_value() {
        // Field without data.
        $d = \core_customfield\data_controller::create(0, null, $this->cfields[1]);
        $this->assertEquals('<h1>This is a static text field 1.</h1>', $d->get_value());
        $this->assertEquals('<h1>This is a static text field 1.</h1>', $d->get_default_value());
        $this->assertEquals('<div class="text_to_html"><h1>This is a static text field 1.</h1></div>',
            $d->export_value());
    }

    /**
     * Deleting fields and data
     */
    public function test_delete() {
        $this->cfcat->get_handler()->delete_all();
    }
}
