<div id="google_translate_element"></div>

@push('scripts')
    <script type="text/javascript">
        function googleTranslateElementInit() {
            new google.translate.TranslateElement({
                //pageLanguage: 'it',
                //includedLanguages: 'en,fr,de,es,ja,zh-CN,ru,ar,pt',
                layout: google.translate.TranslateElement.InlineLayout.SIMPLE
            }, 'google_translate_element');
        }
    </script>
    <script src="https://translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>
@endpush

@push('styles')
    <style>
        .translate-widget select.goog-te-combo {
            background: transparent;
            border: 1px solid #ccc;
            border-radius: 9999px;
            padding: 0.25rem 0.75rem;
            font-size: 0.75rem;
            font-family: inherit;
            color: #444;
            appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg width='10' height='6' viewBox='0 0 10 6' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M0 0l5 6 5-6z' fill='%23666'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 0.5rem center;
            background-size: 0.6rem;
        }

        /* Nasconde tutto il superfluo */
        .translate-widget .goog-te-gadget span,
        .translate-widget .goog-logo-link,
        .translate-widget .goog-te-banner-frame,
        .translate-widget .goog-te-balloon-frame {
            display: none !important;
        }

        .translate-widget .goog-te-gadget {
            font-size: 0;
        }
    </style>
@endpush
