$(document).ready(function () {
    'use strict';
    $('.testselect1').SumoSelect();
    $('.testselect2').SumoSelect();
    $('.optgroup_test').SumoSelect();
    $('.search_test').SumoSelect({
        search: true,
        searchText: 'Enter here.'
    });
    $('.select1').SumoSelect({okCancelInMulti: true, selectAll: true});
    $('.select2').SumoSelect({
        placeholder: 'Chọn tags từ khóa',
        captionFormat: '{0} từ khóa đã được chọn!',
        captionFormatAllSelected: '{0} từ khóa đã được chọn!',
        locale :  ['OK', 'Cancel', 'Chọn tất cả'],
        selectAll: true,
        search: true,
        searchText: 'Nhập từ vào đây.'
    });
});