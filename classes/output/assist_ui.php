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

namespace aiplacement_exaaichat\output;

use aiplacement_exaaichat\utils;
use block_exaaichat\output;
use core\hook\output\after_http_headers;

/**
 * Output handler for the course assist AI Placement.
 *
 * @package    aiplacement_exaaichat
 * @copyright  2025 GTN Solutions https://gtn-solutions.com
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class assist_ui {
    /**
     * Determine if we should be loading a single button or a dropdown.
     *
     * @param after_http_headers $hook
     */
    public static function chat_content_handler(after_http_headers $hook): void {
        // Preflight checks.
        if (!self::preflight_checks()) {
            return;
        }

        $hook->add_html(output::render_aiplacement_content());
    }

    /**
     * Preflight checks to determine if the assist UI should be loaded.
     *
     * @return bool
     */
    private static function preflight_checks(): bool {
        global $PAGE;

        if (during_initial_install()) {
            return false;
        }
        if (!get_config('aiplacement_exaaichat', 'version')) {
            return false;
        }
        if (in_array($PAGE->pagelayout, ['maintenance', 'print', 'redirect', 'embedded'])) {
            // Do not try to show assist UI inside iframe, in maintenance mode,
            // when printing, or during redirects.
            return false;
        }
        // Check we are in the right context, exit if not activity.
        if ($PAGE->context->contextlevel != CONTEXT_MODULE && $PAGE->context->contextlevel != CONTEXT_COURSE) {
            return false;
        }

        // don't show the chat on the block config page
        if (preg_replace('!\?.*!', '', $PAGE->url->out_as_local_url(false)) == '/course/view.php' && $PAGE->url->get_param('bui_editid')) {
            return false;
        }

        // Check if the user has permission to use the AI service.
        return utils::is_course_assist_available();
    }
}
