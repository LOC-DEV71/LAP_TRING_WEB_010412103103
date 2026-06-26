<?php
/**
 * UI Utilities - Tái sử dụng các thành phần giao diện
 */

if (!function_exists('ui_toast_error')) {
    function ui_toast_error($message) {
        if (empty($message)) return '';
        return "
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                if (typeof showToast === 'function') {
                    showToast('" . addslashes($message) . "', 'error');
                }
            });
        </script>
        ";
    }
}

if (!function_exists('ui_toast_success')) {
    function ui_toast_success($message) {
        if (empty($message)) return '';
        return "
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                if (typeof showToast === 'function') {
                    showToast('" . addslashes($message) . "', 'success');
                }
            });
        </script>
        ";
    }
}

if (!function_exists('ui_alert_error')) {
    function ui_alert_error($message) {
        if (empty($message)) return '';
        return '
        <div class="ui-alert ui-alert-error" style="background: rgba(215, 0, 24, 0.15); backdrop-filter: blur(12px); -webkit-backdrop-filter: blur(12px); border: 1px solid rgba(215, 0, 24, 0.2); border-left: 4px solid #d70018; color: #d70018; padding: 14px 18px; border-radius: 12px; display: flex; align-items: center; gap: 10px; margin-bottom: 20px; font-size: 14.5px; box-shadow: 0 4px 15px rgba(0,0,0,0.05);">
            <span class="material-symbols-outlined" style="font-size: 22px; color: #d70018;">error</span>
            <span style="font-weight: 500; letter-spacing: 0.3px;">' . htmlspecialchars($message) . '</span>
        </div>';
    }
}

if (!function_exists('ui_alert_success')) {
    function ui_alert_success($message) {
        if (empty($message)) return '';
        return '
        <div class="ui-alert ui-alert-success" style="background: rgba(46, 204, 113, 0.15); backdrop-filter: blur(12px); -webkit-backdrop-filter: blur(12px); border: 1px solid rgba(46, 204, 113, 0.2); border-left: 4px solid #2ecc71; color: #111111; padding: 14px 18px; border-radius: 12px; display: flex; align-items: center; gap: 10px; margin-bottom: 20px; font-size: 14.5px; box-shadow: 0 4px 15px rgba(0,0,0,0.05);">
            <span class="material-symbols-outlined" style="font-size: 22px; color: #2ecc71;">check_circle</span>
            <span style="font-weight: 500; letter-spacing: 0.3px;">' . htmlspecialchars($message) . '</span>
        </div>';
    }
}
