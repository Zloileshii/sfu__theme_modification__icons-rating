/**
* Отменяет клик если было перетаскивание
* Для десктопной версии
*/

$('body').mousedown(function (e) {
    // координата при нажатии на клавишу мыши
    d = e.pageX;
    $(this).mouseup(function (e) {
        // координата при отпускании клавиши мыши
        u = e.pageX;
        if (d != u) {
            $('.block-icons__item').click(function (e) {
                // отмена действия ссылки по умолчанию
                e.preventDefault();
            })
        }
    })
    // отмена отмены действия ссылки по умолчанию
    $('.block-icons__item').unbind('click');
})

/**
 * Поведение теней
 * Улучшенный вариант с маркерами
 */

function shadows() {
    let ml = $('#ml').position().left;
    // $('#oml').text(ml);

    let mr = $('#mr').position().left;
    // $('#omr').text(mr);

    let cl = $('.block-icons__list').position().left;
    // $('#ocl').text(cl);
    let cr = $('.block-icons__list').position().left + $('.block-icons__list').width();
    // $('#ocr').text(cr);

    if (ml < cl) {
        // $('#flagl').text('левая: скрыто');
        $('.block-icons__shadow-left').fadeIn('fast');
    } else {
        // $('#flagl').text('левая: открыто');
        $('.block-icons__shadow-left').fadeOut('fast');
    }
    if (mr > cr) {
        $('.block-icons__shadow-right').fadeIn('fast');
        // $('#flagr').text('правая: скрыто');
    } else {
        $('.block-icons__shadow-right').fadeOut('fast');
        // $('#flagr').text('правая: открыто');
    }
}

// при скролле мышью
$('.block-icons').mousemove(function () {
    shadows();
})

// при скролле пальцем
let el = $('.block-icons');
el[0].addEventListener("touchmove", shadows, false);