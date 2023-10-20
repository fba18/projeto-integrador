(function ($) {
    let $sidebar = $('.control-sidebar');
    let $container = $('<div />', {
        class: 'p-3 control-sidebar-content'
    });

    $sidebar.append($container);

    // Carrega a configuração do Local Storage e aplica a classe 'dark-mode' conforme necessário
    if (loadSetting('dark-mode', 'false') === 'true') {
        $('body').addClass('dark-mode');
    }
    if (loadSetting('layout-navbar-fixed', 'false') === 'true') {
        $('body').addClass('layout-navbar-fixed');
    }
    if (loadSetting('dropdown-legacy', 'false') === 'true') {
        $('.main-header').addClass('dropdown-legacy');
    }
    if (loadSetting('border-bottom-0', 'false') === 'true') {
        $('.main-header').addClass('border-bottom-0');
    }
    if (loadSetting('border-bottom-0', 'false') === 'true') {
        $('.main-header').addClass('border-bottom-0');
    }
    if (loadSetting('sidebar-collapse', 'false') === 'true') {
        $('body').addClass('sidebar-collapse');
    }
    if (loadSetting('layout-fixed', 'false') === 'true') {
        $('body').addClass('layout-fixed');
    }
    if (loadSetting('sidebar-mini', 'false') === 'true') {
        $('body').addClass('sidebar-mini');
    }
    if (loadSetting('sidebar-mini-md', 'false') === 'true') {
        $('body').addClass('sidebar-mini-md');
    }
    if (loadSetting('sidebar-mini-xs', 'false') === 'true') {
        $('body').addClass('sidebar-mini-xs');
    }
    if (loadSetting('nav-flat', 'false') === 'true') {
        $('.nav-sidebar').addClass('nav-flat');
    }
    if (loadSetting('nav-legacy', 'false') === 'true') {
        $('.nav-sidebar').addClass('nav-legacy');
    }
    if (loadSetting('nav-compact', 'false') === 'true') {
        $('.nav-sidebar').addClass('nav-compact');
    }
    if (loadSetting('nav-child-indent', 'false') === 'true') {
        $('.nav-sidebar').addClass('nav-child-indent');
    }
    if (loadSetting('nav-collapse-hide-child', 'false') === 'true') {
        $('.nav-sidebar').addClass('nav-collapse-hide-child');
    }
    if (loadSetting('sidebar-no-expand', 'false') === 'true') {
        $('.main-sidebar').addClass('sidebar-no-expand');
    }
    if (loadSetting('layout-footer-fixed', 'false') === 'true') {
        $('body').addClass('layout-footer-fixed');
    }

    // Função para salvar a configuração no Local Storage
    function saveSetting(key, value) {
        localStorage.setItem(key, value);
    }

    // Função para carregar a configuração do Local Storage
    function loadSetting(key, defaultValue) {
        return localStorage.getItem(key) || defaultValue;
    }


    // Checkboxes

    $container.append(
        '<h5>Personalizar SGDTE</h5><hr class="mb-2"/>'
    );

    let $dark_mode_checkbox = $('<input />', {
        type: 'checkbox',
        value: 1,
        //checked: $('body').hasClass('dark-mode'),
        checked: loadSetting('dark-mode', 'false') === 'true', // Carrega a configuração do Local Storage
        class: 'mr-1'
    }).on('click', function () {
        if ($(this).is(':checked')) {
            $('body').addClass('dark-mode');
            saveSetting('dark-mode', 'true'); // Salva a configuração no Local Storage
        } else {
            $('body').removeClass('dark-mode');
            saveSetting('dark-mode', 'false'); // Salva a configuração no Local Storage
        }
    });
    let $dark_mode_container = $('<div />', {class: 'mb-4'}).append($dark_mode_checkbox).append('<span>Modo Escuro</span>');
    $container.append($dark_mode_container);

    // Header Options

    $container.append('<h6>Opções de cabeçalho</h6>');
    let $header_fixed_checkbox = $('<input />', {
        type: 'checkbox',
        value: 1,
        checked: $('body').hasClass('layout-navbar-fixed'),
        class: 'mr-1'
    }).on('click', function () {
        if ($(this).is(':checked')) {
            $('body').addClass('layout-navbar-fixed');
            saveSetting('layout-navbar-fixed', 'true'); // Salva a configuração no Local Storage
        } else {
            $('body').removeClass('layout-navbar-fixed');
            saveSetting('layout-navbar-fixed', 'false'); // Salva a configuração no Local Storage
        }
    });
    let $header_fixed_container = $('<div />', {class: 'mb-1'}).append($header_fixed_checkbox).append('<span>Fixo</span>');
    $container.append($header_fixed_container);

    let $dropdown_legacy_offset_checkbox = $('<input />', {
        type: 'checkbox',
        value: 1,
        checked: $('.main-header').hasClass('dropdown-legacy'),
        class: 'mr-1'
    }).on('click', function () {
        if ($(this).is(':checked')) {
            $('.main-header').addClass('dropdown-legacy');
            saveSetting('dropdown-legacy', 'true'); // Salva a configuração no Local Storage
        } else {
            $('.main-header').removeClass('dropdown-legacy');
            saveSetting('dropdown-legacy', 'false'); // Salva a configuração no Local Storage
        }
    });
    let $dropdown_legacy_offset_container = $('<div />', {class: 'mb-1'}).append($dropdown_legacy_offset_checkbox).append('<span>Deslocamento Suspenso Herdado</span>');
    $container.append($dropdown_legacy_offset_container);

    let $no_border_checkbox = $('<input />', {
        type: 'checkbox',
        value: 1,
        checked: $('.main-header').hasClass('border-bottom-0'),
        class: 'mr-1'
    }).on('click', function () {
        if ($(this).is(':checked')) {
            $('.main-header').addClass('border-bottom-0');
            saveSetting('border-bottom-0', 'true'); // Salva a configuração no Local Storage
        } else {
            $('.main-header').removeClass('border-bottom-0');
            saveSetting('border-bottom-0', 'false'); // Salva a configuração no Local Storage
        }
    });
    let $no_border_container = $('<div />', {class: 'mb-4'}).append($no_border_checkbox).append('<span>Sem limite</span>');
    $container.append($no_border_container);

    // Sidebar Options

    $container.append('<h6>Sidebar Options</h6>');

    let $sidebar_collapsed_checkbox = $('<input />', {
        type: 'checkbox',
        value: 1,
        checked: $('body').hasClass('sidebar-collapse'),
        class: 'mr-1'
    }).on('click', function () {
        if ($(this).is(':checked')) {
            $('body').addClass('sidebar-collapse');
            $(window).trigger('resize');
            saveSetting('sidebar-collapse', 'true'); // Salva a configuração no Local Storage
        } else {
            $('body').removeClass('sidebar-collapse');
            $(window).trigger('resize');
            saveSetting('sidebar-collapse', 'false'); // Salva a configuração no Local Storage
        }
    });
    let $sidebar_collapsed_container = $('<div />', { class: 'mb-1' }).append($sidebar_collapsed_checkbox).append('<span>Recolhido</span>');
    $container.append($sidebar_collapsed_container);

    $(document).on('collapsed.lte.pushmenu', '[data-widget="pushmenu"]', function () {
        $sidebar_collapsed_checkbox.prop('checked', true);
    });
    $(document).on('shown.lte.pushmenu', '[data-widget="pushmenu"]', function () {
        $sidebar_collapsed_checkbox.prop('checked', false);
    });

    let $sidebar_fixed_checkbox = $('<input />', {
        type: 'checkbox',
        value: 1,
        checked: $('body').hasClass('layout-fixed'),
        class: 'mr-1'
    }).on('click', function () {
        if ($(this).is(':checked')) {
            $('body').addClass('layout-fixed');
            saveSetting('layout-fixed', 'true'); // Salva a configuração no Local Storage
            $(window).trigger('resize');
        } else {
            $('body').removeClass('layout-fixed');
            saveSetting('layout-fixed', 'false'); // Salva a configuração no Local Storage
            $(window).trigger('resize');
        }
    });
    let $sidebar_fixed_container = $('<div />', { class: 'mb-1' }).append($sidebar_fixed_checkbox).append('<span>Fixo</span>');
    $container.append($sidebar_fixed_container);

    let $sidebar_mini_checkbox = $('<input />', {
        type: 'checkbox',
        value: 1,
        checked: $('body').hasClass('sidebar-mini'),
        class: 'mr-1'
    }).on('click', function () {
        if ($(this).is(':checked')) {
            $('body').addClass('sidebar-mini');
            saveSetting('sidebar-mini', 'true'); // Salva a configuração no Local Storage
        } else {
            $('body').removeClass('sidebar-mini');
            saveSetting('sidebar-mini', 'false'); // Salva a configuração no Local Storage
        }
    });
    let $sidebar_mini_container = $('<div />', { class: 'mb-1' }).append($sidebar_mini_checkbox).append('<span>Barra Lateral Mini</span>');
    $container.append($sidebar_mini_container);

    let $sidebar_mini_md_checkbox = $('<input />', {
        type: 'checkbox',
        value: 1,
        checked: $('body').hasClass('sidebar-mini-md'),
        class: 'mr-1'
    }).on('click', function () {
        if ($(this).is(':checked')) {
            $('body').addClass('sidebar-mini-md');
            saveSetting('sidebar-mini-md', 'true'); // Salva a configuração no Local Storage
        } else {
            $('body').removeClass('sidebar-mini-md');
            saveSetting('sidebar-mini-md', 'false'); // Salva a configuração no Local Storage
        }
    });
    let $sidebar_mini_md_container = $('<div />', { class: 'mb-1' }).append($sidebar_mini_md_checkbox).append('<span>Barra Lateral Mini MD</span>');
    $container.append($sidebar_mini_md_container);

    let $sidebar_mini_xs_checkbox = $('<input />', {
        type: 'checkbox',
        value: 1,
        checked: $('body').hasClass('sidebar-mini-xs'),
        class: 'mr-1'
    }).on('click', function () {
        if ($(this).is(':checked')) {
            $('body').addClass('sidebar-mini-xs');
            saveSetting('sidebar-mini-xs', 'true'); // Salva a configuração no Local Storage
        } else {
            $('body').removeClass('sidebar-mini-xs');
            saveSetting('sidebar-mini-xs', 'false'); // Salva a configuração no Local Storage
        }
    });
    let $sidebar_mini_xs_container = $('<div />', { class: 'mb-1' }).append($sidebar_mini_xs_checkbox).append('<span>Barra Lateral Mini XS</span>');
    $container.append($sidebar_mini_xs_container);

    let $flat_sidebar_checkbox = $('<input />', {
        type: 'checkbox',
        value: 1,
        checked: $('.nav-sidebar').hasClass('nav-flat'),
        class: 'mr-1'
    }).on('click', function () {
        if ($(this).is(':checked')) {
            $('.nav-sidebar').addClass('nav-flat');
            saveSetting('nav-flat', 'true'); // Salva a configuração no Local Storage
        } else {
            $('.nav-sidebar').removeClass('nav-flat');
            saveSetting('nav-flat', 'false'); // Salva a configuração no Local Storage
        }
    });
    let $flat_sidebar_container = $('<div />', { class: 'mb-1' }).append($flat_sidebar_checkbox).append('<span>Estilo Simples de Menu</span>');
    $container.append($flat_sidebar_container);

    let $legacy_sidebar_checkbox = $('<input />', {
        type: 'checkbox',
        value: 1,
        checked: $('.nav-sidebar').hasClass('nav-legacy'),
        class: 'mr-1'
    }).on('click', function () {
        if ($(this).is(':checked')) {
            $('.nav-sidebar').addClass('nav-legacy');
            saveSetting('nav-legacy', 'true'); // Salva a configuração no Local Storage
        } else {
            $('.nav-sidebar').removeClass('nav-legacy');
            saveSetting('nav-legacy', 'false'); // Salva a configuração no Local Storage
        }
    });
    let $legacy_sidebar_container = $('<div />', { class: 'mb-1' }).append($legacy_sidebar_checkbox).append('<span>Estilo Legado de Menu</span>');
    $container.append($legacy_sidebar_container);

    let $compact_sidebar_checkbox = $('<input />', {
        type: 'checkbox',
        value: 1,
        checked: $('.nav-sidebar').hasClass('nav-compact'),
        class: 'mr-1'
    }).on('click', function () {
        if ($(this).is(':checked')) {
            $('.nav-sidebar').addClass('nav-compact');
            saveSetting('nav-compact', 'true'); // Salva a configuração no Local Storage
        } else {
            $('.nav-sidebar').removeClass('nav-compact');
            saveSetting('nav-compact', 'false'); // Salva a configuração no Local Storage
        }
    });
    let $compact_sidebar_container = $('<div />', { class: 'mb-1' }).append($compact_sidebar_checkbox).append('<span>Menu Compacto</span>');
    $container.append($compact_sidebar_container);

    let $child_indent_sidebar_checkbox = $('<input />', {
        type: 'checkbox',
        value: 1,
        checked: $('.nav-sidebar').hasClass('nav-child-indent'),
        class: 'mr-1'
    }).on('click', function () {
        if ($(this).is(':checked')) {
            $('.nav-sidebar').addClass('nav-child-indent');
            saveSetting('nav-child-indent', 'true'); // Salva a configuração no Local Storage
        } else {
            $('.nav-sidebar').removeClass('nav-child-indent');
            saveSetting('nav-child-indent', 'false'); // Salva a configuração no Local Storage
        }
    });
    let $child_indent_sidebar_container = $('<div />', { class: 'mb-1' }).append($child_indent_sidebar_checkbox).append('<span>Recuo Menu Filho</span>');
    $container.append($child_indent_sidebar_container);

    let $child_hide_sidebar_checkbox = $('<input />', {
        type: 'checkbox',
        value: 1,
        checked: $('.nav-sidebar').hasClass('nav-collapse-hide-child'),
        class: 'mr-1'
    }).on('click', function () {
        if ($(this).is(':checked')) {
            $('.nav-sidebar').addClass('nav-collapse-hide-child');
            saveSetting('nav-collapse-hide-child', 'true'); // Salva a configuração no Local Storage
        } else {
            $('.nav-sidebar').removeClass('nav-collapse-hide-child');
            saveSetting('nav-collapse-hide-child', 'false'); // Salva a configuração no Local Storage
        }
    });
    let $child_hide_sidebar_container = $('<div />', { class: 'mb-1' }).append($child_hide_sidebar_checkbox).append('<span>Ocultar Menu Filho ao Recolher</span>');
    $container.append($child_hide_sidebar_container);

    let $no_expand_sidebar_checkbox = $('<input />', {
        type: 'checkbox',
        value: 1,
        checked: $('.main-sidebar').hasClass('sidebar-no-expand'),
        class: 'mr-1'
    }).on('click', function () {
        if ($(this).is(':checked')) {
            $('.main-sidebar').addClass('sidebar-no-expand');
            saveSetting('sidebar-no-expand', 'true'); // Salva a configuração no Local Storage
        } else {
            $('.main-sidebar').removeClass('sidebar-no-expand');
            saveSetting('sidebar-no-expand', 'false'); // Salva a configuração no Local Storage
        }
    });
    let $no_expand_sidebar_container = $('<div />', { class: 'mb-4' }).append($no_expand_sidebar_checkbox).append('<span>Desativar a expansão automática de foco/focalização</span>');
    $container.append($no_expand_sidebar_container);

    // Footer Options

    $container.append('<h6>Opções de rodapé</h6>')
    let $footer_fixed_checkbox = $('<input />', {
        type: 'checkbox',
        value: 1,
        checked: $('body').hasClass('layout-footer-fixed'),
        class: 'mr-1'
    }).on('click', function () {
        if ($(this).is(':checked')) {
            $('body').addClass('layout-footer-fixed');
            saveSetting('layout-footer-fixed', 'true'); // Salva a configuração no Local Storage
        } else {
            $('body').removeClass('layout-footer-fixed');
            saveSetting('layout-footer-fixed', 'false'); // Salva a configuração no Local Storage
        }
    });
    let $footer_fixed_container = $('<div />', { class: 'mb-4' }).append($footer_fixed_checkbox).append('<span>Fixo</span>');
    $container.append($footer_fixed_container);
})(jQuery);