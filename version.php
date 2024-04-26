<?php
// This file is part of the Contact Form plugin for Moodle - https://moodle.org/
//
// Contact Form is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Contact Form is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Contact Form.  If not, see <https://www.gnu.org/licenses/>.

/**
 * Version information for Contact Form (also called Contact).
 *
 * @package    local_contact
 * @copyright  2016-2024 TNG Consulting Inc. - {@link https://www.tngconsulting.ca/}
 * @author     Michael Milette
 * @license    https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

$plugin->version   = 2024042600;        // The current module version (Date: YYYYMMDDXX).
$plugin->requires  = 2015111600;        // Requires Moodle version 3.0.
$plugin->component = 'local_contact';   // To check on upgrade, that module sits in correct place.
$plugin->release   = '1.4.0';
$plugin->maturity  = MATURITY_STABLE;
$plugin->cron      = 0;
