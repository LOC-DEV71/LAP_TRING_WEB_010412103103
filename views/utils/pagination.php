<?php
/**
 * Pagination Utility - Tái sử dụng cho mọi trang trong Admin
 *
 * Cách dùng (trong Controller):
 *   [$items, $pagination] = paginate($allItems, $perPage, $currentPage);
 *
 * Cách dùng (trong View):
 *   <?php require_once __DIR__ . '/../../../utils/pagination.php'; ?>
 *   <?= render_pagination($pagination, url('admin/products'), $_GET) ?>
 */

/**
 * Tính toán pagination từ mảng dữ liệu.
 * Trả về [$slicedItems, $paginationMeta]
 *
 * @param array  $items       Toàn bộ dữ liệu
 * @param int    $perPage     Số item mỗi trang
 * @param int    $currentPage Trang hiện tại
 * @return array [$slicedItems, $meta]
 */
if (!function_exists('paginate')) {
    function paginate(array $items, int $perPage = 10, int $currentPage = 1): array
    {
        $total       = count($items);
        $totalPages  = max(1, (int) ceil($total / $perPage));
        $currentPage = max(1, min($currentPage, $totalPages));
        $offset      = ($currentPage - 1) * $perPage;

        $sliced = array_slice($items, $offset, $perPage);

        $meta = [
            'total'       => $total,
            'perPage'     => $perPage,
            'currentPage' => $currentPage,
            'totalPages'  => $totalPages,
            'from'        => $total > 0 ? $offset + 1 : 0,
            'to'          => min($offset + $perPage, $total),
        ];

        return [$sliced, $meta];
    }
}

/**
 * Tính toán pagination trực tiếp từ DB (dùng khi đã query với LIMIT/OFFSET).
 *
 * @param int $total       Tổng số bản ghi (COUNT query)
 * @param int $perPage     Số item mỗi trang
 * @param int $currentPage Trang hiện tại
 * @return array $meta
 */
if (!function_exists('paginate_meta')) {
    function paginate_meta(int $total, int $perPage = 10, int $currentPage = 1): array
    {
        $totalPages  = max(1, (int) ceil($total / $perPage));
        $currentPage = max(1, min($currentPage, $totalPages));
        $offset      = ($currentPage - 1) * $perPage;

        return [
            'total'       => $total,
            'perPage'     => $perPage,
            'currentPage' => $currentPage,
            'totalPages'  => $totalPages,
            'offset'      => $offset,
            'from'        => $total > 0 ? $offset + 1 : 0,
            'to'          => min($offset + $perPage, $total),
        ];
    }
}

/**
 * Render HTML cho thanh pagination.
 *
 * Logic 5-button sliding window:
 *   - Luôn hiện tối đa 5 nút trang
 *   - Khi trang hiện tại ở giữa (vị trí 3 trong 5 nút), cửa sổ trượt
 *     VD: trang 1-3 → hiện 1-5 | trang 4 → 2-6 | trang 5 → 3-7
 *
 * @param array  $meta       Mảng meta từ paginate() hoặc paginate_meta()
 * @param string $baseUrl    URL cơ sở (không có query string)
 * @param array  $queryParams Các query params hiện tại (từ $_GET), page sẽ bị ghi đè
 * @return string HTML
 */
if (!function_exists('render_pagination')) {
    function render_pagination(array $meta, string $baseUrl, array $queryParams = []): string
    {
        if ($meta['totalPages'] <= 1) return '';

        $current    = $meta['currentPage'];
        $total      = $meta['totalPages'];
        $windowSize = 5;

        // --- Tính sliding window ---
        // current <= 3          → start = 1 (current ở vị trí 1, 2, 3)
        // current > 3           → start = current - 2 (current luôn ở vị trí 3 - giữa)
        // Nhưng không vượt quá max start = total - windowSize + 1
        $start = max(1, min($current - 2, $total - $windowSize + 1));
        $end   = min($total, $start + $windowSize - 1);

        // Build query string helper
        $buildUrl = function(int $page) use ($baseUrl, $queryParams): string {
            $params = array_merge($queryParams, ['page' => $page]);
            unset($params['page']);
            $qs = http_build_query(array_filter(array_merge($params, ['page' => $page])));
            return $baseUrl . '?' . $qs;
        };

        $btnBase = 'display:inline-flex;align-items:center;justify-content:center;'
                 . 'width:36px;height:36px;border-radius:8px;font-size:13px;font-weight:600;'
                 . 'text-decoration:none;border:1px solid #e5e7eb;transition:all .15s;cursor:pointer;';
        $btnNormal  = $btnBase . 'background:#fff;color:#374151;';
        $btnActive  = $btnBase . 'background:#2563eb;color:#fff;border-color:#2563eb;';
        $btnDisabled = $btnBase . 'background:#f9fafb;color:#d1d5db;cursor:not-allowed;pointer-events:none;';

        $html = '<div style="display:flex;align-items:center;justify-content:between;gap:8px;margin-top:20px;padding:0 2px;">';

        // --- Info text ---
        $html .= '<span style="font-size:13px;color:#6b7280;flex:1;">'
               . 'Hiển thị <b>' . $meta['from'] . '</b>–<b>' . $meta['to'] . '</b>'
               . ' / <b>' . $meta['total'] . '</b> sản phẩm</span>';

        $html .= '<div style="display:flex;gap:4px;">';

        // --- Prev button ---
        if ($current > 1) {
            $html .= '<a href="' . $buildUrl($current - 1) . '" style="' . $btnNormal . '">'
                   . '<span class="material-symbols-outlined" style="font-size:18px;">chevron_left</span></a>';
        } else {
            $html .= '<span style="' . $btnDisabled . '">'
                   . '<span class="material-symbols-outlined" style="font-size:18px;">chevron_left</span></span>';
        }

        // --- First page + ellipsis ---
        if ($start > 1) {
            $html .= '<a href="' . $buildUrl(1) . '" style="' . $btnNormal . '">1</a>';
            if ($start > 2) {
                $html .= '<span style="' . $btnDisabled . 'border:none;">…</span>';
            }
        }

        // --- Page buttons ---
        for ($i = $start; $i <= $end; $i++) {
            $style = ($i === $current) ? $btnActive : $btnNormal;
            $html .= '<a href="' . $buildUrl($i) . '" style="' . $style . '">' . $i . '</a>';
        }

        // --- Last page + ellipsis ---
        if ($end < $total) {
            if ($end < $total - 1) {
                $html .= '<span style="' . $btnDisabled . 'border:none;">…</span>';
            }
            $html .= '<a href="' . $buildUrl($total) . '" style="' . $btnNormal . '">' . $total . '</a>';
        }

        // --- Next button ---
        if ($current < $total) {
            $html .= '<a href="' . $buildUrl($current + 1) . '" style="' . $btnNormal . '">'
                   . '<span class="material-symbols-outlined" style="font-size:18px;">chevron_right</span></a>';
        } else {
            $html .= '<span style="' . $btnDisabled . '">'
                   . '<span class="material-symbols-outlined" style="font-size:18px;">chevron_right</span></span>';
        }

        $html .= '</div></div>';

        return $html;
    }
}
