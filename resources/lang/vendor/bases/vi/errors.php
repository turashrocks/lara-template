<?php
return [
    '401_title' => 'Bạn không có quyền truy cập trang này',
    '401_msg' => '<li>Bạn không được cấp quyền truy cập bởi quản trị viên.</li>
	                <li>Bạn sử dụng sai loại tài khoản.</li>
	                <li>Bạn không được cấp quyền để có thể truy cập trang này</li>',
    '404_title' => 'Không tìm thấy trang yêu cầu',
    '404_msg' => '<li>Trang bạn yêu cầu không tồn tại.</li>
	                <li>Liên kết bạn vừa nhấn không còn được sử dụng.</li>
	                <li>Trang này có thể đã được chuyển sang vị trí khác.</li>
	                <li>Có thể có lỗi xảy ra.</li>
	                <li>Bạn không được cấp quyền để có thể truy cập trang này</li>',
    '500_title' => 'Không thể tải trang',
    '500_msg' => '<li>Trang bạn yêu cầu không tồn tại.</li>
	                <li>Liên kết bạn vừa nhấn không còn được sử dụng.</li>
	                <li>Trang này có thể đã được chuyển sang vị trí khác.</li>
	                <li>Có thể có lỗi xảy ra.</li>
	                <li>Bạn không được cấp quyền để có thể truy cập trang này</li>',
    'reasons' => 'Điều này có thể xảy ra vì nhiều lý do.',
    'try_again' => 'Vui lòng thử lại trong vài phút, hoặc quay trở lại trang chủ bằng cách <a href="' . route('dashboard.index') . '"> nhấn vào đây </a>.',
    'home_try_again' => 'Vui lòng thử lại trong vài phút, hoặc quay trở lại trang chủ bằng cách <a href="' . route('public.index') . '"> nhấn vào đây </a>.',
];
