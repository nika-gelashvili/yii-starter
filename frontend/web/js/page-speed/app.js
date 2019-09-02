$('.check-button').click(function () {
    $('#main').find('.removableElement').each((key, value) => {
        value.remove();
    });
    ajaxData(function (data) {
        $('#load-fcp').append(createHtmlElement(data.loadingExperience.metrics.FIRST_CONTENTFUL_PAINT_MS.category));
        $('#load-fid').append(createHtmlElement(data.loadingExperience.metrics.FIRST_INPUT_DELAY_MS.category));
        $('#origin-fcp').append(createHtmlElement(data.originLoadingExperience.metrics.FIRST_CONTENTFUL_PAINT_MS.category));
        $('#light-fcp').append(createHtmlElement(data.lighthouseResult.audits['first-contentful-paint'].displayValue));
        $('#light-si').append(createHtmlElement(data.lighthouseResult.audits['speed-index'].displayValue));
        $('#light-tti').append(createHtmlElement(data.lighthouseResult.audits['interactive'].displayValue));
        $('#light-fci').append(createHtmlElement(data.lighthouseResult.audits['first-cpu-idle'].displayValue));
        $('#light-fmp').append(createHtmlElement(data.lighthouseResult.audits['first-meaningful-paint'].displayValue));
        $('#light-eil').append(createHtmlElement(data.lighthouseResult.audits['estimated-input-latency'].displayValue));
        $('#captcha').append(createHtmlElement(data.captchaResult));
        $('#kind').append(createHtmlElement(data.kind));
        $('#web-page').append(createHtmlElement(data.id));
        $('#time').append(createHtmlElement(data.analysisUTCTimestamp));
    })
});

function ajaxData(returnData) {
    $.ajax({
        url: 'index',
        type: 'POST',
        dataType: 'JSON',
        data: {_csrf: yii.getCsrfToken(), url: $('#url').val()},
        beforeSend: function () {
            $('#ajaxSpinner').show();
            $('#main').css('display', 'none');
        },
        success: function (data) {
            returnData(data);
        },
        complete: function () {
            $('#ajaxSpinner').hide();
            $('#main').css('display', 'flex');
        },
        error: function () {
            $('#errorMessage').show();
        }
    });
}

function createHtmlElement(data) {
    // let htmlData = $('<p>' + data + '</p>', {class: 'removableElement'});
    return $('<p/>').addClass('removableElement').text(data);
}