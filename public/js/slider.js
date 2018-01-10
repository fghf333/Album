$(document).ready(function () {
    $('[data-fancybox]').fancybox({
        hash : false,
        toolbar: true,
        buttons: [
            'slideShow',
            'fullScreen',
            'thumbs',
            'close'
        ],
        loop: true,
        protect: true,
        transitionEffect: "circular",
        iframe: {
            preload: true
        },
        lang: 'ru',
        i18n: {
            'ru': {
                CLOSE: 'Закрыть',
                NEXT: 'Следующее',
                PREV: 'Предыдущее',
                ERROR: 'Фотография не может быть закгружена. <br/> Пожалуйста попробуйте позднее.',
                PLAY_START: 'Запустить слайдшоу',
                PLAY_STOP: 'Остановить слайдшоу',
                FULL_SCREEN: 'На весь экран',
                THUMBS: 'Список фотографий',
                DOWNLOAD: 'Скачать',
                SHARE: 'Поделиться',
                ZOOM: 'Приблизить'
            }
        }
    })
});
