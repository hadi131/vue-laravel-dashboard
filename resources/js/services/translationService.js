import axios from 'axios';

export const getTranslations = async (locale) => {
  try {
    const response = await axios.get(`/api/translations/${locale}`);
    return response.data;
  } catch (error) {
    console.error('Error fetching translations:', error);
    throw error;
  }
};
