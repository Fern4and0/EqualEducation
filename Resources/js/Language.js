function googleTranslateElementInit() {
    new google.translate.TranslateElement({
        pageLanguage: 'en',
        includedLanguages: 'en,pt,fr,it,la,zh-CN,es',
        layout: google.translate.TranslateElement.InlineLayout.SIMPLE
    }, 'google_translate_element');
}

// Load the Google Translate API script
(function() {
    var gtScript = document.createElement('script');
    gtScript.type = 'text/javascript';
    gtScript.async = true;
    gtScript.src = 'https://translate.google.com/translate_a/element.js?cb=googleTranslateElementInit';
    var s = document.getElementsByTagName('script')[0];
    s.parentNode.insertBefore(gtScript, s);
})();

// Define the translatePage function
function translatePage(language) {
    var iframe = document.querySelector('iframe.goog-te-menu-frame');
    if (iframe) {
        var innerDoc = iframe.contentDocument || iframe.contentWindow.document;
        var langSelect = innerDoc.querySelector('.goog-te-combo');
        if (langSelect) {
            langSelect.value = language;
            langSelect.dispatchEvent(new Event('change'));
        }
    }
}