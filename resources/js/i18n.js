// src/i18n.js
import { createI18n } from 'vue-i18n';
import { getTranslations } from './services/translationService';

const i18n = createI18n({
    // legacy: false,
    locale: 'en',
    messages: {},
});

export const loadLocaleMessages = async (locale) => {
    const messages = await getTranslations(locale);
    i18n.global.setLocaleMessage(locale, messages);
    i18n.global.locale = locale;
    console.log(`Loaded messages for ${locale}:`, messages); // Log the loaded messages

};

export default i18n;
