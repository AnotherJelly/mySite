$(function() {
    $('#admin-select-all-checkbox').on('change', function() {
        if ($(this).prop('checked') == true) {
            $('.admin-element-checkbox').each(function() {
                $(this).prop('checked', true);
            });
        }
        else {
            $('.admin-element-checkbox').each(function() {
                $(this).prop('checked', false);
            });
        }
    });

    $('#admin-button-download').on('click', function() {
        $('.admin-element-checkbox:checked').each(function() {
            download($(this).attr('data-file-name'));
        });
    });

    function download(filename) {
        const a = document.createElement('a');
        a.download = filename;
        a.href = '/mysite/images/serverfile/' + filename + '.png';
        a.style.display = 'none';
        document.body.appendChild(a);
        a.click();
        document.body.removeChild(a);
    }
});