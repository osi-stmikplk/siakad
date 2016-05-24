/**
 * Utility PANATAU yfktn@15102015
 */
var TSSTMIK = {
    /**
     * Hilangkan penanda error pada form dgn bootstrap css style, dgn asumsi bahwa eId adalah id milik komponen yang
     * menjadi tempat untuk menampilkan error.
     * @param eId
     */
    resetFormErrorMsg:function(eId){
        $(eId).addClass('hidden')
            .closest('div.form-group').removeClass('has-error');
    },
    /**
     * Tampilkan error pada masing2 element, dgn asumsi bahwa tempat error ditampilkan memiliki element HTML dengan
     * nama id: <nama_field>-error; ex: email-error.
     * @param responseText adalah kembalian dari hasil proses ajax dgn format JSON!
     */
    showFormErrorMsg:function(responseText){
        $.each($.parseJSON(responseText),function(i,v){
            $('#error-'+i).removeClass('hidden').empty().append(v.toString())
                .closest('div.form-group').addClass('has-error');
        });
    },
    /**
     * tampilkan pesan kesalahan yang dilakukan setelah suatu proses AJAX, didapatkan dari xhr.responseText
     * @param responseText
     */
    alertAboutErrorMsg:function(responseText){
        theM = "";
        $.each($.parseJSON(responseText),function(i,v){
            theM += "Pada inputan " + i + " : " + v.toString();
        });
        alert("Terdapat kesalahan: \n" + theM);
    },
    /**
     * Load CSS dynamically, to use it: LoadCss('plugin/foo/bar.css')
     * @param href target
     */
    loadCSS : function(href){
        var cssLink = $('<link>');
        $('head').append(cssLink);
        cssLink.attr({
            rel: 'stylesheet',
            type: 'text/css',
            href: href
        });
    },
    /**
     * Load bootstrap table dynamically, add callback with script to initialize bt table.
     * @param callback
     * @constructor
     */
    loadBootstrapTableScript: function(callback)
    {
        function LoadBootstrapTable(){
            $.getScript('/plugins/btable/bootstrap-table.min.js', function(){
                $.getScript('/plugins/btable/extensions/export/bootstrap-table-export.min.js', callback);
            });
        }
        if(!$.fn.bootstrapTable){
            this.loadCSS('/plugins/btable/bootstrap-table.min.css');
            LoadBootstrapTable();
        } else {
            if(callback && typeof(callback) === "function") {
                callback();
            }
        }
    },
    setMenuActiveBasedOnURL: function() {
        $themenu = $('ul.sidebar-menu li a[href="'+window.location.href+'"]');
        // get parent li
        $parent_li = $themenu.parent('li');
        // get parent ul
        $treview = $parent_li.closest('li.treeview');
        // set active
        $parent_li.addClass('active');
        $treview.addClass('active');
    }
};
$(document).ready(function () {
    // set ajaxsetup jadi nilai token csrf selalu update setiap kali kita menggunakan ajax!
    $.ajaxSetup({
        headers:
        {
            'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
        }
    });
    // setiap baru saja di load, set active menu sesuai dengan URL
    TSSTMIK.setMenuActiveBasedOnURL();
    $('.modal').on('shown.bs.modal', function (e) {
        $b = $(e.relatedTarget);
        title = $b.attr('title');
        if(title.length<0) {
            title = "Modal App.";
        }
        $(this).find('h4.modal-title').text(title);
        $(this).find('input[type=text],textarea,select').filter(':visible:first').focus();
    });

}).ajaxError(function( event, request, settings, s ) {
    if(request.status == 401) {
        alert('Unauthorized, Login Ulang Dibutuhkan!');
        window.location.reload();
    }
});