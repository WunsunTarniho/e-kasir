$('#print').on('click', function() {
    let printArea = $('#print-area').html();

    let originalContent = $('body').html();

    $('body').html(printArea);

    window.print();

    $('body').html(originalContent);
})