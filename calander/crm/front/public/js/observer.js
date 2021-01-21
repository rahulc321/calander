var observer = {
    url: '',
    container: '',
    params: {},
    loader : '#loader',
    init: function (url) {
        this.url = url;
        return observer;
    },
    getFormData: function () {
        /*var data = {};
         $formObj.find('input').each(function (i, v) {
         data[$(this).attr('name')] = $(this).val();
         });
         data['orderBy'] = $("[name=orderBy]:checked").val();
         return data;*/
        return new FormData(document.getElementById('chart-form'));
    }
};

function merge(to, from) {
    console.log(from);
    if (typeof to === 'object' && typeof from === 'object') {
        for (var pro in from) {
            if (from.hasOwnProperty(pro)) {
                to[pro] = from[pro];
            }
        }
    }
    else {
        throw "Merge function can apply only on object";
    }
}

(function ($, window, undefined) {
    observer.fetchData = function () {
        var config = {
            url: observer.url,
            data: observer.getFormData(),
            method: 'POST',
            processData: false,
            contentType: false
        };
        $(observer.loader).show();
        $.ajax(config).done(function (response) {
            $("#notificationArea").empty();
            $(observer.loader).hide();
            console.log(response.data);
            if(response.notification){
                $("#notificationArea").empty().append(response.notification);
            }
            drawChart(response);
            /*observer.container.empty().append(response.data);*/
        });
    };
    observer.listenForEvents = function () {
        /*var collector = this;*/
        $(".changable").on('change', function () {
            observer.fetchData();
        });

    };
    observer.listen = function () {
        /*console.log(this);*/
        observer.listenForEvents();
        return observer;
    };


})
(jQuery, window);