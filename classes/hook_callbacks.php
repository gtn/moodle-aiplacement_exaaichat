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

namespace aiplacement_exaaichat;

use core\hook\output\after_http_headers;

/**
 * Hook callbacks for the course assist AI Placement.
 *
 * @package    aiplacement_exaaichat
 * @copyright  2025 GTN Solutions https://gtn-solutions.com
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class hook_callbacks {
    /**
     * Bootstrap the action buttons.
     *
     * @param after_http_headers $hook
     */
    public static function after_http_headers(after_http_headers $hook): void {
        \aiplacement_exaaichat\output\assist_ui::chat_content_handler($hook);
    }
}
